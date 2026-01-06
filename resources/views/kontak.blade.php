<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak - Dimsum Time</title>
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

        /* Contact Hero Section */
        .contact-hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                        url('{{ asset("images/189febcef92dbbbb1859d116eb999e4861f7f980.png") }}');
            background-size: cover;
            background-position: center;
            padding: 100px 0;
            text-align: center;
            color: white;
        }

        .contact-hero-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .hero-title {
            font-family: 'Baloo', cursive;
            font-size: 48px;
            margin-bottom: 20px;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.8s ease;
        }

        .hero-title.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .hero-subtitle {
            font-size: 18px;
            line-height: 1.6;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.8s ease 0.2s;
        }

        .hero-subtitle.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Contact Details Section */
        .contact-details-section {
            padding: 80px 0;
            background: white;
        }

        .contact-details-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr;
            gap: 40px;
            padding: 0 20px;
        }

        @media (min-width: 992px) {
            .contact-details-container {
                grid-template-columns: 1fr 1fr;
                gap: 60px;
            }
        }

        .contact-box {
            background: #f9f9f7;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.8s ease;
        }

        .contact-box.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .contact-box-title {
            font-family: 'Baloo', cursive;
            font-size: 32px;
            color: var(--text-dark);
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--primary-color);
        }

        .contact-list {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .contact-list-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .contact-list-icon {
            width: 24px;
            height: 24px;
            flex-shrink: 0;
        }

        .contact-list-text {
            font-size: 16px;
            line-height: 1.5;
            color: var(--text-dark);
        }

        /* Map Container */
        .map-container {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.8s ease 0.2s;
        }

        .map-container.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .map-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }

        .map-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.7);
            padding: 20px;
            text-align: center;
        }

        .map-button {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--primary-color);
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .map-button:hover {
            background: #c62828;
            transform: translateY(-2px);
        }

        /* Contact Form Section */
        .contact-form-section {
            padding: 80px 0;
            background: #f9f9f7;
        }

        .contact-form-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr;
            gap: 60px;
            padding: 0 20px;
        }

        @media (min-width: 992px) {
            .contact-form-container {
                grid-template-columns: 1fr 1fr;
            }
        }

        .form-info {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.8s ease;
        }

        .form-info.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .form-info h2 {
            font-family: 'Baloo', cursive;
            font-size: 36px;
            color: var(--text-dark);
            margin-bottom: 20px;
        }

        .form-info p {
            font-size: 16px;
            line-height: 1.6;
            color: var(--text-muted);
            margin-bottom: 40px;
        }

        .info-highlights {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .info-icon {
            width: 50px;
            height: 50px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            flex-shrink: 0;
        }

        .info-item h4 {
            font-size: 18px;
            color: var(--text-dark);
            margin-bottom: 5px;
        }

        .info-item p {
            font-size: 14px;
            color: var(--text-muted);
            margin: 0;
        }

        /* Contact Form */
        .contact-form {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.8s ease 0.2s;
        }

        .contact-form.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            color: var(--text-dark);
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            font-size: 16px;
            font-family: 'DM Sans', sans-serif;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background: white;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(229, 57, 53, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            background: #c62828;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(229, 57, 53, 0.3);
        }

        /* WhatsApp Floating Button */
        .dimsum-whatsapp-float {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: #25d366;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
            cursor: pointer;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .dimsum-whatsapp-float:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 16px rgba(37, 211, 102, 0.4);
        }

        /* Footer Styles */
        .dimsum-footer {
            background-color: var(--bg-dark);
            color: var(--text-footer);
            padding: 60px 0 30px;
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

        .dimsum-footer-logo-icon {
            height: 40px;
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

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 36px;
            }
            
            .hero-subtitle {
                font-size: 16px;
            }
            
            .contact-box-title {
                font-size: 28px;
            }
            
            .form-info h2 {
                font-size: 28px;
            }
            
            .contact-form {
                padding: 30px 20px;
            }
            
            .dimsum-whatsapp-float {
                width: 50px;
                height: 50px;
                font-size: 24px;
                bottom: 20px;
                right: 20px;
            }
        }

        /* Fade-in Animation */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>
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
                        <li><a href="{{ route('kontak') }}" class="active">Kontak</a></li>
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

    <!-- MAIN CONTENT -->
    <main>
        <section id="contact-hero" class="contact-hero-section">
            <div class="contact-hero-container">
                <h1 class="hero-title fade-in">Hubungi Kami</h1>
                <p class="hero-subtitle fade-in">Ingin pesan atau tanya-tanya seputar menu kami? Silakan hubungi kami melalui berbagai cara yang tersedia</p>
            </div>
        </section>
        
        <section id="contact-details" class="contact-details-section">
            <div class="contact-details-container">
                <div class="contact-box fade-in">
                    <h2 class="contact-box-title">Kunjungi Kami</h2>
                    <ul class="contact-list">
                        <li class="contact-list-item">
                            <img src="{{ asset('images/644_1196.svg') }}" alt="Whatsapp Icon" class="contact-list-icon" onerror="this.src='{{ asset('images/icon-whatsapp.png') }}'">
                            <span class="contact-list-text">08 - 888 - 999 (WhatsApp)</span>
                        </li>
                        <li class="contact-list-item">
                            <img src="{{ asset('images/644_1201.svg') }}" alt="Email Icon" class="contact-list-icon" onerror="this.src='{{ asset('images/icon-email.png') }}'">
                            <span class="contact-list-text">dimsumtime.id@gmail.com</span>
                        </li>
                        <li class="contact-list-item">
                            <img src="{{ asset('images/644_1205.svg') }}" alt="Location Icon" class="contact-list-icon" onerror="this.src='{{ asset('images/icon-location.png') }}'">
                            <span class="contact-list-text">Ruko Sakuram Point Blok B-12, Cikarang Selatan, Bekasi</span>
                        </li>
                        <li class="contact-list-item">
                            <img src="{{ asset('images/644_1209.svg') }}" alt="Time Icon" class="contact-list-icon" onerror="this.src='{{ asset('images/icon-time.png') }}'">
                            <span class="contact-list-text">Senin - Sabtu : 10.00 - 21.00</span>
                        </li>
                    </ul>
                </div>
                
                <div class="map-container fade-in">
                    <img src="{{ asset('images/43205ee862b180e3aeba34d591e287439e711624.png') }}" alt="Location Map" class="map-image" onerror="this.src='{{ asset('images/map-placeholder.jpg') }}'">
                    <div class="map-overlay">
                        <a href="https://maps.google.com/maps?q=Ruko+Sakuram+Point+Blok+B-12,+Cikarang+Selatan,+Bekasi" target="_blank" class="map-button">
                            <i class="fas fa-directions"></i> Dapatkan Petunjuk Arah
                        </a>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- New Contact Form Section -->
        <section class="contact-form-section">
            <div class="contact-form-container">
                <div class="form-info fade-in">
                    <h2>Ada Pertanyaan?</h2>
                    <p>Isi form di samping untuk menghubungi kami. Kami akan membalas pesan Anda dalam 24 jam.</p>
                    
                    <div class="info-highlights">
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <h4>Respon Cepat</h4>
                                <p>Biasanya membalas dalam 1-2 jam</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-headset"></i>
                            </div>
                            <div>
                                <h4>Support 24/7</h4>
                                <p>Customer service selalu siap membantu</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                            <div>
                                <h4>Free Delivery</h4>
                                <p>Gratis ongkir untuk order di atas Rp 100.000</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <form id="contactForm" class="contact-form fade-in">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" id="name" name="name" placeholder="Masukkan nama Anda" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="nama@email.com" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Nomor Telepon</label>
                        <input type="tel" id="phone" name="phone" placeholder="0812-3456-7890" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="subject">Subjek</label>
                        <select id="subject" name="subject" required>
                            <option value="">Pilih subjek</option>
                            <option value="order">Pemesanan</option>
                            <option value="complaint">Keluhan</option>
                            <option value="question">Pertanyaan</option>
                            <option value="catering">Catering & Event</option>
                            <option value="other">Lainnya</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Pesan</label>
                        <textarea id="message" name="message" rows="5" placeholder="Tulis pesan Anda di sini..." required></textarea>
                    </div>
                    
                    <button type="submit" class="submit-btn">
                        <i class="fas fa-paper-plane"></i> Kirim Pesan
                    </button>
                </form>
            </div>
        </section>
    </main>

    <!-- FOOTER SECTION -->
    <footer class="dimsum-footer">
        <div class="dimsum-footer-container">
            <div class="dimsum-footer-top">
                <!-- Column 1: Logo & Description -->
                <div class="dimsum-footer-column">
                    <a href="{{ route('home') }}" class="dimsum-footer-logo">
                        <img src="{{ asset('images/668_889.svg') }}" alt="Dimsum Time Icon" class="dimsum-footer-logo-icon" onerror="this.src='{{ asset('images/logo.png') }}'">
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

        <!-- WhatsApp Floating Button -->
        <div class="dimsum-whatsapp-float" id="whatsappFloat">
            <i class="fab fa-whatsapp"></i>
        </div>
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // WhatsApp Floating Button
        const whatsappFloat = document.getElementById('whatsappFloat');
        if (whatsappFloat) {
            whatsappFloat.addEventListener('click', function() {
                const phoneNumber = '628888999';
                const message = 'Halo Dimsum Time, saya ingin bertanya tentang menu Anda.';
                const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
                window.open(whatsappUrl, '_blank');
            });
        }

        // User Dropdown Close on Click Outside
        document.addEventListener('click', function(e) {
            const userProfile = document.querySelector('.dimsum-user-profile');
            const dropdownMenu = document.querySelector('.dimsum-dropdown-menu');
            
            if (userProfile && !userProfile.contains(e.target) && dropdownMenu) {
                dropdownMenu.style.opacity = '0';
                dropdownMenu.style.visibility = 'hidden';
                dropdownMenu.style.transform = 'translateY(-10px)';
            }
        });

        // Scroll animation for fade-in elements
        const fadeElements = document.querySelectorAll('.fade-in');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        
        fadeElements.forEach(element => {
            observer.observe(element);
        });
        
        // Form submission
        const contactForm = document.getElementById('contactForm');
        if (contactForm) {
            contactForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Show loading
                const submitBtn = contactForm.querySelector('.submit-btn');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
                submitBtn.disabled = true;
                
                // Simulate API call
                setTimeout(() => {
                    alert('Terima kasih! Pesan Anda telah dikirim. Kami akan membalas segera.');
                    contactForm.reset();
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 1500);
            });
        }

        // Update cart count on page load
        updateCartCountFromSession();
    });

    // Function to update cart count
    function updateCartCount(count) {
        const cartCountElement = document.querySelector('.dimsum-cart-count');
        if (cartCountElement) {
            cartCountElement.textContent = count;
        }
    }

    // Fetch cart count from session
    function updateCartCountFromSession() {
        fetch('/cart/count', {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.cart_count !== undefined) {
                updateCartCount(data.cart_count);
            }
        })
        .catch(error => {
            console.error('Error fetching cart count:', error);
        });
    }
    </script>
</body>
</html>