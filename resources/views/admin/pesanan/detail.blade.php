@extends('admin.layouts.main')

@section('content')
<header class="main-header">
    <h2 class="page-title">Detail Pesanan #{{ $pesanan->nomor_pesanan }}</h2>
    <p class="page-subtitle">
        Tanggal: {{ $pesanan->tanggal_pesanan->format('d/m/Y H:i') }}
        @if($pesanan->pembayaran)
            • Status Pembayaran: 
            <span class="status-badge {{ $pesanan->pembayaran->status_pembayaran == 'dibayar' ? 'status-selesai' : 'status-pending' }}">
                {{ ucfirst($pesanan->pembayaran->status_pembayaran) }}
            </span>
        @endif
    </p>
</header>

<div class="summary-section" style="margin-bottom: 20px; grid-template-columns: repeat(2, 1fr);">
    <div class="summary-card">
        <h3 style="margin-bottom: 15px; color: var(--text-secondary);">Informasi Pelanggan</h3>
        <table style="width: 100%; font-size: 13px;">
            <tr>
                <td style="padding: 5px 0; color: #666;">Nama</td>
                <td style="padding: 5px 0;">: {{ $pesanan->nama_penerima }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0; color: #666;">Telepon</td>
                <td style="padding: 5px 0;">: {{ $pesanan->nomor_telepon }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0; color: #666;">Email</td>
                <td style="padding: 5px 0;">: {{ $pesanan->user->email ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0; color: #666;">Alamat</td>
                <td style="padding: 5px 0;">: {{ $pesanan->alamat_pengiriman }}</td>
            </tr>
        </table>
    </div>
    
    <div class="summary-card">
        <h3 style="margin-bottom: 15px; color: var(--text-secondary);">Informasi Pesanan</h3>
        <table style="width: 100%; font-size: 13px;">
            <tr>
                <td style="padding: 5px 0; color: #666;">Status</td>
                <td style="padding: 5px 0;">
                    : <span class="status-badge status-{{ $pesanan->status }}">
                        {{ ucfirst(str_replace('_', ' ', $pesanan->status)) }}
                    </span>
                </td>
            </tr>
            <tr>
                <td style="padding: 5px 0; color: #666;">Pengiriman</td>
                <td style="padding: 5px 0;">: {{ ucfirst($pesanan->jenis_pengiriman) }}</td>
            </tr>
            @if($pesanan->tanggal_pengiriman)
            <tr>
                <td style="padding: 5px 0; color: #666;">Tanggal Antar</td>
                <td style="padding: 5px 0;">: {{ $pesanan->tanggal_pengiriman->format('d/m/Y H:i') }}</td>
            </tr>
            @endif
            <tr>
                <td style="padding: 5px 0; color: #666;">Catatan</td>
                <td style="padding: 5px 0;">: {{ $pesanan->catatan_pelanggan ?: '-' }}</td>
            </tr>
        </table>
    </div>
</div>

<div class="orders-section" style="margin-bottom: 20px;">
    <h3 class="section-title">Items Pesanan</h3>
    <div class="table-container">
        <table style="width: 100%;">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Varian</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pesanan->details as $detail)
                <tr>
                    <td>
                        {{ $detail->varian->menu->nama_menu ?? 'Produk tidak ditemukan' }}
                    </td>
                    <td>
                        {{ $detail->varian->nama_varian ?? '-' }}<br>
                        <small style="color: #666;">{{ $detail->varian->nama_jenis ?? '' }}</small>
                    </td>
                    <td>Rp{{ number_format($detail->harga_per_unit, 0, ',', '.') }}</td>
                    <td>{{ $detail->jumlah }}</td>
                    <td>Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    <td>{{ $detail->catatan ?: '-' }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right; padding: 10px; font-weight: bold;">Subtotal</td>
                    <td colspan="2">Rp{{ number_format($pesanan->subtotal, 0, ',', '.') }}</td>
                </tr>
                @if($pesanan->diskon > 0)
                <tr>
                    <td colspan="4" style="text-align: right; padding: 10px; font-weight: bold;">Diskon</td>
                    <td colspan="2">-Rp{{ number_format($pesanan->diskon, 0, ',', '.') }}</td>
                </tr>
                @endif
                @if($pesanan->biaya_pengiriman > 0)
                <tr>
                    <td colspan="4" style="text-align: right; padding: 10px; font-weight: bold;">Biaya Pengiriman</td>
                    <td colspan="2">Rp{{ number_format($pesanan->biaya_pengiriman, 0, ',', '.') }}</td>
                </tr>
                @endif
                <tr>
                    <td colspan="4" style="text-align: right; padding: 10px; font-weight: bold; font-size: 16px;">Total</td>
                    <td colspan="2" style="font-size: 16px; font-weight: bold; color: var(--bg-sidebar);">
                        Rp{{ number_format($pesanan->total_bayar, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@if($pesanan->pembayaran)
<div class="orders-section" style="margin-bottom: 20px;">
    <h3 class="section-title">Informasi Pembayaran</h3>
    <div style="padding: 15px; background-color: #f8f9fa; border-radius: 6px;">
        <table style="width: 100%; font-size: 13px;">
            <tr>
                <td style="padding: 5px 0; color: #666; width: 150px;">Metode Pembayaran</td>
                <td style="padding: 5px 0;">: {{ ucfirst($pesanan->pembayaran->metode_pembayaran) }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0; color: #666;">Jumlah Bayar</td>
                <td style="padding: 5px 0;">: Rp{{ number_format($pesanan->pembayaran->jumlah, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0; color: #666;">Status Pembayaran</td>
                <td style="padding: 5px 0;">
                    : <span class="status-badge {{ $pesanan->pembayaran->status_pembayaran == 'dibayar' ? 'status-selesai' : 'status-pending' }}">
                        {{ ucfirst($pesanan->pembayaran->status_pembayaran) }}
                    </span>
                </td>
            </tr>
            @if($pesanan->pembayaran->tanggal_pembayaran)
            <tr>
                <td style="padding: 5px 0; color: #666;">Tanggal Bayar</td>
                <td style="padding: 5px 0;">: {{ $pesanan->pembayaran->tanggal_pembayaran->format('d/m/Y H:i') }}</td>
            </tr>
            @endif
            @if($pesanan->pembayaran->bukti_pembayaran)
            <tr>
                <td style="padding: 5px 0; color: #666;">Bukti Pembayaran</td>
                <td style="padding: 5px 0;">
                    : <a href="{{ asset('storage/' . $pesanan->pembayaran->bukti_pembayaran) }}" 
                         target="_blank" style="color: var(--bg-sidebar); text-decoration: none;">
                        <i class="fas fa-image"></i> Lihat Bukti
                    </a>
                </td>
            </tr>
            @endif
            @if($pesanan->pembayaran->keterangan)
            <tr>
                <td style="padding: 5px 0; color: #666;">Keterangan</td>
                <td style="padding: 5px 0;">: {{ $pesanan->pembayaran->keterangan }}</td>
            </tr>
            @endif
        </table>
    </div>
</div>
@endif

<div class="orders-section">
    <h3 class="section-title">Ubah Status Pesanan</h3>
    <form action="{{ route('admin.pesanan.update-status', $pesanan->id_pesanan) }}" method="POST" 
          style="display: flex; gap: 10px; align-items: center;">
        @csrf
        @method('PUT')
        
        <select name="status" style="padding: 10px; border: 1px solid var(--border-color); border-radius: 4px; flex-grow: 1;">
            @php
                $statusOptions = [
                    'menunggu_pembayaran' => 'Menunggu Pembayaran',
                    'dikonfirmasi' => 'Dikonfirmasi',
                    'diproses' => 'Diproses',
                    'dimasak' => 'Dimasak',
                    'siap_diantar' => 'Siap Diantar',
                    'diantar' => 'Diantar',
                    'selesai' => 'Selesai',
                    'dibatalkan' => 'Dibatalkan'
                ];
            @endphp
            @foreach($statusOptions as $value => $label)
                <option value="{{ $value }}" {{ $pesanan->status == $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        
        <button type="submit" class="btn" 
                style="background-color: var(--bg-sidebar); color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">
            <i class="fas fa-save"></i> Update Status
        </button>
        
        @if(!in_array($pesanan->status, ['selesai', 'dibatalkan']))
        <button type="button" onclick="confirmBatal()" 
                style="background-color: #dc3545; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">
            <i class="fas fa-times"></i> Batalkan Pesanan
        </button>
        @endif
    </form>
    
    <form id="batalForm" action="{{ route('admin.pesanan.batal', $pesanan->id_pesanan) }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>

<div style="margin-top: 20px; display: flex; gap: 10px;">
    <a href="{{ route('admin.pesanan.index') }}" class="btn" 
       style="background-color: #6c757d; color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none;">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
    </a>
    
    @if($pesanan->status == 'diantar')
    <form action="{{ route('admin.pesanan.update-status', $pesanan->id_pesanan) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="status" value="selesai">
        <button type="submit" class="btn" 
                style="background-color: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">
            <i class="fas fa-check"></i> Tandai sebagai Selesai
        </button>
    </form>
    @endif
</div>

<script>
function confirmBatal() {
    if (confirm('Apakah Anda yakin ingin membatalkan pesanan ini?\n\nStok produk akan dikembalikan ke sistem.')) {
        document.getElementById('batalForm').submit();
    }
}

// Auto-refresh halaman setiap 30 detik untuk update status real-time
setTimeout(function() {
    window.location.reload();
}, 30000);
</script>

<style>
.orders-section {
    background-color: var(--bg-card);
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 2px 4px rgba(0,0,0,0.1);
    border: 1px solid var(--border-color);
}

.section-title {
    font-family: var(--font-title);
    font-size: 20px;
    color: var(--text-secondary);
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid var(--bg-table-header);
}

.table-container {
    overflow-x: auto;
    margin-bottom: 15px;
}

table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

th, td {
    padding: 12px 10px;
    text-align: left;
    border-bottom: 1px solid var(--border-color);
}

thead {
    background-color: var(--bg-table-header);
}

th {
    font-weight: 600;
    color: var(--text-secondary);
}

.status-badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 4px;
    color: white;
    font-weight: 700;
    font-size: 12px;
    text-align: center;
    min-width: 70px;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    cursor: pointer;
}

.btn:hover {
    opacity: 0.9;
}
</style>
@endsection