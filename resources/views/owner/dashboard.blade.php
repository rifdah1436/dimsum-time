<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Panel - Executive Dashboard</title>
    
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        :root { --bg: #f3f4f6; --sidebar: #1f2937; --gold: #d4af37; --text: #333; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'DM Sans', sans-serif; }
        body { background-color: var(--bg); display: flex; min-height: 100vh; color: var(--text); }

        /* SIDEBAR */
        .sidebar { width: 260px; background-color: var(--sidebar); color: white; position: fixed; height: 100vh; display: flex; flex-direction: column; z-index: 100; }
        .brand { padding: 25px; font-size: 1.5rem; font-weight: bold; color: var(--gold); border-bottom: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; gap: 10px; }
        .nav-links { list-style: none; padding: 20px 0; flex: 1; }
        .nav-item { padding: 15px 25px; color: rgba(255,255,255,0.7); cursor: pointer; display: flex; align-items: center; gap: 15px; transition: 0.3s; }
        .nav-item:hover, .nav-item.active { background: rgba(212,175,55,0.1); color: var(--gold); border-left: 4px solid var(--gold); }
        
        /* CONTENT */
        .main-content { flex: 1; margin-left: 260px; padding: 30px 40px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        
        /* TAB LOGIC */
        .tab-content { display: none; animation: fadeIn 0.4s; }
        .tab-content.show { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        /* CARDS */
        .card-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-top: 4px solid var(--gold); }
        .stat-value { font-size: 2rem; font-weight: bold; color: var(--sidebar); margin: 10px 0; }
        
        /* TABLES */
        .box { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 25px; }
        .custom-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .custom-table th { text-align: left; padding: 15px; background: #f9fafb; color: #6b7280; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; }
        .custom-table td { padding: 15px; border-bottom: 1px solid #e5e7eb; }
        
        /* BADGE */
        .badge { padding: 5px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: bold; }
        .badge-gold { background: #fffbeb; color: #b45309; border: 1px solid #fcd34d; }
        .badge-green { background: #ecfdf5; color: #047857; }
    </style>
</head>
<body>

    <nav class="sidebar">
        <div class="brand"><i class="fas fa-crown"></i> OWNER PANEL</div>
        <ul class="nav-links">
            <li class="nav-item active" onclick="switchTab('ringkasan', this)" id="nav-ringkasan">
                <i class="fas fa-chart-pie"></i> Ringkasan Bisnis
            </li>
            <li class="nav-item" onclick="switchTab('keuangan', this)" id="nav-keuangan">
                <i class="fas fa-wallet"></i> Laporan Keuangan
            </li>
            <li class="nav-item" onclick="switchTab('pelanggan', this)" id="nav-pelanggan">
                <i class="fas fa-users"></i> Top Pelanggan
            </li>
            <li class="nav-item" onclick="switchTab('pegawai', this)" id="nav-pegawai">
                <i class="fas fa-id-card-alt"></i> Data Staff
            </li>
        </ul>
        <div style="padding: 20px;">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" style="background:none; border:none; color:#f87171; cursor:pointer; display:flex; gap:10px; align-items: center;">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </nav>

    <main class="main-content">
        <header class="header">
            <div>
                <h2 style="color: var(--sidebar);" id="page-title">Ringkasan Bisnis</h2>
                <p style="color: #666;">Pantau performa bisnis Anda secara real-time.</p>
            </div>
            <div style="display: flex; align-items: center; gap: 15px;">
                <div style="text-align: right;">
                    <div style="font-weight: bold;">Owner Account</div>
                    <div style="font-size: 0.8rem; color: #888;">Super Admin</div>
                </div>
                <div style="width: 45px; height: 45px; background: var(--gold); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1.2rem;">O</div>
            </div>
        </header>

        <div id="ringkasan" class="tab-content show">
            <div class="card-grid">
                <div class="stat-card">
                    <div style="color: #6b7280;">Omzet Hari Ini</div>
                    <div class="stat-value">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</div>
                    <div style="font-size: 0.9rem; color: #10b981;"><i class="fas fa-calendar-day"></i> Update Realtime</div>
                </div>
                <div class="stat-card">
                    <div style="color: #6b7280;">Total Pesanan Hari Ini</div>
                    <div class="stat-value">{{ $pesananHariIni }}</div>
                    <div style="font-size: 0.9rem; color: #6b7280;">Transaksi berhasil</div>
                </div>
                <div class="stat-card">
                    <div style="color: #6b7280;">Total Pelanggan Terdaftar</div>
                    <div class="stat-value">{{ $totalPelanggan }}</div>
                    <div style="font-size: 0.9rem; color: #6b7280;">User aktif</div>
                </div>
            </div>
            
            <div class="box">
                <h3 style="margin-bottom: 20px;">📈 Tren Pendapatan (7 Hari Terakhir)</h3>
                <canvas id="dailyChart" height="100"></canvas>
            </div>
        </div>

        <div id="keuangan" class="tab-content">
            <div class="box">
                <h3 style="margin-bottom: 20px;">📊 Grafik Pendapatan Bulanan (Tahun Ini)</h3>
                <canvas id="monthlyChart" height="80"></canvas>
            </div>

            <div class="box">
                <h3 style="margin-bottom: 15px;">💰 10 Transaksi Terbesar (Big Sales)</h3>
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>No. Order</th>
                            <th>Pelanggan</th>
                            <th>Tanggal</th>
                            <th>Total Bayar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksiBesar as $t)
                        <tr>
                            <td style="font-weight: bold;">#{{ $t->id_pesanan }}</td>
                            <td>{{ $t->nama_lengkap }}</td>
                            <td>{{ \Carbon\Carbon::parse($t->created_at)->format('d M Y, H:i') }}</td>
                            <td style="color: var(--sidebar); font-weight: bold;">Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div id="pelanggan" class="tab-content">
            <div class="box">
                <h3 style="margin-bottom: 15px;">🏆 Top Pelanggan</h3>
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Nama Pelanggan</th>
                            <th>Kontak</th>
                            <th>Frekuensi</th>
                            <th>Total Belanja</th>
                            <th>Label</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataPelanggan as $p)
                        <tr>
                            <td>
                                <b>{{ $p->nama_lengkap }}</b>
                                <div style="font-size: 0.8rem; color: #999;">ID: {{ $p->id_pengguna }}</div>
                            </td>
                            <td>{{ $p->email }}<br><small>{{ $p->nomor_telepon }}</small></td>
                            <td style="text-align: center;">{{ $p->total_order }}x</td>
                            <td style="font-weight: bold;">Rp {{ number_format($p->total_belanja, 0, ',', '.') }}</td>
                            <td>
                                @if($p->total_belanja > 1000000)
                                    <span class="badge badge-gold">VIP</span>
                                @else
                                    <span class="badge badge-green">Member</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div id="pegawai" class="tab-content">
            <div class="box">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <h3>🆔 Data Staff Operasional</h3>
                    <a href="{{ route('owner.pegawai.create') }}" style="background: var(--gold); color: white; padding: 10px 20px; text-decoration: none; border-radius: 8px; font-weight: bold;">
                        + Tambah Pegawai
                    </a>
                </div>

                @if(session('success'))
                    <div style="background: #ecfdf5; color: #047857; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Nama Pegawai</th>
                            <th>Peran / Jabatan</th>
                            <th>Email & Telp</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dataPegawai as $pg)
                        <tr>
                            <td style="font-weight: bold;">{{ $pg->nama_lengkap }}</td>
                            <td><span style="text-transform: uppercase; color: var(--gold); font-weight: bold;">{{ $pg->peran }}</span></td>
                            <td>
                                {{ $pg->email }}<br>
                                <small style="color: #666;">{{ $pg->nomor_telepon }}</small>
                            </td>
                            <td>
                                <div style="display: flex; gap: 10px;">
                                    <a href="{{ route('owner.pegawai.edit', $pg->id_pengguna) }}" style="background: #3b82f6; color: white; padding: 5px 10px; border-radius: 5px; text-decoration: none; font-size: 0.8rem;">
                                        Edit
                                    </a>
                                    
                                    <form action="{{ route('owner.pegawai.destroy', $pg->id_pengguna) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pegawai ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: #ef4444; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; font-size: 0.8rem;">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" style="text-align: center;">Tidak ada data pegawai.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <script>
        // A. FUNGSI GANTI TAB
        function switchTab(tabId, element) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('show'));
            document.getElementById(tabId).classList.add('show');
            document.querySelectorAll('.nav-item').forEach(el => el.classList.remove('active'));
            if(element) element.classList.add('active');
            
            const titles = {
                'ringkasan': 'Ringkasan Bisnis', 'keuangan': 'Laporan Keuangan',
                'pelanggan': 'Database Pelanggan', 'pegawai': 'Data Staff'
            };
            document.getElementById('page-title').innerText = titles[tabId];
        }

        // B. KONFIGURASI CHART (GRAFIK)
        // 1. Chart Harian
        const ctxDaily = document.getElementById('dailyChart').getContext('2d');
        new Chart(ctxDaily, {
            type: 'line',
            data: {
                labels: @json($chartLabels), 
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: @json($chartData),
                    borderColor: '#D4AF37',
                    backgroundColor: 'rgba(212, 175, 55, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });

        // 2. Chart Bulanan
        const ctxMonthly = document.getElementById('monthlyChart').getContext('2d');
        new Chart(ctxMonthly, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Total Pendapatan (Rp)',
                    data: @json($chartBulanan),
                    backgroundColor: '#1f2937',
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });
    </script>

</body>
</html>