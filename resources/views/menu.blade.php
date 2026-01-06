<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dimsum Time - Menu</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Baloo+2:wght@600&family=Baloo&family=Inter:wght@400;500&display=swap"
    rel="stylesheet">
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

    .page-wrapper {
      max-width: 1440px;
      margin: 0 auto;
    }

    .container {
      padding-left: 24px;
      padding-right: 24px;
      max-width: 1200px;
      margin: 0 auto;
    }

    @media (max-width: 768px) {
      .container {
        padding-left: 16px;
        padding-right: 16px;
      }
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

    /* CSS for section section:Menu */
    .menu-section {
      padding-top: 40px;
      padding-bottom: 80px;
    }

    .menu-section__title {
      text-align: center;
      margin-bottom: 40px;
    }

    .menu-section__title h1 {
      font-family: 'Baloo', cursive;
      font-size: 72px;
      line-height: 1;
      color: var(--text-dark);
      margin: 0 0 20px 0;
    }

    @media (min-width: 992px) {
      .menu-section__title h1 {
        font-size: 100px;
      }
    }

    .menu-section__title p {
      font-size: 18px;
      line-height: 28px;
      color: var(--text-muted);
      max-width: 560px;
      margin: 0 auto;
    }

    /* Kategori Tabs */
    .kategori-tabs {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-bottom: 40px;
      flex-wrap: wrap;
    }

    .kategori-tab {
      padding: 10px 24px;
      background: white;
      border: 2px solid var(--border-color);
      border-radius: 50px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .kategori-tab:hover {
      border-color: var(--primary-color);
      color: var(--primary-color);
    }

    .kategori-tab.active {
      background: var(--primary-color);
      border-color: var(--primary-color);
      color: white;
    }

    /* Product Grid */
    .product-grid {
      display: grid;
      grid-template-columns: repeat(1, 1fr);
      gap: 24px;
    }

    @media (min-width: 576px) {
      .product-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (min-width: 992px) {
      .product-grid {
        grid-template-columns: repeat(3, 1fr);
      }
    }

    @media (min-width: 1200px) {
      .product-grid {
        grid-template-columns: repeat(4, 1fr);
      }
    }

    /* Product Card Styling */
    .product-card {
      background: white;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      padding: 16px;
      display: flex;
      flex-direction: column;
      height: 100%;
    }

    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .product-card__image-wrapper {
      width: 100%;
      height: 200px;
      overflow: hidden;
      border-radius: 8px;
      position: relative;
      flex-shrink: 0;
      background: #f5f5f5;
    }

    .product-card__image {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.3s ease;
    }

    .product-card:hover .product-card__image {
      transform: scale(1.05);
    }

    .product-card__content {
      padding: 12px 0;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
    }

    .product-card__title {
      font-size: 20px;
      font-weight: 700;
      margin: 0 0 8px 0;
      color: var(--text-dark);
    }

    .product-card__description {
      font-size: 14px;
      line-height: 1.5;
      color: var(--text-muted);
      margin: 0 0 12px 0;
      flex-grow: 1;
    }

    /* Varian Menu */
    .varian-list {
      margin-bottom: 15px;
    }

    .varian-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 8px 0;
      border-bottom: 1px solid #f0f0f0;
    }

    .varian-item:last-child {
      border-bottom: none;
    }

    .varian-info {
      display: flex;
      flex-direction: column;
      gap: 2px;
    }

    .varian-ukuran {
      font-weight: 600;
      font-size: 14px;
    }

    .varian-detail {
      font-size: 12px;
      color: var(--text-muted);
    }

    .varian-price {
      font-size: 16px;
      font-weight: 700;
      color: var(--primary-color);
    }

    .product-card__footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: auto;
      padding-top: 15px;
      border-top: 1px solid #f0f0f0;
    }

    .product-card__price {
      font-size: 18px;
      font-weight: 700;
      color: var(--primary-color);
    }

    /* Stok Info */
    .stok-info {
      font-size: 12px;
      color: var(--text-muted);
      margin-bottom: 5px;
    }

    .stok-habis {
      color: #e53935;
      font-weight: 600;
    }

    .stok-tersedia {
      color: #4caf50;
      font-weight: 600;
    }

    /* Perbaikan tombol + */
    .product-card__add-btn {
      background: var(--primary-color);
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.2s ease;
      border: none;
      padding: 0;
      flex-shrink: 0;
      font-size: 24px;
      color: white;
      font-weight: bold;
      position: relative;
    }

    .product-card__add-btn:hover:not(:disabled) {
      background: #c62828;
      transform: scale(1.1);
    }

    .product-card__add-btn:disabled {
      background: #cccccc;
      cursor: not-allowed;
    }

    /* Tambahkan tanda + menggunakan CSS */
    .product-card__add-btn::after {
      content: '+';
      font-size: 24px;
      font-weight: bold;
      line-height: 1;
    }

    /* Background gelap */
    .popup-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.6);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }

    /* Box popup yang diperbaiki */
    .popup-box {
      width: 350px;
      background: #fff;
      padding: 30px;
      border-radius: 15px;
      text-align: center;
      animation: popupScale 0.2s ease;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
      max-width: 90%;
    }

    .popup-box h3 {
      margin: 0 0 20px 0;
      color: var(--text-dark);
      font-size: 22px;
    }

    .popup-box label {
      display: block;
      text-align: left;
      margin: 15px 0 5px 0;
      font-weight: 500;
      color: var(--text-dark);
    }

    /* Input di dalam popup */
    .popup-box select,
    .popup-box input {
      width: 100%;
      padding: 12px;
      margin: 0 0 15px 0;
      border: 1px solid var(--border-color);
      border-radius: 8px;
      font-family: 'DM Sans', sans-serif;
      font-size: 16px;
    }

    .popup-box select:focus,
    .popup-box input:focus {
      outline: none;
      border-color: var(--primary-color);
      box-shadow: 0 0 0 2px rgba(229, 57, 53, 0.2);
    }

    /* Tombol */
    #addToCart {
      width: 100%;
      padding: 14px;
      background: var(--primary-color);
      border: none;
      color: white;
      border-radius: 8px;
      margin-top: 10px;
      cursor: pointer;
      font-weight: 600;
      font-size: 16px;
      transition: background-color 0.3s ease;
    }

    #addToCart:hover {
      background: #c62828;
    }

    #addToCart:disabled {
      background: #cccccc;
      cursor: not-allowed;
    }

    .close-popup {
      width: 100%;
      padding: 12px;
      background: #f0f0f0;
      border: none;
      color: var(--text-dark);
      border-radius: 8px;
      margin-top: 10px;
      cursor: pointer;
      font-weight: 500;
      font-size: 16px;
      transition: background-color 0.3s ease;
    }

    .close-popup:hover {
      background: #e0e0e0;
    }

    /* Animasi */
    @keyframes popupScale {
      from {
        transform: scale(0.8);
        opacity: 0;
      }
      to {
        transform: scale(1);
        opacity: 1;
      }
    }

    /* WhatsApp Floating Button */
    .whatsapp-float {
      position: fixed;
      bottom: 30px;
      right: 30px;
      width: 60px;
      height: 60px;
      border-radius: 50%;
      background: #25D366;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
      z-index: 9998;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: pointer;
    }

    .whatsapp-float:hover {
      transform: scale(1.1);
      box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4);
    }

    .whatsapp-float i {
      color: white;
      font-size: 30px;
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
            <li><a href="{{ route('menu') }}" class="active">Menu</a></li>
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

  <main id="menu" class="menu-section container">
    <div class="menu-section__title">
      <h1>Menu Kami</h1>
      <p>Nikmati dimsum fresh dengan rasa gurih dan lembut yang selalu bikin nagih. Disajikan hangat untuk nemenin momen
        santai kamu.</p>
    </div>

    <!-- Kategori Tabs -->
    <div class="kategori-tabs">
      <button class="kategori-tab active" data-kategori="all">Semua</button>
      @foreach($kategori as $kat)
      <button class="kategori-tab" data-kategori="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</button>
      @endforeach
    </div>

    <!-- Product Grid -->
    <div class="product-grid">
      @foreach($kategori as $kat)
        @foreach($kat->menu as $menu)
          @if($menu->variants->count() > 0)
          <article class="product-card" data-kategori="{{ $kat->id_kategori }}">
          <div class="product-card__image-wrapper">
  @php
    // Cek apakah ada gambar di database
    if (!empty($menu->gambar)) {
        // Jika gambar ada di database, tampilkan
        $gambarPath = asset('storage/' . $menu->gambar);
    } else {
        // Jika tidak ada gambar di database, gunakan gambar default
        $gambarList = [
          asset('images/6e99faa7d46f4b6778d3a2222a5f67c12bedf618.png'),
          asset('images/e2e3f05338db82569157db39e4d022414a838793.png'),
          asset('images/6c2d753ec53fffbb5ae6f666e771c0e3491ac7e9.png'),
          asset('images/ec9089681541bba792e4b2d2c5d273ddd20466fe.png'),
          asset('images/372cef40f35f774bd9ba4110538c35c370a5762f.png'),
          asset('images/121c2dcceec8aa39a8b0c3768cde9c78f03c3ba6.png'),
          asset('images/14ea8733748fe09895bbdddfc64bb97f80bd704b.png'),
          asset('images/fb05b4fb74e829d3f6d99dffe090e08af8bcfb9f.png'),
          asset('images/5078258e7740f3b78ef25ac57cef10d1e8426663.png'),
          asset('images/54685455f2f7a13cf4fb179741fbdd76f9ec21a9.png'),
          asset('images/2318f39ec28aa7147d031b5a1927890f455a6ec3.png'),
          asset('images/61a5da51a0db9a9109f2ebbbc626c3f7a128831d.png')
        ];
        $gambarIndex = $loop->index % count($gambarList);
        $gambarPath = $gambarList[$gambarIndex];
    }
  @endphp
  <img src="{{ $gambarPath }}" alt="{{ $menu->nama_menu }}" class="product-card__image" 
       onerror="this.src='{{ asset('images/menu-placeholder.png') }}'">
</div>
            <div class="product-card__content">
              <h3 class="product-card__title">{{ $menu->nama_menu }}</h3>
              <p class="product-card__description">{{ $menu->deskripsi }}</p>
              
              <!-- Daftar Varian -->
              <div class="varian-list">
                @foreach($menu->variants->take(3) as $varian)
                <div class="varian-item" 
                     data-id="{{ $varian->id_varian }}"
                     data-ukuran="{{ $varian->ukuran }}"
                     data-jumlah-pcs="{{ $varian->jumlah_pcs }}"
                     data-harga="{{ $varian->harga }}"
                     data-stok="{{ $varian->stok }}">
                  <div class="varian-info">
                    <span class="varian-ukuran">{{ $varian->ukuran }}</span>
                    <span class="varian-detail">{{ $varian->jumlah_pcs }} pcs</span>
                  </div>
                  <span class="varian-price">Rp{{ number_format($varian->harga, 0, ',', '.') }}</span>
                </div>
                @endforeach
                
                @if($menu->variants->count() > 3)
                <div class="varian-item">
                  <div class="varian-info">
                    <span class="varian-ukuran" style="color: var(--primary-color); font-size: 12px;">
                      +{{ $menu->variants->count() - 3 }} varian lainnya
                    </span>
                  </div>
                </div>
                @endif
              </div>
              
              <!-- Stok Info -->
              @php
                $totalStok = $menu->variants->sum('stok');
                $hargaTerendah = $menu->variants->min('harga');
                $hargaTertinggi = $menu->variants->max('harga');
              @endphp
              <div class="stok-info">
                @if($totalStok > 0)
                  <span class="stok-tersedia">Stok tersedia</span>
                @else
                  <span class="stok-habis">Stok habis</span>
                @endif
              </div>
            </div>
            
            <div class="product-card__footer">
    <span class="product-card__price">
        @if($hargaTerendah == $hargaTertinggi)
            Rp{{ number_format($hargaTerendah, 0, ',', '.') }}
        @else
            Rp{{ number_format($hargaTerendah, 0, ',', '.') }} - Rp{{ number_format($hargaTertinggi, 0, ',', '.') }}
        @endif
    </span>
    
    @auth
        <!-- Tombol + hanya muncul jika sudah login -->
        <button class="product-card__add-btn" 
                data-menu-id="{{ $menu->id_menu }}"
                data-menu-name="{{ $menu->nama_menu }}"
                @if($totalStok == 0) disabled @endif>
        </button>
    @else
        <!-- Jika belum login, tombol + mengarah ke login -->
        <button class="product-card__add-btn" 
                onclick="window.location.href='{{ route('login') }}'"
                title="Login untuk menambahkan ke keranjang"
                style="cursor: pointer;">
        </button>
    @endauth
</div>
          </article>
          @endif
        @endforeach
      @endforeach
    </div>
  </main>

  <!-- FOOTER SECTION -->
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
            Dimsum berkualitas dengan cita rasa autentik. Kami berkomitmen memberikan pengalaman kuliner terbaik untuk
            setiap pelanggan.
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

  <!-- POPUP -->
  <div id="popup" class="popup-overlay">
    <div class="popup-box">
      <h3 id="popup-title">Pilih Varian</h3>
      
      <label>Varian:</label>
      <select id="popup-varian">
        <option value="">Pilih varian</option>
        <!-- Options akan diisi oleh JavaScript -->
      </select>
      
      <label>Jumlah:</label>
      <input type="number" id="popup-qty" min="1" value="1">
      
      <label>Catatan (opsional):</label>
      <input type="text" id="popup-catatan" placeholder="Contoh: Tanpa pedas">
      
      <div id="popup-info" style="text-align: left; margin: 10px 0; font-size: 14px; color: var(--text-muted);">
        <!-- Info varian akan diisi di sini -->
      </div>
      
      <!-- tombol -->
      <button id="addToCart">Masukkan Keranjang</button>
      <button class="close-popup">Tutup</button>
    </div>
  </div>

  <!-- WhatsApp Floating Button -->
  <div class="whatsapp-float" id="whatsappFloat">
    <i class="fab fa-whatsapp"></i>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const popup = document.getElementById("popup");
      const popupTitle = document.getElementById("popup-title");
      const popupVarian = document.getElementById("popup-varian");
      const popupQty = document.getElementById("popup-qty");
      const popupCatatan = document.getElementById("popup-catatan");
      const popupInfo = document.getElementById("popup-info");
      const addToCartBtn = document.getElementById("addToCart");
      const closePopupBtn = document.querySelector(".close-popup");
      const loadingSpinner = document.getElementById("loadingSpinner");

      // Fungsi untuk menampilkan loading
      function showLoading() {
        if (loadingSpinner) loadingSpinner.style.display = 'flex';
      }

      // Fungsi untuk menyembunyikan loading
      function hideLoading() {
        if (loadingSpinner) loadingSpinner.style.display = 'none';
      }

     // Event listener untuk tombol + - FIXED
document.addEventListener('click', function(e) {
    // Cek jika yang diklik adalah tombol + yang tidak disabled
    if (e.target.classList.contains('product-card__add-btn') && !e.target.disabled) {
        e.preventDefault();
        e.stopPropagation();
        
        // Cek apakah user sudah login
        const isLoggedIn = @json(auth()->check());
        
        if (!isLoggedIn) {
            // Jika belum login, arahkan ke halaman login
            window.location.href = '{{ route('login') }}';
            return;
        }
        
          console.log('Tombol + diklik!');
          
          const button = e.target;
          const card = button.closest('.product-card');
          const varianItems = card.querySelectorAll('.varian-item');
          const menuName = button.dataset.menuName;
          
          // Clear previous options
          popupVarian.innerHTML = '<option value="">Pilih varian</option>';
          
          // Add options for each variant
          let hasAvailableVarian = false;
          
          varianItems.forEach(item => {
            const stok = parseInt(item.dataset.stok);
            const harga = parseFloat(item.dataset.harga);
            const ukuran = item.dataset.ukuran;
            const jumlahPcs = item.dataset.jumlahPcs;
            const idVarian = item.dataset.id;
            
            // Hanya tampilkan varian yang ada stok
            if (stok > 0) {
              const option = document.createElement('option');
              option.value = idVarian;
              option.textContent = `${ukuran} (${jumlahPcs} pcs) - Rp${harga.toLocaleString('id-ID')}`;
              option.dataset.stok = stok;
              option.dataset.harga = harga;
              option.dataset.ukuran = ukuran;
              option.dataset.jumlahpcs = jumlahPcs;
              popupVarian.appendChild(option);
              hasAvailableVarian = true;
            }
          });
          
          // Cek jika tidak ada varian yang tersedia
          if (!hasAvailableVarian) {
            alert('Maaf, semua varian untuk menu ini sedang habis stok.');
            return;
          }
          
          // Reset form
          popupTitle.textContent = menuName;
          popupQty.value = 1;
          popupCatatan.value = '';
          popupInfo.innerHTML = '';
          
          // Reset select state
          popupVarian.selectedIndex = 0;
          addToCartBtn.disabled = true;
          
          // Show popup
          popup.style.display = 'flex';
          document.body.style.overflow = 'hidden';
        }
      });

      // Update info ketika varian dipilih
      popupVarian.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
          const stok = parseInt(selectedOption.dataset.stok);
          const harga = parseFloat(selectedOption.dataset.harga);
          const ukuran = selectedOption.dataset.ukuran;
          const jumlahPcs = selectedOption.dataset.jumlahpcs;
          
          popupInfo.innerHTML = `
            <div><strong>Ukuran:</strong> ${ukuran}</div>
            <div><strong>Isi:</strong> ${jumlahPcs} pcs</div>
            <div><strong>Stok Tersedia:</strong> ${stok} pcs</div>
            <div><strong>Harga:</strong> Rp${harga.toLocaleString('id-ID')}</div>
          `;
          
          // Enable/disable add to cart button based on stock
          addToCartBtn.disabled = stok <= 0;
        } else {
          popupInfo.innerHTML = '';
          addToCartBtn.disabled = true;
        }
      });

      // Tutup popup
      closePopupBtn.addEventListener('click', () => {
        popup.style.display = 'none';
        document.body.style.overflow = 'auto';
      });

      // Tutup popup kalau klik di luar area popup
      popup.addEventListener('click', (e) => {
        if (e.target === popup) {
          popup.style.display = 'none';
          document.body.style.overflow = 'auto';
        }
      });

      // Tambah ke keranjang
      addToCartBtn.addEventListener('click', async () => {
        const varianId = popupVarian.value;
        const jumlah = parseInt(popupQty.value);
        const catatan = popupCatatan.value;
        
        if (!varianId) {
          alert('Silakan pilih varian terlebih dahulu!');
          return;
        }
        
        if (jumlah < 1) {
          alert('Jumlah minimal 1');
          return;
        }
        
        const selectedOption = popupVarian.options[popupVarian.selectedIndex];
        const stok = parseInt(selectedOption.dataset.stok);
        
        if (jumlah > stok) {
          alert(`Stok hanya tersedia ${stok} pcs`);
          return;
        }
        
        // Tampilkan loading
        showLoading();
        
        try {
          // Buat form untuk submit
          const form = document.createElement('form');
          form.method = 'POST';
          form.action = '/cart/add';
          form.style.display = 'none';
          
          // Tambahkan CSRF token
          const csrfInput = document.createElement('input');
          csrfInput.type = 'hidden';
          csrfInput.name = '_token';
          csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;
          form.appendChild(csrfInput);
          
          // Tambahkan data varian
          const varianInput = document.createElement('input');
          varianInput.type = 'hidden';
          varianInput.name = 'id_varian';
          varianInput.value = varianId;
          form.appendChild(varianInput);
          
          // Tambahkan jumlah
          const jumlahInput = document.createElement('input');
          jumlahInput.type = 'hidden';
          jumlahInput.name = 'jumlah';
          jumlahInput.value = jumlah;
          form.appendChild(jumlahInput);
          
          // Tambahkan catatan jika ada
          if (catatan) {
            const catatanInput = document.createElement('input');
            catatanInput.type = 'hidden';
            catatanInput.name = 'catatan';
            catatanInput.value = catatan;
            form.appendChild(catatanInput);
          }
          
          // Tambahkan form ke body dan submit
          document.body.appendChild(form);
          form.submit();
          
        } catch (error) {
          console.error('Error:', error);
          alert('Terjadi kesalahan saat menambahkan ke keranjang');
        } finally {
          hideLoading();
        }
      });

      // Kategori Tabs Filter
      const kategoriTabs = document.querySelectorAll('.kategori-tab');
      const productCards = document.querySelectorAll('.product-card');

      kategoriTabs.forEach(tab => {
        tab.addEventListener('click', function() {
          // Update active tab
          kategoriTabs.forEach(t => t.classList.remove('active'));
          this.classList.add('active');
          
          const selectedKategori = this.dataset.kategori;
          
          // Filter product cards
          productCards.forEach(card => {
            if (selectedKategori === 'all' || card.dataset.kategori === selectedKategori) {
              card.style.display = 'block';
            } else {
              card.style.display = 'none';
            }
          });
        });
      });

      // WhatsApp Floating Button
      const whatsappFloat = document.getElementById('whatsappFloat');
      if (whatsappFloat) {
        whatsappFloat.addEventListener('click', function() {
          window.open('https://wa.me/6283806340992', '_blank');
        });
      }

      // User Dropdown Toggle
      const userProfile = document.querySelector(".dimsum-user-profile");
      const dropdownMenu = document.querySelector(".dimsum-dropdown-menu");

      if (userProfile && dropdownMenu) {
        userProfile.addEventListener("mouseenter", function () {
          dropdownMenu.style.opacity = "1";
          dropdownMenu.style.visibility = "visible";
          dropdownMenu.style.transform = "translateY(0)";
        });

        userProfile.addEventListener("mouseleave", function () {
          dropdownMenu.style.opacity = "0";
          dropdownMenu.style.visibility = "hidden";
          dropdownMenu.style.transform = "translateY(-10px)";
        });

        // Close dropdown when clicking outside
        document.addEventListener("click", function (e) {
          if (!userProfile.contains(e.target) && dropdownMenu) {
            dropdownMenu.style.opacity = "0";
            dropdownMenu.style.visibility = "hidden";
            dropdownMenu.style.transform = "translateY(-10px)";
          }
        });
      }

      // Logout confirmation
      const logoutForm = document.querySelector('form[action*="logout"]');
      if (logoutForm) {
        logoutForm.addEventListener('submit', function(e) {
          if (!confirm('Apakah Anda yakin ingin logout?')) {
            e.preventDefault();
          }
        });
      }

      // Debug info
      console.log('Jumlah tombol +:', document.querySelectorAll('.product-card__add-btn').length);
      console.log('Jumlah tombol + aktif:', document.querySelectorAll('.product-card__add-btn:not(:disabled)').length);
    });
  </script>
</body>
</html>