<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class OwnerDashboardController extends Controller
{
    // Constructor (Satpam)
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            // Izinkan 'pemilik' (sesuai DB) atau 'owner'
            if ($user->peran !== 'pemilik' && $user->peran !== 'owner') {
                return redirect()->route('home');
            }
            return $next($request);
        });
    }

    public function index()
    {
        // ==========================================
        // 1. LOGIKA TANGGAL PINTAR (SMART DATE)
        // ==========================================
        // Kita cari tanggal transaksi terakhir di database. 
        // Ini penting karena data kamu ada di tahun 2025.
        $lastOrder = DB::table('pesanan')->max('tanggal_pesanan');
        
        // Jika ada data, pakai tanggal itu. Jika kosong, pakai hari ini.
        $today = $lastOrder ? Carbon::parse($lastOrder) : Carbon::today();
        
        // Status yang dianggap sebagai "Pendapatan Masuk"
        // Kita ambil semua kecuali yang dibatalkan atau masih menunggu bayar
        $validStatus = ['dikonfirmasi', 'diproses', 'dimasak', 'siap_diantar', 'diantar', 'selesai'];

        // ==========================================
        // 2. DATA RINGKASAN (Statistik Atas)
        // ==========================================
        
        // Pendapatan Hari Ini (Berdasarkan tanggal data terakhir)
        $pendapatanHariIni = DB::table('pesanan')
            ->whereDate('tanggal_pesanan', $today)
            ->whereIn('status', $validStatus)
            ->sum('total_bayar');

        // Total Pesanan Hari Ini (Termasuk yang belum bayar, untuk trafik)
        $pesananHariIni = DB::table('pesanan')
            ->whereDate('tanggal_pesanan', $today)
            ->where('status', '!=', 'dibatalkan')
            ->count();

        // Total Pelanggan
        $totalPelanggan = DB::table('pengguna')
            ->where('peran', 'pelanggan')
            ->count();
        
        // ==========================================
        // 3. CHART HARIAN (7 Hari Terakhir dari Data)
        // ==========================================
        $chartLabels = [];
        $chartData = [];
        
        // Loop 7 hari ke belakang dari tanggal data terakhir
        for ($i = 6; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i);
            
            $revenue = DB::table('pesanan')
                ->whereDate('tanggal_pesanan', $date)
                ->whereIn('status', $validStatus)
                ->sum('total_bayar');
                
            $chartLabels[] = $date->format('d M'); // Contoh: 21 Des
            $chartData[] = $revenue;
        }

        // ==========================================
        // 4. CHART BULANAN (Tahun dari Data Terakhir)
        // ==========================================
        $chartBulanan = [];
        $dataYear = $today->year; // Ambil tahun dari data (2025)
        
        for ($i = 1; $i <= 12; $i++) {
            $chartBulanan[] = DB::table('pesanan')
                ->whereMonth('tanggal_pesanan', $i)
                ->whereYear('tanggal_pesanan', $dataYear)
                ->whereIn('status', $validStatus)
                ->sum('total_bayar');
        }

        // ==========================================
        // 5. TRANSAKSI TERBESAR & TERBARU
        // ==========================================
        $transaksiBesar = DB::table('pesanan')
            ->join('pengguna', 'pesanan.id_pengguna', '=', 'pengguna.id_pengguna')
            ->whereIn('pesanan.status', $validStatus) // Hanya yang valid
            ->select('pesanan.*', 'pengguna.nama_lengkap')
            ->orderByDesc('tanggal_pesanan') // Urutkan yang terbaru
            ->limit(10)
            ->get();

        // ==========================================
        // 6. TOP PELANGGAN
        // ==========================================
        $dataPelanggan = DB::table('pengguna')
            ->join('pesanan', 'pengguna.id_pengguna', '=', 'pesanan.id_pengguna')
            ->select(
                'pengguna.id_pengguna',
                'pengguna.nama_lengkap',
                'pengguna.email',
                'pengguna.nomor_telepon',
                DB::raw('COUNT(pesanan.id_pesanan) as total_order'),
                DB::raw('SUM(pesanan.total_bayar) as total_belanja')
            )
            ->where('pengguna.peran', 'pelanggan')
            ->whereIn('pesanan.status', $validStatus) // Hitung belanja yang valid saja
            ->groupBy('pengguna.id_pengguna', 'pengguna.nama_lengkap', 'pengguna.email', 'pengguna.nomor_telepon')
            ->orderByDesc('total_belanja')
            ->limit(10)
            ->get();

        // ==========================================
        // 7. DATA PEGAWAI
        // ==========================================
        $dataPegawai = DB::table('pengguna')
            ->whereIn('peran', ['admin', 'kasir', 'kurir'])
            ->get();

        return view('owner.dashboard', compact(
            'pendapatanHariIni', 'pesananHariIni', 'totalPelanggan',
            'chartLabels', 'chartData', 
            'chartBulanan', 'transaksiBesar',
            'dataPelanggan', 'dataPegawai'
        ));
    }
}