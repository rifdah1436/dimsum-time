<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data cart
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('keranjang')->with('error', 'Keranjang kosong');
        }
    
        // Hitung subtotal
        $subtotal = 0;
        $totalQuantity = 0;
        foreach ($cart as $item) {
            $subtotal += $item['harga'] * $item['jumlah'];
            $totalQuantity += $item['jumlah'];
        }
    
        // Biaya pengiriman default
        $shippingFee = 5000;
        
        // **PASTIKAN AMBIL SEMUA VOUCHER AKTIF**
        $availableCoupons = Coupon::where('status_aktif', 1)
            ->where('berlaku_dari', '<=', Carbon::now())
            ->where('berlaku_hingga', '>=', Carbon::now())
            ->where(function($query) {
                $query->where('kuota', -1) // unlimited
                      ->orWhereRaw('kuota > terpakai');
            })
            ->orderBy('tipe', 'desc')
            ->orderBy('nilai', 'desc')
            ->get();
    
        // Ambil voucher yang sudah diapply dari session
        $appliedCoupon = session()->get('applied_coupon');
    
        // Hitung total dengan voucher jika ada
        $total = $subtotal + $shippingFee;
        $discount = 0;
        
        if ($appliedCoupon) {
            $coupon = Coupon::where('kode_kupon', $appliedCoupon['code'])
                ->first();
                
            if ($coupon && $coupon->bisaDigunakan($subtotal)) {
                $discount = $coupon->hitungDiskon($subtotal);
                // Jika tipe ongkir, kurangi dari shipping fee
                if ($coupon->tipe == 'ongkir') {
                    $shippingFee = max(0, $shippingFee - $discount);
                    $discount = 0;
                }
                $total = $subtotal + $shippingFee - $discount;
            } else {
                // Hapus voucher jika tidak berlaku
                session()->forget('applied_coupon');
                $appliedCoupon = null;
            }
        }
    
        return view('checkout', compact(
            'cart',
            'subtotal',
            'totalQuantity',
            'shippingFee',
            'availableCoupons',
            'appliedCoupon',
            'discount',
            'total'
        ));
    }
    private function getCouponColor($type)
    {
        switch($type) {
            case 'ongkir':
                return '#ee4d2d'; // Orange Shopee
            case 'persentase':
                return '#00bfa5'; // Green
            case 'nominal':
                return '#ff9800'; // Orange
            default:
                return '#ee4d2d';
        }
    }
    
    private function getCouponText($coupon)
    {
        switch($coupon->tipe) {
            case 'persentase':
                return $coupon->nilai . '% OFF';
            case 'nominal':
                return 'Rp' . number_format($coupon->nilai, 0, ',', '.');
            case 'ongkir':
                return 'GRATIS ONGKIR';
            default:
                return 'DISKON';
        }
    }

    /**
     * Apply voucher dari modal
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string'
        ]);

        $coupon = Coupon::where('kode_kupon', $request->coupon_code)
            ->where('status_aktif', 1)
            ->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Kode voucher tidak ditemukan'
            ], 404);
        }

        // Hitung subtotal dari cart
        $cart = session()->get('cart', []);
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['harga'] * $item['jumlah'];
        }

        // Cek apakah bisa digunakan
        if (!$coupon->bisaDigunakan($subtotal)) {
            return response()->json([
                'success' => false,
                'message' => 'Voucher tidak dapat digunakan. Minimal belanja Rp' . 
                    number_format($coupon->minimal_belanja, 0, ',', '.')
            ], 400);
        }

        // Hitung diskon
        $discount = $coupon->hitungDiskon($subtotal);
        
        // Simpan voucher yang dipilih ke session
        session()->put('applied_coupon', [
            'code' => $coupon->kode_kupon,
            'name' => $coupon->nama_kupon,
            'type' => $coupon->tipe,
            'value' => $coupon->nilai,
            'discount' => $discount,
            'min_purchase' => $coupon->minimal_belanja,
            'max_discount' => $coupon->diskon_maksimal
        ]);

        return response()->json([
            'success' => true,
            'coupon' => [
                'name' => $coupon->nama_kupon,
                'type' => $coupon->tipe,
                'value' => $coupon->nilai,
                'discount' => $discount,
                'minPurchase' => $coupon->minimal_belanja,
                'maxDiscount' => $coupon->diskon_maksimal
            ]
        ]);
    }

    /**
     * Remove applied coupon
     */
    public function removeCoupon(Request $request)
    {
        session()->forget('applied_coupon');
        
        return response()->json([
            'success' => true,
            'message' => 'Voucher berhasil dihapus'
        ]);
    }
}