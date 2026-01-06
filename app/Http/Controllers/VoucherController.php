<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\UserCoupon;
use Illuminate\Support\Facades\Auth;

class VoucherController extends Controller
{
    public function index()
    {
        $availableCoupons = Coupon::where('status_aktif', true)
            ->where('berlaku_dari', '<=', now())
            ->where('berlaku_hingga', '>=', now())
            ->orderBy('minimal_belanja')
            ->get();

        $userCoupons = UserCoupon::where('id_pengguna', Auth::id())
            ->with('coupon')
            ->whereHas('coupon', function($q) {
                $q->where('berlaku_hingga', '>=', now());
            })
            ->get();

        return view('voucher', compact('availableCoupons', 'userCoupons'));
    }

    public function claim($id)
    {
        $coupon = Coupon::where('id', $id)
            ->where('status_aktif', true)
            ->where('berlaku_dari', '<=', now())
            ->where('berlaku_hingga', '>=', now())
            ->first();

        if (!$coupon) {
            return back()->with('error', 'Voucher tidak tersedia');
        }

        // Cek kuota
        if ($coupon->kuota_penggunaan && $coupon->penggunaan_sekarang >= $coupon->kuota_penggunaan) {
            return back()->with('error', 'Voucher sudah habis');
        }

        // Cek apakah user sudah claim
        $alreadyClaimed = UserCoupon::where('id_pengguna', Auth::id())
            ->where('id_coupon', $id)
            ->exists();

        if ($alreadyClaimed) {
            return back()->with('error', 'Anda sudah mengklaim voucher ini');
        }

        // Simpan ke user coupons
        UserCoupon::create([
            'id_pengguna' => Auth::id(),
            'id_coupon' => $id,
            'status' => 'active'
        ]);

        // Update penggunaan
        $coupon->increment('penggunaan_sekarang');

        return back()->with('success', 'Voucher berhasil diklaim!');
    }
}