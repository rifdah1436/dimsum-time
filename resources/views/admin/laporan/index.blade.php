@extends('admin.layouts.main')

@section('content')
<header class="main-header">
    <h2 class="page-title">Laporan Penjualan</h2>
    <p class="page-subtitle">Analisis performa penjualan Dimsum Time</p>
</header>

<div class="summary-section">
    <div class="summary-card">
        <p class="card-title">Total Pesanan</p>
        <p class="card-value">{{ number_format($totalPesanan) }}</p>
    </div>
    <div class="summary-card">
        <p class="card-title">Total Pendapatan</p>
        <p class="card-value">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</p>
    </div>
    <div class="summary-card">
        <p class="card-title">Pelanggan Baru</p>
        <p class="card-value">{{ number_format($totalPelanggan) }}</p>
    </div>
    <div class="summary-card">
        <p class="card-title">Rata-rata Transaksi</p>
        <p class="card-value">Rp{{ number_format($rataTransaksi, 0, ',', '.') }}</p>
    </div>
</div>

<div class="orders-section" style="margin-bottom: 20px;">
    <h3 class="section-title">Filter Periode</h3>
    <form method="GET" style="display: flex; gap: 10px; align-items: center;">
        <div style="display: flex; align-items: center; gap: 5px;">
            <label>Dari:</label>
            <input type="date" name="tanggal_dari" value="{{ $startDate }}" 
                   style="padding: 8px; border: 1px solid var(--border-color); border-radius: 4px;">
        </div>
        
        <div style="display: flex; align-items: center; gap: 5px;">
            <label>Sampai:</label>
            <input type="date" name="tanggal_sampai" value="{{ $endDate }}" 
                   style="padding: 8px; border: 1px solid var(--border-color); border-radius: 4px;">
        </div>
        
        <button type="submit" class="btn" style="background-color: var(--bg-sidebar); color: white; padding: 8px 16px; border: none; border-radius: 4px;">
            <i class="fas fa-filter"></i> Terapkan
        </button>
        
        <a href="{{ route('admin.laporan.index') }}" class="btn" style="background-color: #6c757d; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none;">
            <i class="fas fa-redo"></i> Reset
        </a>
    </form>
</div>

<div class="summary-section" style="margin-bottom: 20px; grid-template-columns: 1fr 1fr;">
    <div class="summary-card">
        <h3 class="section-title">Menu Terlaris</h3>
        <table style="width: 100%; font-size: 13px;">
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>Terjual</th>
                    <th>Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($menuTerlaris as $menu)
                <tr>
                    <td>{{ $menu->nama_menu }}</td>
                    <td style="text-align: center;">{{ number_format($menu->total_terjual) }} pcs</td>
                    <td style="text-align: right;">Rp{{ number_format($menu->total_pendapatan, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="text-align: center; padding: 10px;">Belum ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="summary-card">
        <h3 class="section-title">Metode Pembayaran</h3>
        <table style="width: 100%; font-size: 13px;">
            <thead>
                <tr>
                    <th>Metode</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($metodePembayaran as $metode)
                <tr>
                    <td>{{ ucfirst($metode->metode_pembayaran) }}</td>
                    <td style="text-align: center;">{{ number_format($metode->jumlah) }}</td>
                    <td style="text-align: right;">Rp{{ number_format($metode->total, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="text-align: center; padding: 10px;">Belum ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="orders-section">
    <h3 class="section-title">Grafik Pendapatan Harian</h3>
    <div style="overflow-x: auto;">
        <table style="width: 100%; font-size: 13px;">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jumlah Pesanan</th>
                    <th>Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendapatanHarian as $harian)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($harian->tanggal)->format('d M Y') }}</td>
                    <td style="text-align: center;">{{ number_format($harian->jumlah_pesanan) }}</td>
                    <td style="text-align: right;">Rp{{ number_format($harian->pendapatan, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="text-align: center; padding: 10px;">Belum ada data untuk periode ini</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div style="text-align: center; margin-top: 20px;">
    <button onclick="window.print()" class="btn" style="background-color: var(--bg-sidebar); color: white; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer;">
        <i class="fas fa-print"></i> Cetak Laporan
    </button>
</div>

<style>
@media print {
    .sidebar, .logout-button, button {
        display: none !important;
    }
    .main-content {
        margin-left: 0 !important;
        width: 100% !important;
    }
}
</style>
@endsection