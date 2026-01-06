@extends('admin.layouts.main')

@section('content')
<header class="main-header">
    <h2 class="page-title">Edit Produk: {{ $produk->nama_menu }}</h2>
    <p class="page-subtitle">Edit informasi menu dimsum</p>
</header>

<div class="orders-section">
    <form action="{{ route('admin.produk.update', $produk->id_menu) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
            <!-- Kolom 1: Informasi Dasar Produk -->
            <div>
                <h3 style="color: var(--text-secondary); margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid var(--bg-table-header);">
                    <i class="fas fa-info-circle"></i> Informasi Dasar
                </h3>
                
                <!-- Nama Menu -->
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; color: var(--text-secondary);">
                        Nama Menu <span style="color: #dc3545;">*</span>
                    </label>
                    <input type="text" name="nama_menu" 
                           class="form-input"
                           placeholder="Contoh: Dimsum Ayam Jamur"
                           value="{{ old('nama_menu', $produk->nama_menu) }}"
                           required>
                </div>
                
                <!-- Kategori -->
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; color: var(--text-secondary);">
                        Kategori <span style="color: #dc3545;">*</span>
                    </label>
                    <select name="id_kategori" class="form-select" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id_kategori }}" {{ (old('id_kategori', $produk->id_kategori) == $kat->id_kategori) ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Status Ketersediaan -->
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; color: var(--text-secondary);">
                        Status Ketersediaan
                    </label>
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <label style="display: flex; align-items: center; gap: 5px; cursor: pointer;">
                            <input type="checkbox" name="status_tersedia" value="1" 
                                   {{ old('status_tersedia', $produk->status_tersedia) ? 'checked' : '' }}
                                   style="width: 18px; height: 18px;">
                            <span>Tersedia</span>
                        </label>
                    </div>
                </div>
                
                <!-- Gambar Produk -->
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; color: var(--text-secondary);">
                        Gambar Produk
                    </label>
                    
                    @if($produk->gambar)
                    <div style="margin-bottom: 15px;">
                        <img src="{{ asset('storage/' . $produk->gambar) }}" 
                             alt="{{ $produk->nama_menu }}"
                             style="max-width: 200px; max-height: 200px; border-radius: 6px; border: 1px solid var(--border-color);">
                        <div style="margin-top: 5px;">
                            <a href="{{ asset('storage/' . $produk->gambar) }}" target="_blank" 
                               style="color: #17a2b8; text-decoration: none; font-size: 13px;">
                                <i class="fas fa-external-link-alt"></i> Lihat Gambar
                            </a>
                        </div>
                    </div>
                    @endif
                    
                    <div style="border: 2px dashed var(--border-color); border-radius: 8px; padding: 15px; text-align: center; background-color: #f8f9fa;">
                        <p style="margin-bottom: 10px; color: #666;">Ubah gambar (opsional)</p>
                        <input type="file" name="gambar" 
                               accept="image/*"
                               style="width: 100%; padding: 8px;">
                    </div>
                    <small style="color: #666; display: block; margin-top: 5px;">
                        Biarkan kosong jika tidak ingin mengubah gambar
                    </small>
                </div>
            </div>
            
            <!-- Kolom 2: Deskripsi -->
            <div>
                <h3 style="color: var(--text-secondary); margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid var(--bg-table-header);">
                    <i class="fas fa-align-left"></i> Deskripsi
                </h3>
                
                <!-- Deskripsi -->
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; color: var(--text-secondary);">
                        Deskripsi Menu
                    </label>
                    <textarea name="deskripsi" 
                              class="form-textarea"
                              placeholder="Deskripsi lengkap tentang menu..."
                              rows="10">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                </div>
            </div>
        </div>
        
        <!-- Tombol Aksi -->
        <div style="display: flex; justify-content: flex-end; gap: 10px; padding-top: 20px; border-top: 1px solid var(--border-color);">
            <a href="{{ route('admin.produk.index') }}" 
               class="btn" style="background-color: #6c757d; color: white; text-decoration: none;">
                <i class="fas fa-times"></i> Batal
            </a>
            <a href="{{ route('admin.produk.varian.edit', $produk->id_menu) }}" 
   class="btn" style="background-color: #17a2b8; color: white; text-decoration: none;">
    <i class="fas fa-edit"></i> Edit Varian
</a>
            <button type="submit" class="btn" style="background-color: var(--bg-sidebar); color: white;">
                <i class="fas fa-save"></i> Update Produk
            </button>
        </div>
    </form>
</div>

<style>
.form-input, .form-select, .form-textarea {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid var(--border-color);
    border-radius: 4px;
    font-size: 14px;
    transition: all 0.3s;
    background-color: white;
}

.form-input:focus, .form-select:focus, .form-textarea:focus {
    outline: none;
    border-color: var(--bg-sidebar);
    box-shadow: 0 0 0 2px rgba(229, 57, 53, 0.1);
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
}

.btn:hover {
    opacity: 0.9;
    transform: translateY(-1px);
}
</style>
@endsection