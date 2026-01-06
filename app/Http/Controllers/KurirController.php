<?php
// app/Http/Controllers/KurirController.php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\VarianMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KurirController extends Controller
{
    public function __construct()
    {
        // Middleware untuk memastikan hanya kurir yang bisa akses
        $this->middleware('auth');
        $this->middleware('kurir');
    }

    /**
     * Dashboard kurir - hanya tampilkan pesanan delivery yang status diantar
     */
    public function dashboard(Request $request)
    {
        // Filter hanya pesanan dengan:
        // 1. jenis_pengiriman = 'delivery'
        // 2. status = 'diantar' (sedang dikirim)
        
        $query = Pesanan::with(['details' => function($q) {
            $q->with('varian');
        }])
        ->where('jenis_pengiriman', 'delivery')
        ->where('status', 'diantar')
        ->orderBy('tanggal_pengiriman', 'asc');

        // Filter berdasarkan search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_pesanan', 'like', "%{$search}%")
                  ->orWhere('nama_penerima', 'like', "%{$search}%")
                  ->orWhere('nomor_telepon', 'like', "%{$search}%");
            });
        }

        $pesanan = $query->paginate(10);

        // Hitung statistik
        $statistik = [
            'sedang_dikirim' => Pesanan::where('jenis_pengiriman', 'delivery')
                ->where('status', 'diantar')
                ->count(),
            
            'selesai_hari_ini' => Pesanan::where('jenis_pengiriman', 'delivery')
                ->where('status', 'selesai')
                ->whereDate('updated_at', today())
                ->count(),
            
            'total_pengiriman' => Pesanan::where('jenis_pengiriman', 'delivery')
                ->where('status', 'selesai')
                ->count(),
        ];

        return view('kurir.dashboard', compact('pesanan', 'statistik'));
    }

    /**
     * Get detail pesanan untuk modal
     */
    public function getOrderDetail($id_pesanan)
    {
        $pesanan = Pesanan::with(['details' => function($q) {
            $q->with(['varian' => function($q2) {
                // Jika varian memiliki relasi ke menu, bisa ditambahkan
                $q2->with('menu');
            }]);
        }])
        ->where('id_pesanan', $id_pesanan)
        ->where('jenis_pengiriman', 'delivery')
        ->where('status', 'diantar')
        ->first();

        if (!$pesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $pesanan
        ]);
    }

    /**
     * Update status pesanan menjadi selesai
     */
    public function completeDelivery(Request $request, $id_pesanan)
    {
        $request->validate([
            'bukti_pengiriman' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'catatan_kurir' => 'nullable|string|max:500',
        ]);

        try {
            $pesanan = Pesanan::where('id_pesanan', $id_pesanan)
                ->where('jenis_pengiriman', 'delivery')
                ->where('status', 'diantar')
                ->firstOrFail();

            // Upload foto bukti pengiriman
            if ($request->hasFile('bukti_pengiriman')) {
                $file = $request->file('bukti_pengiriman');
                $filename = 'delivery_' . time() . '_' . $pesanan->nomor_pesanan . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('bukti_pengiriman', $filename, 'public');
                
                // Simpan path foto ke database
                $pesanan->bukti_pengiriman = $path;
            }

            // Update catatan kurir jika ada
            if ($request->filled('catatan_kurir')) {
                $pesanan->catatan_kurir = $request->catatan_kurir;
            }

            // Update status menjadi selesai
            $pesanan->status = 'selesai';
            $pesanan->tanggal_pengiriman = now(); // Tambah ini untuk update waktu pengiriman
            $pesanan->save();

            return response()->json([
                'success' => true,
                'message' => 'Pengiriman berhasil diselesaikan!',
                'redirect' => route('kurir.dashboard')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyelesaikan pengiriman: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Riwayat pengiriman selesai
     */
    public function history(Request $request)
    {
        $query = Pesanan::with(['details' => function($q) {
            $q->with('varian');
        }])
        ->where('jenis_pengiriman', 'delivery')
        ->where('status', 'selesai')
        ->orderBy('updated_at', 'desc');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_pesanan', 'like', "%{$search}%")
                  ->orWhere('nama_penerima', 'like', "%{$search}%");
            });
        }

        if ($request->has('date')) {
            $query->whereDate('updated_at', $request->date);
        }

        $pesanan = $query->paginate(10);

        return view('kurir.history', compact('pesanan'));
    }

    /**
     * Fungsi bantuan untuk mendapatkan nama menu dari varian
     */
    private function getMenuNameFromVarian($varian)
    {
        // Jika varian memiliki relasi menu, ambil namanya
        if ($varian && $varian->menu) {
            return $varian->menu->nama_menu;
        }
        
        // Jika tidak, coba ambil dari properti varian
        if ($varian && isset($varian->nama_varian)) {
            return $varian->nama_varian;
        }
        
        return 'Produk';
    }
}