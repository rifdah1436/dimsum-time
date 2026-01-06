@extends('admin.layouts.main')

@section('content')
<header class="main-header">
    <h2 class="page-title">Edit Varian Produk: {{ $produk->nama_menu }}</h2>
    <p class="page-subtitle">Kelola varian produk</p>
</header>

<div class="orders-section">
    <!-- Tombol Tambah Varian -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <a href="{{ route('admin.produk.edit', $produk->id_menu) }}" 
           class="btn" style="background-color: #6c757d; color: white; text-decoration: none;">
            <i class="fas fa-arrow-left"></i> Kembali ke Edit Produk
        </a>
        <a href="{{ route('admin.produk.create') }}" 
           class="btn" style="background-color: var(--bg-sidebar); color: white; text-decoration: none;">
            <i class="fas fa-plus"></i> Tambah Varian Baru
        </a>
    </div>
    
    <!-- List Varian -->
    <div class="table-container">
        <table id="varianTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Ukuran</th>
                    <th>Jumlah/Pcs</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Stok Minimum</th>
                    <th>Status Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produk->varian as $index => $varian)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $varian->ukuran }}</td>
                    <td>{{ $varian->jumlah_pcs }} pcs</td>
                    <td>Rp{{ number_format($varian->harga, 0, ',', '.') }}</td>
                    <td>
                        <span id="stok-{{ $varian->id_varian }}" style="font-weight: bold;">
                            {{ $varian->stok }}
                        </span>
                        <button type="button" 
                                onclick="showUpdateStokModal({{ $varian->id_varian }}, {{ $varian->stok }})"
                                class="btn-small" 
                                style="background-color: #17a2b8; color: white; padding: 2px 8px; border-radius: 3px; margin-left: 5px; font-size: 12px;">
                            <i class="fas fa-edit"></i>
                        </button>
                    </td>
                    <td>{{ $varian->stok_minimum }}</td>
                    <td>
                        @if($varian->stok <= 0)
                            <span class="status-badge status-gagal">Habis</span>
                        @elseif($varian->stok <= $varian->stok_minimum)
                            <span class="status-badge status-pending">Hampir Habis</span>
                        @else
                            <span class="status-badge status-selesai">Aman</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 5px;">
                            <!-- Edit Varian Modal Trigger -->
                            <button type="button" 
                                    onclick="showEditVarianModal({{ $varian->id_varian }})"
                                    class="btn-action" title="Edit Varian" style="color: #17a2b8;">
                                <i class="fas fa-edit"></i>
                            </button>
                            
                            <!-- Hapus Varian -->
                            <form action="{{ route('admin.produk.varian.destroy', [$produk->id_menu, $varian->id_varian]) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Hapus varian ini?')"
                                  style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action" title="Hapus" style="color: #dc3545;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center" style="text-align: center; padding: 20px;">
                        <i class="fas fa-box" style="font-size: 48px; color: #ddd; margin-bottom: 10px;"></i><br>
                        Belum ada varian
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Edit Varian -->
<div id="editVarianModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit Varian</h3>
            <span class="close" onclick="closeEditVarianModal()">&times;</span>
        </div>
        <div class="modal-body">
            <form id="editVarianForm" method="POST">
                @csrf
                @method('PUT')
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Ukuran</label>
                        <select name="ukuran" id="editUkuran" class="form-select-sm">
                            <option value="Reguler">Reguler</option>
                            <option value="S">Small (S)</option>
                            <option value="M">Medium (M)</option>
                            <option value="L">Large (L)</option>
                            <option value="XL">Extra Large (XL)</option>
                        </select>
                    </div>
                    
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Jumlah/Pcs</label>
                        <input type="number" name="jumlah_pcs" id="editJumlahPcs" 
                               class="form-input-sm" min="1" required>
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Harga <span style="color: #dc3545;">*</span></label>
                        <div style="position: relative;">
                            <span style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #666;">Rp</span>
                            <input type="number" name="harga" id="editHarga" 
                                   class="form-input-sm" 
                                   min="0" 
                                   step="500"
                                   style="padding-left: 30px;"
                                   required>
                        </div>
                    </div>
                    
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Stok Minimum</label>
                        <input type="number" name="stok_minimum" id="editStokMinimum" 
                               class="form-input-sm" min="1" required>
                    </div>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Stok Saat Ini</label>
                    <input type="number" name="stok" id="editStok" 
                           class="form-input-sm" min="0">
                    <small style="color: #666;">Isi untuk mengubah stok</small>
                </div>
                
                <div style="display: flex; gap: 10px; justify-content: flex-end;">
                    <button type="button" onclick="closeEditVarianModal()" class="btn-cancel">
                        Batal
                    </button>
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Update Stok -->
<div id="updateStokModal" class="modal" style="display: none;">
    <div class="modal-content" style="max-width: 400px;">
        <div class="modal-header">
            <h3>Update Stok</h3>
            <span class="close" onclick="closeUpdateStokModal()">&times;</span>
        </div>
        <div class="modal-body">
            <form id="updateStokForm" method="POST">
                @csrf
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Stok Baru</label>
                    <input type="number" name="stok" id="newStok" 
                           class="form-input" 
                           min="0" 
                           required>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Keterangan (Opsional)</label>
                    <textarea name="keterangan" 
                              class="form-textarea" 
                              placeholder="Misal: Stok masuk dari supplier, atau penjualan"
                              rows="2"></textarea>
                </div>
                
                <div style="display: flex; gap: 10px; justify-content: flex-end;">
                    <button type="button" onclick="closeUpdateStokModal()" class="btn-cancel">
                        Batal
                    </button>
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Update Stok
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
}

.modal-content {
    background-color: white;
    margin: 5% auto;
    padding: 0;
    border-radius: 8px;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.2);
    animation: modalopen 0.3s;
}

@keyframes modalopen {
    from {opacity: 0; transform: translateY(-50px);}
    to {opacity: 1; transform: translateY(0);}
}

.modal-header {
    padding: 15px 20px;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h3 {
    margin: 0;
    font-size: 18px;
    color: var(--text-secondary);
}

.close {
    font-size: 24px;
    font-weight: bold;
    cursor: pointer;
    color: #666;
}

.close:hover {
    color: #000;
}

.modal-body {
    padding: 20px;
}

/* Form Styles */
.form-input, .form-select, .form-textarea {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid var(--border-color);
    border-radius: 4px;
    font-size: 14px;
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

.btn-small {
    padding: 4px 8px;
    font-size: 12px;
    border-radius: 3px;
    cursor: pointer;
    border: none;
}

.btn-cancel {
    padding: 8px 16px;
    background: #6c757d;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn-save {
    padding: 8px 16px;
    background: var(--bg-sidebar);
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

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
    background-color: rgba(0,0,0,0.1);
}

/* Status Badge */
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
.status-pending { background-color: #ffc107; }
.status-gagal { background-color: #dc3545; }
</style>

<script>
let currentVarianId = null;

// Modal Edit Varian
function showEditVarianModal(varianId) {
    currentVarianId = varianId;
    const modal = document.getElementById('editVarianModal');
    const form = document.getElementById('editVarianForm');
    
    // Set form action
    form.action = `/admin/produk/${currentVarianId}/varian`;
    
    // Fetch varian data via AJAX
    fetch(`/admin/produk/varian/${varianId}/data`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Fill form with existing data
                document.getElementById('editUkuran').value = data.varian.ukuran;
                document.getElementById('editJumlahPcs').value = data.varian.jumlah_pcs;
                document.getElementById('editHarga').value = data.varian.harga;
                document.getElementById('editStok').value = data.varian.stok;
                document.getElementById('editStokMinimum').value = data.varian.stok_minimum;
                
                // Show modal
                modal.style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal memuat data varian');
        });
}

function closeEditVarianModal() {
    document.getElementById('editVarianModal').style.display = 'none';
}

// Modal Update Stok
function showUpdateStokModal(varianId, currentStok) {
    currentVarianId = varianId;
    const modal = document.getElementById('updateStokModal');
    const form = document.getElementById('updateStokForm');
    const stokInput = document.getElementById('newStok');
    
    // Set form action
    form.action = `/admin/produk/varian/${varianId}/stok`;
    
    // Set current stok as placeholder
    stokInput.value = currentStok;
    stokInput.focus();
    
    // Show modal
    modal.style.display = 'block';
}

function closeUpdateStokModal() {
    document.getElementById('updateStokModal').style.display = 'none';
}

// Close modal when clicking outside
window.onclick = function(event) {
    const editModal = document.getElementById('editVarianModal');
    const stokModal = document.getElementById('updateStokModal');
    
    if (event.target === editModal) {
        closeEditVarianModal();
    }
    if (event.target === stokModal) {
        closeUpdateStokModal();
    }
};

// Handle form submission with AJAX for better UX
document.getElementById('updateStokForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const formData = new FormData(form);
    
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update stok display
            const stokElement = document.getElementById(`stok-${currentVarianId}`);
            if (stokElement) {
                stokElement.textContent = formData.get('stok');
            }
            
            alert('Stok berhasil diperbarui');
            closeUpdateStokModal();
            
            // Reload page untuk update status stok
            setTimeout(() => {
                window.location.reload();
            }, 500);
        } else {
            alert('Gagal memperbarui stok: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memperbarui stok');
    });
});

// Quick stok update tanpa modal (opsional)
function quickUpdateStok(varianId, change) {
    const stokElement = document.getElementById(`stok-${varianId}`);
    const currentStok = parseInt(stokElement.textContent);
    const newStok = currentStok + change;
    
    if (newStok < 0) return;
    
    if (confirm(`Ubah stok dari ${currentStok} menjadi ${newStok}?`)) {
        fetch(`/admin/produk/varian/${varianId}/stok-quick`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                stok: newStok,
                perubahan: change > 0 ? `+${change}` : change.toString()
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                stokElement.textContent = newStok;
                alert('Stok berhasil diperbarui');
            }
        });
    }
}
</script>
@endsection