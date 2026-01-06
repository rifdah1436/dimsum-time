<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Pembayaran;
use App\Models\Pengguna;
use App\Models\Menu;
use App\Models\VarianMenu;
use App\Models\KategoriMenu;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KasirController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('kasir');
    }

    /**
     * Dashboard utama kasir
     */
    public function dashboard(Request $request)
    {
        try {
            // Query untuk pesanan
            $query = Pesanan::with(['user', 'pembayaran', 'details.varian.menu'])
                ->orderBy('created_at', 'desc');

            // Filter berdasarkan status pesanan
            if ($request->has('status') && $request->status) {
                $query->where('status', $request->status);
            }

            // Filter berdasarkan status pembayaran
            if ($request->has('payment_status') && $request->payment_status) {
                $query->whereHas('pembayaran', function($q) use ($request) {
                    $q->where('status_pembayaran', $request->payment_status);
                });
            }

            // Filter berdasarkan tanggal
            if ($request->has('date') && $request->date) {
                $query->whereDate('tanggal_pesanan', $request->date);
            }

            // Filter berdasarkan metode pengiriman
            if ($request->has('delivery_method') && $request->delivery_method) {
                $query->where('jenis_pengiriman', $request->delivery_method);
            }

            // Search
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('nomor_pesanan', 'like', "%{$search}%")
                      ->orWhere('nama_penerima', 'like', "%{$search}%")
                      ->orWhere('nomor_telepon', 'like', "%{$search}%")
                      ->orWhere('id_pesanan', 'like', "%{$search}%");
                });
            }

            $pesanan = $query->paginate(15);

            // Statistik untuk kasir
            $statistik = [
                'total_pesanan' => Pesanan::count(),
                'menunggu_pembayaran' => Pesanan::where('status', 'menunggu_pembayaran')->count(),
                'dikonfirmasi' => Pesanan::where('status', 'dikonfirmasi')->count(),
                'diproses' => Pesanan::where('status', 'diproses')->count(),
                'dimasak' => Pesanan::where('status', 'dimasak')->count(),
                'siap_diambil' => Pesanan::where('status', 'siap_diambil')->count(),
                'diantar' => Pesanan::where('status', 'diantar')->count(),
                'selesai' => Pesanan::where('status', 'selesai')->count(),
                'pendapatan_hari_ini' => Pesanan::where('status', 'selesai')
                    ->whereDate('tanggal_pesanan', today())
                    ->sum('total_bayar') ?? 0,
            ];

            // Status options - sesuai dengan database
            $statusOptions = [
                'menunggu_pembayaran' => 'Menunggu Pembayaran',
                'dikonfirmasi' => 'Dikonfirmasi',
                'diproses' => 'Diproses',
                'dimasak' => 'Dimasak',
                'siap_diambil' => 'Siap Diambil',
                'diantar' => 'Diantar',
                'selesai' => 'Selesai',
                'dibatalkan' => 'Dibatalkan',
            ];

            // Metode pembayaran options - sesuai dengan database
            $paymentMethods = [
                'cod' => 'Cash on Delivery (COD)',
                'ovo' => 'OVO',
                'gopay' => 'GoPay',
                'dana' => 'DANA',
                'shopeepay' => 'ShopeePay',
                'bca' => 'Transfer BCA',
                'mandiri' => 'Transfer Mandiri',
                'bri' => 'Transfer BRI',
                'bni' => 'Transfer BNI',
                'cash' => 'Tunai (Cash)',
            ];

            // Status pembayaran options - sesuai dengan database
            $paymentStatusOptions = [
                'menunggu' => 'Menunggu Pembayaran',
                'menunggu_verifikasi' => 'Menunggu Verifikasi',
                'dibayar' => 'Sudah Dibayar',
                'gagal' => 'Pembayaran Gagal',
                'dibatalkan' => 'Dibatalkan',
            ];

            return view('kasir.dashboard', compact(
                'pesanan', 
                'statistik', 
                'statusOptions', 
                'paymentMethods', 
                'paymentStatusOptions'
            ));

        } catch (\Exception $e) {
            Log::error('Kasir Dashboard Error: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Terjadi kesalahan saat memuat dashboard.');
        }
    }

    /**
     * Get detail pesanan untuk modal
     */
    public function getOrderDetail($id_pesanan)
    {
        try {
            $pesanan = Pesanan::with([
                'user',
                'pembayaran',
                'details' => function($q) {
                    $q->with(['varian' => function($q2) {
                        $q2->with('menu');
                    }]);
                }
            ])->findOrFail($id_pesanan);

            return response()->json([
                'success' => true,
                'data' => $pesanan
            ]);

        } catch (\Exception $e) {
            Log::error('Get Order Detail Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat detail pesanan.'
            ], 500);
        }
    }

    /**
     * Get detail pembayaran untuk modal
     */
    public function getPaymentDetail($id_pesanan)
    {
        try {
            $pembayaran = Pembayaran::where('id_pesanan', $id_pesanan)->first();
            $pesanan = Pesanan::find($id_pesanan);

            if (!$pembayaran) {
                // Buat record pembayaran jika belum ada
                $pembayaran = Pembayaran::create([
                    'id_pesanan' => $id_pesanan,
                    'metode_pembayaran' => 'cash', // default cash
                    'status_pembayaran' => 'menunggu',
                    'jumlah' => $pesanan->total_bayar,
                ]);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'pembayaran' => $pembayaran,
                    'pesanan' => $pesanan
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Get Payment Detail Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat detail pembayaran.'
            ], 500);
        }
    }

    /**
     * Update status pesanan
     */
    public function updateOrderStatus(Request $request, $id_pesanan)
    {
        $request->validate([
            'status' => 'required|in:menunggu_pembayaran,dikonfirmasi,diproses,dimasak,siap_diambil,diantar,selesai,dibatalkan',
            'catatan' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();
            
            $pesanan = Pesanan::with(['details.varian'])->findOrFail($id_pesanan);
            
            // Simpan status lama untuk log
            $oldStatus = $pesanan->status;
            $newStatus = $request->status;
            
            // Update status
            $pesanan->status = $newStatus;
            
            // Logika khusus untuk status tertentu
            switch ($newStatus) {
                case 'diantar':
                    $pesanan->tanggal_pengiriman = now();
                    break;
                    
                case 'selesai':
                    // Update status pembayaran jika belum selesai
                    $pembayaran = Pembayaran::where('id_pesanan', $id_pesanan)->first();
                    if ($pembayaran && $pembayaran->status_pembayaran === 'menunggu') {
                        $pembayaran->status_pembayaran = 'dibayar';
                        $pembayaran->tanggal_pembayaran = now();
                        $pembayaran->save();
                    }
                    break;
                    
                case 'dikonfirmasi':
                    // Kurangi stok ketika dikonfirmasi
                    $this->kurangiStok($pesanan);
                    break;
                    
                case 'dibatalkan':
                    // Kembalikan stok jika dibatalkan
                    $this->kembalikanStok($pesanan);
                    break;
            }
            
            // Update catatan jika ada
            if ($request->filled('catatan')) {
                $pesanan->catatan_pelanggan = ($pesanan->catatan_pelanggan ?? '') . "\n[Kasir]: " . $request->catatan;
            }
            
            $pesanan->save();
            
            DB::commit();

            // Log perubahan status
            Log::info('Status pesanan diupdate oleh kasir', [
                'kasir_id' => Auth::id(),
                'pesanan_id' => $id_pesanan,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status pesanan berhasil diupdate!',
                'data' => [
                    'status' => $newStatus,
                    'status_text' => $this->getStatusText($newStatus),
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Update Status Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update pembayaran
     */
    public function updatePayment(Request $request, $id_pesanan)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:cash,cod,ovo,gopay,dana,shopeepay,bca,mandiri,bri,bni',
            'status_pembayaran' => 'required|in:menunggu,menunggu_verifikasi,dibayar,gagal,dibatalkan',
            'id_transaksi' => 'nullable|string|max:100',
            'catatan' => 'nullable|string|max:500',
            'bukti_pembayaran' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        try {
            DB::beginTransaction();
            
            $pembayaran = Pembayaran::where('id_pesanan', $id_pesanan)->firstOrFail();
            $oldStatus = $pembayaran->status_pembayaran;
            
            // Update data pembayaran
            $pembayaran->metode_pembayaran = $request->metode_pembayaran;
            $pembayaran->status_pembayaran = $request->status_pembayaran;
            $pembayaran->id_transaksi = $request->id_transaksi;
            $pembayaran->catatan = $request->catatan;
            
            // Upload bukti pembayaran jika ada
            if ($request->hasFile('bukti_pembayaran')) {
                // Hapus file lama jika ada
                if ($pembayaran->bukti_pembayaran && Storage::disk('public')->exists($pembayaran->bukti_pembayaran)) {
                    Storage::disk('public')->delete($pembayaran->bukti_pembayaran);
                }
                
                $file = $request->file('bukti_pembayaran');
                $filename = 'payment_' . time() . '_' . $id_pesanan . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('bukti_pembayaran', $filename, 'public');
                $pembayaran->bukti_pembayaran = $path;
            }
            
            // Jika status pembayaran berubah menjadi dibayar
            if ($request->status_pembayaran == 'dibayar' && $oldStatus != 'dibayar') {
                $pembayaran->tanggal_pembayaran = now();
                
                // Update status pesanan menjadi dikonfirmasi jika masih menunggu pembayaran
                $pesanan = Pesanan::find($id_pesanan);
                if ($pesanan && $pesanan->status == 'menunggu_pembayaran') {
                    $pesanan->status = 'dikonfirmasi';
                    
                    // Kurangi stok
                    $this->kurangiStok($pesanan);
                    
                    $pesanan->save();
                }
            }
            
            $pembayaran->save();
            
            DB::commit();

            // Log perubahan pembayaran
            Log::info('Pembayaran diupdate oleh kasir', [
                'kasir_id' => Auth::id(),
                'pesanan_id' => $id_pesanan,
                'old_status' => $oldStatus,
                'new_status' => $request->status_pembayaran,
                'metode' => $request->metode_pembayaran,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data pembayaran berhasil diupdate!',
                'data' => $pembayaran
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Update Payment Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Proses pembayaran COD/cash (langsung dibayar)
     */
    public function processCashPayment(Request $request, $id_pesanan)
    {
        try {
            DB::beginTransaction();
            
            $pesanan = Pesanan::with(['details.varian'])->findOrFail($id_pesanan);
            
            // Cek apakah sudah ada pembayaran
            $pembayaran = Pembayaran::where('id_pesanan', $id_pesanan)->first();
            
            if (!$pembayaran) {
                $pembayaran = new Pembayaran();
                $pembayaran->id_pesanan = $id_pesanan;
            }
            
            // Set pembayaran cash
            $pembayaran->metode_pembayaran = 'cash';
            $pembayaran->status_pembayaran = 'dibayar';
            $pembayaran->jumlah = $pesanan->total_bayar;
            $pembayaran->tanggal_pembayaran = now();
            $pembayaran->catatan = 'Pembayaran tunai di kasir - Diproses oleh ' . Auth::user()->nama_lengkap;
            $pembayaran->save();
            
            // Update status pesanan
            if ($pesanan->status == 'menunggu_pembayaran') {
                $pesanan->status = 'dikonfirmasi';
                
                // Kurangi stok
                $this->kurangiStok($pesanan);
            }
            
            $pesanan->save();
            
            DB::commit();

            // Log pembayaran cash
            Log::info('Pembayaran cash diproses oleh kasir', [
                'kasir_id' => Auth::id(),
                'pesanan_id' => $id_pesanan,
                'total' => $pesanan->total_bayar,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran tunai berhasil diproses!',
                'data' => $pembayaran
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Process Cash Payment Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * View untuk laporan harian
     */
    public function dailyReport(Request $request)
    {
        try {
            $date = $request->get('date', today()->format('Y-m-d'));
            
            $pesanan = Pesanan::with('pembayaran')
                ->whereDate('tanggal_pesanan', $date)
                ->where('status', 'selesai')
                ->get();
            
            $totalPendapatan = $pesanan->sum('total_bayar');
            $totalPesanan = $pesanan->count();
            
            // Group by metode pembayaran
            $paymentMethods = [
                'cash' => $pesanan->where('pembayaran.metode_pembayaran', 'cash')->count(),
                'cod' => $pesanan->where('pembayaran.metode_pembayaran', 'cod')->count(),
                'ovo' => $pesanan->where('pembayaran.metode_pembayaran', 'ovo')->count(),
                'gopay' => $pesanan->where('pembayaran.metode_pembayaran', 'gopay')->count(),
                'dana' => $pesanan->where('pembayaran.metode_pembayaran', 'dana')->count(),
                'shopeepay' => $pesanan->where('pembayaran.metode_pembayaran', 'shopeepay')->count(),
                'transfer' => $pesanan->whereIn('pembayaran.metode_pembayaran', ['bca', 'mandiri', 'bri', 'bni'])->count(),
            ];

            return view('kasir.report', compact('pesanan', 'totalPendapatan', 'totalPesanan', 'paymentMethods', 'date'));

        } catch (\Exception $e) {
            Log::error('Daily Report Error: ' . $e->getMessage());
            return redirect()->route('kasir.dashboard')->with('error', 'Gagal memuat laporan harian.');
        }
    }

    /**
     * Cetak invoice/struk
     */
    public function printInvoice($id_pesanan)
    {
        try {
            $pesanan = Pesanan::with([
                'pembayaran',
                'details' => function($q) {
                    $q->with('varian.menu');
                },
                'user'
            ])->findOrFail($id_pesanan);

            return view('kasir.invoice', compact('pesanan'));

        } catch (\Exception $e) {
            Log::error('Print Invoice Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal mencetak invoice.');
        }
    }

    /**
     * View untuk melihat menu (read-only)
     */
    public function viewMenu(Request $request)
    {
        try {
            $query = Menu::with(['kategori', 'varian'])
                ->where('status_tersedia', true)
                ->orderBy('nama_menu');

            // Filter pencarian
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('nama_menu', 'like', "%{$search}%")
                      ->orWhere('deskripsi', 'like', "%{$search}%")
                      ->orWhereHas('kategori', function($q) use ($search) {
                          $q->where('nama_kategori', 'like', "%{$search}%");
                      });
                });
            }

            // Filter kategori
            if ($request->has('kategori') && $request->kategori) {
                $query->where('id_kategori', $request->kategori);
            }

            $produk = $query->paginate(20);
            $kategori = KategoriMenu::orderBy('nama_kategori')->get();

            return view('kasir.menu.index', compact('produk', 'kategori'));

        } catch (\Exception $e) {
            Log::error('View Menu Error: ' . $e->getMessage());
            return redirect()->route('kasir.dashboard')->with('error', 'Gagal memuat daftar menu.');
        }
    }

    /**
     * View untuk melihat detail menu (read-only)
     */
    public function viewMenuDetail($id)
    {
        try {
            $produk = Menu::with(['kategori', 'varian'])->findOrFail($id);
            return view('kasir.menu.detail', compact('produk'));

        } catch (\Exception $e) {
            Log::error('View Menu Detail Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat detail menu.');
        }
    }

    /**
     * Helper: Kurangi stok saat pesanan dikonfirmasi
     */
    private function kurangiStok($pesanan)
    {
        try {
            foreach ($pesanan->details as $detail) {
                $varian = VarianMenu::find($detail->id_varian);
                if ($varian) {
                    if ($varian->stok < $detail->jumlah) {
                        throw new \Exception("Stok {$varian->nama_varian} tidak cukup. Tersedia: {$varian->stok}, Dibutuhkan: {$detail->jumlah}");
                    }
                    $varian->stok -= $detail->jumlah;
                    $varian->save();
                    
                    Log::info("Stok dikurangi oleh kasir: {$varian->nama_varian} -{$detail->jumlah}, sisa: {$varian->stok}");
                }
            }
            
        } catch (\Exception $e) {
            Log::error('Kurangi Stok Error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Helper: Kembalikan stok saat pesanan dibatalkan
     */
    private function kembalikanStok($pesanan)
    {
        try {
            foreach ($pesanan->details as $detail) {
                $varian = VarianMenu::find($detail->id_varian);
                if ($varian) {
                    $varian->stok += $detail->jumlah;
                    $varian->save();
                    
                    Log::info("Stok dikembalikan oleh kasir: {$varian->nama_varian} +{$detail->jumlah}, total: {$varian->stok}");
                }
            }
            
        } catch (\Exception $e) {
            Log::error('Kembalikan Stok Error: ' . $e->getMessage());
            // Tetap lanjutkan meskipun ada error di pengembalian stok
        }
    }

    /**
     * Helper: Get status text
     */
    private function getStatusText($status)
    {
        $statusMap = [
            'menunggu_pembayaran' => 'Menunggu Pembayaran',
            'dikonfirmasi' => 'Dikonfirmasi',
            'diproses' => 'Diproses',
            'dimasak' => 'Dimasak',
            'siap_diambil' => 'Siap Diambil',
            'diantar' => 'Diantar',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
        ];
        
        return $statusMap[$status] ?? $status;
    }

    /**
     * View untuk melihat laporan stok (read-only)
     */
    public function viewStockReport(Request $request)
    {
        try {
            $query = VarianMenu::with('menu')
                ->orderBy('stok', 'asc');

            // Filter pencarian
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->whereHas('menu', function($q) use ($search) {
                        $q->where('nama_menu', 'like', "%{$search}%");
                    })
                    ->orWhere('ukuran', 'like', "%{$search}%");
                });
            }

            // Filter stok minimum
            if ($request->has('low_stock') && $request->low_stock) {
                $query->whereRaw('stok <= stok_minimum');
            }

            $varian = $query->paginate(20);
            
            // Hitung statistik stok
            $totalProducts = $varian->count();
            $lowStockCount = VarianMenu::whereRaw('stok <= stok_minimum')->count();
            $outOfStockCount = VarianMenu::where('stok', 0)->count();

            return view('kasir.stock.index', compact('varian', 'totalProducts', 'lowStockCount', 'outOfStockCount'));

        } catch (\Exception $e) {
            Log::error('View Stock Report Error: ' . $e->getMessage());
            return redirect()->route('kasir.dashboard')->with('error', 'Gagal memuat laporan stok.');
        }
    }

    /**
     * View untuk melihat pesanan berdasarkan status (filtered)
     */
    public function viewOrdersByStatus($status)
    {
        try {
            $validStatuses = ['menunggu_pembayaran', 'dikonfirmasi', 'diproses', 'dimasak', 'siap_diambil', 'diantar', 'selesai', 'dibatalkan'];
            
            if (!in_array($status, $validStatuses)) {
                return redirect()->route('kasir.dashboard')->with('error', 'Status tidak valid.');
            }

            $pesanan = Pesanan::with(['user', 'pembayaran'])
                ->where('status', $status)
                ->orderBy('tanggal_pesanan', 'desc')
                ->paginate(15);

            $statusText = $this->getStatusText($status);

            return view('kasir.orders.by_status', compact('pesanan', 'status', 'statusText'));

        } catch (\Exception $e) {
            Log::error('View Orders By Status Error: ' . $e->getMessage());
            return redirect()->route('kasir.dashboard')->with('error', 'Gagal memuat pesanan.');
        }
    }
}