<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Dimsum Time</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Baloo+2:wght@600&family=Baloo&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Gunakan CSS yang sama dari pesanan.blade.php */
        :root {
            --primary-color: #e53935;
            --secondary-color: #ff9800;
            --accent-color: #fbc02d;
            --bg-light: #fff3e0;
            --bg-dark: #5c4033;
            --text-dark: #2c2f24;
            --text-light: #f9f9f7;
            --text-muted: #495460;
            --text-footer: #dbdfd0;
            --text-footer-muted: #adb29e;
            --border-color: #c6c6c6;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'DM Sans', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header - gunakan sama dengan pesanan.blade.php */
        
        /* Payment Section */
        .payment-section {
            padding: 40px 0 80px;
            min-height: 70vh;
        }

        .payment-title {
            text-align: center;
            margin-bottom: 40px;
        }

        .payment-title h1 {
            font-family: 'Baloo', cursive;
            font-size: 48px;
            line-height: 1.2;
            color: var(--text-dark);
            margin: 0 0 10px 0;
        }

        .payment-title p {
            font-size: 18px;
            color: var(--text-muted);
            margin: 0;
        }

        /* Countdown Timer */
        .countdown-timer {
            text-align: center;
            margin-bottom: 30px;
        }

        .countdown-box {
            display: inline-block;
            background: white;
            padding: 20px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .countdown-label {
            font-size: 16px;
            color: var(--text-muted);
            margin-bottom: 10px;
        }

        #countdown {
            font-size: 32px;
            font-weight: 700;
            color: var(--primary-color);
        }

        /* Payment Content */
        .payment-content {
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
        }

        @media (min-width: 992px) {
            .payment-content {
                grid-template-columns: 2fr 1fr;
            }
        }

        /* Payment Instructions */
        .payment-instructions {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .payment-method-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .payment-method-icon {
            width: 50px;
            height: 50px;
            background: var(--primary-color);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
        }

        .payment-method-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

        .payment-info-box {
            background: #f9f9f9;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 25px;
        }

        .payment-step {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .payment-step:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .step-number {
            width: 30px;
            height: 30px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            flex-shrink: 0;
        }

        .step-content h4 {
            margin: 0 0 8px 0;
            color: var(--text-dark);
        }

        .step-content p {
            margin: 0;
            color: var(--text-muted);
            line-height: 1.6;
        }

        .bank-details, .ewallet-details {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
            border: 2px dashed #ddd;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: var(--text-muted);
            font-weight: 500;
        }

        .detail-value {
            font-weight: 600;
            color: var(--text-dark);
            text-align: right;
        }

        .copy-btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 5px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            margin-left: 10px;
        }

        .copy-btn:hover {
            background: #c62828;
        }

        .whatsapp-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #25D366;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .whatsapp-btn:hover {
            background: #128C7E;
            transform: translateY(-2px);
        }

        /* Order Summary */
        .order-summary-box {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 20px;
        }

        .summary-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .summary-label {
            color: var(--text-muted);
        }

        .summary-value {
            font-weight: 600;
            color: var(--text-dark);
        }

        .summary-total {
            border-top: 2px solid #f0f0f0;
            padding-top: 20px;
            margin-top: 20px;
            font-size: 20px;
            font-weight: 700;
            color: var(--primary-color);
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 15px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background: #c62828;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: white;
            color: var(--text-dark);
            border: 2px solid var(--border-color);
        }

        .btn-secondary:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        /* Alert Messages */
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        /* Loading Spinner */
        .loading-spinner {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .payment-title h1 {
                font-size: 36px;
            }
            
            .countdown-box {
                padding: 15px 25px;
            }
            
            #countdown {
                font-size: 24px;
            }
            
            .payment-method-header {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Loading Spinner -->
    <div class="loading-spinner" id="loadingSpinner">
        <div class="spinner"></div>
    </div>

    <!-- HEADER SECTION - Sama seperti pesanan.blade.php -->
    <header class="dimsum-header">
        <!-- Copy header dari pesanan.blade.php -->
        <div class="dimsum-top-bar">
            <div class="dimsum-top-bar-container">
                <div class="dimsum-contact-info">
                    <a href="tel:(414) 857 - 0107" class="dimsum-contact-item">
                        <i class="fas fa-phone"></i>
                        <span>(414) 857 - 0107</span>
                    </a>
                    <a href="mailto:dimsumtime.id@gmail.com" class="dimsum-contact-item">
                        <i class="fas fa-envelope"></i>
                        <span>dimsumtime.id@gmail.com</span>
                    </a>
                </div>
                <div class="dimsum-top-social-links">
                    <a href="#" class="dimsum-top-social-icon">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="dimsum-top-social-icon">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="dimsum-top-social-icon">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="dimsum-top-social-icon">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Navigation -->
        <div class="dimsum-main-nav-wrapper">
            <nav class="dimsum-main-nav-container">
                <a href="{{ route('home') }}" class="dimsum-logo">
                    <img src="{{ asset('images/21aa72030e155c4f9f34f27101287b6f2a7240e4.png') }}" alt="Dimsum Time Logo" class="dimsum-logo-img" onerror="this.src='{{ asset('images/logo-placeholder.png') }}'">
                    <span class="dimsum-logo-text">DIMSUM TIME</span>
                </a>

                <div class="dimsum-nav-menu">
                    <ul class="dimsum-nav-links">
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('tentang') }}">Tentang</a></li>
                        <li><a href="{{ route('menu') }}">Menu</a></li>
                        <li><a href="{{ route('kontak') }}">Kontak</a></li>
                    </ul>
                </div>

                <div class="dimsum-header-actions">
                    <a href="{{ route('keranjang') }}" class="dimsum-cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="dimsum-cart-count">{{ count(session('cart', [])) }}</span>
                    </a>

                    <div class="dimsum-user-profile">
                        <div class="dimsum-profile-trigger">
                            <i class="fas fa-user-circle"></i>
                            <span>{{ auth()->user()->nama_lengkap ?? 'Guest' }}</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>

                        <div class="dimsum-dropdown-menu">
                            @auth
                            <a href="{{ route('profile') }}" class="dimsum-dropdown-item">
                                <i class="fas fa-user"></i>
                                <span>Lihat Profil</span>
                            </a>
                            <a href="{{ route('pesanan') }}" class="dimsum-dropdown-item">
                                <i class="fas fa-history"></i>
                                <span>Riwayat Pesanan</span>
                            </a>
                            <div class="dimsum-dropdown-divider"></div>
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="dimsum-dropdown-item" style="background: none; border: none; width: 100%; text-align: left; cursor: pointer;">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                            @endauth
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <!-- Payment Section -->
    <section class="payment-section">
        <div class="container">
            <div class="payment-title">
                <h1>Pembayaran</h1>
                <p>Selesaikan pembayaran untuk pesanan Anda</p>
            </div>

            <!-- Alert Messages -->
            @if(session('error'))
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ session('error') }}
                </div>
            @endif

            <div class="countdown-timer">
                <div class="countdown-box">
                    <div class="countdown-label">Selesaikan dalam:</div>
                    <div id="countdown">01:30:00</div>
                </div>
            </div>

            <div class="payment-content">
                <!-- Left Column: Payment Instructions -->
                <div class="payment-instructions">
                    <div class="payment-method-header">
                        @php
                            $metode = $pesanan->pembayaran->metode_pembayaran ?? 'cod';
                            $iconClass = '';
                            $methodName = '';
                            
                            switch($metode) {
                                case 'cod':
                                    $iconClass = 'fas fa-money-bill-wave';
                                    $methodName = 'Cash on Delivery (COD)';
                                    break;
                                case 'bca':
                                case 'mandiri':
                                case 'bni':
                                case 'bri':
                                case 'seabank':
                                    $iconClass = 'fas fa-university';
                                    $methodName = 'Transfer Bank ' . strtoupper($metode);
                                    break;
                                case 'ovo':
                                case 'gopay':
                                case 'dana':
                                case 'shopeepay':
                                    $iconClass = 'fas fa-wallet';
                                    $methodName = 'E-Wallet ' . strtoupper($metode);
                                    break;
                                default:
                                    $iconClass = 'fas fa-credit-card';
                                    $methodName = 'Pembayaran';
                            }
                        @endphp
                        
                        <div class="payment-method-icon">
                            <i class="{{ $iconClass }}"></i>
                        </div>
                        <h2 class="payment-method-title">{{ $methodName }}</h2>
                    </div>

                    <div class="payment-info-box">
                        <h3 style="margin-top: 0; margin-bottom: 20px; color: var(--text-dark);">
                            Nomor Pesanan: <span style="color: var(--primary-color);">{{ $pesanan->nomor_pesanan }}</span>
                        </h3>

                        @if(in_array($metode, ['bca', 'mandiri', 'bni', 'bri', 'seabank']))
                            <!-- Bank Transfer Instructions -->
                            <div class="bank-details">
                                <h4 style="margin-top: 0; margin-bottom: 15px; color: var(--text-dark);">
                                    Transfer ke rekening berikut:
                                </h4>
                                
                                @php
                                    $bankDetails = [
                                        'bca' => ['no' => '1234567890', 'name' => 'Dimsum Time'],
                                        'mandiri' => ['no' => '0987654321', 'name' => 'Dimsum Time'],
                                        'bni' => ['no' => '5678901234', 'name' => 'Dimsum Time'],
                                        'bri' => ['no' => '4321098765', 'name' => 'Dimsum Time'],
                                        'seabank' => ['no' => '1111222233', 'name' => 'Dimsum Time'],
                                    ];
                                @endphp
                                
                                <div class="detail-item">
                                    <span class="detail-label">Bank</span>
                                    <span class="detail-value">{{ strtoupper($metode) }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Nomor Rekening</span>
                                    <span class="detail-value">
                                        {{ $bankDetails[$metode]['no'] ?? '1234567890' }}
                                        <button class="copy-btn" onclick="copyToClipboard('{{ $bankDetails[$metode]['no'] ?? '1234567890' }}')">
                                            <i class="fas fa-copy"></i> Salin
                                        </button>
                                    </span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Atas Nama</span>
                                    <span class="detail-value">{{ $bankDetails[$metode]['name'] ?? 'Dimsum Time' }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Jumlah Transfer</span>
                                    <span class="detail-value">Rp{{ number_format($pesanan->total_bayar, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <div class="payment-step">
                                <div class="step-number">1</div>
                                <div class="step-content">
                                    <h4>Lakukan Transfer</h4>
                                    <p>Transfer sesuai jumlah di atas ke rekening {{ strtoupper($metode) }} yang tertera.</p>
                                </div>
                            </div>

                        @elseif(in_array($metode, ['ovo', 'gopay', 'dana', 'shopeepay']))
                            <!-- E-Wallet Instructions -->
                            <div class="ewallet-details">
                                <h4 style="margin-top: 0; margin-bottom: 15px; color: var(--text-dark);">
                                    Kirim ke nomor berikut:
                                </h4>
                                
                                @php
                                    $ewalletDetails = [
                                        'ovo' => '081234567890',
                                        'gopay' => '081234567891',
                                        'dana' => '081234567892',
                                        'shopeepay' => '081234567893',
                                    ];
                                @endphp
                                
                                <div class="detail-item">
                                    <span class="detail-label">Metode</span>
                                    <span class="detail-value">{{ strtoupper($metode) }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Nomor Tujuan</span>
                                    <span class="detail-value">
                                        {{ $ewalletDetails[$metode] ?? '081234567890' }}
                                        <button class="copy-btn" onclick="copyToClipboard('{{ $ewalletDetails[$metode] ?? '081234567890' }}')">
                                            <i class="fas fa-copy"></i> Salin
                                        </button>
                                    </span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Jumlah</span>
                                    <span class="detail-value">Rp{{ number_format($pesanan->total_bayar, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <div class="payment-step">
                                <div class="step-number">1</div>
                                <div class="step-content">
                                    <h4>Kirim via E-Wallet</h4>
                                    <p>Buka aplikasi {{ strtoupper($metode) }} Anda dan kirim ke nomor yang tertera.</p>
                                </div>
                            </div>

                        @else
                            <!-- COD Instructions -->
                            <div class="payment-step">
                                <div class="step-number">1</div>
                                <div class="step-content">
                                    <h4>Tunggu Pesanan Datang</h4>
                                    <p>Pesanan Anda sedang diproses. Siapkan uang tunai sebesar <strong>Rp{{ number_format($pesanan->total_bayar, 0, ',', '.') }}</strong> untuk pembayaran saat pesanan tiba.</p>
                                </div>
                            </div>
                        @endif

                        @if($metode != 'cod')
                            <div class="payment-step">
                                <div class="step-number">2</div>
                                <div class="step-content">
                                    <h4>Screenshot Bukti Pembayaran</h4>
                                    <p>Simpan bukti transfer/pembayaran Anda sebagai screenshot atau foto.</p>
                                </div>
                            </div>

                            <div class="payment-step">
                                <div class="step-number">3</div>
                                <div class="step-content">
                                    <h4>Upload Bukti atau Kirim ke WhatsApp</h4>
                                    <p>Upload bukti pembayaran melalui tombol di bawah atau kirim langsung ke WhatsApp Admin.</p>
                                </div>
                            </div>
                        @endif

                        <div style="margin-top: 30px;">
                            <h4 style="margin-bottom: 15px; color: var(--text-dark);">Catatan Penting:</h4>
                            <ul style="color: var(--text-muted); line-height: 1.6; padding-left: 20px;">
                                <li>Pesanan akan otomatis dibatalkan jika belum dibayar dalam 1.5 jam</li>
                                <li>Admin akan memverifikasi pembayaran maksimal 1x24 jam</li>
                                <li>Hubungi kami jika ada kendala dalam pembayaran</li>
                            </ul>
                        </div>
                    </div>

                    @if($metode != 'cod')
                    <div style="display: flex; gap: 15px; margin-top: 25px;">
                        <a href="https://wa.me/6281234567890?text=Halo%20Admin,%20saya%20sudah%20bayar%20pesanan%20{{ $pesanan->nomor_pesanan }}%20sebesar%20Rp{{ number_format($pesanan->total_bayar, 0, ',', '.') }}%20via%20{{ strtoupper($metode) }}" 
                           class="whatsapp-btn" target="_blank">
                            <i class="fab fa-whatsapp"></i>
                            Kirim ke WhatsApp Admin
                        </a>
                    </div>
                    @endif
                </div>

                <!-- Right Column: Order Summary -->
                <div class="order-summary-box">
                    <h3 class="summary-title">Ringkasan Pesanan</h3>

                    <div class="summary-row">
                        <span class="summary-label">Nomor Pesanan</span>
                        <span class="summary-value">{{ $pesanan->nomor_pesanan }}</span>
                    </div>

                    <div class="summary-row">
                        <span class="summary-label">Tanggal</span>
                        <span class="summary-value">{{ \Carbon\Carbon::parse($pesanan->created_at)->format('d/m/Y H:i') }}</span>
                    </div>

                    <div class="summary-row">
                        <span class="summary-label">Status</span>
                        <span class="summary-value" style="color: #ff9800; font-weight: 700;">
                            Menunggu Pembayaran
                        </span>
                    </div>

                    <div class="summary-row">
                        <span class="summary-label">Subtotal</span>
                        <span class="summary-value">Rp{{ number_format($pesanan->subtotal, 0, ',', '.') }}</span>
                    </div>

                    <div class="summary-row">
                        <span class="summary-label">Biaya Pengiriman</span>
                        <span class="summary-value">Rp{{ number_format($pesanan->biaya_pengiriman, 0, ',', '.') }}</span>
                    </div>

                    @if($pesanan->diskon > 0)
                    <div class="summary-row">
                        <span class="summary-label">Diskon</span>
                        <span class="summary-value">-Rp{{ number_format($pesanan->diskon, 0, ',', '.') }}</span>
                    </div>
                    @endif

                    <div class="summary-row summary-total">
                        <span class="summary-label">Total</span>
                        <span class="summary-value">Rp{{ number_format($pesanan->total_bayar, 0, ',', '.') }}</span>
                    </div>

                    <div class="action-buttons">
                        @if($metode != 'cod')
                        <a href="{{ route('pesanan.upload-bukti', $pesanan->id_pesanan) }}" class="btn btn-primary">
                            <i class="fas fa-upload"></i>
                            Upload Bukti Pembayaran
                        </a>
                        @endif
                        
                        <a href="{{ route('pesanan') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            Kembali ke Riwayat Pesanan
                        </a>

                        <button class="btn btn-secondary" onclick="copyOrderNumber()">
                            <i class="fas fa-copy"></i>
                            Salin Nomor Pesanan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER - Sama seperti pesanan.blade.php -->
    <footer class="dimsum-footer">
        <div class="dimsum-footer-container">
            <!-- Copy footer dari pesanan.blade.php -->
            <div class="dimsum-footer-top">
                <div class="dimsum-footer-column">
                    <a href="{{ route('home') }}" class="dimsum-footer-logo">
                        <i class="fas fa-utensils" style="font-size: 30px;"></i>
                        <span class="dimsum-footer-logo-text">DIMSUM TIME</span>
                    </a>
                    <p class="dimsum-footer-description">
                        Dimsum berkualitas dengan cita rasa autentik. Kami berkomitmen memberikan pengalaman kuliner terbaik untuk setiap pelanggan.
                    </p>
                    <div class="dimsum-footer-socials">
                        <a href="#" class="dimsum-footer-social-icon">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="dimsum-footer-social-icon">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="dimsum-footer-social-icon">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="dimsum-footer-social-icon">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>

                <div class="dimsum-footer-column">
                    <h3 class="dimsum-footer-heading">Halaman</h3>
                    <div class="dimsum-footer-links">
                        <a href="{{ route('home') }}">Beranda</a>
                        <a href="{{ route('tentang') }}">Tentang Kami</a>
                        <a href="{{ route('menu') }}">Menu</a>
                        <a href="{{ route('kontak') }}">Kontak</a>
                        <a href="{{ route('pesanan') }}">Riwayat Pesanan</a>
                    </div>
                </div>

                <div class="dimsum-footer-column">
                    <h3 class="dimsum-footer-heading">Informasi</h3>
                    <div class="dimsum-footer-links">
                        <a href="#">Cara Order</a>
                        <a href="#">FAQ</a>
                        <a href="#">Event & Catering</a>
                        <a href="#">Syarat & Ketentuan</a>
                        <a href="#">Kebijakan Privasi</a>
                    </div>
                </div>

                <div class="dimsum-footer-column">
                    <h3 class="dimsum-footer-heading">Hubungi Kami</h3>
                    <ul class="dimsum-footer-links">
                        <li>
                            <i class="fas fa-map-marker-alt" style="margin-right: 8px;"></i>
                            <span>Jl. Dimsum No. 123, Jakarta Selatan</span>
                        </li>
                        <li>
                            <i class="fas fa-phone" style="margin-right: 8px;"></i>
                            <span>(414) 857 - 0107</span>
                        </li>
                        <li>
                            <i class="fas fa-envelope" style="margin-right: 8px;"></i>
                            <span>dimsumtime.id@gmail.com</span>
                        </li>
                        <li>
                            <i class="fas fa-clock" style="margin-right: 8px;"></i>
                            <span>Buka setiap hari 10:00 - 22:00</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="dimsum-footer-bottom">
                <div class="dimsum-copyright">
                    Copyright © {{ date('Y') }} Dimsum Time. All Rights Reserved
                </div>
                <div class="dimsum-payment-methods">
                    <span>Metode Pembayaran:</span>
                    <div class="dimsum-payment-icon">BCA</div>
                    <div class="dimsum-payment-icon">Mandiri</div>
                    <div class="dimsum-payment-icon">Gopay</div>
                    <div class="dimsum-payment-icon">OVO</div>
                    <div class="dimsum-payment-icon">DANA</div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Fungsi untuk menampilkan loading spinner
        function showLoading() {
            document.getElementById('loadingSpinner').style.display = 'flex';
        }

        function hideLoading() {
            document.getElementById('loadingSpinner').style.display = 'none';
        }

        // Countdown timer 1.5 jam
        function startCountdown(expiryTime) {
            function updateTimer() {
                const now = new Date().getTime();
                const distance = expiryTime - now;
                
                if (distance < 0) {
                    document.getElementById("countdown").innerHTML = "WAKTU HABIS!";
                    document.getElementById("countdown").style.color = "#dc3545";
                    
                    // Auto redirect setelah 5 detik
                    setTimeout(() => {
                        window.location.reload();
                    }, 5000);
                    return;
                }
                
                const hours = Math.floor(distance / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                
                document.getElementById("countdown").innerHTML = 
                    (hours < 10 ? "0" : "") + hours + ":" + 
                    (minutes < 10 ? "0" : "") + minutes + ":" + 
                    (seconds < 10 ? "0" : "") + seconds;
                    
                // Ubah warna menjadi merah jika kurang dari 30 menit
                if (hours === 0 && minutes < 30) {
                    document.getElementById("countdown").style.color = "#dc3545";
                }
            }
            
            updateTimer();
            const timerInterval = setInterval(updateTimer, 1000);
            
            // Cleanup interval
            return () => clearInterval(timerInterval);
        }

        // Fungsi untuk copy ke clipboard
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Berhasil disalin: ' + text);
            }).catch(err => {
                console.error('Gagal menyalin: ', err);
            });
        }

        function copyOrderNumber() {
            const orderNumber = '{{ $pesanan->nomor_pesanan }}';
            copyToClipboard(orderNumber);
        }

        // Inisialisasi saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            // Set waktu kadaluarsa (1.5 jam dari pembuatan pesanan)
            const createdAt = new Date("{{ $pesanan->created_at }}").getTime();
            const expiryTime = createdAt + (1.5 * 60 * 60 * 1000); // 1.5 jam
            
            startCountdown(expiryTime);
            
            // Check setiap menit apakah sudah expired
            setInterval(() => {
                const now = new Date().getTime();
                if (now > expiryTime) {
                    window.location.reload();
                }
            }, 60000); // Check setiap menit
        });
    </script>
</body>
</html>