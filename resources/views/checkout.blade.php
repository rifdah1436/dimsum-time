<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout - Dimsum Time</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <style>
        :root {
            --primary: #e53935;
            --primary-light: #fee9e5;
            --secondary: #00bfa5;
            --dark: #212121;
            --gray-dark: #757575;
            --gray: #9e9e9e;
            --gray-light: #e0e0e0;
            --gray-bg: #f5f5f5;
            --white: #ffffff;
            --success: #00bfa5;
            --warning: #ff9800;
            --danger: #f44336;
            --success-light: #e8f5e9;
        }
        :root {
            --primary: #ee4d2d;
            --primary-light: #fee9e5;
            --secondary: #00bfa5;
            --dark: #212121;
            --gray-dark: #757575;
            --gray: #9e9e9e;
            --gray-light: #e0e0e0;
            --gray-bg: #f5f5f5;
            --white: #ffffff;
            --success: #00bfa5;
            --warning: #ff9800;
            --danger: #f44336;
            --success-light: #e8f5e9;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            background-color: var(--gray-bg);
            color: var(--dark);
            font-size: 14px;
            line-height: 1.4;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: var(--white);
            min-height: 100vh;
        }

        @media (min-width: 768px) {
            .container {
                border-radius: 12px;
                box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
                margin: 20px auto;
                overflow: hidden;
            }
            
            .footer {
                max-width: 1200px;
                margin: 0 auto;
                border-radius: 0 0 12px 12px;
            }
        }

        /* Header */
        .header {
            position: sticky;
            top: 0;
            background: var(--white);
            border-bottom: 1px solid var(--gray-light);
            z-index: 100;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            height: 56px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .back-btn {
            background: none;
            border: none;
            font-size: 20px;
            color: var(--dark);
            cursor: pointer;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo {
            font-weight: 700;
            font-size: 18px;
            color: var(--primary);
        }

        /* Delivery/Pickup Toggle */
        .delivery-toggle {
            display: flex;
            background: var(--white);
            border-bottom: 1px solid var(--gray-light);
        }

        .toggle-option {
            flex: 1;
            text-align: center;
            padding: 16px;
            font-weight: 600;
            cursor: pointer;
            position: relative;
            color: var(--gray-dark);
        }

        .toggle-option.active {
            color: var(--primary);
        }

        .toggle-option.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--primary);
        }

        /* Main Content */
        .checkout-content {
            padding-bottom: 100px;
            display: flex;
            flex-wrap: wrap;
        }

        /* Desktop Layout */
        @media (min-width: 768px) {
            .checkout-left {
                flex: 0 0 65%;
                max-width: 65%;
                padding-right: 20px;
            }
            
            .checkout-right {
                flex: 0 0 35%;
                max-width: 35%;
                padding-left: 20px;
                border-left: 1px solid var(--gray-light);
            }
            
            .checkout-content {
                padding: 20px;
            }
        }

        /* Section */
        .section {
            margin: 12px 16px;
            background: var(--white);
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid var(--gray-light);
        }

        @media (min-width: 768px) {
            .section {
                margin: 0 0 16px 0;
            }
        }

        .section-title {
            font-size: 16px;
            font-weight: 600;
            padding: 16px;
            border-bottom: 1px solid var(--gray-light);
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .section-content {
            padding: 16px;
        }

        /* Address */
        .address-card {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            cursor: pointer;
        }

        .address-icon {
            color: var(--primary);
            font-size: 18px;
            margin-top: 2px;
        }

        .address-info h3 {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 4px;
            color: var(--dark);
        }

        .address-info p {
            font-size: 12px;
            color: var(--gray-dark);
            line-height: 1.5;
        }

        .address-phone {
            margin-top: 4px;
            color: var(--gray-dark);
        }

        .change-address-btn {
            color: var(--primary);
            font-weight: 500;
            cursor: pointer;
            font-size: 13px;
        }

        /* Store Map */
        .store-map {
            margin: 16px 0;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid var(--gray-light);
        }

        .map-placeholder {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 150px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--white);
            text-align: center;
            padding: 20px;
        }

        .map-placeholder i {
            font-size: 48px;
            margin-bottom: 12px;
            opacity: 0.9;
        }

        .map-placeholder h3 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .map-placeholder p {
            font-size: 12px;
            opacity: 0.8;
        }

        /* Store Info */
        .store-info {
            background: var(--primary-light);
            border-radius: 8px;
            padding: 12px;
            margin-top: 12px;
        }

        .store-info-item {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            margin-bottom: 8px;
        }

        .store-info-item:last-child {
            margin-bottom: 0;
        }

        .store-info-item i {
            color: var(--primary);
            margin-top: 2px;
        }

        .store-info-item p {
            font-size: 13px;
            color: var(--dark);
            flex: 1;
        }

        /* Order Items */
        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 12px 0;
            border-bottom: 1px solid var(--gray-light);
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .item-info {
            flex: 1;
        }

        .item-name {
            font-weight: 500;
            margin-bottom: 4px;
            color: var(--dark);
        }

        .item-details {
            font-size: 12px;
            color: var(--gray-dark);
            margin-bottom: 4px;
        }

        .item-price {
            font-weight: 600;
            color: var(--dark);
            font-size: 14px;
            text-align: right;
        }

        .item-quantity {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 8px;
            color: var(--gray-dark);
            font-size: 12px;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 8px;
            border: 1px solid var(--gray-light);
            border-radius: 4px;
            padding: 2px 8px;
        }

        .qty-btn {
            background: none;
            border: none;
            color: var(--gray-dark);
            cursor: pointer;
            font-size: 14px;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Voucher Section */
        .voucher-section {
            background: linear-gradient(to right, #ff7a45, #ee4d2d);
            color: var(--white);
            border-radius: 8px;
            margin: 12px 16px;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
        }

        @media (min-width: 768px) {
            .voucher-section {
                margin: 0 0 16px 0;
            }
        }

        .voucher-left {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .voucher-icon {
            font-size: 18px;
        }

        .voucher-text h4 {
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 2px;
        }

        .voucher-text p {
            font-size: 12px;
            opacity: 0.9;
        }

        .voucher-arrow {
            font-size: 14px;
        }

        /* Payment Methods */
        .payment-method {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid var(--gray-light);
            cursor: pointer;
        }

        .payment-method:last-child {
            border-bottom: none;
        }

        .payment-icon-container {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: var(--gray-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark);
            font-size: 20px;
        }

        .payment-info {
            flex: 1;
        }

        .payment-info h4 {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 2px;
        }

        .payment-info p {
            font-size: 12px;
            color: var(--gray-dark);
        }

        .payment-check {
            color: var(--success);
            font-size: 18px;
            display: none;
        }

        /* Order Summary */
        .summary-section {
            background: var(--white);
            margin: 12px 16px;
            border-radius: 8px;
            padding: 16px;
            border: 1px solid var(--gray-light);
        }

        @media (min-width: 768px) {
            .summary-section {
                margin: 0;
                position: sticky;
                top: 80px;
            }
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .summary-label {
            color: var(--gray-dark);
        }

        .summary-value {
            font-weight: 500;
        }

        .summary-total {
            border-top: 1px solid var(--gray-light);
            margin-top: 12px;
            padding-top: 12px;
            font-weight: 600;
            font-size: 16px;
        }

        .summary-savings {
            color: var(--success);
            font-size: 12px;
            margin-top: 4px;
            text-align: right;
        }

        /* Fixed Footer */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--white);
            border-top: 1px solid var(--gray-light);
            padding: 16px;
            max-width: 480px;
            margin: 0 auto;
        }

        @media (min-width: 768px) {
            .footer {
                position: sticky;
                top: auto;
                bottom: 0;
                max-width: 100%;
                border-top: 1px solid var(--gray-light);
                background: var(--white);
                z-index: 99;
            }
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .total-amount {
            text-align: right;
        }

        .total-label {
            font-size: 12px;
            color: var(--gray-dark);
            margin-bottom: 2px;
        }

        .total-value {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary);
        }

        .checkout-btn {
            background: var(--primary);
            color: var(--white);
            border: none;
            border-radius: 4px;
            padding: 12px 24px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            min-width: 140px;
        }

        .checkout-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            display: none;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .modal-content {
            background: var(--white);
            border-radius: 12px;
            width: 100%;
            max-width: 500px;
            max-height: 80vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px;
            border-bottom: 1px solid var(--gray-light);
        }

        .modal-title {
            font-size: 18px;
            font-weight: 600;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 20px;
            color: var(--gray-dark);
            cursor: pointer;
        }

        .modal-body {
            padding: 16px;
        }

        /* Voucher Modal */
        .voucher-search {
            display: flex;
            gap: 8px;
            margin-bottom: 16px;
        }

        .voucher-input {
            flex: 1;
            padding: 10px 12px;
            border: 1px solid var(--gray-light);
            border-radius: 4px;
            font-size: 14px;
        }

        .voucher-apply {
            background: var(--primary);
            color: var(--white);
            border: none;
            border-radius: 4px;
            padding: 10px 16px;
            font-weight: 500;
            cursor: pointer;
        }

        .voucher-category {
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--dark);
        }

        .voucher-list {
            margin-bottom: 16px;
        }

        .voucher-item {
            background: var(--white);
            border: 1px solid var(--gray-light);
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .voucher-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .voucher-item.active {
            border-color: var(--primary);
            background: var(--primary-light);
        }

        .voucher-item.disabled {
            opacity: 0.6;
            cursor: not-allowed;
            background: #f9f9f9;
        }

        .voucher-item.disabled:hover {
            transform: none;
            box-shadow: none;
            border-color: var(--gray-light);
        }

        .voucher-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 6px;
        }

        .voucher-name {
            font-weight: 700;
            color: var(--primary);
            font-size: 15px;
        }

        .voucher-type {
            background: var(--primary);
            color: var(--white);
            font-size: 10px;
            padding: 3px 8px;
            border-radius: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .voucher-desc {
            font-size: 13px;
            color: var(--gray-dark);
            margin-bottom: 6px;
            line-height: 1.4;
        }

        .voucher-conditions {
            font-size: 11px;
            color: var(--gray);
            background: var(--gray-bg);
            padding: 6px 8px;
            border-radius: 4px;
            margin-top: 6px;
        }

        .voucher-expiry {
            display: inline-block;
            background: #ff9800;
            color: white;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 10px;
            margin-left: 5px;
            font-weight: 500;
        }

        /* Empty State */
        .empty-cart {
            text-align: center;
            padding: 40px 20px;
        }

        .empty-icon {
            font-size: 48px;
            color: var(--gray-light);
            margin-bottom: 16px;
        }

        .empty-text {
            color: var(--gray-dark);
            font-size: 14px;
        }

        /* Loading Spinner */
        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid var(--gray-light);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* QR Code Container */
        .qrcode-container {
            text-align: center;
            margin: 20px 0;
            padding: 20px;
            background: var(--gray-bg);
            border-radius: 8px;
        }

        .qrcode-image {
            max-width: 200px;
            margin: 0 auto 15px;
        }

        .qrcode-image img {
            width: 100%;
            height: auto;
        }

        .bank-details {
            background: var(--primary-light);
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            border-left: 4px solid var(--primary);
        }

        .bank-details h4 {
            color: var(--primary);
            margin-bottom: 10px;
            font-size: 16px;
        }

        .bank-details p {
            margin: 5px 0;
            font-size: 14px;
            color: var(--dark);
        }

        /* Order Timer */
        .order-timer {
            background: #fff3e0;
            padding: 12px;
            border-radius: 8px;
            border-left: 4px solid var(--warning);
            margin: 15px 0;
            font-size: 13px;
            color: var(--dark);
        }

        .order-timer i {
            color: var(--warning);
            margin-right: 8px;
        }

        /* Payment Timer in Modal */
        .payment-timer {
            background: linear-gradient(135deg, #ff5252, #ff9800);
            color: white;
            padding: 12px;
            border-radius: 8px;
            margin: 15px 0;
            text-align: center;
            font-weight: 600;
            font-size: 16px;
        }

        .payment-timer i {
            margin-right: 8px;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        /* Instructions */
        .instructions {
            background: #e8f5e9;
            padding: 12px;
            border-radius: 8px;
            margin: 15px 0;
            border-left: 4px solid var(--success);
        }

        .instructions h4 {
            color: var(--success);
            margin-bottom: 8px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .instructions ol {
            margin-left: 20px;
            font-size: 13px;
            color: var(--dark);
        }

        .instructions li {
            margin-bottom: 4px;
        }

        /* Responsive */
        @media (max-width: 767px) {
            .container {
                border-radius: 0;
            }
            
            .footer {
                border-radius: 0;
            }
            
            .checkout-left, .checkout-right {
                flex: 0 0 100%;
                max-width: 100%;
                padding: 0;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-content">
                <div class="header-left">
                    <button class="back-btn" onclick="window.history.back()">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <div class="logo">DIMSUM TIME</div>
                </div>
            </div>
        </div>

        <!-- Delivery/Pickup Toggle -->
        <div class="delivery-toggle">
            <div class="toggle-option active" id="deliveryTab" onclick="selectDeliveryTab()">
                <i class="fas fa-motorcycle"></i> Delivery
            </div>
            <div class="toggle-option" id="pickupTab" onclick="selectPickupTab()">
                <i class="fas fa-store"></i> Pickup
            </div>
        </div>

        <!-- Main Content -->
        <div class="checkout-content">
            @if(empty($cart))
                <!-- Empty Cart -->
                <div class="empty-cart">
                    <div class="empty-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="empty-text">Keranjang Anda kosong</div>
                    <button class="checkout-btn" style="margin-top: 20px;" onclick="window.location.href='{{ route('menu') }}'">
                        Lihat Menu
                    </button>
                </div>
            @else
                <!-- Desktop Layout -->
                <div class="checkout-left">
                    <!-- DELIVERY CONTENT -->
                    <div id="deliveryContent">
                        <!-- Address Section -->
                        <div class="section">
                            <div class="section-title">
                                <span>Alamat Pengiriman</span>
                                <span class="change-address-btn" onclick="showAddressModal()">Ubah</span>
                            </div>
                            <div class="section-content">
                                <div class="address-card" onclick="showAddressModal()">
                                    <div class="address-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="address-info">
                                        <h3>Kirim ke alamat</h3>
                                        <p id="addressDisplay">
                                            @if(auth()->user()->alamat)
                                                <strong>{{ auth()->user()->nama_lengkap ?? 'Pelanggan' }}</strong> | {{ auth()->user()->nomor_telepon ?? '' }}<br>
                                                {{ auth()->user()->alamat }}<br>
                                                {{ auth()->user()->kecamatan ?? '' }}, {{ auth()->user()->kota ?? '' }}
                                            @else
                                                <span style="color: var(--danger);">Belum ada alamat. Klik untuk tambah alamat.</span>
                                            @endif
                                        </p>
                                        <div class="address-phone">
                                            <i class="fas fa-phone"></i> {{ auth()->user()->nomor_telepon ?? '' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Delivery Time -->
                        <div class="section">
                            <div class="section-title">
                                <span>Waktu Pengiriman</span>
                            </div>
                            <div class="section-content">
                                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                                    <div style="width: 36px; height: 36px; background: var(--primary-light); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; font-size: 14px;">Pesan sekarang</div>
                                        <div style="font-size: 12px; color: var(--gray-dark);">Estimasi: <span id="deliveryTime">30-45 menit</span></div>
                                    </div>
                                </div>
                                
                                <div style="border-top: 1px solid var(--gray-light); padding-top: 12px;">
                                    <div style="font-weight: 500; margin-bottom: 8px; font-size: 13px;">Atau jadwalkan pengiriman:</div>
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                                        <input type="date" 
                                               id="scheduleDate" 
                                               style="padding: 8px 12px; border: 1px solid var(--gray-light); border-radius: 4px; font-size: 14px;"
                                               min="{{ date('Y-m-d') }}">
                                        <select id="scheduleHour" style="padding: 8px 12px; border: 1px solid var(--gray-light); border-radius: 4px; font-size: 14px;">
                                            <option value="">Pilih Jam</option>
                                            @for($i = 10; $i <= 22; $i++)
                                                <option value="{{ sprintf('%02d:00', $i) }}">{{ sprintf('%02d:00', $i) }}</option>
                                                @if($i < 22)
                                                    <option value="{{ sprintf('%02d:30', $i) }}">{{ sprintf('%02d:30', $i) }}</option>
                                                @endif
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PICKUP CONTENT -->
                    <div id="pickupContent" style="display: none;">
                        <!-- Store Location -->
                        <div class="section">
                            <div class="section-title">
                                <span>Lokasi Toko</span>
                            </div>
                            <div class="section-content">
                                <!-- Store Map -->
                                <div class="store-map">
                                    <div class="map-placeholder">
                                        <i class="fas fa-store"></i>
                                        <h3>Dimsum Time Store</h3>
                                        <p>Jl. Raya Dimsum No. 123, Jakarta Selatan</p>
                                    </div>
                                </div>

                                <!-- Store Info -->
                                <div class="store-info">
                                    <div class="store-info-item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <p><strong>Alamat:</strong> Jl. Raya Dimsum No. 123, Kebayoran Baru, Jakarta Selatan 12120</p>
                                    </div>
                                    <div class="store-info-item">
                                        <i class="fas fa-clock"></i>
                                        <p><strong>Jam Operasional:</strong> 10:00 - 22:00 (Setiap Hari)</p>
                                    </div>
                                    <div class="store-info-item">
                                        <i class="fas fa-phone"></i>
                                        <p><strong>Telepon:</strong> (021) 1234-5678</p>
                                    </div>
                                </div>

                                <!-- Pickup Instructions -->
                                <div style="margin-top: 16px; padding: 12px; background: #e8f5e9; border-radius: 8px; border-left: 4px solid var(--success);">
                                    <div style="font-weight: 600; color: var(--success); margin-bottom: 4px;">
                                        <i class="fas fa-info-circle"></i> Cara Pickup:
                                    </div>
                                    <div style="font-size: 12px; color: var(--dark);">
                                        1. Pesan terlebih dahulu melalui aplikasi<br>
                                        2. Datang ke toko sesuai waktu yang dipilih<br>
                                        3. Sebutkan nomor pesanan Anda<br>
                                        4. Ambil pesanan dan bayar di kasir
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pickup Time -->
                        <div class="section">
                            <div class="section-title">
                                <span>Waktu Pickup</span>
                            </div>
                            <div class="section-content">
                                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                                    <div style="width: 36px; height: 36px; background: var(--success-light); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--success);">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; font-size: 14px;">Ambil sekarang</div>
                                        <div style="font-size: 12px; color: var(--gray-dark);">Siap dalam: <span>15-30 menit</span></div>
                                    </div>
                                </div>
                                
                                <div style="border-top: 1px solid var(--gray-light); padding-top: 12px;">
                                    <div style="font-weight: 500; margin-bottom: 8px; font-size: 13px;">Atau jadwalkan pickup:</div>
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                                        <input type="date" 
                                               id="pickupDate" 
                                               style="padding: 8px 12px; border: 1px solid var(--gray-light); border-radius: 4px; font-size: 14px;"
                                               min="{{ date('Y-m-d') }}">
                                        <select id="pickupHour" style="padding: 8px 12px; border: 1px solid var(--gray-light); border-radius: 4px; font-size: 14px;">
                                            <option value="">Pilih Jam</option>
                                            @for($i = 10; $i <= 22; $i++)
                                                <option value="{{ sprintf('%02d:00', $i) }}">{{ sprintf('%02d:00', $i) }}</option>
                                                @if($i < 22)
                                                    <option value="{{ sprintf('%02d:30', $i) }}">{{ sprintf('%02d:30', $i) }}</option>
                                                @endif
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="section">
                        <div class="section-title">
                            <span>Pesanan Anda</span>
                            <span class="change-address-btn" onclick="window.location.href='{{ route('keranjang') }}'">Ubah</span>
                        </div>
                        <div class="section-content">
                            @php
                                $subtotal = 0;
                                $totalQuantity = 0;
                            @endphp
                            
                            @foreach($cart as $id => $item)
                                @php
                                    $itemSubtotal = $item['harga'] * $item['jumlah'];
                                    $subtotal += $itemSubtotal;
                                    $totalQuantity += $item['jumlah'];
                                @endphp
                                <div class="order-item">
                                    <div class="item-info">
                                        <div class="item-name">{{ $item['nama'] }}</div>
                                        <div class="item-details">
                                            {{ $item['ukuran'] ?? 'Reguler' }} • {{ $item['jumlah_pcs'] ?? 6 }} pcs
                                            @if(!empty($item['catatan']))
                                                <br><i>{{ $item['catatan'] }}</i>
                                            @endif
                                        </div>
                                        <div class="item-quantity">
                                            <div class="quantity-control">
                                                <span style="min-width: 20px; text-align: center;">{{ $item['jumlah'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item-price">
                                        Rp{{ number_format($itemSubtotal, 0, ',', '.') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Payment Methods -->
                    <div class="section">
                        <div class="section-title">
                            <span>Metode Pembayaran</span>
                        </div>
                        <div class="section-content">
                            <div class="payment-method active" onclick="selectPayment('cod')">
                                <div class="payment-icon-container">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                <div class="payment-info">
                                    <h4>COD (Bayar di Tempat)</h4>
                                    <p>Bayar ketika pesanan sampai/diambil</p>
                                </div>
                                <div class="payment-check">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                            
                            <div class="payment-method" onclick="selectPayment('bca')">
                                <div class="payment-icon-container">
                                    <i class="fas fa-university"></i>
                                </div>
                                <div class="payment-info">
                                    <h4>Transfer BCA</h4>
                                    <p>Bank Central Asia</p>
                                </div>
                                <div class="payment-check">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                            
                            <div class="payment-method" onclick="selectPayment('mandiri')">
                                <div class="payment-icon-container">
                                    <i class="fas fa-university"></i>
                                </div>
                                <div class="payment-info">
                                    <h4>Transfer Mandiri</h4>
                                    <p>Bank Mandiri</p>
                                </div>
                                <div class="payment-check">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                            
                            <div class="payment-method" onclick="selectPayment('ovo')">
                                <div class="payment-icon-container">
                                    <i class="fas fa-wallet"></i>
                                </div>
                                <div class="payment-info">
                                    <h4>OVO</h4>
                                    <p>E-Wallet OVO</p>
                                </div>
                                <div class="payment-check">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>

                            <div class="payment-method" onclick="selectPayment('dana')">
                                <div class="payment-icon-container">
                                    <i class="fas fa-wallet"></i>
                                </div>
                                <div class="payment-info">
                                    <h4>DANA</h4>
                                    <p>E-Wallet DANA</p>
                                </div>
                                <div class="payment-check">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar (Desktop) -->
                <div class="checkout-right">
                    <!-- Voucher Section -->
                    <div class="voucher-section" onclick="showVoucherModal()">
                        <div class="voucher-left">
                            <div class="voucher-icon">
                                <i class="fas fa-tag"></i>
                            </div>
                            <div class="voucher-text">
                                <h4>Voucher & Promo</h4>
                                <p id="voucherDisplay">
                                    @if($appliedCoupon)
                                        {{ $appliedCoupon['name'] }} diterapkan
                                    @else
                                        Pilih voucher atau masukkan kode promo
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="voucher-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="summary-section">
                        <div class="summary-row">
                            <span class="summary-label">Subtotal ({{ $totalQuantity }} items)</span>
                            <span class="summary-value" id="subtotalDisplay">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Biaya Pengiriman</span>
                            <span class="summary-value" id="shippingDisplay">Rp{{ number_format($shippingFee, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-row" id="discountRow" style="{{ $appliedCoupon ? '' : 'display: none;' }}">
                            <span class="summary-label">Diskon Voucher</span>
                            <span class="summary-value" style="color: var(--success);" id="discountDisplay">
                                @if($appliedCoupon)
                                    -Rp{{ number_format($appliedCoupon['discount'] ?? 0, 0, ',', '.') }}
                                @else
                                    -Rp0
                                @endif
                            </span>
                        </div>
                        <div class="summary-row summary-total">
                            <span class="summary-label">Total Pembayaran</span>
                            <span class="summary-value" id="totalDisplay">
                                @php
                                    $total = $subtotal + $shippingFee;
                                    if($appliedCoupon) {
                                        $total -= ($appliedCoupon['discount'] ?? 0);
                                    }
                                @endphp
                                Rp{{ number_format($total, 0, ',', '.') }}
                            </span>
                        </div>
                        @if($appliedCoupon)
                        <div class="summary-savings" id="savingsDisplay">
                            Hemat Rp{{ number_format($appliedCoupon['discount'] ?? 0, 0, ',', '.') }}
                        </div>
                        @endif
                    </div>

                    <!-- Order Timer Info -->
                    <div class="order-timer">
                        <i class="fas fa-clock"></i>
                        Pesanan akan otomatis dibatalkan jika tidak dibayar dalam 1.5 jam
                    </div>
                </div>
            @endif
        </div>

        <!-- Fixed Footer -->
        @if(!empty($cart))
            <div class="footer">
                <div class="footer-content">
                    <div class="total-amount">
                        <div class="total-label">Total Pembayaran</div>
                        <div class="total-value" id="footerTotal">
                            @php
                                $total = $subtotal + $shippingFee;
                                if($appliedCoupon) {
                                    $total -= ($appliedCoupon['discount'] ?? 0);
                                }
                            @endphp
                            Rp{{ number_format($total, 0, ',', '.') }}
                        </div>
                    </div>
                    <button class="checkout-btn" id="checkoutBtn" onclick="processCheckout()">
                        Buat Pesanan
                    </button>
                </div>
            </div>
        @endif
    </div>

    <!-- Voucher Modal -->
    <div class="modal-overlay" id="voucherModal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Pilih atau Masukkan Voucher</div>
                <button class="modal-close" onclick="closeVoucherModal()">×</button>
            </div>
            <div class="modal-body">
                <div class="voucher-search">
                    <input type="text" class="voucher-input" placeholder="Masukkan kode voucher" id="voucherCode">
                    <button class="voucher-apply" onclick="applyVoucherCode()">Pakai</button>
                </div>
                
                @if(isset($availableCoupons) && count($availableCoupons) > 0)
                    <div class="voucher-category">Voucher Tersedia</div>
                    <div class="voucher-list" id="voucherList">
                        @foreach($availableCoupons as $coupon)
                            @php
                                $isApplied = $appliedCoupon && ($appliedCoupon['code'] ?? '') == $coupon->kode_kupon;
                                $canUse = $coupon->bisaDigunakan($subtotal);
                                
                                // Tentukan warna dan teks berdasarkan tipe
                                $typeText = '';
                                $typeColor = 'var(--primary)';
                                
                                if ($coupon->tipe == 'persentase') {
                                    $typeText = $coupon->nilai . '% OFF';
                                    $typeColor = '#00bfa5';
                                } elseif ($coupon->tipe == 'nominal') {
                                    $typeText = 'Rp' . number_format($coupon->nilai, 0, ',', '.');
                                    $typeColor = '#ff9800';
                                } elseif ($coupon->tipe == 'ongkir') {
                                    $typeText = 'GRATIS ONGKIR';
                                    $typeColor = '#ee4d2d';
                                }
                                
                                // Deskripsi diskon
                                $discountDesc = '';
                                if ($coupon->tipe == 'persentase') {
                                    $discountDesc = 'Diskon ' . $coupon->nilai . '%';
                                    if ($coupon->diskon_maksimal) {
                                        $discountDesc .= ' (maks Rp' . number_format($coupon->diskon_maksimal, 0, ',', '.') . ')';
                                    }
                                } elseif ($coupon->tipe == 'nominal') {
                                    $discountDesc = 'Potongan Rp' . number_format($coupon->nilai, 0, ',', '.');
                                } elseif ($coupon->tipe == 'ongkir') {
                                    $discountDesc = 'Gratis ongkir';
                                    if ($coupon->nilai > 0) {
                                        $discountDesc .= ' s/d Rp' . number_format($coupon->nilai, 0, ',', '.');
                                    }
                                }
                                
                                // Tentukan apakah voucher bisa digunakan
                                $itemClass = $isApplied ? 'active' : '';
                                if (!$canUse) {
                                    $itemClass .= ' disabled';
                                }
                                
                                // Hitung estimasi diskon
                                $estimatedDiscount = $canUse ? $coupon->hitungDiskon($subtotal) : 0;
                            @endphp
                            
                            <div class="voucher-item {{ $itemClass }}" 
                                 data-code="{{ $coupon->kode_kupon }}"
                                 data-name="{{ $coupon->nama_kupon }}"
                                 data-type="{{ $coupon->tipe }}"
                                 data-value="{{ $coupon->nilai }}"
                                 data-min="{{ $coupon->minimal_belanja }}"
                                 data-max="{{ $coupon->diskon_maksimal ?? 0 }}"
                                 data-can-use="{{ $canUse ? 'true' : 'false' }}">
                                
                                <div class="voucher-header">
                                    <div class="voucher-name">{{ $coupon->nama_kupon }}</div>
                                    <div class="voucher-type" style="background: {{ $typeColor }};">
                                        {{ $typeText }}
                                    </div>
                                </div>
                                
                                <div class="voucher-desc">
                                    {{ $discountDesc }}
                                    
                                    @if($coupon->minimal_belanja > 0)
                                        <br>Min. belanja: Rp{{ number_format($coupon->minimal_belanja, 0, ',', '.') }}
                                    @endif
                                    
                                    @if(!$canUse)
                                        <br>
                                        <span style="color: #f44336; font-size: 12px;">
                                            <i class="fas fa-exclamation-circle"></i> Belum memenuhi syarat
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="voucher-conditions">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span>
                                            @php
                                                $expiryDate = \Carbon\Carbon::parse($coupon->berlaku_hingga);
                                                $daysLeft = $expiryDate->diffInDays(now());
                                                echo $daysLeft <= 7 ? "Berakhir {$daysLeft} hari lagi" : "Hingga " . $expiryDate->format('d/m/Y');
                                            @endphp
                                        </span>
                                        @if($coupon->kuota > 0)
                                            <span style="color: #666; font-size: 11px;">
                                                Tersisa: {{ $coupon->kuota - $coupon->terpakai }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                    @if($canUse && $estimatedDiscount > 0)
                                        <div style="margin-top: 8px; padding: 6px; background: #e8f5e9; border-radius: 4px; text-align: center;">
                                            <span style="color: #00bfa5; font-weight: 600;">
                                                <i class="fas fa-bolt"></i> Hemat: Rp{{ number_format($estimatedDiscount, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                
                                @if($isApplied)
                                    <div style="margin-top: 10px; padding: 6px; background: #00bfa5; color: white; border-radius: 4px; text-align: center; font-size: 12px;">
                                        <i class="fas fa-check"></i> Sedang digunakan
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: 40px 20px;">
                        <div style="width: 80px; height: 80px; background: #f5f5f5; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                            <i class="fas fa-tag" style="font-size: 36px; color: #ccc;"></i>
                        </div>
                        <h4 style="color: #666; margin-bottom: 8px;">Tidak ada voucher</h4>
                        <p style="color: #999; font-size: 14px;">Tidak ada voucher aktif saat ini</p>
                    </div>
                @endif
                
                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    @if($appliedCoupon)
                        <button class="checkout-btn" style="flex: 1; background: #f44336;" onclick="removeVoucher()">
                            <i class="fas fa-times"></i> Hapus Voucher
                        </button>
                    @endif
                    <button class="checkout-btn" style="flex: 1;" onclick="applySelectedVoucher()">
                        <i class="fas fa-check"></i> Simpan Pilihan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Address Modal -->
    <div class="modal-overlay" id="addressModal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Ubah Alamat</div>
                <button class="modal-close" onclick="closeAddressModal()">×</button>
            </div>
            <div class="modal-body">
                <div style="margin-bottom: 16px;">
                    <div style="font-weight: 500; margin-bottom: 8px; font-size: 14px;">Alamat Sekarang:</div>
                    <div style="background: var(--gray-bg); padding: 12px; border-radius: 8px; font-size: 13px; min-height: 60px;">
                        {{ auth()->user()->alamat ?? 'Belum ada alamat' }}
                    </div>
                </div>
                
                <div style="border-top: 1px solid var(--gray-light); padding-top: 16px;">
                    <div style="font-weight: 500; margin-bottom: 12px; font-size: 14px;">Ubah Alamat:</div>
                    
                    <div style="margin-bottom: 12px;">
                        <label style="display: block; margin-bottom: 4px; font-weight: 500; font-size: 13px;">Alamat Lengkap *</label>
                        <textarea 
                            class="voucher-input" 
                            id="addressInput" 
                            rows="3" 
                            placeholder="Masukkan alamat lengkap (jalan, nomor rumah, RT/RW)"
                            style="margin-bottom: 12px;">{{ auth()->user()->alamat ?? '' }}</textarea>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 12px;">
                        <div>
                            <label style="display: block; margin-bottom: 4px; font-weight: 500; font-size: 13px;">Kecamatan *</label>
                            <select class="voucher-input" id="kecamatanInput">
                                <option value="">Pilih Kecamatan</option>
                                <option value="Serang" {{ (auth()->user()->kecamatan ?? '') == 'Serang' ? 'selected' : '' }}>Serang</option>
                                <option value="Bekasi" {{ (auth()->user()->kecamatan ?? '') == 'Bekasi' ? 'selected' : '' }}>Bekasi</option>
                                <option value="Jakarta Selatan" {{ (auth()->user()->kecamatan ?? '') == 'Jakarta Selatan' ? 'selected' : '' }}>Jakarta Selatan</option>
                                <option value="Jakarta Pusat" {{ (auth()->user()->kecamatan ?? '') == 'Jakarta Pusat' ? 'selected' : '' }}>Jakarta Pusat</option>
                                <option value="Jakarta Barat" {{ (auth()->user()->kecamatan ?? '') == 'Jakarta Barat' ? 'selected' : '' }}>Jakarta Barat</option>
                                <option value="Jakarta Utara" {{ (auth()->user()->kecamatan ?? '') == 'Jakarta Utara' ? 'selected' : '' }}>Jakarta Utara</option>
                            </select>
                        </div>
                        
                        <div>
                            <label style="display: block; margin-bottom: 4px; font-weight: 500; font-size: 13px;">Kota *</label>
                            <select class="voucher-input" id="kotaInput">
                                <option value="">Pilih Kota</option>
                                <option value="Serang" {{ (auth()->user()->kota ?? '') == 'Serang' ? 'selected' : '' }}>Serang</option>
                                <option value="Bekasi" {{ (auth()->user()->kota ?? '') == 'Bekasi' ? 'selected' : '' }}>Bekasi</option>
                                <option value="Jakarta" {{ (auth()->user()->kota ?? '') == 'Jakarta' ? 'selected' : '' }}>Jakarta</option>
                                <option value="Tangerang" {{ (auth()->user()->kota ?? '') == 'Tangerang' ? 'selected' : '' }}>Tangerang</option>
                                <option value="Depok" {{ (auth()->user()->kota ?? '') == 'Depok' ? 'selected' : '' }}>Depok</option>
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label style="display: block; margin-bottom: 4px; font-weight: 500; font-size: 13px;">Kode Pos</label>
                        <input type="text" class="voucher-input" id="kodePosInput" 
                               placeholder="Contoh: 12345" 
                               value="{{ auth()->user()->kode_pos ?? '' }}">
                    </div>
                    
                    <div style="margin-top: 12px;">
                        <label style="display: block; margin-bottom: 4px; font-weight: 500; font-size: 13px;">Catatan Alamat (Opsional)</label>
                        <input type="text" class="voucher-input" id="catatanAlamatInput" 
                               placeholder="Contoh: Dekat masjid, rumah warna biru" 
                               value="{{ auth()->user()->catatan_alamat ?? '' }}">
                    </div>
                </div>
                
                <button type="button" class="checkout-btn" style="width: 100%; margin-top: 20px;" onclick="saveAddress()">
                    Simpan Alamat
                </button>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal-overlay" id="paymentModal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Pembayaran</div>
                <button class="modal-close" onclick="closePaymentModal()">×</button>
            </div>
            <div class="modal-body">
                <!-- Timer -->
                <div class="payment-timer">
                    <i class="fas fa-clock"></i>
                    <span id="paymentTimer">01:30:00</span>
                </div>
                
                <!-- Order Info -->
                <div style="background: var(--gray-bg); padding: 15px; border-radius: 8px; margin: 15px 0;">
                    <div style="font-weight: 600; margin-bottom: 8px; color: var(--dark);">
                        <i class="fas fa-receipt"></i> Detail Pesanan
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 4px; font-size: 13px;">
                        <span>No. Pesanan:</span>
                        <span id="modalOrderNumber" style="font-weight: 600;">-</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 4px; font-size: 13px;">
                        <span>Total Pembayaran:</span>
                        <span id="modalTotalAmount" style="font-weight: 600; color: var(--primary);">-</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 13px;">
                        <span>Metode:</span>
                        <span id="modalPaymentMethod" style="font-weight: 600;">-</span>
                    </div>
                </div>
                
                <!-- Dynamic Content based on Payment Method -->
                <div id="paymentContent">
                    <!-- Content will be loaded dynamically -->
                </div>
                
                <!-- Instructions -->
                <div class="instructions">
                    <h4><i class="fas fa-info-circle"></i> Instruksi Pembayaran</h4>
                    <ol id="paymentInstructions">
                        <!-- Instructions will be loaded dynamically -->
                    </ol>
                </div>
                
                <!-- Action Buttons -->
                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button class="checkout-btn" style="flex: 1; background: var(--success);" onclick="confirmPayment()">
                        <i class="fas fa-check"></i> Saya Sudah Bayar
                    </button>
                    <button class="checkout-btn" style="flex: 1; background: var(--danger);" onclick="closePaymentModal()">
                        <i class="fas fa-times"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    // State variables
    let selectedMethod = 'delivery'; // 'delivery' or 'pickup'
    let selectedPayment = 'cod';
    let selectedVoucher = null;
    let subtotal = {{ $subtotal ?? 0 }};
    let shippingFee = {{ $shippingFee ?? 10000 }};
    let discount = {{ $appliedCoupon ? ($appliedCoupon['discount'] ?? 0) : 0 }};
    let cart = @json($cart ?? []);
    let paymentTimerInterval = null;
    let paymentTimerSeconds = 5400; // 1.5 jam dalam detik (90 menit)
    let currentOrderNumber = '';
    let appliedCoupon = @json($appliedCoupon ?? null);
    
    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        calculateTotals();
        
        // Set default dates
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('scheduleDate').min = today;
        document.getElementById('pickupDate').min = today;
        
        // Set default to tomorrow
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        document.getElementById('scheduleDate').value = tomorrow.toISOString().split('T')[0];
        document.getElementById('pickupDate').value = tomorrow.toISOString().split('T')[0];
        
        // If user has no address, show address modal
        const userAddress = "{{ auth()->user()->alamat ?? '' }}";
        if (!userAddress) {
            setTimeout(() => {
                showAddressModal();
            }, 1000);
        }
        
        // Setup event listeners for voucher items
        document.querySelectorAll('.voucher-item').forEach(item => {
            item.addEventListener('click', function() {
                const canUse = this.dataset.canUse === 'true';
                if (canUse) {
                    selectVoucher(this);
                } else {
                    const minAmount = this.dataset.min;
                    showMinimalInfo(minAmount);
                }
            });
        });
        
        // Responsive layout
        setupResponsiveLayout();
        window.addEventListener('resize', setupResponsiveLayout);
    });
    
    // Setup responsive layout
    function setupResponsiveLayout() {
        if (window.innerWidth >= 768) {
            document.querySelector('.checkout-content').style.flexWrap = 'wrap';
            document.querySelector('.checkout-left').style.flex = '0 0 65%';
            document.querySelector('.checkout-left').style.maxWidth = '65%';
            document.querySelector('.checkout-right').style.flex = '0 0 35%';
            document.querySelector('.checkout-right').style.maxWidth = '35%';
        } else {
            document.querySelector('.checkout-content').style.flexWrap = 'nowrap';
            document.querySelector('.checkout-left').style.flex = '0 0 100%';
            document.querySelector('.checkout-left').style.maxWidth = '100%';
            document.querySelector('.checkout-right').style.flex = '0 0 100%';
            document.querySelector('.checkout-right').style.maxWidth = '100%';
        }
    }
    
    // Select delivery tab
    function selectDeliveryTab() {
        selectedMethod = 'delivery';
        
        // Update UI
        document.getElementById('deliveryTab').classList.add('active');
        document.getElementById('pickupTab').classList.remove('active');
        document.getElementById('deliveryContent').style.display = 'block';
        document.getElementById('pickupContent').style.display = 'none';
        
        // Update shipping fee
        shippingFee = {{ $shippingFee ?? 10000 }};
        calculateTotals();
    }
    
    // Select pickup tab
    function selectPickupTab() {
        selectedMethod = 'pickup';
        
        // Update UI
        document.getElementById('deliveryTab').classList.remove('active');
        document.getElementById('pickupTab').classList.add('active');
        document.getElementById('deliveryContent').style.display = 'none';
        document.getElementById('pickupContent').style.display = 'block';
        
        // PASTIKAN ongkir pickup = 0
        shippingFee = 0;
        
        // Update display langsung
        document.getElementById('shippingDisplay').textContent = 'GRATIS';
        document.getElementById('shippingDisplay').style.color = 'var(--success)';
        document.getElementById('shippingDisplay').style.fontWeight = '600';
        
        calculateTotals();
    }
    
    // Calculate totals
    function calculateTotals() {
        // Untuk pickup, pastikan shippingFee = 0
        if (selectedMethod === 'pickup') {
            shippingFee = 0;
        }
        
        // Update shipping display
        const shippingDisplay = document.getElementById('shippingDisplay');
        if (shippingFee > 0) {
            shippingDisplay.textContent = 'Rp' + formatNumber(shippingFee);
            shippingDisplay.style.color = '';
            shippingDisplay.style.fontWeight = '';
        } else {
            shippingDisplay.textContent = 'GRATIS';
            shippingDisplay.style.color = 'var(--success)';
            shippingDisplay.style.fontWeight = '600';
        }
        
        // Calculate total (tanpa pajak)
        const total = subtotal + shippingFee - discount;
        
        // Update all displays
        document.getElementById('totalDisplay').textContent = 'Rp' + formatNumber(total);
        document.getElementById('footerTotal').textContent = 'Rp' + formatNumber(total);
        
        // Show/hide discount row
        if (discount > 0) {
            document.getElementById('discountRow').style.display = 'flex';
            document.getElementById('discountDisplay').textContent = '-Rp' + formatNumber(discount);
            document.getElementById('savingsDisplay').style.display = 'block';
            document.getElementById('savingsDisplay').textContent = 'Hemat Rp' + formatNumber(discount);
        } else {
            document.getElementById('discountRow').style.display = 'none';
            document.getElementById('savingsDisplay').style.display = 'none';
        }
        
        // Update voucher display
        updateVoucherDisplay();
    }
    
    // Format number with thousand separators
    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    
    // Format time MM:SS
    function formatTime(seconds) {
        const hours = Math.floor(seconds / 3600);
        const minutes = Math.floor((seconds % 3600) / 60);
        const secs = seconds % 60;
        return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
    }
    
    // Select payment method
    function selectPayment(method) {
        selectedPayment = method;
        
        // Update UI
        document.querySelectorAll('.payment-method').forEach(payment => {
            payment.classList.remove('active');
            payment.querySelector('.payment-check').style.display = 'none';
        });
        
        const selectedPaymentEl = event.currentTarget;
        selectedPaymentEl.classList.add('active');
        selectedPaymentEl.querySelector('.payment-check').style.display = 'block';
    }
    
    // Voucher modal functions
    function showVoucherModal() {
        console.log('Opening voucher modal');
        
        // Update tampilan voucher di modal berdasarkan subtotal saat ini
        document.querySelectorAll('.voucher-item').forEach(item => {
            const minPurchase = parseFloat(item.dataset.min);
            const canUse = subtotal >= minPurchase;
            
            // Update data attribute
            item.dataset.canUse = canUse ? 'true' : 'false';
            
            // Update styling
            if (!canUse) {
                item.classList.add('disabled');
                item.style.cursor = 'not-allowed';
            } else {
                item.classList.remove('disabled');
                item.style.cursor = 'pointer';
            }
            
            // Reset active state kecuali yang sedang digunakan
            if (!appliedCoupon || item.dataset.code !== appliedCoupon.code) {
                item.classList.remove('active');
            }
        });
        
        // Highlight voucher yang sedang digunakan jika ada
        if (appliedCoupon) {
            document.querySelectorAll('.voucher-item').forEach(item => {
                if (item.dataset.code === appliedCoupon.code) {
                    item.classList.add('active');
                    selectedVoucher = {
                        code: item.dataset.code,
                        name: item.dataset.name,
                        type: item.dataset.type,
                        value: item.dataset.value,
                        min: item.dataset.min,
                        max: item.dataset.max
                    };
                }
            });
        }
        
        document.getElementById('voucherModal').style.display = 'flex';
    }
    
    function closeVoucherModal() {
        document.getElementById('voucherModal').style.display = 'none';
    }
    
    function selectVoucher(element) {
        // Toggle active state
        document.querySelectorAll('.voucher-item').forEach(item => {
            item.classList.remove('active');
        });
        element.classList.add('active');
        
        selectedVoucher = {
            code: element.dataset.code,
            name: element.dataset.name,
            type: element.dataset.type,
            value: element.dataset.value,
            min: element.dataset.min,
            max: element.dataset.max
        };
    }
    
    function showMinimalInfo(minAmount) {
        Swal.fire({
            icon: 'info',
            title: 'Minimal Belanja',
            html: `Anda memerlukan minimal belanja <strong>Rp${formatNumber(minAmount)}</strong> untuk menggunakan voucher ini.<br><br>
                   Belanja Anda saat ini: <strong>Rp${formatNumber(subtotal)}</strong>`,
            confirmButtonText: 'OK'
        });
    }
    
    function applyVoucherCode() {
        const voucherCode = document.getElementById('voucherCode').value.trim();
        
        if (!voucherCode) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Masukkan kode voucher terlebih dahulu',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        applyVoucher(voucherCode);
    }
    
    function applyVoucher(code) {
        fetch('{{ route("checkout.apply.coupon") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                coupon_code: code,
                subtotal: subtotal
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                appliedCoupon = data.coupon;
                discount = data.coupon.discount;
                
                // Jika tipe ongkir, update shipping fee
                if (data.coupon.type === 'ongkir') {
                    shippingFee = Math.max(0, shippingFee - data.coupon.discount);
                }
                
                calculateTotals();
                closeVoucherModal();
                
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Voucher berhasil diterapkan!',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: data.message,
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Terjadi kesalahan saat menerapkan voucher',
                confirmButtonText: 'OK'
            });
        });
    }
    
    function applySelectedVoucher() {
        if (selectedVoucher) {
            // Check minimum purchase
            if (parseFloat(selectedVoucher.min) > subtotal) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Minimal Belanja',
                    html: `Voucher ini memerlukan minimal belanja <strong>Rp${formatNumber(selectedVoucher.min)}</strong><br><br>
                           Belanja Anda saat ini: <strong>Rp${formatNumber(subtotal)}</strong>`,
                    confirmButtonText: 'OK'
                });
                return;
            }
            
            // Apply the voucher from database
            applyVoucher(selectedVoucher.code);
        } else {
            // Coba apply dari input jika ada
            const voucherCode = document.getElementById('voucherCode').value.trim();
            if (voucherCode) {
                applyVoucherCode();
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Pilih voucher terlebih dahulu atau masukkan kode voucher',
                    confirmButtonText: 'OK'
                });
            }
        }
    }
    
    function removeVoucher() {
        fetch('{{ route("checkout.remove.coupon") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                appliedCoupon = null;
                selectedVoucher = null;
                discount = 0;
                
                // Reset shipping fee jika sebelumnya ada diskon ongkir
                if (selectedMethod === 'delivery') {
                    shippingFee = 10000;
                }
                
                calculateTotals();
                closeVoucherModal();
                
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Voucher berhasil dihapus',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Terjadi kesalahan saat menghapus voucher',
                confirmButtonText: 'OK'
            });
        });
    }
    
    // Fungsi untuk update tampilan voucher
    function updateVoucherDisplay() {
        const voucherDisplay = document.getElementById('voucherDisplay');
        if (appliedCoupon) {
            voucherDisplay.textContent = appliedCoupon.name + ' diterapkan';
            voucherDisplay.style.fontWeight = '600';
            voucherDisplay.style.color = 'var(--success)';
        } else {
            voucherDisplay.textContent = 'Pilih voucher atau masukkan kode promo';
            voucherDisplay.style.fontWeight = '';
            voucherDisplay.style.color = '';
        }
    }
    
    // Address modal functions
    function showAddressModal() {
        document.getElementById('addressModal').style.display = 'flex';
    }
    
    function closeAddressModal() {
        document.getElementById('addressModal').style.display = 'none';
    }
    
    function saveAddress() {
        const address = document.getElementById('addressInput').value.trim();
        const kecamatan = document.getElementById('kecamatanInput').value;
        const kota = document.getElementById('kotaInput').value;
        const kodePos = document.getElementById('kodePosInput').value.trim();
        const catatan = document.getElementById('catatanAlamatInput').value.trim();
        
        if (!address || !kecamatan || !kota) {
            Swal.fire({
                icon: 'warning',
                title: 'Data Tidak Lengkap',
                text: 'Harap isi semua field yang wajib diisi (alamat, kecamatan, kota)',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        // Save address via API
        fetch('{{ route("profile.update.address") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                alamat: address,
                kecamatan: kecamatan,
                kota: kota,
                kode_pos: kodePos,
                catatan_alamat: catatan
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update display
                const alamatLengkap = `${address}<br>${kecamatan}, ${kota}`;
                document.getElementById('addressDisplay').innerHTML = `
                    <strong>{{ auth()->user()->nama_lengkap ?? 'Pelanggan' }}</strong> | {{ auth()->user()->nomor_telepon ?? '' }}<br>
                    ${alamatLengkap}
                `;
                
                closeAddressModal();
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Alamat berhasil disimpan!',
                    timer: 2000,
                    showConfirmButton: false
                });
                
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: data.message,
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Terjadi kesalahan saat menyimpan alamat',
                confirmButtonText: 'OK'
            });
        });
    }
    
    // Payment modal functions
    function showPaymentModal(orderData) {
        document.getElementById('paymentModal').style.display = 'flex';
        
        // Set order data
        currentOrderNumber = orderData.order_number || 'DT-' + Date.now();
        document.getElementById('modalOrderNumber').textContent = currentOrderNumber;
        document.getElementById('modalTotalAmount').textContent = orderData.total_amount || document.getElementById('footerTotal').textContent;
        document.getElementById('modalPaymentMethod').textContent = getPaymentMethodName(selectedPayment);
        
        // Load payment content based on method
        loadPaymentContent();
        
        // Start timer
        startPaymentTimer();
    }
    
    function closePaymentModal() {
        if (paymentTimerInterval) {
            clearInterval(paymentTimerInterval);
            paymentTimerInterval = null;
        }
        document.getElementById('paymentModal').style.display = 'none';
    }
    
    function startPaymentTimer() {
        paymentTimerSeconds = 5400; // Reset to 1.5 jam
        updatePaymentTimerDisplay();
        
        if (paymentTimerInterval) {
            clearInterval(paymentTimerInterval);
        }
        
        paymentTimerInterval = setInterval(() => {
            paymentTimerSeconds--;
            updatePaymentTimerDisplay();
            
            if (paymentTimerSeconds <= 0) {
                clearInterval(paymentTimerInterval);
                Swal.fire({
                    icon: 'warning',
                    title: 'Waktu Habis',
                    text: 'Waktu pembayaran telah habis. Pesanan akan dibatalkan.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    closePaymentModal();
                    // Redirect to order page
                    window.location.href = '{{ route("pesanan") }}';
                });
            }
        }, 1000);
    }
    
    function updatePaymentTimerDisplay() {
        document.getElementById('paymentTimer').textContent = formatTime(paymentTimerSeconds);
        
        // Change color when less than 10 minutes
        if (paymentTimerSeconds < 600) {
            document.getElementById('paymentTimer').parentElement.style.background = 'linear-gradient(135deg, #ff0000, #ff5252)';
        }
    }
    
    function getPaymentMethodName(method) {
        const methods = {
            'cod': 'COD (Bayar di Tempat)',
            'bca': 'Transfer BCA',
            'mandiri': 'Transfer Mandiri',
            'ovo': 'OVO',
            'dana': 'DANA'
        };
        return methods[method] || method;
    }
    
    function loadPaymentContent() {
        const contentDiv = document.getElementById('paymentContent');
        const instructionsDiv = document.getElementById('paymentInstructions');
        
        switch(selectedPayment) {
            case 'cod':
                contentDiv.innerHTML = `
                    <div style="text-align: center; padding: 20px;">
                        <div style="width: 80px; height: 80px; background: var(--success); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                            <i class="fas fa-money-bill-wave" style="font-size: 36px; color: white;"></i>
                        </div>
                        <h3 style="color: var(--success); margin-bottom: 10px;">Bayar di Tempat</h3>
                        <p style="color: var(--gray-dark);">Anda akan membayar ketika pesanan sudah sampai/diambil</p>
                    </div>
                `;
                instructionsDiv.innerHTML = `
                    <li>Tunggu pesanan Anda diproses</li>
                    <li>Untuk delivery: Siapkan uang tunai saat kurir datang</li>
                    <li>Untuk pickup: Bayar di kasir saat mengambil pesanan</li>
                    <li>Pastikan nominal uang pas</li>
                `;
                break;
                
            case 'bca':
                contentDiv.innerHTML = `
                    <div class="bank-details">
                        <h4><i class="fas fa-university"></i> Transfer Bank BCA</h4>
                        <p><strong>No. Rekening:</strong> 1234 5678 9012</p>
                        <p><strong>Atas Nama:</strong> DIMSUM TIME INDONESIA</p>
                        <p><strong>Jumlah Transfer:</strong> ${document.getElementById('footerTotal').textContent}</p>
                        <p><strong>Kode Unik:</strong> 123</p>
                    </div>
                    <div class="instructions">
                        <h4><i class="fas fa-exclamation-triangle"></i> Penting!</h4>
                        <p style="font-size: 12px; color: var(--dark);">
                            Transfer persis sesuai nominal yang tertera. Jika berbeda, pembayaran tidak akan diproses secara otomatis.
                        </p>
                    </div>
                `;
                instructionsDiv.innerHTML = `
                    <li>Transfer ke rekening BCA di atas</li>
                    <li>Transfer tepat sesuai nominal total pembayaran</li>
                    <li>Simpan bukti transfer Anda</li>
                    <li>Klik "Saya Sudah Bayar" setelah transfer</li>
                    <li>Upload bukti transfer pada halaman berikutnya</li>
                `;
                break;
                
            case 'mandiri':
                contentDiv.innerHTML = `
                    <div class="bank-details">
                        <h4><i class="fas fa-university"></i> Transfer Bank Mandiri</h4>
                        <p><strong>No. Rekening:</strong> 0987 6543 2109</p>
                        <p><strong>Atas Nama:</strong> DIMSUM TIME INDONESIA</p>
                        <p><strong>Jumlah Transfer:</strong> ${document.getElementById('footerTotal').textContent}</p>
                        <p><strong>Kode Unik:</strong> 456</p>
                    </div>
                    <div class="instructions">
                        <h4><i class="fas fa-exclamation-triangle"></i> Penting!</h4>
                        <p style="font-size: 12px; color: var(--dark);">
                            Transfer persis sesuai nominal yang tertera. Jika berbeda, pembayaran tidak akan diproses secara otomatis.
                        </p>
                    </div>
                `;
                instructionsDiv.innerHTML = `
                    <li>Transfer ke rekening Mandiri di atas</li>
                    <li>Transfer tepat sesuai nominal total pembayaran</li>
                    <li>Simpan bukti transfer Anda</li>
                    <li>Klik "Saya Sudah Bayar" setelah transfer</li>
                    <li>Upload bukti transfer pada halaman berikutnya</li>
                `;
                break;
                
            case 'ovo':
                contentDiv.innerHTML = `
                    <div class="qrcode-container">
                        <h3><i class="fas fa-qrcode"></i> Scan QR Code OVO</h3>
                        <div class="qrcode-image">
                            <div style="width: 200px; height: 200px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; border: 2px dashed #ccc; margin: 0 auto;">
                                <i class="fas fa-qrcode" style="font-size: 80px; color: #999;"></i>
                            </div>
                        </div>
                        <p style="color: var(--gray-dark); margin-bottom: 10px;">Scan QR code di atas menggunakan aplikasi OVO</p>
                        <p><strong>Nomor OVO:</strong> 0812-3456-7890</p>
                        <p><strong>Atas Nama:</strong> DIMSUM TIME</p>
                    </div>
                `;
                instructionsDiv.innerHTML = `
                    <li>Buka aplikasi OVO di smartphone Anda</li>
                    <li>Pilih fitur "Scan QR Code"</li>
                    <li>Arahkan kamera ke QR code di atas</li>
                    <li>Konfirmasi pembayaran di aplikasi OVO</li>
                    <li>Klik "Saya Sudah Bayar" setelah berhasil</li>
                `;
                break;
                
            case 'dana':
                contentDiv.innerHTML = `
                    <div class="qrcode-container">
                        <h3><i class="fas fa-qrcode"></i> Scan QR Code DANA</h3>
                        <div class="qrcode-image">
                            <div style="width: 200px; height: 200px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; border: 2px dashed #ccc; margin: 0 auto;">
                                <i class="fas fa-qrcode" style="font-size: 80px; color: #999;"></i>
                            </div>
                        </div>
                        <p style="color: var(--gray-dark); margin-bottom: 10px;">Scan QR code di atas menggunakan aplikasi DANA</p>
                        <p><strong>Nomor DANA:</strong> 0812-3456-7890</p>
                        <p><strong>Atas Nama:</strong> DIMSUM TIME</p>
                    </div>
                `;
                instructionsDiv.innerHTML = `
                    <li>Buka aplikasi DANA di smartphone Anda</li>
                    <li>Pilih fitur "Scan QR Code" atau "Bayar"</li>
                    <li>Arahkan kamera ke QR code di atas</li>
                    <li>Konfirmasi pembayaran di aplikasi DANA</li>
                    <li>Klik "Saya Sudah Bayar" setelah berhasil</li>
                `;
                break;
                
            default:
                contentDiv.innerHTML = `<p>Metode pembayaran tidak dikenali</p>`;
                instructionsDiv.innerHTML = `<li>Hubungi customer service untuk bantuan</li>`;
        }
    }
    
    // Fungsi confirmPayment yang bisa diklik
    function confirmPayment() {
        const orderNumber = currentOrderNumber || document.getElementById('modalOrderNumber').textContent;
        const totalAmount = document.getElementById('footerTotal').textContent;
        
        if (selectedPayment === 'cod') {
            // For COD, redirect directly to order page
            Swal.fire({
                title: 'Pesanan Berhasil!',
                text: 'Pesanan Anda telah berhasil dibuat. Silakan tunggu konfirmasi dari kami.',
                icon: 'success',
                confirmButtonText: 'Lihat Pesanan'
            }).then(() => {
                window.location.href = '/pesanan';
            });
        } else {
            // For other payments, show upload proof page
            showUploadProofModal(orderNumber, totalAmount);
        }
        closePaymentModal();
    }
    
    // Fungsi untuk upload bukti pembayaran
    function showUploadProofModal(orderNumber, totalAmount) {
        // Create file input first
        const fileInput = document.createElement('input');
        fileInput.type = 'file';
        fileInput.id = 'paymentProofInput';
        fileInput.accept = 'image/*,.pdf,.jpg,.jpeg,.png';
        fileInput.style.display = 'none';
        document.body.appendChild(fileInput);
        
        // Trigger file input
        fileInput.click();
        
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                const file = this.files[0];
                
                // Check file size (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Terlalu Besar',
                        text: 'Ukuran file maksimal 5MB',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                
                // Show confirmation dialog
                Swal.fire({
                    title: 'Konfirmasi Upload',
                    html: `
                        <div style="text-align: left; margin-bottom: 15px;">
                            <p><strong>No. Pesanan:</strong> ${orderNumber}</p>
                            <p><strong>Total:</strong> ${totalAmount}</p>
                            <p><strong>Metode:</strong> ${getPaymentMethodName(selectedPayment)}</p>
                            <p><strong>File:</strong> ${file.name}</p>
                        </div>
                        <p>Apakah Anda yakin ingin mengupload file ini?</p>
                    `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Upload',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        savePaymentProof(orderNumber, file);
                    }
                });
            }
            
            // Remove file input
            document.body.removeChild(fileInput);
        });
    }
    
    // Fungsi untuk menyimpan bukti pembayaran
    function savePaymentProof(orderNumber, file) {
        const formData = new FormData();
        formData.append('payment_proof', file);
        formData.append('payment_method', selectedPayment);
        formData.append('order_number', orderNumber);
        
        // Tampilkan loading
        Swal.fire({
            title: 'Menyimpan bukti pembayaran...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Kirim ke endpoint
        fetch('/pesanan/simpan-bukti', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            Swal.close();
            
            if (data.success) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: data.message || 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.',
                    icon: 'success',
                    confirmButtonText: 'Lihat Pesanan'
                }).then(() => {
                    // Redirect ke halaman pesanan
                    window.location.href = '/pesanan';
                });
            } else {
                Swal.fire({
                    title: 'Gagal!',
                    text: data.message || 'Terjadi kesalahan saat mengupload bukti pembayaran',
                    icon: 'error',
                    confirmButtonText: 'Coba Lagi'
                }).then(() => {
                    // Tampilkan kembali modal upload
                    const totalAmount = document.getElementById('footerTotal').textContent;
                    showUploadProofModal(orderNumber, totalAmount);
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error',
                text: 'Terjadi kesalahan jaringan. Silakan coba lagi.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    }
    
    // Process checkout
    function processCheckout() {
        const checkoutBtn = document.getElementById('checkoutBtn');
        
        // Validate for delivery
        if (selectedMethod === 'delivery') {
            // Check if address is already filled
            const addressText = document.getElementById('addressDisplay').textContent;
            if (addressText.includes('Belum ada alamat')) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Alamat Tidak Lengkap',
                    text: 'Harap isi alamat terlebih dahulu untuk pengiriman',
                    confirmButtonText: 'Isi Alamat'
                }).then((result) => {
                    if (result.isConfirmed) {
                        showAddressModal();
                    }
                });
                return;
            }
        }
        
        // Show loading
        const originalText = checkoutBtn.innerHTML;
        checkoutBtn.innerHTML = '<div class="spinner"></div>';
        checkoutBtn.disabled = true;
        
        // Prepare form data
        const formData = new FormData();
        formData.append('metode_pengiriman', selectedMethod);
        formData.append('metode_pembayaran', selectedPayment);
        formData.append('shipping_fee', shippingFee);
        formData.append('agree_terms', '1');
        
        // Add voucher if any
        if (selectedVoucher) {
            formData.append('kode_promo', selectedVoucher.code);
        }
        
        // Add user information
        const user = @json(auth()->user());
        if (user) {
            formData.append('nama_penerima', user.nama_lengkap);
            formData.append('nomor_telepon', user.nomor_telepon);
            formData.append('email', user.email);
            
            if (selectedMethod === 'delivery') {
                formData.append('alamat_lengkap', user.alamat);
            } else {
                formData.append('alamat_lengkap', 'Ambil di toko - Dimsum Time Store');
            }
        }
        
        // Submit checkout
        fetch('{{ route("checkout.process") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            checkoutBtn.innerHTML = originalText;
            checkoutBtn.disabled = false;
            
            if (data.success) {
                // Generate order number if not provided
                const orderNumber = data.order_number || 'DT-' + Date.now() + '-' + Math.floor(Math.random() * 1000);
                
                // If COD, redirect directly
                if (selectedPayment === 'cod') {
                    Swal.fire({
                        title: 'Pesanan Berhasil!',
                        text: 'Pesanan Anda telah berhasil dibuat.',
                        icon: 'success',
                        confirmButtonText: 'Lihat Pesanan'
                    }).then(() => {
                        window.location.href = data.redirect_url || '{{ route("pesanan") }}';
                    });
                } else {
                    // For non-COD payments, show payment modal
                    showPaymentModal({
                        order_number: orderNumber,
                        total_amount: document.getElementById('footerTotal').textContent
                    });
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: data.message || 'Terjadi kesalahan saat membuat pesanan',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            checkoutBtn.innerHTML = originalText;
            checkoutBtn.disabled = false;
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Terjadi kesalahan saat membuat pesanan',
                confirmButtonText: 'OK'
            });
        });
    }
</script>
</body>
</html>