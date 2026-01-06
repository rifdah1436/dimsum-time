@extends('admin.layouts.main')

@section('content')
<header class="main-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 class="page-title">Detail Pelanggan</h2>
            <p class="page-subtitle">Informasi lengkap pelanggan</p>
        </div>
        <a href="{{ route('admin.pelanggan.index') }}" class="btn" style="background-color: var(--bg-sidebar); color: white; padding: 8px 16px; border: none; border-radius: 4px; text-decoration: none;">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</header>

<div class="summary-section" style="margin-bottom: 20px;">
    <div class="summary-card" style="grid-column: span 4;">
        <div style="display: flex; gap: 20px; align-items: center;">
            <div style="width: 80px; height: 80px; background-color: var(--bg-sidebar); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-user" style="font-size: 32px; color: white;"></i>
            </div>
            <div>
                <h3 style="margin: 0 0 5px 0;">{{ $pelanggan->nama_lengkap }}</h3>
                <p style="margin: 0; color: #666;">{{ $pelanggan->username }} • {{ $pelanggan->email }}</p>
                <p style="margin: 5px 0 0 0; color: #666;">{{ $pelanggan->nomor_telepon }}</p>
            </div>
            <div style="margin-left: auto;">
                <span class="badge" style="background-color: {{ $pelanggan->status_aktif ? 'var(--bg-status-selesai)' : '#e53935' }}; color: white; padding: 8px 16px; border-radius: 20px;">
                    {{ $pelanggan->status_aktif ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>
        </div>
    </div>
</div>

<div class="summary-section">
    <div class="summary-card">
        <p class="card-title">Total Pesanan</p>
        <p class="card-value">{{ $totalPesanan }}</p>
    </div>
    <div class="summary-card">
        <p class="card-title">Total Belanja</p>
        <p class="card-value">Rp{{ number_format($totalBelanja, 0, ',', '.') }}</p>
    </div>
    <div class="summary-card">
        <p class="card-title">Pesanan Selesai</p>
        <p class="card-value">{{ $pesananSelesai }}</p>
    </div>
    <div class="summary-card">
        <p class="card-title">Pesanan Aktif</p>
        <p class="card-value">{{ $pesananAktif }}</p>
    </div>
</div>

<div class="orders-section" style="margin-top: 20px;">
    <h3 style="margin-bottom: 15px;">Riwayat Pesanan</h3>
    
    @if($pelanggan->pesanan->count() > 0)
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Metode Bayar</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pelanggan->pesanan as $pesanan)
                <tr>
                    <td>#{{ str_pad($pesanan->id_pesanan, 6, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $pesanan->tanggal_pesanan->format('d/m/Y H:i') }}</td>
                    <td>
                        <span class="badge" style="background-color: 
                            @if($pesanan->status == 'selesai') var(--bg-status-selesai)
                            @elseif($pesanan->status == 'diproses') var(--bg-status-diproses)
                            @elseif($pesanan->status == 'dikirim') var(--bg-status-dikirim)
                            @elseif($pesanan->status == 'dibatalkan') #e53935
                            @else var(--bg-sidebar) @endif; 
                            color: white; padding: 4px 8px; border-radius: 4px;">
                            {{ ucfirst($pesanan->status) }}
                        </span>
                    </td>
                    <td>{{ ucfirst($pesanan->metode_pembayaran) }}</td>
                    <td>Rp{{ number_format($pesanan->total_bayar, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('admin.pesanan.show', $pesanan->id_pesanan) }}" 
                           class="btn-link" title="Detail" style="color: var(--bg-sidebar);">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="text-center" style="text-align: center; padding: 40px;">
        <i class="fas fa-shopping-cart" style="font-size: 48px; color: #ddd; margin-bottom: 10px;"></i><br>
        <p style="color: #666;">Belum ada riwayat pesanan</p>
    </div>
    @endif
</div>

<div class="orders-section" style="margin-top: 20px;">
    <h3 style="margin-bottom: 15px;">Informasi Akun</h3>
    <div class="summary-card" style="grid-column: span 4;">
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <div>
                <p><strong>Tanggal Bergabung:</strong><br>
                {{ $pelanggan->created_at->format('d F Y H:i') }}</p>
                
                <p><strong>Terakhir Login:</strong><br>
                {{ $pelanggan->last_login ? $pelanggan->last_login->format('d F Y H:i') : 'Belum pernah login' }}</p>
            </div>
            <div>
                <p><strong>Status Akun:</strong><br>
                {{ $pelanggan->status_aktif ? 'Aktif' : 'Nonaktif' }}</p>
                
                <div style="margin-top: 20px;">
                    <form action="{{ route('admin.pelanggan.update-status', $pelanggan->id_pengguna) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="status" value="{{ $pelanggan->status_aktif ? 'nonaktif' : 'aktif' }}">
                        <button type="submit" class="btn" 
                                style="background-color: {{ $pelanggan->status_aktif ? '#e53935' : 'var(--bg-status-selesai)' }}; 
                                       color: white; padding: 8px 16px; border: none; border-radius: 4px;">
                            {{ $pelanggan->status_aktif ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection