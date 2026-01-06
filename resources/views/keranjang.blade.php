<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Dimsum Time</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Baloo+2:wght@600&family=Baloo&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
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

        a {
            text-decoration: none;
            color: inherit;
        }

        ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header Styles */
        .dimsum-header {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .dimsum-top-bar {
            background: linear-gradient(135deg, var(--primary-color) 0%, #c62828 100%);
            color: white;
            padding: 8px 0;
        }

        .dimsum-top-bar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .dimsum-contact-info {
            display: flex;
            gap: 20px;
        }

        .dimsum-contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: white;
            font-size: 13px;
            transition: opacity 0.3s ease;
        }

        .dimsum-contact-item:hover {
            opacity: 0.8;
        }

        .dimsum-top-social-links {
            display: flex;
            gap: 8px;
        }

        .dimsum-top-social-icon {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: transform 0.3s ease;
        }

        .dimsum-top-social-icon:hover {
            transform: translateY(-2px);
        }

        .dimsum-main-nav-wrapper {
            background: white;
            border-bottom: 1px solid var(--border-color);
        }

        .dimsum-main-nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 15px 20px;
        }

        .dimsum-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 20px;
            color: var(--primary-color);
        }

        .dimsum-logo-img {
            height: 40px;
        }

        .dimsum-nav-menu {
            flex: 1;
            display: flex;
            justify-content: center;
        }

        .dimsum-nav-links {
            display: flex;
            gap: 30px;
        }

        .dimsum-nav-links a {
            font-weight: 500;
            padding: 8px 0;
            position: relative;
            transition: color 0.3s ease;
        }

        .dimsum-nav-links a:hover,
        .dimsum-nav-links a.active {
            color: var(--primary-color);
        }

        .dimsum-nav-links a.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--primary-color);
        }

        .dimsum-header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .dimsum-cart-icon {
            position: relative;
            font-size: 24px;
            color: var(--text-dark);
            transition: color 0.3s ease;
        }

        .dimsum-cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
        }

        .dimsum-user-profile {
            position: relative;
            cursor: pointer;
        }

        .dimsum-profile-trigger {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        .dimsum-profile-trigger:hover {
            background: rgba(0, 0, 0, 0.05);
        }

        .dimsum-profile-trigger i {
            font-size: 24px;
            color: var(--text-dark);
        }

        .dimsum-dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            min-width: 200px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
            margin-top: 5px;
        }

        .dimsum-user-profile:hover .dimsum-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dimsum-dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            transition: background-color 0.3s ease;
            color: var(--text-dark);
        }

        .dimsum-dropdown-item:hover {
            background: #f5f5f5;
        }

        .dimsum-dropdown-divider {
            height: 1px;
            background: var(--border-color);
            margin: 8px 0;
        }

        /* Cart Page Styles */
        .cart-section {
            padding: 40px 0 80px;
        }

        .cart-title {
            text-align: center;
            margin-bottom: 40px;
        }

        .cart-title h1 {
            font-family: 'Baloo', cursive;
            font-size: 48px;
            line-height: 1.2;
            color: var(--text-dark);
            margin: 0 0 10px 0;
        }

        .cart-title p {
            font-size: 18px;
            color: var(--text-muted);
            margin: 0;
        }

        .cart-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 40px;
        }

        @media (min-width: 992px) {
            .cart-container {
                grid-template-columns: 2fr 1fr;
            }
        }

        /* Cart Items */
        .cart-items {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .cart-items-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 20px;
            margin-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }

        .cart-items-header h2 {
            font-size: 24px;
            margin: 0;
        }

        .empty-cart {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-cart-icon {
            font-size: 60px;
            color: #ddd;
            margin-bottom: 20px;
        }

        .empty-cart h3 {
            font-size: 24px;
            color: var(--text-dark);
            margin-bottom: 10px;
        }

        .empty-cart p {
            color: var(--text-muted);
            margin-bottom: 30px;
        }

        .btn-primary {
            display: inline-block;
            background: var(--primary-color);
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #c62828;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(229, 57, 53, 0.3);
        }

        /* Cart Item */
        .cart-item {
            display: grid;
            grid-template-columns: auto 1fr auto;
            gap: 20px;
            padding: 20px 0;
            border-bottom: 1px solid #f0f0f0;
            align-items: center;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item-image {
            width: 100px;
            height: 100px;
            border-radius: 8px;
            overflow: hidden;
            background: #f5f5f5;
        }

        .cart-item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cart-item-details {
            flex: 1;
        }

        .cart-item-title {
            font-size: 18px;
            font-weight: 700;
            margin: 0 0 8px 0;
            color: var(--text-dark);
        }

        .cart-item-variant {
            font-size: 14px;
            color: var(--text-muted);
            margin: 0 0 5px 0;
        }

        .cart-item-catatan {
            font-size: 13px;
            color: #666;
            font-style: italic;
            margin: 5px 0;
        }

        .cart-item-actions {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-top: 10px;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f5f5f5;
            border-radius: 8px;
            padding: 5px 15px;
        }

        .quantity-btn {
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            color: var(--text-dark);
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            transition: background 0.3s ease;
        }

        .quantity-btn:hover {
            background: #e0e0e0;
        }

        .quantity-input {
            width: 40px;
            text-align: center;
            border: none;
            background: none;
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .remove-btn {
            background: none;
            border: none;
            color: #e53935;
            cursor: pointer;
            font-size: 14px;
            padding: 5px 10px;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .remove-btn:hover {
            background: rgba(229, 57, 53, 0.1);
        }

        .cart-item-price {
            text-align: right;
            min-width: 120px;
        }

        .item-price {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .item-subtotal {
            font-size: 14px;
            color: var(--text-muted);
        }

        /* Order Summary */
        .order-summary {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            height: fit-content;
        }

        .order-summary h2 {
            font-size: 24px;
            margin: 0 0 20px 0;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f0f0f0;
        }

        .summary-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .summary-label {
            font-size: 16px;
            color: var(--text-muted);
        }

        .summary-value {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .summary-total {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #f0f0f0;
        }

        .summary-total .summary-label {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .summary-total .summary-value {
            font-size: 24px;
            color: var(--primary-color);
        }

        .checkout-btn {
            width: 100%;
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 16px;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 20px;
            transition: all 0.3s ease;
        }

        .checkout-btn:hover {
            background: #c62828;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(229, 57, 53, 0.3);
        }

        .continue-shopping {
            display: inline-block;
            text-align: center;
            width: 100%;
            margin-top: 15px;
            color: var(--primary-color);
            font-weight: 600;
        }

        /* Footer Styles */
        .dimsum-footer {
            background-color: var(--bg-dark);
            color: var(--text-footer);
            padding: 60px 0 30px;
            margin-top: 40px;
        }

        .dimsum-footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .dimsum-footer-top {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 40px;
            margin-bottom: 40px;
        }

        @media (min-width: 768px) {
            .dimsum-footer-top {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 992px) {
            .dimsum-footer-top {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .dimsum-footer-column {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .dimsum-footer-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            font-weight: 700;
            font-size: 24px;
        }

        .dimsum-footer-description {
            color: var(--text-footer-muted);
            line-height: 1.6;
        }

        .dimsum-footer-heading {
            color: white;
            font-size: 18px;
            margin-bottom: 15px;
        }

        .dimsum-footer-links {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .dimsum-footer-links a {
            color: var(--text-footer);
            transition: color 0.3s ease;
        }

        .dimsum-footer-links a:hover {
            color: white;
        }

        .dimsum-instagram-gallery {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .dimsum-instagram-gallery img {
            width: 100%;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }

        .dimsum-footer-bottom {
            display: flex;
            flex-direction: column;
            gap: 20px;
            justify-content: space-between;
            align-items: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        @media (min-width: 768px) {
            .dimsum-footer-bottom {
                flex-direction: row;
                text-align: left;
            }
        }

        .dimsum-copyright {
            color: var(--text-footer-muted);
            font-size: 14px;
        }

        .dimsum-payment-methods {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: center;
        }

        @media (min-width: 768px) {
            .dimsum-payment-methods {
                justify-content: flex-end;
            }
        }

        .dimsum-payment-icon {
            background: white;
            color: var(--text-dark);
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }

        .dimsum-footer-socials {
            display: flex;
            gap: 10px;
        }

        .dimsum-footer-social-icon {
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.3s ease;
        }

        .dimsum-footer-social-icon:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
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

        /* Alert Messages */
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

        /* Responsive */
        @media (max-width: 768px) {
            .cart-item {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 15px;
            }
            
            .cart-item-image {
                margin: 0 auto;
            }
            
            .cart-item-price {
                text-align: center;
            }
            
            .cart-title h1 {
                font-size: 36px;
            }
        }
    </style>
</head>
<body>
    <!-- Loading Spinner -->
    <div class="loading-spinner" id="loadingSpinner">
        <div class="spinner"></div>
    </div>

    <!-- HEADER SECTION -->
    <header class="dimsum-header">
        <!-- Top Bar -->
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
                <!-- Logo di pojok kiri -->
                <a href="{{ route('home') }}" class="dimsum-logo">
                    <img src="{{ asset('images/21aa72030e155c4f9f34f27101287b6f2a7240e4.png') }}" alt="Dimsum Time Logo" class="dimsum-logo-img" onerror="this.src='{{ asset('images/logo-placeholder.png') }}'">
                    <span class="dimsum-logo-text">DIMSUM TIME</span>
                </a>

                <!-- Navigation Menu di tengah -->
                <div class="dimsum-nav-menu">
                    <ul class="dimsum-nav-links">
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('tentang') }}">Tentang</a></li>
                        <li><a href="{{ route('menu') }}">Menu</a></li>
                        <li><a href="{{ route('kontak') }}">Kontak</a></li>
                    </ul>
                </div>

                <!-- Header Actions di pojok kanan -->
                <div class="dimsum-header-actions">
                    <!-- Cart Icon -->
                    <a href="{{ route('keranjang') }}" class="dimsum-cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="dimsum-cart-count">{{ count(session('cart', [])) }}</span>
                    </a>

                    <!-- User Profile Dropdown -->
                    <div class="dimsum-user-profile">
                        <div class="dimsum-profile-trigger">
                            <i class="fas fa-user-circle"></i>
                            <span>{{ auth()->user()->nama_lengkap ?? 'Guest' }}</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>

                        <!-- Dropdown Menu -->
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
                            @else
                            <a href="{{ route('login') }}" class="dimsum-dropdown-item">
                                <i class="fas fa-sign-in-alt"></i>
                                <span>Login</span>
                            </a>
                            <a href="{{ route('register') }}" class="dimsum-dropdown-item">
                                <i class="fas fa-user-plus"></i>
                                <span>Register</span>
                            </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <!-- Cart Section -->
    <section class="cart-section">
        <div class="container">
            <div class="cart-title">
                <h1>Keranjang Belanja</h1>
                <p>Review pesanan Anda sebelum checkout</p>
            </div>

            <!-- Alert Messages -->
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

            <div class="cart-container">
                <!-- Cart Items -->
                <div class="cart-items">
                    <div class="cart-items-header">
                        <h2>Items dalam Keranjang ({{ count($cart) }})</h2>
                        @if(count($cart) > 0)
                            <form action="{{ route('cart.clear') }}" method="POST" id="clearCartForm">
                            @csrf
                            @method('POST')
                                <button type="button" onclick="clearCart()" class="remove-btn" style="font-size: 14px;">
                                    <i class="fas fa-trash"></i> Kosongkan Keranjang
                                </button>
                            </form>
                        @endif
                    </div>

                    @if(count($cart) == 0)
                        <div class="empty-cart">
                            <div class="empty-cart-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <h3>Keranjang Anda kosong</h3>
                            <p>Tambahkan beberapa dimsum lezat ke keranjang Anda!</p>
                            <a href="{{ route('menu') }}" class="btn-primary">
                                <i class="fas fa-utensils"></i> Lihat Menu
                            </a>
                        </div>
                    @else
                    <div class="cart-items-list">
                            @foreach($cart as $item)
                            @php
                                // Ambil data menu dari database berdasarkan id_menu di cart
                                $menuItem = \App\Models\Menu::find($item['id_menu']);
                                // Ambil gambar dari database atau gunakan fallback
                                $gambarMenu = $menuItem && $menuItem->gambar 
                                    ? asset('storage/' . $menuItem->gambar) 
                                    : asset('images/menu-placeholder.png');
                            @endphp
                            <div class="cart-item" data-id="{{ $item['id_varian'] }}">
                                <div class="cart-item-image">
                                    <img src="{{ $gambarMenu }}" alt="{{ $item['nama_menu'] }}" 
                                         onerror="this.src='{{ asset('images/menu-placeholder.png') }}'">
                                </div>
                                
                                <div class="cart-item-details">
                                    <h3 class="cart-item-title">{{ $item['nama_menu'] }}</h3>
                                    <p class="cart-item-variant">
                                        {{ $item['ukuran'] }} • {{ $item['jumlah_pcs'] }} pcs
                                    </p>
                                    @if($item['catatan'])
                                        <p class="cart-item-catatan">
                                            <i class="fas fa-sticky-note"></i> {{ $item['catatan'] }}
                                        </p>
                                    @endif
                                    
                                    <div class="cart-item-actions">
                                        <div class="quantity-control">
                                            <button class="quantity-btn minus" type="button" onclick="updateQuantity('{{ $item['id_varian'] }}', -1)">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="text" class="quantity-input" 
                                                   value="{{ $item['jumlah'] }}" 
                                                   readonly
                                                   id="quantity-{{ $item['id_varian'] }}">
                                            <button class="quantity-btn plus" type="button" onclick="updateQuantity('{{ $item['id_varian'] }}', 1)">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        
                                        <form action="{{ route('cart.remove', $item['id_varian']) }}" method="POST" class="remove-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="removeItem('{{ $item['id_varian'] }}')" class="remove-btn">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                
                                <div class="cart-item-price">
                                    <div class="item-price">Rp{{ number_format($item['harga'], 0, ',', '.') }}</div>
                                    <div class="item-subtotal">
                                        {{ $item['jumlah'] }} × Rp{{ number_format($item['harga'], 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Order Summary -->
                @if(count($cart) > 0)
                <div class="order-summary">
                    <h2>Ringkasan Pesanan</h2>
                    
                    <div class="summary-item">
                        <span class="summary-label">Subtotal</span>
                        <span class="summary-value">Rp{{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="summary-item">
                        <span class="summary-label">Biaya Pengiriman</span>
                        <!-- TAMPILKAN ONGKIR Rp10.000 BUKAN GRATIS -->
                        <span class="summary-value">Rp5.000</span>
                    </div>
                    
                    <div class="summary-total">
                        <span class="summary-label">Total</span>
                        <!-- TOTAL TANPA PAJAK: subtotal + ongkir 10.000 -->
                        <span class="summary-value">Rp{{ number_format($total + 5000, 0, ',', '.') }}</span>
                    </div>
                    
                    <!-- Perbaiki di keranjang.blade.php -->
                    <form action="{{ route('checkout') }}" method="GET">
                        <button type="submit" class="checkout-btn">
                            <i class="fas fa-shopping-cart"></i> Check out
                        </button>
                    </form>
                    
                    <a href="{{ route('menu') }}" class="continue-shopping">
                        <i class="fas fa-arrow-left"></i> Lanjut Belanja
                    </a>
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="dimsum-footer">
        <div class="dimsum-footer-container">
            <div class="dimsum-footer-top">
                <!-- Column 1: Logo & Description -->
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

                <!-- Column 2: Pages -->
                <div class="dimsum-footer-column">
                    <h3 class="dimsum-footer-heading">Halaman</h3>
                    <div class="dimsum-footer-links">
                        <a href="{{ route('home') }}">Beranda</a>
                        <a href="{{ route('tentang') }}">Tentang Kami</a>
                        <a href="{{ route('menu') }}">Menu</a>
                        <a href="{{ route('kontak') }}">Kontak</a>
                        <a href="#">Lokasi & Jam</a>
                    </div>
                </div>

                <!-- Column 3: Information -->
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

                <!-- Column 4: Instagram -->
                <div class="dimsum-footer-column">
                    <h3 class="dimsum-footer-heading">Instagram</h3>
                    <div class="dimsum-instagram-gallery">
                        @php
                            $instagramPosts = [
                                asset('images/fb05b4fb74e829d3f6d99dffe090e08af8bcfb9f.png'),
                                asset('images/121c2dcceec8aa39a8b0c3768cde9c78f03c3ba6.png'),
                                asset('images/5078258e7740f3b78ef25ac57cef10d1e8426663.png'),
                                asset('images/372cef40f35f774bd9ba4110538c35c370a5762f.png')
                            ];
                        @endphp
                        @foreach($instagramPosts as $post)
                        <img src="{{ $post }}" alt="Instagram post {{ $loop->iteration }}"
                             onerror="this.src='https://images.unsplash.com/photo-1563245372-f21724e3856d?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80'">
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
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
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loadingSpinner = document.getElementById('loadingSpinner');
            
            // Fungsi untuk menampilkan loading
            function showLoading() {
                if (loadingSpinner) loadingSpinner.style.display = 'flex';
            }
            
            // Fungsi untuk menyembunyikan loading
            function hideLoading() {
                if (loadingSpinner) loadingSpinner.style.display = 'none';
            }
            
            // Update cart count in header
            function updateCartCount(count) {
                const cartCountElement = document.querySelector('.dimsum-cart-count');
                if (cartCountElement) {
                    cartCountElement.textContent = count;
                }
            }
        });
        
        // Update quantity function
        function updateQuantity(itemId, change) {
            const quantityInput = document.getElementById('quantity-' + itemId);
            let currentQuantity = parseInt(quantityInput.value);
            let newQuantity = currentQuantity + change;
            
            if (newQuantity < 1) {
                removeItem(itemId);
                return;
            }
            
            showLoading();
            
            // Send AJAX request to update quantity
            fetch('/cart/update/' + itemId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    jumlah: newQuantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update quantity display
                    quantityInput.value = newQuantity;
                    
                    // Update cart count
                    updateCartCount(data.cart_count);
                    
                    // Reload page to update totals
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                } else {
                    alert(data.message || 'Gagal mengupdate jumlah');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengupdate jumlah');
            })
            .finally(() => {
                hideLoading();
            });
        }
        
        // Remove item function
        function removeItem(itemId) {
            if (!confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')) {
                return;
            }
            
            showLoading();
            
            fetch('/cart/remove/' + itemId, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove item from DOM
                    const itemElement = document.querySelector('.cart-item[data-id="' + itemId + '"]');
                    if (itemElement) {
                        itemElement.remove();
                    }
                    
                    // Update cart count
                    updateCartCount(data.cart_count);
                    
                    // Reload if cart is empty
                    if (data.cart_count === 0) {
                        setTimeout(() => {
                            location.reload();
                        }, 500);
                    } else {
                        // Reload to update totals
                        setTimeout(() => {
                            location.reload();
                        }, 500);
                    }
                } else {
                    alert(data.message || 'Gagal menghapus item');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus item');
            })
            .finally(() => {
                hideLoading();
            });
        }
        
        // Clear cart function
        function clearCart() {
            if (!confirm('Apakah Anda yakin ingin mengosongkan seluruh keranjang?')) {
                return;
            }
            
            showLoading();
            
            document.getElementById('clearCartForm').submit();
        }
        
        // Simple loading functions
        function showLoading() {
            const spinner = document.getElementById('loadingSpinner');
            if (spinner) spinner.style.display = 'flex';
        }
        
        function hideLoading() {
            const spinner = document.getElementById('loadingSpinner');
            if (spinner) spinner.style.display = 'none';
        }
        
        // Update cart count in header
        function updateCartCount(count) {
            const cartCountElement = document.querySelector('.dimsum-cart-count');
            if (cartCountElement) {
                cartCountElement.textContent = count;
            }
        }
    </script>
</body>
</html>