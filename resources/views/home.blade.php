<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dimsum Time - Home</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Baloo+2:wght@600&family=Playfair+Display:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

    /* Button Styles */
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 12px 24px;
      border-radius: 8px;
      font-weight: 600;
      font-size: 16px;
      cursor: pointer;
      transition: all 0.3s ease;
      border: none;
      font-family: 'DM Sans', sans-serif;
    }

    .btn-large {
      padding: 20px 32px;
      font-size: 18px;
      min-width: 200px;
      text-align: center;
    }

    .btn-primary {
      background-color: var(--primary-color);
      color: white;
    }

    .btn-primary:hover {
      background-color: #c62828;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(229, 57, 53, 0.3);
    }

    .btn-secondary {
      background-color: var(--secondary-color);
      color: white;
    }

    .btn-secondary:hover {
      background-color: #f57c00;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(255, 152, 0, 0.3);
    }

    /* Welcome Popup */
    .welcome-popup {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.8);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
      animation: fadeIn 0.3s ease;
    }

    .welcome-content {
      background: white;
      border-radius: 15px;
      padding: 40px;
      max-width: 500px;
      text-align: center;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
      animation: slideUp 0.5s ease;
      position: relative;
    }

    .welcome-icon {
      font-size: 60px;
      color: var(--primary-color);
      margin-bottom: 20px;
      animation: bounce 1s ease infinite;
    }

    .welcome-content h2 {
      color: var(--primary-color);
      margin-bottom: 15px;
      font-size: 32px;
    }

    .welcome-content p {
      color: var(--text-muted);
      margin-bottom: 25px;
      line-height: 1.6;
    }

    .close-popup {
      position: absolute;
      top: 15px;
      right: 15px;
      background: none;
      border: none;
      font-size: 24px;
      color: var(--text-muted);
      cursor: pointer;
      transition: color 0.3s ease;
    }

    .close-popup:hover {
      color: var(--primary-color);
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @keyframes slideUp {
      from {
        opacity: 0;
        transform: translateY(50px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes bounce {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }

    /* CSS for section section:Hero */
    .hero-section {
      background-image: url('{{ asset("images/189febcef92dbbbb1859d116eb999e4861f7f980.png") }}');
      background-size: cover;
      background-position: center;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 150px 24px;
      position: relative;
      min-height: 829px;
      color: var(--text-dark);
    }

    .hero-background-blur {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 656px;
      height: 729px;
      z-index: 0;
      opacity: 0.7;
    }

    .hero-content {
      position: relative;
      z-index: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 32px;
      max-width: 670px;
    }

    .hero-content h1 {
      font-family: 'Playfair Display', serif;
      font-weight: 400;
      font-size: 100px;
      line-height: 96px;
      margin: 0;
    }

    .hero-content p {
      font-size: 20px;
      line-height: 32px;
      max-width: 540px;
      margin: 0;
      color: #414536;
    }

    .hero-buttons {
      display: flex;
      gap: 16px;
      margin-top: 8px;
    }

    /* CSS for section section:Features */
    .features-section {
      padding: 133px 0;
      background-color: var(--bg-light);
    }

    .feature-cards-container {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 24px;
    }

    .feature-card {
      background-color: white;
      border: 1.5px solid var(--border-color);
      border-radius: 12px;
      padding: 34px;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      gap: 15px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .feature-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .feature-icon-wrapper {
      background-color: #ebebeb;
      border-radius: 99px;
      padding: 12px;
      display: flex;
      justify-content: center;
      align-items: center;
      width: 84px;
      height: 84px;
      margin-bottom: 15px;
    }

    .feature-card h3 {
      font-family: 'DM Sans', sans-serif;
      font-weight: 700;
      font-size: 24px;
      line-height: 30px;
      letter-spacing: -0.72px;
      margin: 0;
    }

    .feature-card p {
      font-size: 16px;
      line-height: 24px;
      color: #414536;
      margin: 0;
    }

    /* CSS for section section:About */
    .about-section {
      padding: 119px 0;
      background-color: var(--bg-light);
    }

    .about-container {
      display: flex;
      align-items: center;
      gap: 80px;
    }

    .about-image-wrapper {
      position: relative;
      flex: 1;
      min-width: 0;
    }

    .about-image-bg {
      background-color: #dbeafe;
      border-radius: 12px;
      overflow: hidden;
      line-height: 0;
      width: 100%;
      max-width: 599px;
      height: 566px;
    }

    .about-image {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .contact-card {
      position: absolute;
      bottom: -50px;
      left: 50%;
      transform: translateX(-70%);
      width: 411px;
      background-color: var(--bg-dark);
      color: white;
      border-radius: 12px;
      padding: 40px 30px;
      box-shadow: -10px 4px 20px 0px rgba(0, 0, 0, 0.25);
      display: flex;
      flex-direction: column;
      gap: 30px;
    }

    .contact-card h4 {
      font-family: 'DM Sans', sans-serif;
      font-weight: 700;
      font-size: 24px;
      line-height: 30px;
      margin: 0;
    }

    .contact-card-info {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .contact-card-item {
      display: flex;
      align-items: flex-start;
      gap: 15px;
      font-size: 16px;
      line-height: 24px;
      color: var(--text-light);
    }

    .contact-card-item i {
      font-size: 18px;
      flex-shrink: 0;
      margin-top: 2px;
    }

    .contact-card-item span {
      flex: 1;
    }

    .about-text-content {
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 24px;
      max-width: 425px;
    }

    .about-text-content h2 {
      font-family: 'Playfair Display', serif;
      font-weight: 500;
      font-size: 55px;
      line-height: 60.5px;
      margin: 0;
    }

    .about-text-content .p-large {
      font-size: 18px;
      line-height: 28px;
      font-weight: 500;
      color: var(--text-dark);
    }

    .about-text-content p {
      font-size: 16px;
      line-height: 24px;
      color: #414536;
      margin: 0;
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
      grid-template-columns: repeat(4, 1fr);
      gap: 40px;
      margin-bottom: 40px;
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
      justify-content: space-between;
      align-items: center;
      padding-top: 30px;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .dimsum-copyright {
      color: var(--text-footer-muted);
      font-size: 14px;
    }

    .dimsum-payment-methods {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .dimsum-payment-icon {
      background: white;
      color: var(--text-dark);
      padding: 4px 12px;
      border-radius: 4px;
      font-size: 12px;
      font-weight: 600;
    }

    .dimsum-whatsapp-float {
      position: fixed;
      bottom: 30px;
      right: 30px;
      width: 60px;
      height: 60px;
      background: #25D366;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 30px;
      box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
      cursor: pointer;
      z-index: 1000;
      transition: transform 0.3s ease;
    }

    .dimsum-whatsapp-float:hover {
      transform: scale(1.1);
    }

    /* Responsive Styles */
    @media (max-width: 1200px) {
      .feature-cards-container {
        grid-template-columns: repeat(2, 1fr);
      }

      .dimsum-footer-top {
        grid-template-columns: repeat(2, 1fr);
      }

      .about-container {
        flex-direction: column;
        gap: 100px;
      }

      .contact-card {
        left: 50%;
        transform: translateX(-50%);
      }
    }

    @media (max-width: 768px) {
      .container {
        padding-left: 16px;
        padding-right: 16px;
      }

      .btn-large {
        padding: 16px 24px;
        font-size: 16px;
        min-width: 180px;
      }

      .hero-section {
        padding: 100px 24px;
        min-height: 60vh;
      }

      .hero-content h1 {
        font-size: 60px;
        line-height: 1.1;
      }

      .hero-content p {
        font-size: 18px;
      }

      .hero-buttons {
        flex-direction: column;
        width: 100%;
        max-width: 300px;
      }

      .features-section {
        padding: 80px 0;
      }

      .feature-cards-container {
        grid-template-columns: 1fr;
        max-width: 400px;
        margin: 0 auto;
      }

      .about-section {
        padding: 80px 0;
      }

      .about-image-bg {
        height: auto;
        aspect-ratio: 1/0.95;
      }

      .contact-card {
        position: relative;
        bottom: 0;
        width: 100%;
        margin-top: 30px;
        transform: none;
        left: 0;
      }

      .about-text-content h2 {
        font-size: 40px;
        line-height: 1.2;
      }

      .dimsum-footer-top {
        grid-template-columns: 1fr;
        gap: 30px;
      }

      .dimsum-footer-bottom {
        flex-direction: column;
        gap: 20px;
        text-align: center;
      }

      .dimsum-main-nav-container {
        flex-direction: column;
        gap: 15px;
      }

      .dimsum-nav-links {
        gap: 15px;
        flex-wrap: wrap;
        justify-content: center;
      }
    }

    @media (max-width: 480px) {
      .hero-content h1 {
        font-size: 48px;
      }

      .contact-card {
        padding: 30px 20px;
      }

      .contact-card h4 {
        font-size: 20px;
      }

      .welcome-content {
        padding: 30px 20px;
        margin: 0 20px;
      }

      .welcome-content h2 {
        font-size: 24px;
      }

      .welcome-icon {
        font-size: 40px;
      }
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
            <li><a href="{{ route('home') }}" class="active">Beranda</a></li>
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
              <span>{{ auth()->user()->nama_lengkap?? 'Guest'  }}</span>
              <i class="fas fa-chevron-down"></i>
            </div>

            <!-- Dropdown Menu -->
            <div class="dimsum-dropdown-menu">
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
            </div>
          </div>
        </div>
      </nav>
    </div>
  </header>

  <!-- HERO SECTION -->
  <section id="hero" class="hero-section">
    <div class="hero-background-blur">
    <img src="{{ asset('images/433_1410.svg') }}" alt="background blur" onerror="this.src='{{ asset('images/logo-placeholder.png') }}'">
    </div>
    <div class="hero-content">
      <h1>Hidangan Terbaik untuk Selera Anda</h1>
      <p>Temukan cita rasa lezat dan momen tak terlupakan di tempat kuliner terbaik kami.</p>
      <div class="hero-buttons">
        <!-- Tombol Pesan Sekarang mengarah ke keranjang -->
        <a href="{{ route('keranjang') }}" class="btn btn-primary btn-large">Pesan Sekarang</a>
        <!-- Tombol Jelajahi Menu mengarah ke halaman menu -->
        <a href="{{ route('menu') }}" class="btn btn-secondary btn-large">Jelajahi Menu</a>
      </div>
    </div>
  </section>

  <!-- FEATURES SECTION -->
  <section id="features" class="features-section">
    <div class="container">
      <div class="feature-cards-container">
        <div class="feature-card">
          <div class="feature-icon-wrapper">
            <i class="fas fa-leaf" style="font-size: 40px; color: #4CAF50;"></i>
          </div>
          <h3>100% Tanpa Bahan Pengawet</h3>
          <p>Alami dan Sehat Serta Aman Tanpa Tambahan Pengawet.</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon-wrapper">
            <i class="fas fa-drumstick-bite" style="font-size: 40px; color: #795548;"></i>
          </div>
          <h3>99% Komposisi Daging</h3>
          <p>Kualitas Premium dengan Kandungan Daging Asli Maksimal.</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon-wrapper">
            <i class="fas fa-certificate" style="font-size: 40px; color: #2196F3;"></i>
          </div>
          <h3>Terdaftar BPOM & HALAL</h3>
          <p>Terjamin Aman dengan Sertifikasi Resmi BPOM & HALAL.</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon-wrapper">
            <i class="fas fa-industry" style="font-size: 40px; color: #FF9800;"></i>
          </div>
          <h3>50.000 Produksi Per hari</h3>
          <p>Harga Terjangkau dengan Produksi Skala Besar Setiap Hari.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ABOUT SECTION -->
  <section id="about" class="about-section">
    <div class="container about-container">
      <div class="about-image-wrapper">
        <div class="about-image-bg">
          <img src="{{ asset('images/ea100a0f426f4a6b916df29cb8be0da8e23645df.png') }}" alt="Dimsum dish" class="about-image" onerror="this.src='https://images.unsplash.com/photo-1563245372-f21724e3856d?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'">
        </div>
        <div class="contact-card">
          <h4>Kunjungi kami</h4>
          <div class="contact-card-info">
            <div class="contact-card-item">
              <i class="fas fa-phone"></i>
              <span>(414) 857 - 0107</span>
            </div>
            <div class="contact-card-item">
              <i class="fas fa-envelope"></i>
              <span>dimsumtime.id@gmail.com</span>
            </div>
            <div class="contact-card-item">
              <i class="fas fa-map-marker-alt"></i>
              <span>Ruko Sakura Point Blok B-12, Cikarang Selatan, Bekasi</span>
            </div>
          </div>
        </div>
      </div>
      <div class="about-text-content">
        <h2>Kami Sajikan Hidangan Sehat untuk Keluarga Anda</h2>
        <p class="p-large">Cerita kami dimulai dari sebuah mimpi: menghadirkan pengalaman bersantap yang tak biasa perpaduan antara cita rasa kelas atas, pelayanan luar biasa, dan suasana yang hidup. Terinspirasi dari kekayaan kuliner kota kami, kami bangga mengangkat rasa lokal sambil menyuguhkan sentuhan global.</p>
        <p>Di tempat kami, makan bukan sekadar mengisi perut ini tentang merayakan momen. Tim kami dikenal karena kehangatan dan dedikasinya, siap menjadikan setiap kunjungan Anda sebagai pengalaman yang tak terlupakan.</p>
      </div>
    </div>
  </section>

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
            <a href="#">Tentang Kami</a>
            <a href="{{ route('menu') }}">Menu</a>
            <a href="#">Kontak</a>
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
          <img src="{{ asset('images/fb05b4fb74e829d3f6d99dffe090e08af8bcfb9f.png') }}" alt="Instagram post 1">
            <img src="{{ asset('images/121c2dcceec8aa39a8b0c3768cde9c78f03c3ba6.png') }}" alt="Instagram post 2">
            <img src="{{ asset ('images/5078258e7740f3b78ef25ac57cef10d1e8426663.png') }}" alt="Instagram post 3">
            <img src="{{ asset ('images/372cef40f35f774bd9ba4110538c35c370a5762f.png') }}" alt="Instagram post 4">
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
    document.addEventListener('DOMContentLoaded', function () {

            // Cart count update from session
            function updateCartCount(count) {
          const cartCountElement = document.querySelector('.dimsum-cart-count');
          if (cartCountElement) {
              cartCountElement.textContent = count;
          }
      }

      // Fetch cart count from server
      function fetchCartCount() {
          fetch('/cart/count', {
              method: 'GET',
              headers: {
                  'Accept': 'application/json',
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
              }
          })
          .then(response => {
              if (!response.ok) {
                  throw new Error('Network response was not ok');
              }
              return response.json();
          })
          .then(data => {
              if (data.cart_count !== undefined) {
                  updateCartCount(data.cart_count);
              }
          })
          .catch(error => {
              console.error('Error fetching cart count:', error);
              // Fallback: use session data directly
              const sessionCartCount = {{ count(session('cart', [])) }};
              updateCartCount(sessionCartCount);
          });
      }

      // Sync cart between session and database
      function syncCart() {
          console.log('Syncing cart for home page...');
          fetch('/cart/sync', {
              method: 'GET',
              headers: {
                  'Accept': 'application/json',
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
              }
          })
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  console.log('Cart sync successful:', data.cart_count, 'items');
                  updateCartCount(data.cart_count);
              }
          })
          .catch(error => {
              console.error('Error syncing cart:', error);
              fetchCartCount(); // Fallback to fetch only
          });
      }

      // Update cart count on page load
      document.addEventListener('DOMContentLoaded', function() {
          console.log('Home page loaded, updating cart count...');
          console.log('Initial session cart count:', {{ count(session('cart', [])) }});
          
          // Cek apakah cart count element ada
          const cartCountElement = document.querySelector('.dimsum-cart-count');
          if (!cartCountElement) {
              console.error('Cart count element not found!');
              return;
          }
          
          // First, sync cart with database
          syncCart();
          
          // Then fetch cart count after a short delay
          setTimeout(() => {
              fetchCartCount();
          }, 500);
          
          // Debug: log current cart status
          console.log('Current cart data from session:', {{ json_encode(session('cart', [])) }});
      });

      // WhatsApp Float Button
      const whatsappFloat = document.getElementById('whatsappFloat');
      if (whatsappFloat) {
          whatsappFloat.addEventListener('click', function() {
              window.open('https://wa.me/6281234567890', '_blank');
          });
      }

      // Smooth hover animations for buttons
      const buttons = document.querySelectorAll('.btn');
      buttons.forEach(button => {
          button.addEventListener('mouseenter', function () {
              this.style.transform = 'translateY(-2px)';
          });

          button.addEventListener('mouseleave', function () {
              this.style.transform = 'translateY(0)';
          });
      });

      // User dropdown functionality
      const userProfile = document.querySelector('.dimsum-user-profile');
      const dropdownMenu = document.querySelector('.dimsum-dropdown-menu');

      if (userProfile && dropdownMenu) {
          userProfile.addEventListener('mouseenter', function () {
              dropdownMenu.style.opacity = '1';
              dropdownMenu.style.visibility = 'visible';
              dropdownMenu.style.transform = 'translateY(0)';
          });

          userProfile.addEventListener('mouseleave', function () {
              dropdownMenu.style.opacity = '0';
              dropdownMenu.style.visibility = 'hidden';
              dropdownMenu.style.transform = 'translateY(-10px)';
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
    });

  </script>
</body>
</html>