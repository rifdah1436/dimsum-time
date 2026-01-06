@extends('admin.layouts.main')

@section('content')
<header class="main-header">
    <h2 class="page-title">Manajemen Produk</h2>
    <p class="page-subtitle">Kelola menu dan varian dimsum</p>
</header>

<div class="summary-section" style="margin-bottom: 20px;">
    <div class="summary-card" style="grid-column: span 4; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <p class="card-title">Total Produk</p>
            <p class="card-value">{{ $produk->total() }}</p>
        </div>
        <a href="{{ route('admin.produk.create') }}" class="btn" style="background-color: var(--bg-sidebar); color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none;">
            <i class="fas fa-plus"></i> Tambah Produk
        </a>
    </div>
</div>

<div class="orders-section">
    <div class="table-controls">
        <form method="GET" style="display: flex; gap: 10px; flex-wrap: wrap;">
            <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}" 
                   style="padding: 8px; border: 1px solid var(--border-color); border-radius: 4px;">
            
            <select name="kategori" style="padding: 8px; border: 1px solid var(--border-color); border-radius: 4px;">
                <option value="">Semua Kategori</option>
                @foreach($kategori as $kat)
                    <option value="{{ $kat->id_kategori }}" {{ request('kategori') == $kat->id_kategori ? 'selected' : '' }}>
                        {{ $kat->nama_kategori }}
                    </option>
                @endforeach
            </select>
            
            <select name="status" style="padding: 8px; border: 1px solid var(--border-color); border-radius: 4px;">
                <option value="">Semua Status</option>
                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Tersedia</option>
                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Habis</option>
            </select>
            
            <button type="submit" class="btn" style="background-color: var(--bg-sidebar); color: white; padding: 8px 16px; border: none; border-radius: 4px;">
                <i class="fas fa-search"></i> Filter
            </button>
            
            <a href="{{ route('admin.produk.index') }}" class="btn" style="background-color: #6c757d; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none;">
                <i class="fas fa-redo"></i> Reset
            </a>
        </form>
    </div>
    
    <div class="table-container">
        <table id="produkTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Menu</th>
                    <th>Kategori</th>
                    <th>Varian</th>
                    <th>Status</th>
                    <th>Tanggal Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produk as $index => $item)
                <tr>
                    <td>{{ $index + 1 + (($produk->currentPage() - 1) * $produk->perPage()) }}</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            @if($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama_menu }}" 
                                     style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                            @else
                                <div style="width: 40px; height: 40px; background-color: #f0f0f0; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-image" style="color: #999;"></i>
                                </div>
                            @endif
                            <div>
                                <strong>{{ $item->nama_menu }}</strong><br>
                                <small style="color: #666;">{{ Str::limit($item->deskripsi, 50) }}</small>
                            </div>
                        </div>
                    </td>
                    <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                    <td>
                        @if($item->variants->count() > 0)
                            <span class="badge" style="background-color: #17a2b8; color: white; padding: 4px 8px; border-radius: 4px;">
                                {{ $item->variants->count() }} varian
                            </span>
                        @else
                            <span class="badge" style="background-color: #6c757d; color: white; padding: 4px 8px; border-radius: 4px;">
                                Belum ada varian
                            </span>
                        @endif
                    </td>
                    <td>
                        @if($item->status_tersedia)
                            <span class="status-badge status-selesai">Tersedia</span>
                        @else
                            <span class="status-badge status-gagal">Habis</span>
                        @endif
                    </td>
                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div style="display: flex; gap: 5px;">
                            {{-- Tombol Edit --}}
                            <a href="{{ route('admin.produk.edit', $item->id_menu) }}" 
                               class="btn-action" title="Edit" style="color: #17a2b8;">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            
                            {{-- Tombol Hapus dengan JavaScript --}}
                            <button type="button" 
                                    onclick="confirmDeleteProduk({{ $item->id_menu }}, '{{ addslashes($item->nama_menu) }}', {{ $item->variants->count() }})"
                                    class="btn-action" title="Hapus" style="color: #dc3545;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center" style="text-align: center; padding: 20px;">
                        <i class="fas fa-box-open" style="font-size: 48px; color: #ddd; margin-bottom: 10px;"></i><br>
                        Belum ada produk
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($produk->hasPages())
    <div class="table-footer">
        <p>Menampilkan {{ $produk->firstItem() }} - {{ $produk->lastItem() }} dari {{ $produk->total() }} produk</p>
        <nav class="pagination">
            {{ $produk->links('vendor.pagination.simple') }}
        </nav>
    </div>
    @endif
</div>

{{-- Form tersembunyi untuk hapus --}}
<form id="deleteForm" action="" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
// Fungsi konfirmasi hapus produk
function confirmDeleteProduk(id, namaProduk, jumlahVarian) {
    let message = `Apakah Anda yakin ingin menghapus produk "${namaProduk}"?`;
    
    if (jumlahVarian > 0) {
        message += `\n\nProduk ini memiliki ${jumlahVarian} varian yang juga akan dihapus.`;
    }
    
    if (confirm(message)) {
        // Set action form
        const form = document.getElementById('deleteForm');
        form.action = `/admin/produk/${id}`;
        
        // Submit form
        form.submit();
    }
}

// Alternatif: Event listener untuk semua tombol hapus
document.addEventListener('DOMContentLoaded', function() {
    // Debug: log untuk memastikan script berjalan
    console.log('Produk index loaded');
    
    // Tambahkan event listener jika mau pakai cara lain
    document.querySelectorAll('[title="Hapus"]').forEach(button => {
        button.addEventListener('click', function(e) {
            console.log('Tombol hapus diklik');
        });
    });
});
</script>

<style>
.btn-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 4px;
    border: none;
    background-color: transparent;
    color: inherit;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.3s;
}

.btn-action:hover {
    background-color: rgba(0, 0, 0, 0.1);
}

.btn-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 4px;
    text-decoration: none;
    transition: all 0.3s;
}

.btn-link:hover {
    background-color: rgba(0,0,0,0.1);
}

/* Status Badge Colors */
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

.status-selesai { background-color: #28a745; }
.status-gagal { background-color: #dc3545; }
</style>
@endsection