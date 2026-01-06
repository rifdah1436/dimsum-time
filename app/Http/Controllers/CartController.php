<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VarianMenu;
use App\Models\Pesanan;
use App\Models\Pembayaran;
use App\Models\PesananDetail;
use App\Models\Coupon;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * TAMBAHKAN METHOD add() YANG HILANG INI
     */
    public function add(Request $request)
    {
        $request->validate([
            'id_varian' => 'required|exists:varian_menu,id_varian',
            'jumlah' => 'required|integer|min:1',
            'catatan' => 'nullable|string|max:255'
        ]);
        
        $varian = VarianMenu::find($request->id_varian);
        
        if ($varian->stok < $request->jumlah) {
            return back()->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $varian->stok);
        }
        
        $cart = session()->get('cart', []);
        $cartKey = $request->id_varian;
        
        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['jumlah'] += $request->jumlah;
            $cart[$cartKey]['subtotal'] = $varian->harga * $cart[$cartKey]['jumlah'];
            $cart[$cartKey]['catatan'] = $request->catatan ?: $cart[$cartKey]['catatan'];
        } else {
            $cart[$cartKey] = [
                'id_varian' => $request->id_varian,
                'id_menu' => $varian->id_menu,
                'nama' => $varian->menu->nama_menu,
                'nama_menu' => $varian->menu->nama_menu,
                'ukuran' => $varian->ukuran,
                'jumlah_pcs' => $varian->jumlah_pcs,
                'harga' => $varian->harga,
                'jumlah' => $request->jumlah,
                'catatan' => $request->catatan,
                'subtotal' => $varian->harga * $request->jumlah
            ];
        }
        
        session()->put('cart', $cart);
        
        return redirect()->route('keranjang')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }
    
    /**
     * TAMPILKAN KERANJANG - SEDERHANA
     */
    public function index()
{
    $cart = session()->get('cart', []);
    $total = 0;
    
    foreach ($cart as $item) {
        $total += $item['harga'] * $item['jumlah'];
    }
    
    return view('keranjang', compact('cart', 'total'));
}
    
    /**
     * UPDATE ITEM KERANJANG
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1'
        ]);
        
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            $varian = VarianMenu::find($id);
            
            if ($varian->stok < $request->jumlah) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak mencukupi. Stok tersedia: ' . $varian->stok
                ]);
            }
            
            $cart[$id]['jumlah'] = $request->jumlah;
            $cart[$id]['subtotal'] = $cart[$id]['harga'] * $request->jumlah;
            session()->put('cart', $cart);
            
            return response()->json([
                'success' => true,
                'cart_count' => count($cart)
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Item tidak ditemukan'
        ]);
    }
    
    /**
     * HAPUS ITEM DARI KERANJANG
     */
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            
            return response()->json([
                'success' => true,
                'cart_count' => count($cart)
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Item tidak ditemukan'
        ]);
    }
    
    /**
     * KOSONGKAN KERANJANG
     */
    public function clear()
    {
        session()->forget('cart');
        session()->forget('applied_coupon');
        
        return redirect()->route('keranjang')->with('success', 'Keranjang berhasil dikosongkan');
    }
    
    /**
     * Checkout Page - With Delivery/Pickup Toggle
     */
    public function checkoutPage()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk melanjutkan checkout.');
        }
        
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('keranjang')->with('error', 'Keranjang Anda kosong.');
        }
        
        // Hitung subtotal
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['harga'] * $item['jumlah'];
        }
        
        // Get user data
        $user = Auth::user();
        $isMember = $user && $user->peran == 'pelanggan';
        
        // Get shipping fee based on user address
        $shippingFee = 5000; // Default
        
        // Check if member gets free shipping
        if ($isMember && $user->bebas_ongkir && $subtotal >= 50000) {
            $shippingFee = 0;
        }
        
        // Get available coupons
        $availableCoupons = $this->getAvailableCoupons($user, $subtotal);
        
        // Check applied coupon from session
        $appliedCoupon = session()->get('applied_coupon');
        
        return view('checkout', compact(
            'cart', 
            'subtotal',
            'shippingFee',
            'user',
            'isMember',
            'availableCoupons',
            'appliedCoupon'
        ));
    }
    
    /**
     * Get available coupons for user
     */
    private function getAvailableCoupons($user, $subtotal)
    {
        if (!class_exists('App\Models\Coupon')) {
            return [];
        }
        
        try {
            $coupons = Coupon::where('status_aktif', true)
                ->where('berlaku_dari', '<=', now())
                ->where('berlaku_hingga', '>=', now())
                ->where('minimal_belanja', '<=', $subtotal)
                ->get();
            
            return $coupons;
        } catch (\Exception $e) {
            return [];
        }
    }
    
    /**
     * Process Checkout - SIMPLIFIED VERSION
     */
    public function processCheckout(Request $request)
    {
        // Validasi input dasar
        $request->validate([
            'metode_pengiriman' => 'required|in:delivery,pickup',
            'metode_pembayaran' => 'required|in:cod,bca,mandiri,ovo,gopay,dana',
            'shipping_fee' => 'required|numeric|min:0',
            'agree_terms' => 'required|accepted',
        ]);
        
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang Anda kosong.'
            ]);
        }
        
        // Hitung subtotal
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['harga'] * $item['jumlah'];
        }
        
        // Hitung diskon jika ada kode promo
        $discount = 0;
        if ($request->kode_promo) {
            $discount = $this->validatePromoCode($request->kode_promo, $subtotal);
        }
        
        // Tentukan biaya pengiriman
        $biaya_pengiriman = $request->metode_pengiriman == 'pickup' ? 0 : $request->shipping_fee;
        
        // Cek apakah member berhak gratis ongkir (hanya untuk delivery)
        $user = Auth::user();
        if ($user && $user->peran == 'pelanggan' && $user->bebas_ongkir && $subtotal >= 50000 && $request->metode_pengiriman == 'delivery') {
            $biaya_pengiriman = 0;
        }
        
        // Hitung total (TANPA PAJAK - SESUAI PERMINTAAN)
        $total_bayar = $subtotal + $biaya_pengiriman - $discount;
        
        // Generate nomor pesanan unik
        $nomor_pesanan = 'DIM' . date('YmdHis') . rand(100, 999);
        
        DB::beginTransaction();
        
        try {
            // Persiapkan alamat lengkap
            $alamat_lengkap = '';
            $nama_penerima = $user->nama_lengkap;
            $nomor_telepon = $user->nomor_telepon;
            
            if ($request->metode_pengiriman == 'delivery') {
                // Ambil alamat dari user (kolom alamat di tabel pengguna)
                $alamat_lengkap = $user->alamat ?? 'Alamat tidak tersedia';
            } else {
                $alamat_lengkap = 'Ambil di toko - Dimsum Time Store, Jl. Raya Dimsum No. 123, Jakarta Selatan';
            }
            
            // Persiapkan catatan pelanggan
            $catatan_pelanggan = "Email: " . $user->email;
            if ($request->catatan_pelanggan) {
                $catatan_pelanggan .= "\nCatatan: " . $request->catatan_pelanggan;
            }
            
            // DEFINE BUKTI PENGIRIMAN SEBAGAI NULL (UNTUK PELANGGAN)
            $bukti_pengiriman = null;
            
            // SIMPAN DATA PESANAN (TANPA PAJAK)
            $pesanan = Pesanan::create([
                'nomor_pesanan' => $nomor_pesanan,
                'id_pengguna' => auth()->id(),
                'nama_penerima' => $nama_penerima,
                'alamat_pengiriman' => $alamat_lengkap,
                'nomor_telepon' => $nomor_telepon,
                'jenis_pengiriman' => $request->metode_pengiriman,
                'tanggal_pengiriman' => null,
                'catatan_pelanggan' => $catatan_pelanggan,
                'status' => 'menunggu_pembayaran',
                'subtotal' => $subtotal,
                'biaya_pengiriman' => $biaya_pengiriman,
                'diskon' => $discount,
                'total_bayar' => $total_bayar,
                'bukti_pengiriman' => $bukti_pengiriman,
            ]);
            
            // SIMPAN DATA PEMBAYARAN
            Pembayaran::create([
                'id_pesanan' => $pesanan->id_pesanan,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status_pembayaran' => 'menunggu',
                'jumlah' => $total_bayar,
                'id_transaksi' => 'TXN' . date('YmdHis') . rand(100, 999),
            ]);
            
            // Simpan detail pesanan dan update stok
            foreach ($cart as $item) {
                PesananDetail::create([
                    'id_pesanan' => $pesanan->id_pesanan,
                    'id_varian' => $item['id_varian'],
                    'jumlah' => $item['jumlah'],
                    'harga_per_unit' => $item['harga'],
                    'subtotal' => $item['harga'] * $item['jumlah'],
                    'catatan' => $item['catatan'] ?? null,
                ]);
                
                // Kurangi stok varian menu
                $varian = VarianMenu::find($item['id_varian']);
                if ($varian) {
                    $varian->stok -= $item['jumlah'];
                    $varian->save();
                }
            }
            
            // Commit transaction
            DB::commit();
            
            // Kosongkan session
            session()->forget('cart');
            session()->forget('applied_coupon');
            
            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat!',
                'order_number' => $nomor_pesanan,
                'redirect_url' => route('pesanan') . '?order=' . $nomor_pesanan
            ]);
                
        } catch (\Exception $e) {
            // Rollback transaction jika ada error
            DB::rollBack();
            
            \Log::error('Checkout Error: ' . $e->getMessage());
            \Log::error('Trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat pesanan. Error: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Apply Coupon - VERSI TERBARU DENGAN PERBAIKAN
     */
    public function applyCoupon(Request $request)
    {
        try {
            if (!$request->coupon_code || !$request->subtotal) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak valid'
                ]);
            }
            
            if (!class_exists('App\Models\Coupon')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Fitur kupon belum tersedia'
                ]);
            }
            
            $coupon = Coupon::where('kode_kupon', $request->coupon_code)->first();
            
            if (!$coupon) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kupon tidak ditemukan!'
                ]);
            }
            
            // Cek status kupon
            if (!$coupon->status_aktif) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kupon tidak aktif!'
                ]);
            }
            
            // Cek tanggal berlaku
            $now = now();
            if ($now < $coupon->berlaku_dari || $now > $coupon->berlaku_hingga) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kupon sudah tidak berlaku!'
                ]);
            }
            
            // Cek kuota
            if ($coupon->kuota > 0 && $coupon->terpakai >= $coupon->kuota) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kuota kupon sudah habis!'
                ]);
            }
            
            if ($request->subtotal < $coupon->minimal_belanja) {
                return response()->json([
                    'success' => false,
                    'message' => 'Minimal belanja Rp ' . number_format($coupon->minimal_belanja, 0, ',', '.') . ' untuk menggunakan kupon ini!'
                ]);
            }
            
            // Hitung diskon
            $discount = 0;
            if ($coupon->tipe == 'persentase') {
                $discount = $request->subtotal * ($coupon->nilai / 100);
                if ($coupon->diskon_maksimal && $discount > $coupon->diskon_maksimal) {
                    $discount = $coupon->diskon_maksimal;
                }
            } elseif ($coupon->tipe == 'nominal') {
                $discount = $coupon->nilai;
            } elseif ($coupon->tipe == 'ongkir') {
                // Untuk voucher ongkir, diskon sesuai dengan biaya ongkir atau nilai voucher
                $shippingFee = $request->shipping_fee ?? 0;
                $discount = $coupon->nilai > 0 ? min($coupon->nilai, $shippingFee) : $shippingFee;
            }
            
            // Batasi maksimal diskon tidak melebihi subtotal
            $discount = min($discount, $request->subtotal);
            
            // Simpan di session
            session()->put('applied_coupon', [
                'code' => $coupon->kode_kupon,
                'name' => $coupon->nama_kupon,
                'value' => $coupon->nilai,
                'type' => $coupon->tipe,
                'minPurchase' => $coupon->minimal_belanja,
                'discount' => $discount,
                'max_discount' => $coupon->diskon_maksimal
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Kupon berhasil diterapkan!',
                'coupon' => [
                    'code' => $coupon->kode_kupon,
                    'name' => $coupon->nama_kupon,
                    'type' => $coupon->tipe,
                    'value' => $coupon->nilai,
                    'minPurchase' => $coupon->minimal_belanja,
                    'max_discount' => $coupon->diskon_maksimal,
                    'discount' => $discount
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Remove Coupon
     */
    public function removeCoupon()
    {
        session()->forget('applied_coupon');
        
        return response()->json([
            'success' => true,
            'message' => 'Kupon berhasil dihapus!'
        ]);
    }
    
    /**
     * GET CART COUNT
     */
    public function getCartCount()
    {
        $cart = session()->get('cart', []);
        return response()->json([
            'cart_count' => count($cart)
        ]);
    }
    
    /**
     * Validasi kode promo untuk checkout
     */
    private function validatePromoCode($kode, $subtotal)
    {
        // Cek dari database terlebih dahulu
        if (class_exists('App\Models\Coupon')) {
            $coupon = Coupon::where('kode_kupon', $kode)->first();
            if ($coupon) {
                // Cek status
                if (!$coupon->status_aktif || now() < $coupon->berlaku_dari || now() > $coupon->berlaku_hingga) {
                    return 0;
                }
                
                // Cek kuota
                if ($coupon->kuota > 0 && $coupon->terpakai >= $coupon->kuota) {
                    return 0;
                }
                
                if ($subtotal >= $coupon->minimal_belanja) {
                    // Hitung diskon
                    $discount = 0;
                    if ($coupon->tipe == 'persentase') {
                        $discount = $subtotal * ($coupon->nilai / 100);
                        if ($coupon->diskon_maksimal && $discount > $coupon->diskon_maksimal) {
                            $discount = $coupon->diskon_maksimal;
                        }
                    } elseif ($coupon->tipe == 'nominal') {
                        $discount = $coupon->nilai;
                    } elseif ($coupon->tipe == 'ongkir') {
                        // Untuk voucher ongkir, anggap diskon sesuai dengan nilai voucher
                        $discount = $coupon->nilai;
                    }
                    
                    // Update terpakai count
                    $coupon->increment('terpakai');
                    
                    return min($discount, $subtotal);
                }
            }
        }
        
        // Fallback jika tabel coupons belum ada
        $promoCodes = [
            'DIMSUM10' => ['type' => 'percentage', 'value' => 10, 'min_order' => 50000],
            'DIMSUM20K' => ['type' => 'fixed', 'value' => 20000, 'min_order' => 100000],
            'GRATISONGKIR' => ['type' => 'shipping', 'value' => 10000, 'min_order' => 75000],
        ];
        
        if (array_key_exists($kode, $promoCodes)) {
            $promo = $promoCodes[$kode];
            
            if ($subtotal >= $promo['min_order']) {
                if ($promo['type'] == 'percentage') {
                    return $subtotal * ($promo['value'] / 100);
                } elseif ($promo['type'] == 'shipping') {
                    return 5000; // Gratis ongkir senilai 10.000
                } else {
                    return $promo['value'];
                }
            }
        }
        
        return 0;
    }
}