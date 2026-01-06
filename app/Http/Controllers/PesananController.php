<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Pembayaran;
use App\Models\PesananDetail;
use App\Models\VarianMenu;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PesananController extends Controller
{
    /**
     * Menampilkan halaman riwayat pesanan pengguna dengan filter lengkap
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Query dasar
        $query = Pesanan::where('id_pengguna', $user->id_pengguna)
            ->with(['pembayaran', 'details.varian.menu']);
        
        // Filter berdasarkan status jika ada
        $status = $request->get('status');
        if ($status && $status !== 'semua') {
            $query->where('status', $status);
        }
        
        // Urutkan berdasarkan tanggal terbaru
        $pesanan = $query->orderBy('created_at', 'desc')->get();
        
        // Hitung jumlah per status untuk badge
        $statusCounts = [
            'semua' => Pesanan::where('id_pengguna', $user->id_pengguna)->count(),
            'menunggu_pembayaran' => Pesanan::where('id_pengguna', $user->id_pengguna)
                ->where('status', 'menunggu_pembayaran')->count(),
            'dikonfirmasi' => Pesanan::where('id_pengguna', $user->id_pengguna)
                ->where('status', 'dikonfirmasi')->count(),
            'diproses' => Pesanan::where('id_pengguna', $user->id_pengguna)
                ->where('status', 'diproses')->count(),
            'dimasak' => Pesanan::where('id_pengguna', $user->id_pengguna)
                ->where('status', 'dimasak')->count(),
            'siap_diantar' => Pesanan::where('id_pengguna', $user->id_pengguna)
                ->where('status', 'siap_diantar')->count(),
            'diantar' => Pesanan::where('id_pengguna', $user->id_pengguna)
                ->where('status', 'diantar')->count(),
            'selesai' => Pesanan::where('id_pengguna', $user->id_pengguna)
                ->where('status', 'selesai')->count(),
            'dibatalkan' => Pesanan::where('id_pengguna', $user->id_pengguna)
                ->where('status', 'dibatalkan')->count(),
        ];
        
        return view('pesanan', compact('pesanan', 'statusCounts', 'status'));
    }
    
    /**
     * DETAIL PESANAN
     */
    public function show($id)
    {
        $user = Auth::user();
        $pesanan = Pesanan::where('id_pengguna', $user->id_pengguna)
            ->with(['pembayaran', 'details'])
            ->findOrFail($id);
            
        return view('pesanan.detail', compact('pesanan'));
    }
    
    /**
     * BATAL PESANAN
     */
    public function batal(Request $request, $id)
    {
        $user = Auth::user();
        
        DB::beginTransaction();
        try {
            $pesanan = Pesanan::where('id_pengguna', $user->id_pengguna)
                ->where('status', 'menunggu_pembayaran')
                ->findOrFail($id);
            
            // Kembalikan stok
            foreach ($pesanan->details as $detail) {
                $varian = VarianMenu::find($detail->id_varian);
                if ($varian) {
                    $varian->increment('stok', $detail->jumlah);
                }
            }
            
            // Update status pesanan
            $pesanan->update([
                'status' => 'dibatalkan',
            ]);
            
            // Update status pembayaran jika ada
            if ($pesanan->pembayaran) {
                $pesanan->pembayaran()->update([
                    'status_pembayaran' => 'dibatalkan',
                    'tanggal_pembayaran' => now()
                ]);
            }
            
            DB::commit();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pesanan berhasil dibatalkan.',
                    'redirect_url' => route('pesanan')
                ]);
            }
            
            return redirect()->route('pesanan')
                ->with('success', 'Pesanan berhasil dibatalkan.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membatalkan pesanan: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Gagal membatalkan pesanan: ' . $e->getMessage());
        }
    }
    
    /**
     * BAYAR PESANAN - FIXED VERSION untuk VARCHAR
     */
    public function bayar(Request $request, $id)
    {
        Log::info('=== PROSES PEMBAYARAN DIMULAI ===');
        Log::info('User ID: ' . Auth::id());
        Log::info('Pesanan ID: ' . $id);
        
        $user = Auth::user();
        
        DB::beginTransaction();
        try {
            $pesanan = Pesanan::where('id_pengguna', $user->id_pengguna)
                ->where('status', 'menunggu_pembayaran')
                ->with('pembayaran')
                ->find($id);
                
            if (!$pesanan) {
                Log::warning('Pesanan tidak ditemukan atau tidak dalam status menunggu_pembayaran');
                throw new \Exception('Pesanan tidak ditemukan atau tidak dapat dibayar');
            }
            
            $pembayaran = $pesanan->pembayaran;
            
            if (!$pembayaran) {
                Log::warning('Data pembayaran tidak ditemukan, membuat baru...');
                
                // Buat data pembayaran baru dengan metode default COD
                $pembayaran = Pembayaran::create([
                    'id_pesanan' => $pesanan->id_pesanan,
                    'metode_pembayaran' => 'cod',
                    'metode_pembayaran_string' => 'cod',
                    'status_pembayaran' => 'menunggu',
                    'jumlah' => $pesanan->total_bayar,
                    'id_transaksi' => 'TXN' . date('YmdHis') . rand(100, 999),
                ]);
                
                Log::info('Pembayaran baru dibuat:', [
                    'id' => $pembayaran->id_pembayaran,
                    'metode' => 'cod'
                ]);
            }
            
            // Cek metode pembayaran
            $metode = $pembayaran->metode_pembayaran_string ?? $pembayaran->metode_pembayaran;
            
            if ($metode == 'cod') {
                Log::info('Metode pembayaran: COD');
                
                // Untuk COD, langsung selesaikan pembayaran
                $pesanan->update([
                    'status' => 'dikonfirmasi',
                ]);
                
                $pembayaran->update([
                    'status_pembayaran' => 'dibayar',
                    'tanggal_pembayaran' => now()
                ]);
                
                $message = 'Pembayaran COD berhasil dikonfirmasi. Pesanan akan segera diproses.';
                $redirectUrl = route('pesanan');
                
                Log::info('Pembayaran COD berhasil diproses');
                
            } else {
                Log::info('Metode pembayaran non-COD:', ['metode' => $metode]);
                
                // Untuk non-COD, redirect ke upload bukti
                $message = 'Silakan upload bukti pembayaran.';
                $redirectUrl = route('pesanan.upload-bukti', $pesanan->id_pesanan);
                
                Log::info('Redirect ke upload bukti:', ['url' => $redirectUrl]);
            }
            
            DB::commit();
            
            Log::info('=== PROSES PEMBAYARAN BERHASIL ===');
            
            return response()->json([
                'success' => true,
                'message' => $message,
                'redirect_url' => $redirectUrl
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('=== PROSES PEMBAYARAN GAGAL ===');
            Log::error('Error: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * SELESAI PESANAN
     */
    public function selesai(Request $request, $id)
    {
        $user = Auth::user();
        
        DB::beginTransaction();
        try {
            $pesanan = Pesanan::where('id_pengguna', $user->id_pengguna)
                ->where('status', 'diantar')
                ->findOrFail($id);
            
            $pesanan->update(['status' => 'selesai']);
            
            DB::commit();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pesanan berhasil dikonfirmasi selesai.'
                ]);
            }
            
            return redirect()->route('pesanan')
                ->with('success', 'Pesanan berhasil dikonfirmasi selesai.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengkonfirmasi pesanan: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Gagal mengkonfirmasi pesanan: ' . $e->getMessage());
        }
    }
    
    /**
     * PESAN ULANG
     */
    public function ulang(Request $request, $id)
    {
        $user = Auth::user();
        
        DB::beginTransaction();
        try {
            $pesanan = Pesanan::where('id_pengguna', $user->id_pengguna)
                ->with('details')
                ->findOrFail($id);
            
            $cart = session()->get('cart', []);
            $itemsAdded = 0;
            
            foreach ($pesanan->details as $detail) {
                $varian = VarianMenu::find($detail->id_varian);
                
                if (!$varian) {
                    continue;
                }
                
                // Cek stok
                if ($varian->stok < $detail->jumlah) {
                    continue;
                }
                
                $cartKey = $detail->id_varian;
                
                if (isset($cart[$cartKey])) {
                    $cart[$cartKey]['jumlah'] += $detail->jumlah;
                } else {
                    $cart[$cartKey] = [
                        'id_varian' => $detail->id_varian,
                        'nama_menu' => $varian->menu->nama_menu ?? 'Dimsum',
                        'ukuran' => $varian->ukuran,
                        'jumlah_pcs' => $varian->jumlah_pcs,
                        'harga' => $varian->harga,
                        'jumlah' => $detail->jumlah,
                        'catatan' => $detail->catatan,
                        'subtotal' => $varian->harga * $detail->jumlah
                    ];
                }
                
                $itemsAdded++;
            }
            
            session()->put('cart', $cart);
            DB::commit();
            
            $message = 'Berhasil menambahkan ' . $itemsAdded . ' item ke keranjang!';
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'cart_count' => count($cart),
                    'message' => $message
                ]);
            }
            
            return redirect()->route('keranjang')
                ->with('success', $message);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memesan ulang: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Gagal memesan ulang: ' . $e->getMessage());
        }
    }
    
    /**
     * PEMBAYARAN PAGE
     */
    public function pembayaran($id)
    {
        $user = Auth::user();
        $pesanan = Pesanan::where('id_pengguna', $user->id_pengguna)
            ->with('pembayaran')
            ->findOrFail($id);
        
        // Cek kadaluarsa
        if ($pesanan->status == 'menunggu_pembayaran') {
            $expiredAt = Carbon::parse($pesanan->created_at)->addHours(1.5);
            
            if (Carbon::now()->gt($expiredAt)) {
                // Batalkan otomatis
                DB::beginTransaction();
                try {
                    // Kembalikan stok
                    foreach ($pesanan->details as $detail) {
                        $varian = VarianMenu::find($detail->id_varian);
                        if ($varian) {
                            $varian->increment('stok', $detail->jumlah);
                        }
                    }
                    
                    $pesanan->update(['status' => 'dibatalkan']);
                    
                    if ($pesanan->pembayaran) {
                        $pesanan->pembayaran()->update([
                            'status_pembayaran' => 'dibatalkan',
                            'tanggal_pembayaran' => now()
                        ]);
                    }
                    
                    DB::commit();
                    
                    return redirect()->route('pesanan')
                        ->with('error', 'Pesanan telah kadaluarsa karena belum dibayar dalam 1.5 jam.');
                } catch (\Exception $e) {
                    DB::rollBack();
                }
            }
        }
        
        return view('pembayaran', compact('pesanan'));
    }
    
    /**
     * UPLOAD BUKTI PEMBAYARAN
     */
    public function uploadBukti($id)
    {
        $user = Auth::user();
        $pesanan = Pesanan::where('id_pengguna', $user->id_pengguna)
            ->with('pembayaran')
            ->findOrFail($id);
        
        // Pastikan hanya bisa upload jika status menunggu pembayaran
        if ($pesanan->status !== 'menunggu_pembayaran') {
            return redirect()->route('pesanan')
                ->with('error', 'Pesanan tidak dapat diupload bukti pembayaran.');
        }
        
        // Pastikan metode pembayaran bukan COD
        if ($pesanan->pembayaran && $pesanan->pembayaran->metode_pembayaran == 'cod') {
            return redirect()->route('pesanan')
                ->with('error', 'Metode pembayaran COD tidak memerlukan upload bukti.');
        }
        
        return view('pesanan.upload-bukti', compact('pesanan'));
    }
    
    /**
     * SIMPAN BUKTI PEMBAYARAN - VERSION YANG BISA HANDLE KEDUA FORMAT
     * (dari halaman pesanan DAN dari checkout)
     */
    public function simpanBuktiValidStatus(Request $request, $id = null)
    {
        DB::beginTransaction();
        try {
            Log::info('=== SIMPAN BUKTI PEMBAYARAN DIMULAI ===');
            Log::info('Request data:', [
                'all' => $request->all(),
                'files' => $request->file() ? array_keys($request->file()) : 'no files',
                'has_payment_proof' => $request->hasFile('payment_proof'),
                'has_bukti_pembayaran' => $request->hasFile('bukti_pembayaran'),
                'order_number' => $request->order_number,
                'payment_method' => $request->payment_method
            ]);
            
            $user = Auth::user();
            
            // Cari pesanan berdasarkan ID atau nomor pesanan
            if ($id) {
                // Jika ada ID langsung dari route (halaman pesanan)
                $pesanan = Pesanan::where('id_pesanan', $id)
                                 ->where('id_pengguna', $user->id_pengguna)
                                 ->first();
                
                if (!$pesanan) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Pesanan tidak ditemukan'
                    ], 404);
                }
            } else if ($request->has('order_number')) {
                // Jika dari checkout dengan nomor pesanan
                $pesanan = Pesanan::where('nomor_pesanan', $request->order_number)
                                 ->where('id_pengguna', $user->id_pengguna)
                                 ->first();
                
                if (!$pesanan) {
                    Log::warning('Pesanan tidak ditemukan dengan nomor: ' . $request->order_number);
                    return response()->json([
                        'success' => false,
                        'message' => 'Pesanan tidak ditemukan dengan nomor: ' . $request->order_number
                    ], 404);
                }
                
                $id = $pesanan->id_pesanan;
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Parameter tidak lengkap'
                ], 400);
            }
            
            // Cek file yang dikirim (handle kedua format)
            $file = null;
            $fileField = null;
            
            if ($request->hasFile('payment_proof')) {
                // Format dari checkout.blade.php
                $file = $request->file('payment_proof');
                $fileField = 'payment_proof';
                $paymentMethod = $request->payment_method;
            } elseif ($request->hasFile('bukti_pembayaran')) {
                // Format dari halaman pesanan (upload-bukti.blade.php)
                $file = $request->file('bukti_pembayaran');
                $fileField = 'bukti_pembayaran';
                $paymentMethod = $pesanan->pembayaran ? ($pesanan->pembayaran->metode_pembayaran_string ?? $pesanan->pembayaran->metode_pembayaran) : 'transfer';
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'File bukti pembayaran tidak ditemukan. Harap pilih file.'
                ], 400);
            }
            
            Log::info('File ditemukan:', [
                'field' => $fileField,
                'filename' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime' => $file->getMimeType()
            ]);
            
            // Validasi file
            $validated = $request->validate([
                $fileField => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            ]);
            
            Log::info('Validasi file berhasil');
            
            // Cek status pesanan
            if ($pesanan->status !== 'menunggu_pembayaran') {
                Log::warning('Pesanan tidak dalam status menunggu pembayaran: ' . $pesanan->status);
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan tidak dalam status menunggu pembayaran'
                ], 400);
            }
            
            // Upload file bukti pembayaran
            $filename = 'payment_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('payment_proofs', $filename, 'public');
            
            Log::info('File berhasil diupload:', [
                'filename' => $filename,
                'path' => $path,
                'size' => $file->getSize()
            ]);
            
            // Cek apakah sudah ada data pembayaran
            $pembayaran = Pembayaran::where('id_pesanan', $pesanan->id_pesanan)->first();
            
            if ($pembayaran) {
                // Update pembayaran yang sudah ada
                $pembayaran->update([
                    'bukti_bayar' => $path,
                    'status_pembayaran' => 'dibayar',
                    'tanggal_pembayaran' => now(),
                    'metode_pembayaran' => $paymentMethod,
                ]);
            } else {
                // Buat pembayaran baru
                $pembayaran = Pembayaran::create([
                    'id_pesanan' => $pesanan->id_pesanan,
                    'metode_pembayaran' => $paymentMethod,
                    'jumlah' => $pesanan->total_bayar,
                    'bukti_bayar' => $path,
                    'status_pembayaran' => 'dibayar',
                    'tanggal_pembayaran' => now(),
                    'id_transaksi' => 'TXN' . date('YmdHis') . rand(100, 999)
                ]);
            }
            
            // Update status pesanan
            $pesanan->update([
                'status' => 'dikonfirmasi'
            ]);
            
            Log::info('Pesanan berhasil diperbarui:', [
                'order_id' => $pesanan->id_pesanan,
                'new_status' => $pesanan->status,
                'payment_id' => $pembayaran->id_pembayaran
            ]);
            
            // Kirim notifikasi ke admin (opsional)
            $this->kirimNotifikasiWhatsApp($pesanan);
            
            DB::commit();
            
            Log::info('=== SIMPAN BUKTI PEMBAYARAN BERHASIL ===');
            
            // Return response berdasarkan request type
            if ($request->expectsJson()) {
                // Untuk AJAX request dari checkout
                return response()->json([
                    'success' => true,
                    'message' => 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.',
                    'order_id' => $pesanan->id_pesanan,
                    'order_status' => $pesanan->status
                ]);
            } else {
                // Untuk form submit dari halaman pesanan
                return redirect()->route('pesanan')
                    ->with('success', 'Bukti pembayaran berhasil diupload. Status: Menunggu verifikasi admin.');
            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            
            Log::error('Validasi gagal:', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            
            $errorMessage = implode(', ', array_merge(...array_values($e->errors())));
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal: ' . $errorMessage
                ], 422);
            } else {
                return back()->with('error', 'Validasi gagal: ' . $errorMessage);
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error saving payment proof: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            } else {
                return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }
    }
    
    /**
     * KIRIM NOTIFIKASI WHATSAPP
     */
    private function kirimNotifikasiWhatsApp($pesanan)
    {
        try {
            $message = "📱 *NOTIFIKASI BUKTI PEMBAYARAN BARU*\n" .
                      "==========================\n" .
                      "Nomor Pesanan: {$pesanan->nomor_pesanan}\n" .
                      "Nama: {$pesanan->nama_penerima}\n" .
                      "Total: Rp" . number_format($pesanan->total_bayar, 0, ',', '.') . "\n" .
                      "Waktu: " . now()->format('d/m/Y H:i:s') . "\n" .
                      "Status: Menunggu Verifikasi\n" .
                      "==========================";
            
            Log::info('WhatsApp Notification (inline): ' . $message);
            
            // Ambil admin users
            //$adminUsers = \App\Models\User::where('peran', 'admin')->get();
            
        } catch (\Exception $e) {
            Log::error('Gagal kirim notifikasi WhatsApp (inline): ' . $e->getMessage());
        }
    }
    
    /**
     * DETAIL PESANAN
     */
    public function detail($id)
    {
        return $this->show($id);
    }
    
    /**
     * CANCEL PESANAN
     */
    public function cancel(Request $request, $id)
    {
        return $this->batal($request, $id);
    }
    
    /**
     * PESAN ULANG
     */
    public function pesanUlang(Request $request, $id)
    {
        return $this->ulang($request, $id);
    }
}