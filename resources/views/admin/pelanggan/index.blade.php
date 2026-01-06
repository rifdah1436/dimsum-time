@extends('admin.layouts.main')

@section('content')
<header class="main-header">
    <h2 class="page-title">Manajemen Pelanggan</h2>
    <p class="page-subtitle">Kelola data pelanggan Dimsum Time</p>
</header>

<div class="summary-section" style="margin-bottom: 20px;">
    <div class="summary-card" style="grid-column: span 4; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <p class="card-title">Total Pelanggan</p>
            <p class="card-value">{{ $pelanggan->total() }}</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <form method="GET" style="display: flex; gap: 10px;">
                <input type="text" name="search" placeholder="Cari pelanggan..." value="{{ request('search') }}" 
                       style="padding: 8px; border: 1px solid var(--border-color); border-radius: 4px;">
                <button type="submit" class="btn" style="background-color: var(--bg-sidebar); color: white; padding: 8px 16px; border: none; border-radius: 4px;">
                    <i class="fas fa-search"></i> Cari
                </button>
            </form>
        </div>
    </div>
</div>

<div class="orders-section">
    <div class="table-container">
        <table id="pelangganTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pelanggan</th>
                    <th>Kontak</th>
                    <th>Total Pesanan</th>
                    <th>Total Belanja</th>
                    <th>Status</th>
                    <th>Tanggal Bergabung</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pelanggan as $index => $item)
                <tr>
                    <td>{{ $index + 1 + (($pelanggan->currentPage() - 1) * $pelanggan->perPage()) }}</td>
                    <td>
                        <strong>{{ $item->nama_lengkap }}</strong><br>
                        <small style="color: #666;">{{ $item->username }}</small>
                    </td>
                    <td>
                        {{ $item->email }}<br>
                        <small style="color: #666;">{{ $item->nomor_telepon }}</small>
                    </td>
                    <td>
                        <span class="badge" style="background-color: var(--bg-sidebar); color: white; padding: 4px 8px; border-radius: 4px;">
                            {{ $item->pesanan_count }} pesanan
                        </span>
                    </td>
                    <td>
                        @php
                            $totalBelanja = $item->pesanan()->where('status', 'selesai')->sum('total_bayar');
                        @endphp
                        Rp{{ number_format($totalBelanja, 0, ',', '.') }}
                    </td>
                    <td>
                        <div class="toggle-switch">
                            <input type="checkbox" id="status-{{ $item->id_pengguna }}" 
                                   {{ $item->status_aktif ? 'checked' : '' }}
                                   onchange="updateStatus({{ $item->id_pengguna }}, this.checked)">
                            <label for="status-{{ $item->id_pengguna }}"></label>
                        </div>
                    </td>
                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div style="display: flex; gap: 5px;">
                            <a href="{{ route('admin.pelanggan.show', $item->id_pengguna) }}" 
                               class="btn-link" title="Detail" style="color: var(--bg-sidebar);">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center" style="text-align: center; padding: 20px;">
                        <i class="fas fa-users" style="font-size: 48px; color: #ddd; margin-bottom: 10px;"></i><br>
                        Belum ada pelanggan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($pelanggan->hasPages())
    <div class="table-footer">
        <p>Menampilkan {{ $pelanggan->firstItem() }} - {{ $pelanggan->lastItem() }} dari {{ $pelanggan->total() }} pelanggan</p>
        <nav class="pagination">
            {{ $pelanggan->links('vendor.pagination.simple') }}
        </nav>
    </div>
    @endif
</div>

<script>
function updateStatus(userId, isActive) {
    const status = isActive ? 'aktif' : 'nonaktif';
    
    fetch(`/admin/pelanggan/${userId}/status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Status berhasil diperbarui');
        } else {
            alert('Gagal memperbarui status');
            // Reset toggle
            const checkbox = document.getElementById(`status-${userId}`);
            checkbox.checked = !isActive;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
        // Reset toggle
        const checkbox = document.getElementById(`status-${userId}`);
        checkbox.checked = !isActive;
    });
}
</script>

<style>
.toggle-switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 24px;
}

.toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-switch label {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 24px;
}

.toggle-switch label:before {
    position: absolute;
    content: "";
    height: 16px;
    width: 16px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

.toggle-switch input:checked + label {
    background-color: var(--bg-status-selesai);
}

.toggle-switch input:checked + label:before {
    transform: translateX(26px);
}
</style>
@endsection