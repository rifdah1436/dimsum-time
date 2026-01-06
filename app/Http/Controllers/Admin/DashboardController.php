<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\Pembayaran;
use App\Models\PesananDetail as DetailPesanan;
use App\Models\VarianMenu;
use App\Models\KategoriMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard admin
     */
    public function dashboard()
    {
        try {
            // Statistik utama
            $totalMenu = Menu::count();
            $pesananHariIni = Pesanan::whereDate('tanggal_pesanan', today())->count();
            $totalPelanggan = Pengguna::where('peran', 'pelanggan')->count();
            $pendapatanHariIni = Pesanan::whereDate('tanggal_pesanan', today())
                ->where('status', 'selesai')
                ->sum('total_bayar') ?? 0;

            // Pesanan terbaru (10 pesanan terakhir)
            $pesananTerbaru = Pesanan::with(['user', 'pembayaran'])
                ->orderBy('tanggal_pesanan', 'desc')
                ->take(10)
                ->get();

            // Grafik pendapatan 7 hari terakhir
            $pendapatanHarian = $this->getPendapatanHarian(7);

            // Menu terlaris 30 hari terakhir
            $menuTerlaris = $this->getMenuTerlaris(30, 5);

            // Distribusi status pesanan
            $statusPesanan = $this->getStatusPesanan();

            // Metode pembayaran popular
            $metodePembayaran = $this->getMetodePembayaranStats();

            // Pesanan yang memerlukan perhatian
            $pesananMenungguKonfirmasi = Pesanan::where('status', 'menunggu_pembayaran')->count();
            $pesananDiproses = Pesanan::whereIn('status', ['dikonfirmasi', 'diproses', 'dimasak'])->count();

            return view('admin.dashboard', compact(
                'totalMenu',
                'pesananHariIni',
                'totalPelanggan',
                'pendapatanHariIni',
                'pesananTerbaru',
                'pendapatanHarian',
                'menuTerlaris',
                'statusPesanan',
                'metodePembayaran',
                'pesananMenungguKonfirmasi',
                'pesananDiproses'
            ));

        } catch (\Exception $e) {
            Log::error('Dashboard Error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
            
            // Fallback data jika error
            return view('admin.dashboard', [
                'totalMenu' => 0,
                'pesananHariIni' => 0,
                'totalPelanggan' => 0,
                'pendapatanHariIni' => 0,
                'pesananTerbaru' => collect(),
                'pendapatanHarian' => collect(),
                'menuTerlaris' => collect(),
                'statusPesanan' => collect(),
                'metodePembayaran' => collect(),
                'pesananMenungguKonfirmasi' => 0,
                'pesananDiproses' => 0
            ])->with('error', 'Terjadi kesalahan saat memuat dashboard. Silakan coba lagi.');
        }
    }

    /**
     * Menampilkan daftar produk
     */
    public function produk(Request $request)
    {
        $query = Menu::with(['kategori', 'variants'])
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

        // Filter status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status_tersedia', $request->status);
        }

        $produk = $query->paginate(20);
        $kategori = KategoriMenu::orderBy('nama_kategori')->get();

        return view('admin.produk.index', compact('produk', 'kategori'));
    }

    /**
     * Menampilkan form tambah produk
     */
    public function createProduk()
    {
        $kategori = KategoriMenu::orderBy('nama_kategori')->get();
        return view('admin.produk.create', compact('kategori'));
    }

    /**
     * Menyimpan produk baru dengan varian
     */
    public function storeProduk(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:100',
            'id_kategori' => 'required|exists:kategori_menu,id_kategori',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status_tersedia' => 'boolean',
            'varian' => 'required|array|min:1',
            'varian.*.ukuran' => 'required|in:S,M,L,XL,Reguler',
            'varian.*.jumlah_pcs' => 'required|integer|min:1',
            'varian.*.harga' => 'required|numeric|min:0',
            'varian.*.stok' => 'nullable|integer|min:0',
            'varian.*.stok_minimum' => 'nullable|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // Data produk
            $data = $request->except(['gambar', 'varian']);
            $data['status_tersedia'] = $request->has('status_tersedia');

            // Handle upload gambar - GUNAKAN Str::slug()
            if ($request->hasFile('gambar')) {
                $filename = time() . '_' . Str()->slug($request->nama_menu) . '.' . $request->gambar->extension();
                $path = $request->gambar->storeAs('produk', $filename, 'public');
                $data['gambar'] = $path;
            }

            // Buat produk
            $produk = Menu::create($data);

            // Buat varian
            foreach ($request->varian as $varianData) {
                VarianMenu::create([
                    'id_menu' => $produk->id_menu,
                    'ukuran' => $varianData['ukuran'],
                    'jumlah_pcs' => $varianData['jumlah_pcs'],
                    'harga' => $varianData['harga'],
                    'stok' => $varianData['stok'] ?? 0,
                    'stok_minimum' => $varianData['stok_minimum'] ?? 10,
                ]);
            }

            DB::commit();

            return redirect()->route('admin.produk.index')
                ->with('success', 'Produk berhasil ditambahkan dengan ' . count($request->varian) . ' varian.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Store Produk Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal menambahkan produk: ' . $e->getMessage())
                        ->withInput();
        }
    }

    /**
     * Menampilkan form edit produk
     */
    public function editProduk($id)
    {
        $produk = Menu::with(['kategori', 'varian'])->findOrFail($id);
        $kategori = KategoriMenu::orderBy('nama_kategori')->get();
        
        return view('admin.produk.edit', compact('produk', 'kategori'));
    }

    /**
     * Update produk
     */
    public function updateProduk(Request $request, $id)
    {
        $produk = Menu::findOrFail($id);

        $request->validate([
            'nama_menu' => 'required|string|max:100',
            'id_kategori' => 'required|exists:kategori_menu,id_kategori',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status_tersedia' => 'boolean'
        ]);

        try {
            $data = $request->except('gambar');
            $data['status_tersedia'] = $request->has('status_tersedia');

            // Handle update gambar - GUNAKAN Str::slug()
            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($produk->gambar && file_exists(public_path('storage/' . $produk->gambar))) {
                    unlink(public_path('storage/' . $produk->gambar));
                }

                $filename = time() . '_' . Str()->slug($request->nama_menu) . '.' . $request->gambar->extension();
                $path = $request->gambar->storeAs('produk', $filename, 'public');
                $data['gambar'] = $path;
            }

            $produk->update($data);

            return redirect()->route('admin.produk.index')
                ->with('success', 'Produk berhasil diperbarui.');

        } catch (\Exception $e) {
            Log::error('Update Produk Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui produk. Silakan coba lagi.');
        }
    }

    /**
     * Hapus produk
     */
    public function destroyProduk($id)
    {
        try {
            $produk = Menu::with(['varian'])->findOrFail($id);
            $jumlahVarian = $produk->varian()->count();
            
            DB::beginTransaction();
            
            // Hapus semua varian terlebih dahulu
            if ($jumlahVarian > 0) {
                $produk->varian()->delete();
                Log::info("Menghapus {$jumlahVarian} varian untuk produk ID: {$id}");
            }
            
            // Hapus gambar jika ada
            if ($produk->gambar && file_exists(public_path('storage/' . $produk->gambar))) {
                unlink(public_path('storage/' . $produk->gambar));
                Log::info("Menghapus gambar produk: {$produk->gambar}");
            }
            
            // Hapus produk
            $produk->delete();
            
            DB::commit();
            
            $message = 'Produk berhasil dihapus';
            if ($jumlahVarian > 0) {
                $message .= " beserta {$jumlahVarian} varian";
            }
            
            return redirect()->route('admin.produk.index')
                ->with('success', $message . '.');
    
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Delete Produk Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }
    
    /**
     * Menampilkan form tambah varian untuk produk
     */
    public function createVarian($id_menu)
    {
        $produk = Menu::findOrFail($id_menu);
        return view('admin.produk.create-varian', compact('produk'));
    }

    /**
     * Menyimpan varian baru
     */
    public function storeVarian(Request $request, $id_menu)
    {
        $produk = Menu::findOrFail($id_menu);

        $request->validate([
            'ukuran' => 'required|in:S,M,L,XL,Reguler',
            'jumlah_pcs' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
            'stok' => 'nullable|integer|min:0',
            'stok_minimum' => 'nullable|integer|min:1',
        ]);

        try {
            VarianMenu::create([
                'id_menu' => $produk->id_menu,
                'ukuran' => $request->ukuran,
                'jumlah_pcs' => $request->jumlah_pcs,
                'harga' => $request->harga,
                'stok' => $request->stok ?? 0,
                'stok_minimum' => $request->stok_minimum ?? 10,
            ]);

            return redirect()->route('admin.produk.edit', $produk->id_menu)
                ->with('success', 'Varian berhasil ditambahkan.');

        } catch (\Exception $e) {
            Log::error('Store Varian Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal menambahkan varian.')
                        ->withInput();
        }
    }

    /**
     * Hapus varian - VERSI PERTAMA
     */
    public function destroyVarian($id)
    {
        try {
            $varian = VarianMenu::findOrFail($id);
            $varian->delete();

            return back()->with('success', 'Varian berhasil dihapus.');

        } catch (\Exception $e) {
            Log::error('Delete Varian Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus varian.');
        }
    }

    /**
     * Update stok varian - VERSI PERTAMA
     */
    public function updateStok(Request $request, $id)
    {
        $request->validate([
            'stok' => 'required|integer|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        try {
            $varian = VarianMenu::findOrFail($id);
            $oldStok = $varian->stok;
            $varian->stok = $request->stok;
            $varian->save();

            // Log perubahan stok
            Log::info("Stok varian {$varian->id_varian} diubah dari {$oldStok} ke {$request->stok}. Keterangan: {$request->keterangan}");

            return back()->with('success', 'Stok berhasil diperbarui.');

        } catch (\Exception $e) {
            Log::error('Update Stok Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui stok.');
        }
    }

    /**
     * Update multiple stok (bulk update)
     */
    public function updateBulkStok(Request $request)
    {
        $request->validate([
            'varian' => 'required|array',
            'varian.*.id' => 'required|exists:varian_menu,id_varian',
            'varian.*.stok' => 'required|integer|min:0',
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->varian as $item) {
                $varian = VarianMenu::find($item['id']);
                if ($varian) {
                    $varian->stok = $item['stok'];
                    $varian->save();
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Stok berhasil diperbarui untuk ' . count($request->varian) . ' varian.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Bulk Update Stok Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui stok.'
            ], 500);
        }
    }
    
    /**
     * Menampilkan halaman edit varian
     */
    public function editVarian($id_menu)
    {
        $produk = Menu::with(['varian'])->findOrFail($id_menu);
        return view('admin.produk.edit-varian', compact('produk'));
    }

    /**
     * Get varian data via AJAX
     */
    public function getVarianData($id_varian)
    {
        try {
            $varian = VarianMenu::findOrFail($id_varian);
            
            return response()->json([
                'success' => true,
                'varian' => [
                    'ukuran' => $varian->ukuran,
                    'jumlah_pcs' => $varian->jumlah_pcs,
                    'harga' => $varian->harga,
                    'stok' => $varian->stok,
                    'stok_minimum' => $varian->stok_minimum,
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Varian tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Update varian - VERSI TERBARU (ganti nama)
     */
    public function updateVarianData(Request $request, $id_varian)
    {
        $request->validate([
            'ukuran' => 'required|in:S,M,L,XL,Reguler',
            'jumlah_pcs' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
            'stok' => 'nullable|integer|min:0',
            'stok_minimum' => 'nullable|integer|min:1',
        ]);

        try {
            $varian = VarianMenu::findOrFail($id_varian);
            
            $varian->update([
                'ukuran' => $request->ukuran,
                'jumlah_pcs' => $request->jumlah_pcs,
                'harga' => $request->harga,
                'stok' => $request->stok ?? $varian->stok, // Only update if provided
                'stok_minimum' => $request->stok_minimum ?? $varian->stok_minimum,
            ]);

            return back()->with('success', 'Varian berhasil diperbarui.');

        } catch (\Exception $e) {
            Log::error('Update Varian Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui varian: ' . $e->getMessage());
        }
    }

    /**
     * Update stok varian - VERSI TERBARU (ganti nama)
     */
    public function updateStokVarian(Request $request, $id_varian)
    {
        $request->validate([
            'stok' => 'required|integer|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        try {
            $varian = VarianMenu::findOrFail($id_varian);
            $oldStok = $varian->stok;
            $varian->stok = $request->stok;
            $varian->save();

            // Log perubahan stok
            Log::info("Stok varian {$varian->id_varian} ({$varian->menu->nama_menu} - {$varian->ukuran}) diubah dari {$oldStok} ke {$request->stok}. Keterangan: {$request->keterangan}");

            return response()->json([
                'success' => true,
                'message' => 'Stok berhasil diperbarui.'
            ]);

        } catch (\Exception $e) {
            Log::error('Update Stok Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui stok: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Quick update stok (tambah/kurang)
     */
    public function quickUpdateStok(Request $request, $id_varian)
    {
        $request->validate([
            'stok' => 'required|integer|min:0',
            'perubahan' => 'nullable|string',
        ]);

        try {
            $varian = VarianMenu::findOrFail($id_varian);
            $varian->stok = $request->stok;
            $varian->save();

            return response()->json([
                'success' => true,
                'message' => 'Stok berhasil diperbarui.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui stok'
            ], 500);
        }
    }

    /**
     * Hapus varian - VERSI TERBARU (ganti nama)
     */
    public function deleteVarian($id_menu, $id_varian)
    {
        try {
            $varian = VarianMenu::where('id_menu', $id_menu)
                ->where('id_varian', $id_varian)
                ->firstOrFail();
            
            $varian->delete();

            return back()->with('success', 'Varian berhasil dihapus.');

        } catch (\Exception $e) {
            Log::error('Delete Varian Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus varian: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan daftar pesanan
     */
    public function pesanan(Request $request)
    {
        $query = Pesanan::with(['user', 'pembayaran', 'details'])
            ->orderBy('tanggal_pesanan', 'desc');

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != 'semua') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal
        if ($request->has('tanggal_dari') && $request->tanggal_dari) {
            $query->whereDate('tanggal_pesanan', '>=', $request->tanggal_dari);
        }

        if ($request->has('tanggal_sampai') && $request->tanggal_sampai) {
            $query->whereDate('tanggal_pesanan', '<=', $request->tanggal_sampai);
        }

        // Filter metode pengiriman
        if ($request->has('jenis_pengiriman') && $request->jenis_pengiriman) {
            $query->where('jenis_pengiriman', $request->jenis_pengiriman);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_pesanan', 'like', "%{$search}%")
                  ->orWhere('nama_penerima', 'like', "%{$search}%")
                  ->orWhere('nomor_telepon', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $pesanan = $query->paginate(15);
        
        // Statistik pesanan untuk filter
        $statusCounts = Pesanan::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('admin.pesanan.index', compact('pesanan', 'statusCounts'));
    }

    /**
     * Menampilkan detail pesanan
     */
    public function detailPesanan($id)
    {
        try {
            $pesanan = Pesanan::with([
                'user',
                'pembayaran',
                'details.varian.menu'
            ])->findOrFail($id);

            return view('admin.pesanan.detail', compact('pesanan'));

        } catch (\Exception $e) {
            Log::error('Detail Pesanan Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat detail pesanan.');
        }
    }

  /**
 * Update status pesanan dengan validasi alur berdasarkan jenis pengiriman
 */
public function updateStatusPesanan(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:menunggu_pembayaran,dikonfirmasi,diproses,dimasak,siap_diambil,diantar,selesai,dibatalkan'
    ]);

    try {
        $pesanan = Pesanan::with(['details.varian'])->findOrFail($id);
        $oldStatus = $pesanan->status;
        $newStatus = $request->status;
        
        // Jika status sama, tidak perlu update
        if ($oldStatus === $newStatus) {
            return back()->with('info', 'Status pesanan sudah ' . str_replace('_', ' ', $oldStatus));
        }
        
        // Validasi alur status berdasarkan jenis pengiriman
        $allowedTransitions = $this->getAllowedStatusTransitions($oldStatus, $pesanan->jenis_pengiriman);
        
        // Admin bisa mengubah ke status apapun, tapi kita kasih warning untuk alur tidak normal
        $isNormalFlow = in_array($newStatus, $allowedTransitions);
        
        // Update status
        $pesanan->status = $newStatus;
        
        // Logika khusus untuk status tertentu
        switch ($newStatus) {
            case 'diantar':
                if (!$pesanan->tanggal_pengiriman) {
                    $pesanan->tanggal_pengiriman = now();
                }
                break;
                
            case 'selesai':
                // Set tanggal selesai menggunakan created_at atau tanggal_pesanan
                // Tidak perlu kolom baru
                break;
                
            case 'dibatalkan':
                // Kembalikan stok jika dibatalkan
                $this->kembalikanStok($pesanan);
                break;
                
            case 'dikonfirmasi':
                // Kurangi stok ketika dikonfirmasi
                $this->kurangiStok($pesanan);
                break;
                
            // Untuk status lainnya, hanya update status saja tanpa kolom tambahan
        }
        
        $pesanan->save();
        
        // Log perubahan status
        Log::info("Pesanan {$pesanan->nomor_pesanan} ({$pesanan->jenis_pengiriman}) status changed from {$oldStatus} to {$newStatus} by admin");
        
        $successMessage = 'Status pesanan berhasil diperbarui menjadi: ' . str_replace('_', ' ', $newStatus);
        
        if (!$isNormalFlow) {
            $successMessage .= ' (Perubahan tidak sesuai alur normal)';
        }
        
        // Tambahkan info jenis pengiriman di pesan
        $successMessage .= ' [' . ucfirst($pesanan->jenis_pengiriman) . ']';
        
        return back()->with('success', $successMessage);

    } catch (\Exception $e) {
        Log::error('Update Status Error: ' . $e->getMessage());
        return back()->with('error', 'Gagal memperbarui status pesanan: ' . $e->getMessage());
    }
}

/**
 * Batalkan pesanan dengan validasi berdasarkan jenis pengiriman
 */
public function batalPesanan($id)
{
    try {
        $pesanan = Pesanan::with(['details.varian'])->findOrFail($id);
        
        // Validasi: pesanan yang sudah selesai tidak bisa dibatalkan
        if ($pesanan->status === 'selesai') {
            return back()->with('error', 'Pesanan yang sudah selesai tidak dapat dibatalkan.');
        }
        
        // Validasi: pesanan pickup yang sudah siap diambil tidak bisa dibatalkan
        if ($pesanan->jenis_pengiriman == 'pickup' && $pesanan->status === 'siap_diambil') {
            return back()->with('error', 'Pesanan pickup yang sudah siap diambil tidak dapat dibatalkan.');
        }
        
        // Validasi: pesanan delivery yang sudah diantar tidak bisa dibatalkan
        if ($pesanan->jenis_pengiriman == 'delivery' && $pesanan->status === 'diantar') {
            return back()->with('error', 'Pesanan delivery yang sedang diantar tidak dapat dibatalkan.');
        }

        $oldStatus = $pesanan->status;
        $pesanan->status = 'dibatalkan';
        $pesanan->save();

        // Kembalikan stok jika ada
        $this->kembalikanStok($pesanan);
        
        // Log pembatalan
        Log::info("Pesanan {$pesanan->nomor_pesanan} ({$pesanan->jenis_pengiriman}) dibatalkan dari status {$oldStatus}");

        return back()->with('success', 'Pesanan berhasil dibatalkan. Stok produk telah dikembalikan.');

    } catch (\Exception $e) {
        Log::error('Batal Pesanan Error: ' . $e->getMessage());
        return back()->with('error', 'Gagal membatalkan pesanan: ' . $e->getMessage());
    }
}

/**
 * Helper: Get alur status yang diperbolehkan berdasarkan jenis pengiriman
 */
private function getAllowedStatusTransitions($currentStatus, $jenisPengiriman)
{
    // Alur untuk DELIVERY
    $deliveryTransitions = [
        'menunggu_pembayaran' => ['dikonfirmasi', 'dibatalkan'],
        'dikonfirmasi' => ['diproses', 'dibatalkan'],
        'diproses' => ['diantar', 'dibatalkan'],
        'diantar' => ['selesai', 'dibatalkan'],
        'selesai' => [],
        'dibatalkan' => []
    ];
    
    // Alur untuk PICKUP
    $pickupTransitions = [
        'menunggu_pembayaran' => ['dikonfirmasi', 'dibatalkan'],
        'dikonfirmasi' => ['dimasak', 'dibatalkan'],
        'dimasak' => ['siap_diambil', 'dibatalkan'],
        'siap_diambil' => ['selesai', 'dibatalkan'],
        'selesai' => [],
        'dibatalkan' => []
    ];
    
    // Pilih alur berdasarkan jenis pengiriman
    $transitions = ($jenisPengiriman == 'pickup') ? $pickupTransitions : $deliveryTransitions;
    
    return $transitions[$currentStatus] ?? [];
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
                    $produkNama = $varian->menu ? $varian->menu->nama_menu : $varian->nama_varian;
                    throw new \Exception("Stok {$produkNama} tidak cukup. Tersedia: {$varian->stok}, Dibutuhkan: {$detail->jumlah}");
                }
                $varian->stok -= $detail->jumlah;
                $varian->save();
                
                Log::info("Stok dikurangi ({$pesanan->jenis_pengiriman}): {$varian->nama_varian} -{$detail->jumlah}, sisa: {$varian->stok}");
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
                
                Log::info("Stok dikembalikan ({$pesanan->jenis_pengiriman}): {$varian->nama_varian} +{$detail->jumlah}, total: {$varian->stok}");
            }
        }
        
    } catch (\Exception $e) {
        Log::error('Kembalikan Stok Error: ' . $e->getMessage());
        // Tetap lanjutkan meskipun ada error di pengembalian stok
    }
}
    
    /**
     * Menampilkan daftar pelanggan
     */
    public function pelanggan(Request $request)
    {
        $query = Pengguna::where('peran', 'pelanggan')
            ->withCount(['pesanan' => function($query) {
                $query->where('status', 'selesai');
            }])
            ->orderBy('created_at', 'desc');

        // Filter pencarian
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nomor_telepon', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }

        // Filter status aktif
        if ($request->has('status_aktif') && $request->status_aktif !== '') {
            $query->where('status_aktif', $request->status_aktif);
        }

        $pelanggan = $query->paginate(20);

        return view('admin.pelanggan.index', compact('pelanggan'));
    }

    /**
     * Menampilkan detail pelanggan
     */
    public function detailPelanggan($id)
    {
        try {
            $pelanggan = Pengguna::with(['pesanan' => function($query) {
                $query->orderBy('tanggal_pesanan', 'desc')->take(10);
            }, 'pesanan.details.varian.menu'])
                ->findOrFail($id);

            // Statistik pelanggan
            $totalPesanan = $pelanggan->pesanan()->count();
            $totalBelanja = $pelanggan->pesanan()->where('status', 'selesai')->sum('total_bayar') ?? 0;
            $pesananSelesai = $pelanggan->pesanan()->where('status', 'selesai')->count();
            $pesananAktif = $pelanggan->pesanan()->whereNotIn('status', ['selesai', 'dibatalkan'])->count();

            return view('admin.pelanggan.detail', compact(
                'pelanggan', 
                'totalPesanan', 
                'totalBelanja', 
                'pesananSelesai',
                'pesananAktif'
            ));

        } catch (\Exception $e) {
            Log::error('Detail Pelanggan Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat detail pelanggan.');
        }
    }

    /**
     * Update status pelanggan
     */
    public function updateStatusPelanggan(Request $request, $id)
    {
        try {
            $pelanggan = Pengguna::findOrFail($id);
            $pelanggan->status_aktif = $request->status == 'aktif';
            $pelanggan->save();

            return response()->json([
                'success' => true,
                'message' => 'Status pelanggan berhasil diperbarui.'
            ]);

        } catch (\Exception $e) {
            Log::error('Update Status Pelanggan Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status pelanggan.'
            ], 500);
        }
    }

    /**
     * Menampilkan laporan penjualan
     */
    public function laporan(Request $request)
    {
        // Default periode: bulan ini
        $startDate = $request->get('tanggal_dari', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('tanggal_sampai', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // Validasi tanggal
        if ($startDate > $endDate) {
            return back()->with('error', 'Tanggal awal tidak boleh lebih besar dari tanggal akhir.');
        }

        try {
            // Statistik utama
            $totalPesanan = Pesanan::whereBetween('tanggal_pesanan', [$startDate, $endDate])
                ->where('status', 'selesai')
                ->count();

            $totalPendapatan = Pesanan::whereBetween('tanggal_pesanan', [$startDate, $endDate])
                ->where('status', 'selesai')
                ->sum('total_bayar') ?? 0;

            $totalPelanggan = Pengguna::whereBetween('created_at', [$startDate, $endDate])
                ->where('peran', 'pelanggan')
                ->count();

            $rataTransaksi = $totalPesanan > 0 ? $totalPendapatan / $totalPesanan : 0;

            // Grafik pendapatan harian
            $pendapatanHarian = Pesanan::select(
                    DB::raw('DATE(tanggal_pesanan) as tanggal'),
                    DB::raw('SUM(total_bayar) as pendapatan'),
                    DB::raw('COUNT(*) as jumlah_pesanan')
                )
                ->whereBetween('tanggal_pesanan', [$startDate, $endDate])
                ->where('status', 'selesai')
                ->groupBy('tanggal')
                ->orderBy('tanggal')
                ->get();

            // Menu terlaris periode
            $menuTerlaris = DetailPesanan::select(
                    'menu.nama_menu',
                    DB::raw('SUM(detail_pesanan.jumlah) as total_terjual'),
                    DB::raw('SUM(detail_pesanan.subtotal) as total_pendapatan')
                )
                ->join('varian_menu', 'detail_pesanan.id_varian', '=', 'varian_menu.id_varian')
                ->join('menu', 'varian_menu.id_menu', '=', 'menu.id_menu')
                ->join('pesanan', 'detail_pesanan.id_pesanan', '=', 'pesanan.id_pesanan')
                ->whereBetween('pesanan.tanggal_pesanan', [$startDate, $endDate])
                ->where('pesanan.status', 'selesai')
                ->groupBy('menu.id_menu', 'menu.nama_menu')
                ->orderBy('total_terjual', 'desc')
                ->take(10)
                ->get();

            // Metode pembayaran
            $metodePembayaran = DB::table('pembayaran')
                ->join('pesanan', 'pembayaran.id_pesanan', '=', 'pesanan.id_pesanan')
                ->select(
                    'pembayaran.metode_pembayaran',
                    DB::raw('COUNT(*) as jumlah'),
                    DB::raw('SUM(pembayaran.jumlah) as total')
                )
                ->whereBetween('pesanan.tanggal_pesanan', [$startDate, $endDate])
                ->where('pesanan.status', 'selesai')
                ->groupBy('pembayaran.metode_pembayaran')
                ->get();

            // Tren harian
            $dates = [];
            $revenues = [];
            $orders = [];
            
            $currentDate = Carbon::parse($startDate);
            $endDateObj = Carbon::parse($endDate);
            
            while ($currentDate <= $endDateObj) {
                $dateStr = $currentDate->format('Y-m-d');
                $dates[] = $currentDate->format('d M');
                
                $dailyData = $pendapatanHarian->firstWhere('tanggal', $dateStr);
                $revenues[] = $dailyData ? $dailyData->pendapatan : 0;
                $orders[] = $dailyData ? $dailyData->jumlah_pesanan : 0;
                
                $currentDate->addDay();
            }

            return view('admin.laporan.index', compact(
                'totalPesanan',
                'totalPendapatan',
                'totalPelanggan',
                'rataTransaksi',
                'pendapatanHarian',
                'menuTerlaris',
                'metodePembayaran',
                'startDate',
                'endDate',
                'dates',
                'revenues',
                'orders'
            ));

        } catch (\Exception $e) {
            Log::error('Laporan Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat laporan. Silakan coba lagi.');
        }
    }

    /**
     * API untuk data dashboard real-time
     */
    public function getDashboardData()
    {
        try {
            $today = now()->format('Y-m-d');
            $yesterday = now()->subDay()->format('Y-m-d');
            $lastWeek = now()->subDays(7)->format('Y-m-d');

            // Data untuk chart
            $chartData = Pesanan::select(
                    DB::raw('DATE(tanggal_pesanan) as date'),
                    DB::raw('COUNT(*) as orders'),
                    DB::raw('SUM(total_bayar) as revenue')
                )
                ->whereDate('tanggal_pesanan', '>=', $lastWeek)
                ->where('status', 'selesai')
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            // Perbandingan dengan kemarin
            $pendapatanHariIni = Pesanan::whereDate('tanggal_pesanan', $today)
                ->where('status', 'selesai')
                ->sum('total_bayar') ?? 0;

            $pendapatanKemarin = Pesanan::whereDate('tanggal_pesanan', $yesterday)
                ->where('status', 'selesai')
                ->sum('total_bayar') ?? 0;

            $persentasePendapatan = $pendapatanKemarin > 0 
                ? (($pendapatanHariIni - $pendapatanKemarin) / $pendapatanKemarin) * 100 
                : ($pendapatanHariIni > 0 ? 100 : 0);

            // Pesanan hari ini
            $pesananHariIni = Pesanan::whereDate('tanggal_pesanan', $today)->count();
            $pesananKemarin = Pesanan::whereDate('tanggal_pesanan', $yesterday)->count();
            $persentasePesanan = $pesananKemarin > 0 
                ? (($pesananHariIni - $pesananKemarin) / $pesananKemarin) * 100 
                : ($pesananHariIni > 0 ? 100 : 0);

            // Pesanan yang perlu perhatian
            $pesananMenunggu = Pesanan::where('status', 'menunggu_pembayaran')->count();
            $pesananDiproses = Pesanan::whereIn('status', ['dikonfirmasi', 'diproses', 'dimasak'])->count();

            return response()->json([
                'success' => true,
                'data' => [
                    'chartData' => $chartData,
                    'pendapatan' => [
                        'hari_ini' => $pendapatanHariIni,
                        'kemarin' => $pendapatanKemarin,
                        'persentase' => round($persentasePendapatan, 2)
                    ],
                    'pesanan' => [
                        'hari_ini' => $pesananHariIni,
                        'kemarin' => $pesananKemarin,
                        'persentase' => round($persentasePesanan, 2)
                    ],
                    'perhatian' => [
                        'menunggu_pembayaran' => $pesananMenunggu,
                        'diproses' => $pesananDiproses
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Get Dashboard Data Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data dashboard'
            ], 500);
        }
    }

    /**
     * Helper: Get pendapatan harian
     */
    private function getPendapatanHarian($days = 7)
    {
        return Pesanan::select(
                DB::raw('DATE(tanggal_pesanan) as tanggal'),
                DB::raw('SUM(total_bayar) as total')
            )
            ->where('status', 'selesai')
            ->whereDate('tanggal_pesanan', '>=', Carbon::now()->subDays($days))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();
    }

    /**
     * Helper: Get menu terlaris
     */
    private function getMenuTerlaris($days = 30, $limit = 5)
    {
        return DetailPesanan::select(
                'menu.nama_menu',
                DB::raw('SUM(detail_pesanan.jumlah) as total_terjual'),
                DB::raw('SUM(detail_pesanan.subtotal) as total_pendapatan')
            )
            ->join('varian_menu', 'detail_pesanan.id_varian', '=', 'varian_menu.id_varian')
            ->join('menu', 'varian_menu.id_menu', '=', 'menu.id_menu')
            ->join('pesanan', 'detail_pesanan.id_pesanan', '=', 'pesanan.id_pesanan')
            ->where('pesanan.status', 'selesai')
            ->whereDate('pesanan.tanggal_pesanan', '>=', Carbon::now()->subDays($days))
            ->groupBy('menu.id_menu', 'menu.nama_menu')
            ->orderBy('total_terjual', 'desc')
            ->take($limit)
            ->get();
    }

    /**
     * Helper: Get status pesanan
     */
    private function getStatusPesanan()
    {
        return Pesanan::select(
                'status',
                DB::raw('COUNT(*) as jumlah')
            )
            ->groupBy('status')
            ->get();
    }

    /**
     * Helper: Get metode pembayaran stats
     */
    private function getMetodePembayaranStats()
    {
        return DB::table('pembayaran')
            ->select(
                'metode_pembayaran',
                DB::raw('COUNT(*) as jumlah'),
                DB::raw('SUM(jumlah) as total')
            )
            ->where('status_pembayaran', 'dibayar')
            ->groupBy('metode_pembayaran')
            ->orderBy('jumlah', 'desc')
            ->get();
    }
}