<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Bukti Pembayaran - Dimsum Time</title>
    
    <!-- Include styles from checkout page -->
    <style>
        :root {
            --primary-color: #e53935;
            --secondary-color: #ff9800;
            --accent-color: #fbc02d;
            --bg-light: #fff3e0;
            --text-dark: #2c2f24;
            --text-muted: #495460;
            --border-color: #c6c6c6;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: #f5f5f5;
            color: var(--text-dark);
            line-height: 1.6;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .upload-card {
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .upload-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .upload-header h1 {
            font-family: 'Baloo', cursive;
            font-size: 36px;
            color: var(--text-dark);
            margin-bottom: 10px;
        }

        .upload-header p {
            color: var(--text-muted);
            font-size: 16px;
        }

        .order-info {
            background: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .info-label {
            font-weight: 600;
            color: var(--text-dark);
        }

        .info-value {
            color: var(--text-muted);
        }

        .total-value {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 18px;
        }

        .payment-instruction {
            background: #e8f5e9;
            border-left: 4px solid #4caf50;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .payment-instruction h3 {
            color: #2e7d32;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .bank-info {
            background: white;
            padding: 15px;
            border-radius: 6px;
            margin-top: 15px;
        }

        .bank-info ul {
            list-style: none;
            margin: 10px 0;
        }

        .bank-info li {
            padding: 5px 0;
        }

        .bank-info strong {
            color: #333;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 2px dashed var(--border-color);
            border-radius: 8px;
            font-size: 16px;
            background: #fafafa;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        .file-preview {
            margin-top: 15px;
            text-align: center;
        }

        .file-preview img {
            max-width: 100%;
            max-height: 300px;
            border-radius: 8px;
            border: 2px solid var(--border-color);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 28px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none;
            width: 100%;
            margin-bottom: 10px;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background: #c62828;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(229, 57, 53, 0.3);
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

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .small-text {
            font-size: 14px;
            color: var(--text-muted);
            display: block;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .container {
                margin: 20px auto;
                padding: 0 15px;
            }
            
            .upload-card {
                padding: 25px;
            }
            
            .upload-header h1 {
                font-size: 28px;
            }
            
            .info-row {
                flex-direction: column;
                gap: 5px;
            }
        }
    </style>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Baloo+2:wght@600&family=Baloo&family=Inter:wght@400;500&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        <div class="upload-card">
            <!-- Header -->
            <div class="upload-header">
                <h1>Upload Bukti Pembayaran</h1>
                <p>Silakan upload bukti pembayaran untuk pesanan Anda</p>
            </div>

            <!-- Order Information -->
            <div class="order-info">
                <div class="info-row">
                    <span class="info-label">Nomor Pesanan:</span>
                    <span class="info-value">{{ $pesanan->nomor_pesanan }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Pesanan:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($pesanan->created_at)->format('d/m/Y H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Total Pembayaran:</span>
                    <span class="info-value total-value">
                        Rp{{ number_format($pesanan->total_bayar, 0, ',', '.') }}
                    </span>
                </div>
                @if($pesanan->pembayaran)
                <div class="info-row">
                    <span class="info-label">Metode Pembayaran:</span>
                    <span class="info-value">
                        @php
                            $paymentMethods = [
                                'bca' => 'Transfer BCA',
                                'mandiri' => 'Transfer Mandiri',
                                'bni' => 'Transfer BNI',
                                'bri' => 'Transfer BRI',
                                'ovo' => 'OVO',
                                'gopay' => 'Gopay',
                                'dana' => 'DANA',
                                'shopeepay' => 'ShopeePay',
                                'cod' => 'Cash on Delivery'
                            ];
                            $method = $pesanan->pembayaran->metode_pembayaran;
                        @endphp
                        {{ $paymentMethods[$method] ?? strtoupper($method) }}
                    </span>
                </div>
                @endif
            </div>

            <!-- Payment Instructions for Bank Transfer -->
            @if($pesanan->pembayaran && in_array($pesanan->pembayaran->metode_pembayaran, ['bca', 'mandiri', 'bni', 'bri']))
            <div class="payment-instruction">
                <h3>
                    <i class="fas fa-university"></i>
                    Instruksi Transfer Bank
                </h3>
                
                <p>Silakan transfer ke rekening berikut:</p>
                
                <div class="bank-info">
                    @switch($pesanan->pembayaran->metode_pembayaran)
                        @case('bca')
                            <p><strong>Bank BCA</strong></p>
                            <ul>
                                <li><strong>Nomor Rekening:</strong> 1234 5678 9012</li>
                                <li><strong>Atas Nama:</strong> Dimsum Time</li>
                            </ul>
                            @break
                        @case('mandiri')
                            <p><strong>Bank Mandiri</strong></p>
                            <ul>
                                <li><strong>Nomor Rekening:</strong> 0987 6543 2109</li>
                                <li><strong>Atas Nama:</strong> Dimsum Time</li>
                            </ul>
                            @break
                        @case('bni')
                            <p><strong>Bank BNI</strong></p>
                            <ul>
                                <li><strong>Nomor Rekening:</strong> 5678 9012 3456</li>
                                <li><strong>Atas Nama:</strong> Dimsum Time</li>
                            </ul>
                            @break
                        @case('bri')
                            <p><strong>Bank BRI</strong></p>
                            <ul>
                                <li><strong>Nomor Rekening:</strong> 4321 0987 6543</li>
                                <li><strong>Atas Nama:</strong> Dimsum Time</li>
                            </ul>
                            @break
                    @endswitch
                    
                    <p><strong>Jumlah Transfer:</strong> 
                        <span style="color: var(--primary-color); font-weight: 700;">
                            Rp{{ number_format($pesanan->total_bayar, 0, ',', '.') }}
                        </span>
                    </p>
                    <p><strong>Catatan Penting:</strong> Harap transfer sesuai jumlah yang tertera tanpa pembulatan.</p>
                </div>
            </div>
            @endif

            <!-- Upload Form -->
            <form action="{{ route('pesanan.simpan-bukti', $pesanan->id_pesanan) }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                @csrf
                
                <!-- File Upload -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-file-upload"></i> Upload Bukti Pembayaran *
                    </label>
                    <input type="file" 
                           name="bukti_pembayaran" 
                           id="bukti_pembayaran" 
                           class="form-control" 
                           accept="image/*"
                           required>
                    <span class="small-text">
                        Format: JPG, PNG, GIF (Maksimal 2MB)
                    </span>
                    <div class="file-preview" id="filePreview"></div>
                </div>

                <!-- Action Buttons -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-upload"></i> Upload Bukti Pembayaran
                    </button>
                    
                    <a href="{{ route('pesanan') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Riwayat Pesanan
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Preview image when file is selected
        document.getElementById('bukti_pembayaran').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('filePreview');
            const submitBtn = document.getElementById('submitBtn');
            
            if (file) {
                // Check file size (max 2MB)
                const maxSize = 2 * 1024 * 1024; // 2MB
                if (file.size > maxSize) {
                    alert('File terlalu besar! Maksimal 2MB.');
                    this.value = '';
                    preview.innerHTML = '';
                    submitBtn.disabled = false;
                    return;
                }
                
                // Check file type
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                if (!validTypes.includes(file.type)) {
                    alert('Format file tidak didukung! Hanya JPG, PNG, GIF.');
                    this.value = '';
                    preview.innerHTML = '';
                    submitBtn.disabled = false;
                    return;
                }
                
                // Show loading
                preview.innerHTML = '<p><i class="fas fa-spinner fa-spin"></i> Memuat preview...</p>';
                submitBtn.disabled = true;
                
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.innerHTML = `
                        <img src="${e.target.result}" alt="Preview Bukti Pembayaran">
                        <p style="margin-top: 10px; color: var(--text-muted);">
                            ${file.name} (${(file.size / 1024).toFixed(2)} KB)
                        </p>
                    `;
                    submitBtn.disabled = false;
                }
                
                reader.onerror = function() {
                    preview.innerHTML = '<p style="color: red;">Gagal memuat gambar</p>';
                    submitBtn.disabled = false;
                }
                
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = '';
                submitBtn.disabled = false;
            }
        });

        // Form validation
        document.getElementById('uploadForm').addEventListener('submit', function(e) {
            const fileInput = document.getElementById('bukti_pembayaran');
            const submitBtn = document.getElementById('submitBtn');
            
            if (!fileInput.files[0]) {
                e.preventDefault();
                alert('Silakan pilih file bukti pembayaran terlebih dahulu.');
                return;
            }
            
            // Show loading on button
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengupload...';
            submitBtn.disabled = true;
        });

        // Add some animation
        document.addEventListener('DOMContentLoaded', function() {
            const card = document.querySelector('.upload-card');
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>
</html>