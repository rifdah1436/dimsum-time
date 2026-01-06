@extends('admin.layouts.main')

@section('content')
<header class="main-header">
    <h2 class="page-title">Tambah Produk Baru</h2>
    <p class="page-subtitle">Tambahkan menu dimsum baru ke katalog</p>
</header>

<div class="orders-section">
    <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data" id="produkFrom">
        @csrf
        
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
                           value="{{ old('nama_menu') }}"
                           required>
                    @error('nama_menu')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Kategori -->
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; color: var(--text-secondary);">
                        Kategori <span style="color: #dc3545;">*</span>
                    </label>
                    <select name="id_kategori" class="form-select" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id_kategori }}" {{ old('id_kategori') == $kat->id_kategori ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_kategori')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Status Ketersediaan -->
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; color: var(--text-secondary);">
                        Status Ketersediaan
                    </label>
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <label style="display: flex; align-items: center; gap: 5px; cursor: pointer;">
                            <input type="checkbox" name="status_tersedia" value="1" 
                                   {{ old('status_tersedia', true) ? 'checked' : '' }}
                                   style="width: 18px; height: 18px;">
                            <span>Tersedia</span>
                        </label>
                        <small style="color: #666;">Jika tidak dicentang, produk akan ditandai sebagai habis</small>
                    </div>
                </div>
                
                <!-- Gambar Produk -->
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; color: var(--text-secondary);">
                        Gambar Produk
                    </label>
                    <div style="border: 2px dashed var(--border-color); border-radius: 8px; padding: 20px; text-align: center; background-color: #f8f9fa;">
                        <div id="imagePreview" style="margin-bottom: 15px; display: none;">
                            <img id="previewImage" src="#" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 6px;">
                        </div>
                        <div id="uploadArea">
                            <i class="fas fa-cloud-upload-alt" style="font-size: 48px; color: #6c757d; margin-bottom: 10px;"></i>
                            <p style="margin-bottom: 10px; color: #666;">Drag & drop gambar atau klik untuk upload</p>
                            <input type="file" name="gambar" id="gambarInput" 
                                   accept="image/*" 
                                   style="display: none;" 
                                   onchange="previewImage(this)">
                            <button type="button" onclick="document.getElementById('gambarInput').click()" 
                                    class="btn" style="background-color: #6c757d; color: white;">
                                <i class="fas fa-upload"></i> Pilih Gambar
                            </button>
                        </div>
                    </div>
                    <small style="color: #666; display: block; margin-top: 5px;">
                        Format: JPG, PNG, GIF (Maks: 2MB)
                    </small>
                    @error('gambar')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <!-- Kolom 2: Deskripsi dan Varian -->
            <div>
                <h3 style="color: var(--text-secondary); margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid var(--bg-table-header);">
                    <i class="fas fa-align-left"></i> Deskripsi & Detail
                </h3>
                
                <!-- Deskripsi -->
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; color: var(--text-secondary);">
                        Deskripsi Menu
                    </label>
                    <textarea name="deskripsi" 
                              class="form-textarea"
                              placeholder="Deskripsi lengkap tentang menu..."
                              rows="5">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Varian Produk -->
                <h3 style="color: var(--text-secondary); margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid var(--bg-table-header);">
                    <i class="fas fa-boxes"></i> Varian Produk
                </h3>
                
                <div id="varianContainer">
                    <!-- Varian akan ditambahkan dinamis di sini -->
                    <div class="varian-item" style="background-color: #f8f9fa; padding: 15px; border-radius: 6px; margin-bottom: 15px; border: 1px solid var(--border-color);">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                            <h4 style="margin: 0; color: var(--text-secondary);">Varian #1</h4>
                            <button type="button" class="btn-remove-varian" 
                                    style="background-color: #dc3545; color: white; border: none; border-radius: 4px; width: 30px; height: 30px; cursor: pointer; display: none;">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 10px;">
                            <!-- Ukuran -->
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-size: 13px; color: #666;">Ukuran</label>
                                <select name="varian[0][ukuran]" class="form-select-sm">
                                    <option value="Reguler">Reguler</option>
                                    <option value="S">Small (S)</option>
                                    <option value="M">Medium (M)</option>
                                    <option value="L">Large (L)</option>
                                    <option value="XL">Extra Large (XL)</option>
                                </select>
                            </div>
                            
                            <!-- Jumlah Pcs -->
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-size: 13px; color: #666;">Jumlah/Pcs</label>
                                <input type="number" name="varian[0][jumlah_pcs]" 
                                       class="form-input-sm"
                                       placeholder="10"
                                       min="1"
                                       value="{{ old('varian.0.jumlah_pcs', 1) }}"
                                       required>
                            </div>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 10px;">
                            <!-- Harga -->
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-size: 13px; color: #666;">Harga <span style="color: #dc3545;">*</span></label>
                                <div style="position: relative;">
                                    <span style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #666;">Rp</span>
                                    <input type="number" name="varian[0][harga]" 
                                           class="form-input-sm"
                                           placeholder="25000"
                                           min="0"
                                           step="500"
                                           value="{{ old('varian.0.harga') }}"
                                           style="padding-left: 30px;"
                                           required>
                                </div>
                            </div>
                            
                            <!-- Stok Awal -->
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-size: 13px; color: #666;">Stok Awal</label>
                                <input type="number" name="varian[0][stok]" 
                                       class="form-input-sm"
                                       placeholder="50"
                                       min="0"
                                       value="{{ old('varian.0.stok', 0) }}">
                            </div>
                        </div>
                        
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-size: 13px; color: #666;">Stok Minimum</label>
                            <input type="number" name="varian[0][stok_minimum]" 
                                   class="form-input-sm"
                                   placeholder="10"
                                   min="1"
                                   value="{{ old('varian.0.stok_minimum', 10) }}">
                        </div>
                    </div>
                </div>
                
                <!-- Tombol Tambah Varian -->
                <button type="button" onclick="tambahVarian()" 
                        class="btn" style="background-color: #17a2b8; color: white; margin-bottom: 20px;">
                    <i class="fas fa-plus"></i> Tambah Varian Lain
                </button>
                
                <div style="background-color: #e7f3ff; padding: 10px; border-radius: 6px; border-left: 4px solid #17a2b8;">
                    <p style="margin: 0; color: #0066cc; font-size: 13px;">
                        <i class="fas fa-info-circle"></i> 
                        <strong>Tips:</strong> Minimal 1 varian harus diisi. Anda bisa menambahkan varian dengan ukuran berbeda.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Tombol Aksi -->
        <div style="display: flex; justify-content: flex-end; gap: 10px; padding-top: 20px; border-top: 1px solid var(--border-color);">
            <a href="{{ route('admin.produk.index') }}" 
               class="btn" style="background-color: #6c757d; color: white; text-decoration: none;">
                <i class="fas fa-times"></i> Batal
            </a>
            <button type="submit" class="btn" style="background-color: var(--bg-sidebar); color: white;">
                <i class="fas fa-save"></i> Simpan Produk
            </button>
        </div>
    </form>
</div>

<style>
/* Form Styles */
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

.form-input-sm {
    width: 100%;
    padding: 8px 10px;
    border: 1px solid var(--border-color);
    border-radius: 4px;
    font-size: 13px;
}

.form-select-sm {
    width: 100%;
    padding: 8px 10px;
    border: 1px solid var(--border-color);
    border-radius: 4px;
    font-size: 13px;
    background-color: white;
}

/* Button Styles */
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

/* Error Message */
.error-message {
    color: #dc3545;
    font-size: 12px;
    margin-top: 5px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.error-message:before {
    content: "⚠";
    font-size: 14px;
}

/* Varian Item Animation */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.varian-item {
    animation: fadeIn 0.3s ease-out;
}
</style>

<script>
let varianCount = 1;

function tambahVarian() {
    const container = document.getElementById('varianContainer');
    
    // Clone template varian pertama
    const template = document.querySelector('.varian-item');
    const newVarian = template.cloneNode(true);
    
    // Update nomor varian
    newVarian.querySelector('h4').textContent = `Varian #${varianCount + 1}`;
    
    // Update input names
    const inputs = newVarian.querySelectorAll('input, select');
    inputs.forEach(input => {
        const name = input.getAttribute('name');
        if (name) {
            input.setAttribute('name', name.replace('[0]', `[${varianCount}]`));
        }
    });
    
    // Reset values
    newVarian.querySelectorAll('input[type="number"]').forEach(input => {
        if (input.name.includes('harga')) {
            input.value = '';
        } else if (input.name.includes('jumlah_pcs')) {
            input.value = '1';
        } else if (input.name.includes('stok')) {
            input.value = '0';
        } else if (input.name.includes('stok_minimum')) {
            input.value = '10';
        }
    });
    
    // Tampilkan tombol hapus
    newVarian.querySelector('.btn-remove-varian').style.display = 'flex';
    
    // Tambah event listener untuk tombol hapus
    const removeBtn = newVarian.querySelector('.btn-remove-varian');
    removeBtn.onclick = function() {
        if (document.querySelectorAll('.varian-item').length > 1) {
            newVarian.remove();
            updateVarianNumbers();
        }
    };
    
    // Tambah ke container
    container.appendChild(newVarian);
    varianCount++;
    
    // Scroll ke varian baru
    newVarian.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

function updateVarianNumbers() {
    const varianItems = document.querySelectorAll('.varian-item');
    varianCount = varianItems.length;
    
    varianItems.forEach((item, index) => {
        item.querySelector('h4').textContent = `Varian #${index + 1}`;
        
        // Update input names
        const inputs = item.querySelectorAll('input, select');
        inputs.forEach(input => {
            const name = input.getAttribute('name');
            if (name) {
                const newName = name.replace(/\[\d+\]/, `[${index}]`);
                input.setAttribute('name', newName);
            }
        });
        
        // Sembunyikan tombol hapus untuk varian pertama
        if (index === 0) {
            item.querySelector('.btn-remove-varian').style.display = 'none';
        } else {
            item.querySelector('.btn-remove-varian').style.display = 'flex';
        }
    });
}

// Inisialisasi tombol hapus untuk varian pertama
document.addEventListener('DOMContentLoaded', function() {
    const firstRemoveBtn = document.querySelector('.btn-remove-varian');
    if (firstRemoveBtn) {
        firstRemoveBtn.style.display = 'none';
    }
    
    // Tambah event listener untuk semua tombol hapus yang sudah ada
    document.querySelectorAll('.btn-remove-varian').forEach(btn => {
        if (btn.closest('.varian-item') !== document.querySelector('.varian-item')) {
            btn.style.display = 'flex';
            btn.onclick = function() {
                if (document.querySelectorAll('.varian-item').length > 1) {
                    btn.closest('.varian-item').remove();
                    updateVarianNumbers();
                }
            };
        }
    });
});

// Image Preview Function
function previewImage(input) {
    const preview = document.getElementById('previewImage');
    const previewContainer = document.getElementById('imagePreview');
    const uploadArea = document.getElementById('uploadArea');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
            uploadArea.style.display = 'none';
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Drag and drop untuk gambar
document.addEventListener('DOMContentLoaded', function() {
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('gambarInput');
    
    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });
    
    // Highlight drop area when item is dragged over it
    ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, unhighlight, false);
    });
    
    // Handle dropped files
    uploadArea.addEventListener('drop', handleDrop, false);
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    function highlight() {
        uploadArea.style.borderColor = '#007bff';
        uploadArea.style.backgroundColor = '#e7f3ff';
    }
    
    function unhighlight() {
        uploadArea.style.borderColor = 'var(--border-color)';
        uploadArea.style.backgroundColor = '#f8f9fa';
    }
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length > 0) {
            fileInput.files = files;
            previewImage(fileInput);
        }
    }
});

// Form Validation
document.querySelector('produkform').addEventListener('submit', function(e) {
    let isValid = true;
    const errorMessages = [];
    
    // Validasi nama menu
    const namaMenu = document.querySelector('input[name="nama_menu"]');
    if (!namaMenu.value.trim()) {
        isValid = false;
        errorMessages.push('Nama menu harus diisi');
    }
    
    // Validasi kategori
    const kategori = document.querySelector('select[name="id_kategori"]');
    if (!kategori.value) {
        isValid = false;
        errorMessages.push('Kategori harus dipilih');
    }
    
    // Validasi varian
    const varianHarga = document.querySelectorAll('input[name^="varian"][name$="[harga]"]');
    let hasValidVarian = false;
    varianHarga.forEach(input => {
        if (input.value && parseFloat(input.value) > 0) {
            hasValidVarian = true;
        }
    });
    
    if (!hasValidVarian) {
        isValid = false;
        errorMessages.push('Minimal 1 varian dengan harga harus diisi');
    }
    
    if (!isValid) {
        e.preventDefault();
        alert('Periksa kembali form:\n\n' + errorMessages.join('\n'));
    }
});
</script>
@endsection