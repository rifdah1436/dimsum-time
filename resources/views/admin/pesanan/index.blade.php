@extends('admin.layouts.main')

@section('content')
<header class="main-header">
    <h2 class="page-title">Manajemen Pesanan</h2>
    <p class="page-subtitle">Kelola semua pesanan pelanggan</p>
</header>

<div class="summary-section" style="margin-bottom: 20px; grid-template-columns: repeat(5, 1fr);">
    @php
        $statusLabels = [
            'menunggu_pembayaran' => 'Menunggu Bayar',
            'dikonfirmasi' => 'Dikonfirmasi',
            'diproses' => 'Diproses',
            'dimasak' => 'Dimasak',
            'siap_diambil' => 'Siap Ambil',
            'diantar' => 'Diantar',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan'
        ];
    @endphp
    
    @foreach($statusCounts as $status => $count)
    <div class="summary-card">
        <p class="card-title">{{ $statusLabels[$status] ?? ucfirst(str_replace('_', ' ', $status)) }}</p>
        <p class="card-value">{{ $count }}</p>
        <a href="{{ route('admin.pesanan.index', ['status' => $status]) }}" class="card-link">Lihat <i class="fas fa-arrow-circle-right"></i></a>
    </div>
    @endforeach
</div>

<div class="orders-section">
    <div class="table-controls">
        <form method="GET" style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
            <select name="status" style="padding: 8px; border: 1px solid var(--border-color); border-radius: 4px;">
                <option value="semua">Semua Status</option>
                @foreach($statusLabels as $key => $label)
                    <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            
            <select name="jenis_pengiriman" style="padding: 8px; border: 1px solid var(--border-color); border-radius: 4px;">
                <option value="semua">Semua Jenis</option>
                <option value="delivery" {{ request('jenis_pengiriman') == 'delivery' ? 'selected' : '' }}>Delivery</option>
                <option value="pickup" {{ request('jenis_pengiriman') == 'pickup' ? 'selected' : '' }}>Pickup</option>
            </select>
            
            <input type="date" name="tanggal_dari" placeholder="Dari Tanggal" 
                   value="{{ request('tanggal_dari') }}"
                   style="padding: 8px; border: 1px solid var(--border-color); border-radius: 4px;">
            
            <input type="date" name="tanggal_sampai" placeholder="Sampai Tanggal" 
                   value="{{ request('tanggal_sampai') }}"
                   style="padding: 8px; border: 1px solid var(--border-color); border-radius: 4px;">
            
            <input type="text" name="search" placeholder="Cari pesanan..." 
                   value="{{ request('search') }}"
                   style="padding: 8px; border: 1px solid var(--border-color); border-radius: 4px;">
            
            <button type="submit" class="btn" style="background-color: var(--bg-sidebar); color: white; padding: 8px 16px; border: none; border-radius: 4px;">
                <i class="fas fa-search"></i> Filter
            </button>
            
            <a href="{{ route('admin.pesanan.index') }}" class="btn" style="background-color: #6c757d; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none;">
                <i class="fas fa-redo"></i> Reset
            </a>
        </form>
    </div>
    
    <div class="table-container">
        <table id="pesananTable">
            <thead>
                <tr>
                    <th>No Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesanan as $item)
                <tr>
                    <td>
                        <strong>{{ $item->nomor_pesanan }}</strong><br>
                        <small style="color: #666;">{{ $item->nama_penerima }}</small>
                    </td>
                    <td>
                        {{ $item->user->nama_lengkap ?? $item->nama_penerima }}<br>
                        <small style="color: #666;">{{ $item->nomor_telepon }}</small>
                    </td>
                    <td>{{ $item->tanggal_pesanan->format('d/m/Y H:i') }}</td>
                    <td>Rp{{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                    <td>
                        <span class="method-badge method-{{ $item->jenis_pengiriman }}">
                            {{ ucfirst($item->jenis_pengiriman) }}
                        </span>
                    </td>
                    <td>
                        @php
                            $statusClass = 'status-' . $item->status;
                            $statusText = $statusLabels[$item->status] ?? ucfirst(str_replace('_', ' ', $item->status));
                        @endphp
                        <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 5px; flex-wrap: wrap;">
                            <!-- Button Detail -->
                            <a href="{{ route('admin.pesanan.show', $item->id_pesanan) }}" 
                               class="btn-action btn-info" title="Detail Pesanan">
                                <i class="fas fa-eye"></i>
                            </a>
                            
                            <!-- QUICK ACTIONS berdasarkan jenis pengiriman -->
                            @php
                                $jenis = $item->jenis_pengiriman;
                                $status = $item->status;
                            @endphp
                            
                            <!-- Untuk semua pesanan: Konfirmasi dari menunggu_pembayaran -->
                            @if($status == 'menunggu_pembayaran')
                                <form action="{{ route('admin.pesanan.update-status', $item->id_pesanan) }}" 
                                      method="POST" class="quick-action-form">
                                    @csrf
                                    <input type="hidden" name="status" value="dikonfirmasi">
                                    <button type="submit" class="btn-action btn-success" 
                                            title="Konfirmasi Pesanan"
                                            onclick="return confirm('Konfirmasi pesanan ini?')">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            @endif
                            
                            <!-- Untuk DELIVERY: Flow = dikonfirmasi -> diproses -> diantar -> selesai -->
                            @if($jenis == 'delivery')
                                <!-- Dari dikonfirmasi ke diproses -->
                                @if($status == 'dikonfirmasi')
                                    <form action="{{ route('admin.pesanan.update-status', $item->id_pesanan) }}" 
                                          method="POST" class="quick-action-form">
                                        @csrf
                                        <input type="hidden" name="status" value="diproses">
                                        <button type="submit" class="btn-action btn-warning" 
                                                title="Proses Pesanan"
                                                onclick="return confirm('Proses pesanan delivery ini?')">
                                            <i class="fas fa-cogs"></i>
                                        </button>
                                    </form>
                                @endif
                                
                                <!-- Dari diproses ke diantar -->
                                @if($status == 'diproses')
                                    <form action="{{ route('admin.pesanan.update-status', $item->id_pesanan) }}" 
                                          method="POST" class="quick-action-form">
                                        @csrf
                                        <input type="hidden" name="status" value="diantar">
                                        <button type="submit" class="btn-action btn-delivering" 
                                                title="Tandai Sedang Diantar"
                                                onclick="return confirm('Tandai pesanan sedang diantar?')">
                                            <i class="fas fa-truck"></i>
                                        </button>
                                    </form>
                                @endif
                                
                                <!-- Dari diantar ke selesai -->
                                @if($status == 'diantar')
                                    <form action="{{ route('admin.pesanan.update-status', $item->id_pesanan) }}" 
                                          method="POST" class="quick-action-form">
                                        @csrf
                                        <input type="hidden" name="status" value="selesai">
                                        <button type="submit" class="btn-action btn-complete" 
                                                title="Tandai Selesai"
                                                onclick="return confirm('Tandai pesanan selesai?')">
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                    </form>
                                @endif
                            
                            <!-- Untuk PICKUP: Flow = dikonfirmasi -> dimasak -> siap_diambil -> selesai -->
                            @elseif($jenis == 'pickup')
                                <!-- Dari dikonfirmasi ke dimasak -->
                                @if($status == 'dikonfirmasi')
                                    <form action="{{ route('admin.pesanan.update-status', $item->id_pesanan) }}" 
                                          method="POST" class="quick-action-form">
                                        @csrf
                                        <input type="hidden" name="status" value="dimasak">
                                        <button type="submit" class="btn-action btn-cooking" 
                                                title="Tandai Sedang Dimasak"
                                                onclick="return confirm('Tandai pesanan sedang dimasak?')">
                                            <i class="fas fa-utensils"></i>
                                        </button>
                                    </form>
                                @endif
                                
                                <!-- Dari dimasak ke siap_diantar -->
                                @if($status == 'dimasak')
                                    <form action="{{ route('admin.pesanan.update-status', $item->id_pesanan) }}" 
                                          method="POST" class="quick-action-form">
                                        @csrf
                                        <input type="hidden" name="status" value="siap_diambil">
                                        <button type="submit" class="btn-action btn-ready" 
                                                title="Tandai Siap Diambil"
                                                onclick="return confirm('Tandai pesanan siap diambil?')">
                                            <i class="fas fa-box"></i>
                                        </button>
                                    </form>
                                @endif
                                
                                <!-- Dari siap_diantar ke selesai -->
                                @if($status == 'siap_diambil')
                                    <form action="{{ route('admin.pesanan.update-status', $item->id_pesanan) }}" 
                                          method="POST" class="quick-action-form">
                                        @csrf
                                        <input type="hidden" name="status" value="selesai">
                                        <button type="submit" class="btn-action btn-complete" 
                                                title="Tandai Selesai"
                                                onclick="return confirm('Tandai pesanan selesai?')">
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                    </form>
                                @endif
                            @endif
                            
                            <!-- Button Edit Manual untuk semua status kecuali selesai/dibatalkan -->
                            @if(!in_array($item->status, ['selesai', 'dibatalkan']))
                                <button onclick="showStatusModal({{ $item->id_pesanan }}, '{{ $item->status }}', '{{ $item->jenis_pengiriman }}')" 
                                       class="btn-action btn-edit" title="Ubah Status Manual">
                                    <i class="fas fa-edit"></i>
                                </button>
                            @endif
                            
                            <!-- Button Batalkan (untuk semua status kecuali selesai/dibatalkan) -->
                            @if(!in_array($item->status, ['selesai', 'dibatalkan']))
                                <button onclick="confirmBatal({{ $item->id_pesanan }})" 
                                       class="btn-action btn-danger" title="Batalkan Pesanan">
                                    <i class="fas fa-times"></i>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center" style="text-align: center; padding: 20px;">
                        <i class="fas fa-shopping-cart" style="font-size: 48px; color: #ddd; margin-bottom: 10px;"></i><br>
                        Belum ada pesanan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($pesanan->hasPages())
    <div class="table-footer">
        <p>Menampilkan {{ $pesanan->firstItem() }} - {{ $pesanan->lastItem() }} dari {{ $pesanan->total() }} pesanan</p>
        <nav class="pagination">
            {{ $pesanan->links('vendor.pagination.simple') }}
        </nav>
    </div>
    @endif
</div>

<!-- Modal Ubah Status dengan logika jenis pengiriman -->
<div id="statusModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Ubah Status Pesanan</h3>
            <span class="close" onclick="closeStatusModal()">&times;</span>
        </div>
        <div class="modal-body">
            <form id="statusForm" method="POST">
                @csrf
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Jenis Pengiriman:</label>
                    <div id="jenisPengirimanText" style="padding: 8px; background: #f8f9fa; border-radius: 4px;">
                        <i class="fas fa-truck me-2"></i>
                        <span id="currentJenisText">-</span>
                    </div>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Pilih Status Baru:</label>
                    <select name="status" id="statusSelect" 
                            style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px; font-size: 14px;">
                        <!-- Options akan diisi oleh JavaScript berdasarkan jenis pengiriman -->
                    </select>
                </div>
                
                <div id="statusInfo" style="padding: 10px; background-color: #f8f9fa; border-radius: 4px; margin-bottom: 15px;">
                    <small>Status saat ini: <span id="currentStatusText"></span></small><br>
                    <small id="statusFlowInfo" style="color: #666;"></small>
                </div>
                
                <div style="display: flex; gap: 10px; justify-content: flex-end;">
                    <button type="button" onclick="closeStatusModal()" 
                            class="btn-cancel">
                        Batal
                    </button>
                    <button type="submit" class="btn-save">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Batalkan Pesanan -->
<div id="batalModal" class="modal" style="display: none;">
    <div class="modal-content" style="max-width: 400px;">
        <div class="modal-header">
            <h3>Batalkan Pesanan</h3>
            <span class="close" onclick="closeBatalModal()">&times;</span>
        </div>
        <div class="modal-body">
            <p>Apakah Anda yakin ingin membatalkan pesanan ini?</p>
            <p><small>Catatan: Stok produk akan dikembalikan jika pesanan dibatalkan.</small></p>
            <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
                <button type="button" onclick="closeBatalModal()" class="btn-cancel">
                    Tidak
                </button>
                <button type="button" id="confirmBatalBtn" class="btn-danger">
                    Ya, Batalkan
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Button Action Styles */
.btn-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 4px;
    border: none;
    color: white;
    cursor: pointer;
    font-size: 12px;
    transition: all 0.3s;
    text-decoration: none;
}

.btn-action:hover {
    opacity: 0.9;
    transform: translateY(-2px);
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

/* Button Colors */
.btn-info { background-color: #17a2b8; }
.btn-success { background-color: #28a745; }
.btn-warning { background-color: #ffc107; }
.btn-danger { background-color: #dc3545; }
.btn-delivering { background-color: #fd7e14; }
.btn-complete { background-color: #28a745; }
.btn-edit { background-color: #007bff; }
.btn-cooking { background-color: #ff6b6b; }
.btn-ready { background-color: #20c997; }

/* Quick Action Forms */
.quick-action-form {
    display: inline;
    margin: 0;
    padding: 0;
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

.status-menunggu_pembayaran { background-color: #ffc107; }
.status-dikonfirmasi { background-color: #17a2b8; }
.status-diproses { background-color: #007bff; }
.status-dimasak { background-color: #ff6b6b; }
.status-siap_diambil { background-color: #20c997; }
.status-diantar { background-color: #fd7e14; }
.status-selesai { background-color: #28a745; }
.status-dibatalkan { background-color: #dc3545; }

/* Method Badge */
.method-badge {
    display: inline-block;
    padding: 3px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
}

.method-delivery {
    background-color: rgba(33, 150, 243, 0.1);
    color: #2196f3;
    border: 1px solid rgba(33, 150, 243, 0.2);
}

.method-pickup {
    background-color: rgba(255, 193, 7, 0.1);
    color: #ff9800;
    border: 1px solid rgba(255, 193, 7, 0.2);
}

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

/* Button Styles */
.btn-cancel {
    padding: 8px 16px;
    background: #6c757d;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-cancel:hover {
    background: #5a6268;
}

.btn-save {
    padding: 8px 16px;
    background: var(--bg-sidebar);
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-save:hover {
    background: #c62828;
}

/* Tooltip untuk button */
.btn-action[title]:hover:after {
    content: attr(title);
    position: absolute;
    bottom: -30px;
    left: 50%;
    transform: translateX(-50%);
    background: #333;
    color: white;
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 12px;
    white-space: nowrap;
    z-index: 1000;
}
</style>

<script>
let currentPesananId = null;
let currentJenisPengiriman = null;
let batalPesananId = null;

// Status options berdasarkan jenis pengiriman
const statusOptions = {
    'delivery': [
        { value: 'menunggu_pembayaran', label: 'Menunggu Pembayaran' },
        { value: 'dikonfirmasi', label: 'Dikonfirmasi' },
        { value: 'diproses', label: 'Diproses' },
        { value: 'diantar', label: 'Diantar' },
        { value: 'selesai', label: 'Selesai' },
        { value: 'dibatalkan', label: 'Dibatalkan' }
    ],
    'pickup': [
        { value: 'menunggu_pembayaran', label: 'Menunggu Pembayaran' },
        { value: 'dikonfirmasi', label: 'Dikonfirmasi' },
        { value: 'dimasak', label: 'Dimasak' },
        { value: 'siap_diambil', label: 'Siap Diambil' },
        { value: 'selesai', label: 'Selesai' },
        { value: 'dibatalkan', label: 'Dibatalkan' }
    ]
};

// Status flow info
const statusFlowInfo = {
    'delivery': 'Flow: Dikonfirmasi → Diproses → Diantar → Selesai',
    'pickup': 'Flow: Dikonfirmasi → Dimasak → Siap Diambil → Selesai'
};

// Status labels
const statusLabels = {
    'menunggu_pembayaran': 'Menunggu Pembayaran',
    'dikonfirmasi': 'Dikonfirmasi',
    'diproses': 'Diproses',
    'dimasak': 'Dimasak',
    'siap_diambil': 'Siap Diambil',
    'diantar': 'Diantar',
    'selesai': 'Selesai',
    'dibatalkan': 'Dibatalkan'
};

// Jenis pengiriman labels
const jenisLabels = {
    'delivery': 'Delivery (Dikirim)',
    'pickup': 'Pickup (Ambil di Tempat)'
};

function showStatusModal(pesananId, currentStatus, jenisPengiriman) {
    currentPesananId = pesananId;
    currentJenisPengiriman = jenisPengiriman;
    
    const modal = document.getElementById('statusModal');
    const form = document.getElementById('statusForm');
    const select = document.getElementById('statusSelect');
    const currentStatusText = document.getElementById('currentStatusText');
    const currentJenisText = document.getElementById('currentJenisText');
    const statusFlowInfoEl = document.getElementById('statusFlowInfo');
    
    // Set form action
    form.action = `/admin/pesanan/${pesananId}/status`;
    
    // Set current status and jenis
    currentStatusText.textContent = statusLabels[currentStatus] || currentStatus;
    currentJenisText.textContent = jenisLabels[jenisPengiriman] || jenisPengiriman;
    statusFlowInfoEl.textContent = statusFlowInfo[jenisPengiriman] || '';
    
    // Clear existing options
    select.innerHTML = '';
    
    // Add options based on jenis pengiriman
    const options = statusOptions[jenisPengiriman] || statusOptions.delivery;
    
    options.forEach(option => {
        const opt = document.createElement('option');
        opt.value = option.value;
        opt.textContent = option.label;
        if (option.value === currentStatus) {
            opt.selected = true;
        }
        select.appendChild(opt);
    });
    
    // Show modal
    modal.style.display = 'block';
}

function closeStatusModal() {
    document.getElementById('statusModal').style.display = 'none';
}

// Batalkan pesanan
function confirmBatal(pesananId) {
    batalPesananId = pesananId;
    document.getElementById('batalModal').style.display = 'block';
}

function closeBatalModal() {
    document.getElementById('batalModal').style.display = 'none';
}

document.getElementById('confirmBatalBtn').onclick = function() {
    if (batalPesananId) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/pesanan/${batalPesananId}/batal`;
        
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        
        form.appendChild(csrf);
        document.body.appendChild(form);
        form.submit();
    }
};

// Close modal when clicking outside
window.onclick = function(event) {
    const statusModal = document.getElementById('statusModal');
    const batalModal = document.getElementById('batalModal');
    
    if (event.target === statusModal) {
        closeStatusModal();
    }
    if (event.target === batalModal) {
        closeBatalModal();
    }
};

// Keyboard shortcut to close modal
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeStatusModal();
        closeBatalModal();
    }
});

// Tooltip untuk button action
document.querySelectorAll('.btn-action').forEach(btn => {
    btn.addEventListener('mouseenter', function(e) {
        const rect = this.getBoundingClientRect();
        const tooltip = document.createElement('div');
        tooltip.className = 'btn-tooltip';
        tooltip.textContent = this.getAttribute('title');
        tooltip.style.position = 'fixed';
        tooltip.style.left = rect.left + rect.width / 2 + 'px';
        tooltip.style.top = rect.top - 30 + 'px';
        tooltip.style.transform = 'translateX(-50%)';
        tooltip.style.background = '#333';
        tooltip.style.color = 'white';
        tooltip.style.padding = '5px 10px';
        tooltip.style.borderRadius = '4px';
        tooltip.style.fontSize = '12px';
        tooltip.style.zIndex = '10000';
        tooltip.style.pointerEvents = 'none';
        document.body.appendChild(tooltip);
        
        this._tooltip = tooltip;
    });
    
    btn.addEventListener('mouseleave', function() {
        if (this._tooltip) {
            this._tooltip.remove();
            delete this._tooltip;
        }
    });
});
</script>
@endsection