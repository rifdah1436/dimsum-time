@extends('admin.layouts.main')

@section('content')
<header class="main-header">
    <h2 class="page-title">Dashboard Admin</h2>
    <p class="page-subtitle">Ringkasan data toko Dimsum Time</p>
</header>

<section class="summary-section">
    <div class="summary-card">
        <p class="card-title">Total Menu</p>
        <p class="card-value">{{ $totalMenu }}</p>
        <a href="{{ route('admin.produk.index') }}" class="card-link">Detail <i class="fas fa-arrow-circle-right"></i></a>
    </div>
    <div class="summary-card">
        <p class="card-title">Pemesanan Hari Ini</p>
        <p class="card-value">{{ $pesananHariIni }}</p>
        <a href="{{ route('admin.pesanan.index') }}" class="card-link">Detail <i class="fas fa-arrow-circle-right"></i></a>
    </div>
    <div class="summary-card">
        <p class="card-title">Total Pelanggan</p>
        <p class="card-value">{{ $totalPelanggan }}</p>
        <a href="{{ route('admin.pelanggan.index') }}" class="card-link">Detail <i class="fas fa-arrow-circle-right"></i></a>
    </div>
    <div class="summary-card">
        <p class="card-title">Pendapatan Hari Ini</p>
        <p class="card-value">Rp{{ number_format($pendapatanHariIni, 0, ',', '.') }}</p>
        <a href="{{ route('admin.laporan.index') }}" class="card-link">Detail <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</section>

<section class="orders-section">
    <h3 class="section-title">Pesanan Terbaru</h3>
    <div class="table-controls">
        <div class="entries-control">
            <span>Show</span>
            <div class="dropdown">
                <span id="entriesCount">10</span>
                <span class="dropdown-arrow"><i class="fas fa-chevron-down"></i></span>
            </div>
            <span>Entries</span>
        </div>
        <div class="search-control">
            <label for="searchOrders">Search:</label>
            <input type="text" id="searchOrders" placeholder="Cari pesanan...">
        </div>
    </div>
    <div class="table-container">
        <table id="ordersTable">
            <thead>
                <tr>
                    <th>No <i class="fas fa-sort"></i></th>
                    <th>Pelanggan <i class="fas fa-sort"></i></th>
                    <th>Tanggal <i class="fas fa-sort"></i></th>
                    <th>Total Harga <i class="fas fa-sort"></i></th>
                    <th>Status <i class="fas fa-sort"></i></th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesananTerbaru as $index => $pesanan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pesanan->nama_penerima }}</td>
                    <td>{{ $pesanan->tanggal_pesanan->format('d/m/Y H:i') }}</td>
                    <td>Rp{{ number_format($pesanan->total_bayar, 0, ',', '.') }}</td>
                    <td>
                        @php
                            $statusClass = 'status-' . $pesanan->status;
                            $statusText = ucfirst(str_replace('_', ' ', $pesanan->status));
                        @endphp
                        <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                    </td>
                    <td>
                        <a href="{{ route('admin.pesanan.show', $pesanan->id_pesanan) }}" class="btn-link" title="Lihat Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center" style="text-align: center; padding: 20px;">
                        Belum ada pesanan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="table-footer">
        <p id="tableInfo">Menampilkan 1-{{ min(10, count($pesananTerbaru)) }} pesanan dari {{ count($pesananTerbaru) }} pesanan</p>
        <nav class="pagination">
            <a href="#" class="page-nav" id="prevPage"><i class="fas fa-chevron-left"></i></a>
            <a href="#" class="page-num active" data-page="1">1</a>
            <a href="#" class="page-nav" id="nextPage"><i class="fas fa-chevron-right"></i></a>
        </nav>
    </div>
</section>

<div class="summary-section" style="margin-top: 30px;">
    <div class="summary-card" style="grid-column: span 2;">
        <h3 class="section-title">Menu Terlaris (30 Hari)</h3>
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
                    <td style="text-align: center;">{{ $menu->total_terjual }} pcs</td>
                    <td style="text-align: right;">Rp{{ number_format($menu->total_pendapatan, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="text-align: center; padding: 10px;">Belum ada data penjualan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="summary-card" style="grid-column: span 2;">
        <h3 class="section-title">Status Pesanan</h3>
        <div style="display: flex; flex-direction: column; gap: 10px;">
            @foreach($statusPesanan as $status)
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span>{{ ucfirst(str_replace('_', ' ', $status->status)) }}</span>
                <span class="badge" style="background-color: var(--bg-sidebar); color: white; padding: 4px 8px; border-radius: 4px;">
                    {{ $status->jumlah }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
</div>

<style>
.btn-link {
    color: var(--bg-sidebar);
    text-decoration: none;
    padding: 5px;
    border-radius: 4px;
    transition: all 0.3s;
}

.btn-link:hover {
    background-color: rgba(229, 57, 53, 0.1);
    color: #c62828;
}

.text-center {
    text-align: center;
}

.badge {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
}
</style>
@endsection