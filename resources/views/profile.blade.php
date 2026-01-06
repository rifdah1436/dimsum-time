<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna - Dimsum Time</title>
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
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --info-color: #17a2b8;
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

        /* Profile Section Styles */
        .profile-section {
            padding: 40px 0 80px;
        }

        .profile-title {
            text-align: center;
            margin-bottom: 40px;
        }

        .profile-title h1 {
            font-family: 'Baloo', cursive;
            font-size: 48px;
            line-height: 1.2;
            color: var(--text-dark);
            margin: 0 0 10px 0;
        }

        .profile-title p {
            font-size: 18px;
            color: var(--text-muted);
            margin: 0;
        }

        /* Profile Container */
        .profile-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
        }

        @media (min-width: 992px) {
            .profile-container {
                grid-template-columns: 350px 1fr;
            }
        }

        /* Profile Sidebar */
        .profile-sidebar {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            height: fit-content;
        }

        .profile-header {
            padding: 30px;
            text-align: center;
            background: linear-gradient(135deg, var(--primary-color) 0%, #c62828 100%);
            color: white;
        }

        .profile-avatar {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto 20px;
        }

        .profile-avatar-img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid rgba(255, 255, 255, 0.3);
        }

        .profile-avatar-edit {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background: var(--primary-color);
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .profile-avatar-edit:hover {
            background: #c62828;
            transform: scale(1.1);
        }

        .profile-name {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .profile-role {
            display: inline-block;
            padding: 4px 12px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .profile-menu {
            padding: 20px 0;
        }

        .profile-menu-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 30px;
            color: var(--text-dark);
            transition: all 0.3s ease;
            cursor: pointer;
            border-left: 3px solid transparent;
        }

        .profile-menu-item:hover {
            background: rgba(229, 57, 53, 0.05);
            color: var(--primary-color);
        }

        .profile-menu-item.active {
            background: rgba(229, 57, 53, 0.1);
            color: var(--primary-color);
            border-left: 3px solid var(--primary-color);
        }

        .profile-menu-item i {
            font-size: 20px;
            width: 24px;
            text-align: center;
        }

        /* Profile Content */
        .profile-content {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .profile-content-header {
            padding: 25px 30px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .profile-content-header h2 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

        .profile-content-body {
            padding: 30px;
        }

        /* Profile Info */
        .profile-info-grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 25px;
        }

        @media (min-width: 768px) {
            .profile-info-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .info-label {
            font-size: 14px;
            color: var(--text-muted);
            font-weight: 500;
        }

        .info-value {
            font-size: 16px;
            color: var(--text-dark);
            font-weight: 600;
            padding: 10px 15px;
            background: #f9f9f9;
            border-radius: 8px;
            min-height: 45px;
            display: flex;
            align-items: center;
        }

        .info-value-empty {
            color: #999;
            font-style: italic;
            font-weight: normal;
        }

        /* Form Styles */
        .profile-form {
            max-width: 600px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            color: var(--text-muted);
            font-weight: 500;
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            font-size: 16px;
            font-family: 'DM Sans', sans-serif;
            color: var(--text-dark);
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(229, 57, 53, 0.1);
        }

        .form-control:disabled {
            background: #f5f5f5;
            cursor: not-allowed;
        }

        .form-text {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 5px;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 20px;
        }

        @media (min-width: 768px) {
            .form-row {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Button Styles */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
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
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background: #f5f5f5;
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .btn-danger {
            background: var(--danger-color);
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        }

        .btn-success {
            background: var(--success-color);
            color: white;
        }

        .btn-success:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        }

        .btn-small {
            padding: 8px 16px;
            font-size: 14px;
        }

        .btn-block {
            width: 100%;
        }

        .btn-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        /* Alert Messages */
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
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

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-active {
            background: #d4edda;
            color: #155724;
        }

        .status-inactive {
            background: #f8d7da;
            color: #721c24;
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

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 10000;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            max-width: 500px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: modalSlideIn 0.3s ease;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            padding: 20px 25px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 20px;
            color: var(--text-muted);
            cursor: pointer;
            padding: 5px;
            transition: color 0.3s ease;
        }

        .modal-close:hover {
            color: var(--primary-color);
        }

        .modal-body {
            padding: 25px;
        }

        .modal-footer {
            padding: 20px 25px;
            border-top: 1px solid #f0f0f0;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        /* Password Strength Indicator */
        .password-strength {
            margin-top: 10px;
        }

        .strength-bar {
            height: 5px;
            background: #e0e0e0;
            border-radius: 3px;
            overflow: hidden;
            margin-bottom: 5px;
        }

        .strength-fill {
            height: 100%;
            width: 0%;
            transition: width 0.3s ease, background-color 0.3s ease;
        }

        .strength-text {
            font-size: 12px;
            color: var(--text-muted);
        }

        .strength-weak {
            background-color: #dc3545;
        }

        .strength-fair {
            background-color: #ffc107;
        }

        .strength-good {
            background-color: #28a745;
        }

        .strength-strong {
            background-color: #007bff;
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

        /* Responsive */
        @media (max-width: 768px) {
            .profile-title h1 {
                font-size: 36px;
            }
            
            .profile-content-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .btn-group {
                width: 100%;
            }
            
            .btn {
                flex: 1;
                min-width: auto;
            }
            
            .modal-content {
                margin: 10px;
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

    <!-- Profile Section -->
    <section class="profile-section">
        <div class="container">
            <div class="profile-title">
                <h1>Profil Saya</h1>
                <p>Kelola informasi profil Anda untuk pengalaman berbelanja yang lebih baik</p>
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

            @if(session('warning'))
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ session('warning') }}
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    {{ session('info') }}
                </div>
            @endif

            <div class="profile-container">
                <!-- Profile Sidebar -->
                <div class="profile-sidebar">
                    <div class="profile-header">
                        <div class="profile-avatar">
                            <img src="{{ auth()->user()->foto_profil ? asset('storage/' . auth()->user()->foto_profil) : asset('images/default-avatar.png') }}" 
                                 alt="Foto Profil" class="profile-avatar-img"
                                 onerror="this.src='{{ asset('images/default-avatar.png') }}'">
                            <div class="profile-avatar-edit" onclick="openAvatarModal()">
                                <i class="fas fa-camera"></i>
                            </div>
                        </div>
                        <h2 class="profile-name">{{ auth()->user()->nama_lengkap }}</h2>
                        <span class="profile-role">
                            {{ ucfirst(auth()->user()->peran) }}
                            @if(auth()->user()->status_aktif)
                                <span class="status-badge status-active">Aktif</span>
                            @else
                                <span class="status-badge status-inactive">Nonaktif</span>
                            @endif
                        </span>
                    </div>
                    
                    <div class="profile-menu">
                        <div class="profile-menu-item active" data-tab="profile-info">
                            <i class="fas fa-user"></i>
                            <span>Informasi Profil</span>
                        </div>
                        <div class="profile-menu-item" data-tab="edit-profile">
                            <i class="fas fa-edit"></i>
                            <span>Edit Profil</span>
                        </div>
                        <div class="profile-menu-item" data-tab="change-password">
                            <i class="fas fa-lock"></i>
                            <span>Ubah Password</span>
                        </div>
                        <div class="profile-menu-item" data-tab="order-history">
                            <i class="fas fa-history"></i>
                            <span>Riwayat Pesanan</span>
                        </div>
                        @if(auth()->user()->peran == 'admin' || auth()->user()->peran == 'pemilik')
                        <div class="profile-menu-item" data-tab="admin-panel">
                            <i class="fas fa-cog"></i>
                            <span>Panel Admin</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Profile Content -->
                <div class="profile-content">
                    <!-- Profile Info Tab -->
                    <div class="profile-tab active" id="profile-info">
                        <div class="profile-content-header">
                            <h2>Informasi Profil</h2>
                            <div class="btn-group">
                                <button class="btn btn-secondary" onclick="switchTab('edit-profile')">
                                    <i class="fas fa-edit"></i> Edit Profil
                                </button>
                                <button class="btn btn-primary" onclick="switchTab('order-history')">
                                    <i class="fas fa-history"></i> Lihat Pesanan
                                </button>
                            </div>
                        </div>
                        
                        <div class="profile-content-body">
                            <div class="profile-info-grid">
                                <div class="info-item">
                                    <span class="info-label">Username</span>
                                    <div class="info-value">{{ auth()->user()->username }}</div>
                                </div>
                                
                                <div class="info-item">
                                    <span class="info-label">Email</span>
                                    <div class="info-value">{{ auth()->user()->email }}</div>
                                </div>
                                
                                <div class="info-item">
                                    <span class="info-label">Nama Lengkap</span>
                                    <div class="info-value">{{ auth()->user()->nama_lengkap }}</div>
                                </div>
                                
                                <div class="info-item">
                                    <span class="info-label">Nomor Telepon</span>
                                    <div class="info-value">
                                        @if(auth()->user()->nomor_telepon)
                                            {{ auth()->user()->nomor_telepon }}
                                        @else
                                            <span class="info-value-empty">Belum diisi</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="info-item">
                                    <span class="info-label">Peran</span>
                                    <div class="info-value">{{ ucfirst(auth()->user()->peran) }}</div>
                                </div>
                                
                                <div class="info-item">
                                    <span class="info-label">Status</span>
                                    <div class="info-value">
                                        @if(auth()->user()->status_aktif)
                                            <span class="status-badge status-active">Aktif</span>
                                        @else
                                            <span class="status-badge status-inactive">Nonaktif</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="info-item full-width">
                                    <span class="info-label">Alamat</span>
                                    <div class="info-value" style="min-height: 80px;">
                                        @if(auth()->user()->alamat)
                                            {{ auth()->user()->alamat }}
                                        @else
                                            <span class="info-value-empty">Belum diisi</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="info-item">
                                    <span class="info-label">Bergabung Sejak</span>
                                    <div class="info-value">
                                        {{ \Carbon\Carbon::parse(auth()->user()->created_at)->translatedFormat('d F Y') }}
                                    </div>
                                </div>
                                
                                <div class="info-item">
                                    <span class="info-label">Terakhir Diupdate</span>
                                    <div class="info-value">
                                        {{ \Carbon\Carbon::parse(auth()->user()->updated_at)->translatedFormat('d F Y H:i') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Profile Tab -->
                    <div class="profile-tab" id="edit-profile">
                        <div class="profile-content-header">
                            <h2>Edit Profil</h2>
                            <div class="btn-group">
                                <button class="btn btn-secondary" onclick="switchTab('profile-info')">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </button>
                            </div>
                        </div>
                        
                        <div class="profile-content-body">
                            <form id="editProfileForm" class="profile-form">
                                @csrf
                                @method('PUT')
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="nama_lengkap">Nama Lengkap *</label>
                                        <input type="text" id="nama_lengkap" name="nama_lengkap" 
                                               class="form-control" 
                                               value="{{ old('nama_lengkap', auth()->user()->nama_lengkap) }}"
                                               required>
                                        @error('nama_lengkap')
                                            <div class="form-text" style="color: var(--danger-color);">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="username">Username *</label>
                                        <input type="text" id="username" name="username" 
                                               class="form-control" 
                                               value="{{ old('username', auth()->user()->username) }}"
                                               required>
                                        @error('username')
                                            <div class="form-text" style="color: var(--danger-color);">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="email">Email *</label>
                                        <input type="email" id="email" name="email" 
                                               class="form-control" 
                                               value="{{ old('email', auth()->user()->email) }}"
                                               required>
                                        @error('email')
                                            <div class="form-text" style="color: var(--danger-color);">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="nomor_telepon">Nomor Telepon</label>
                                        <input type="tel" id="nomor_telepon" name="nomor_telepon" 
                                               class="form-control" 
                                               value="{{ old('nomor_telepon', auth()->user()->nomor_telepon) }}"
                                               placeholder="0812-3456-7890">
                                        @error('nomor_telepon')
                                            <div class="form-text" style="color: var(--danger-color);">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="alamat">Alamat Lengkap</label>
                                    <textarea id="alamat" name="alamat" class="form-control" 
                                              rows="4" placeholder="Masukkan alamat lengkap">{{ old('alamat', auth()->user()->alamat) }}</textarea>
                                    @error('alamat')
                                        <div class="form-text" style="color: var(--danger-color);">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <div class="btn-group" style="margin-top: 30px;">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Simpan Perubahan
                                    </button>
                                    <button type="button" class="btn btn-secondary" onclick="switchTab('profile-info')">
                                        <i class="fas fa-times"></i> Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Change Password Tab -->
                    <div class="profile-tab" id="change-password">
                        <div class="profile-content-header">
                            <h2>Ubah Password</h2>
                            <div class="btn-group">
                                <button class="btn btn-secondary" onclick="switchTab('profile-info')">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </button>
                            </div>
                        </div>
                        
                        <div class="profile-content-body">
                            <form id="changePasswordForm" class="profile-form">
                                @csrf
                                
                                <div class="form-group">
                                    <label for="current_password">Password Saat Ini *</label>
                                    <input type="password" id="current_password" name="current_password" 
                                           class="form-control" required>
                                    @error('current_password')
                                        <div class="form-text" style="color: var(--danger-color);">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="new_password">Password Baru *</label>
                                        <input type="password" id="new_password" name="new_password" 
                                               class="form-control" required
                                               onkeyup="checkPasswordStrength(this.value)">
                                        <div class="password-strength">
                                            <div class="strength-bar">
                                                <div class="strength-fill" id="passwordStrengthBar"></div>
                                            </div>
                                            <div class="strength-text" id="passwordStrengthText">
                                                Kekuatan password: -
                                            </div>
                                        </div>
                                        @error('new_password')
                                            <div class="form-text" style="color: var(--danger-color);">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="new_password_confirmation">Konfirmasi Password Baru *</label>
                                        <input type="password" id="new_password_confirmation" 
                                               name="new_password_confirmation" 
                                               class="form-control" required>
                                        @error('new_password_confirmation')
                                            <div class="form-text" style="color: var(--danger-color);">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="form-text" style="margin-top: 20px;">
                                    <i class="fas fa-info-circle"></i> Password harus terdiri dari minimal 8 karakter, termasuk huruf besar, huruf kecil, dan angka.
                                </div>
                                
                                <div class="btn-group" style="margin-top: 30px;">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-key"></i> Ubah Password
                                    </button>
                                    <button type="button" class="btn btn-secondary" onclick="switchTab('profile-info')">
                                        <i class="fas fa-times"></i> Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Order History Tab -->
                    <div class="profile-tab" id="order-history">
                        <div class="profile-content-header">
                            <h2>Riwayat Pesanan</h2>
                            <div class="btn-group">
                                <button class="btn btn-secondary" onclick="switchTab('profile-info')">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </button>
                                <a href="{{ route('pesanan') }}" class="btn btn-primary">
                                    <i class="fas fa-external-link-alt"></i> Lihat Semua
                                </a>
                            </div>
                        </div>
                        
                        <div class="profile-content-body">
                            <div style="text-align: center; padding: 40px 20px;">
                                <div style="font-size: 60px; color: #ddd; margin-bottom: 20px;">
                                    <i class="fas fa-shopping-bag"></i>
                                </div>
                                <h3 style="color: var(--text-dark); margin-bottom: 10px;">
                                    Riwayat Pesanan
                                </h3>
                                <p style="color: var(--text-muted); margin-bottom: 30px;">
                                    Untuk melihat riwayat pesanan lengkap, silakan kunjungi halaman Riwayat Pesanan.
                                </p>
                                <a href="{{ route('pesanan') }}" class="btn btn-primary">
                                    <i class="fas fa-history"></i> Lihat Riwayat Pesanan
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Admin Panel Tab (only for admin/pemilik) -->
                    @if(auth()->user()->peran == 'admin' || auth()->user()->peran == 'pemilik')
                    <div class="profile-tab" id="admin-panel">
                        <div class="profile-content-header">
                            <h2>Panel Admin</h2>
                            <div class="btn-group">
                                <button class="btn btn-secondary" onclick="switchTab('profile-info')">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </button>
                            </div>
                        </div>
                        
                        <div class="profile-content-body">
                            <div style="margin-bottom: 30px;">
                                <h3 style="color: var(--text-dark); margin-bottom: 20px; font-size: 20px;">
                                    <i class="fas fa-cog"></i> Menu Admin
                                </h3>
                                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                                    <a href="#" class="btn btn-secondary" style="text-align: left; justify-content: flex-start;">
                                        <i class="fas fa-users" style="margin-right: 10px;"></i>
                                        <span>Kelola Pengguna</span>
                                    </a>
                                    <a href="#" class="btn btn-secondary" style="text-align: left; justify-content: flex-start;">
                                        <i class="fas fa-box" style="margin-right: 10px;"></i>
                                        <span>Kelola Pesanan</span>
                                    </a>
                                    <a href="#" class="btn btn-secondary" style="text-align: left; justify-content: flex-start;">
                                        <i class="fas fa-utensils" style="margin-right: 10px;"></i>
                                        <span>Kelola Menu</span>
                                    </a>
                                    <a href="#" class="btn btn-secondary" style="text-align: left; justify-content: flex-start;">
                                        <i class="fas fa-chart-bar" style="margin-right: 10px;"></i>
                                        <span>Laporan</span>
                                    </a>
                                </div>
                            </div>
                            
                            <div>
                                <h3 style="color: var(--text-dark); margin-bottom: 20px; font-size: 20px;">
                                    <i class="fas fa-chart-line"></i> Statistik Cepat
                                </h3>
                                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px;">
                                    <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; text-align: center;">
                                        <div style="font-size: 24px; font-weight: 700; color: var(--primary-color);">0</div>
                                        <div style="font-size: 14px; color: var(--text-muted);">Pesanan Hari Ini</div>
                                    </div>
                                    <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; text-align: center;">
                                        <div style="font-size: 24px; font-weight: 700; color: var(--success-color);">0</div>
                                        <div style="font-size: 14px; color: var(--text-muted);">Pengguna Baru</div>
                                    </div>
                                    <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; text-align: center;">
                                        <div style="font-size: 24px; font-weight: 700; color: var(--warning-color);">Rp 0</div>
                                        <div style="font-size: 14px; color: var(--text-muted);">Pendapatan</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Modal for Avatar Upload -->
    <div class="modal" id="avatarModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Ubah Foto Profil</h3>
                <button class="modal-close" onclick="closeAvatarModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="avatarForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div style="text-align: center; margin-bottom: 25px;">
                        <div style="width: 150px; height: 150px; margin: 0 auto 20px; position: relative;">
                            <img id="avatarPreview" 
                                 src="{{ auth()->user()->foto_profil ? asset('storage/' . auth()->user()->foto_profil) : asset('images/default-avatar.png') }}" 
                                 alt="Preview" 
                                 style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 3px solid #f0f0f0;"
                                 onerror="this.src='{{ asset('images/default-avatar.png') }}'">
                        </div>
                        <input type="file" id="foto_profil" name="foto_profil" 
                               accept="image/*" style="display: none;"
                               onchange="previewAvatar(event)">
                        <button type="button" class="btn btn-secondary" onclick="document.getElementById('foto_profil').click()">
                            <i class="fas fa-upload"></i> Pilih Foto
                        </button>
                        <div class="form-text" style="margin-top: 10px;">
                            Ukuran maksimal: 2MB. Format: JPG, PNG, GIF.
                        </div>
                    </div>
                    
                    @error('foto_profil')
                        <div class="alert alert-error" style="margin-bottom: 20px;">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="closeAvatarModal()">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        @if(auth()->user()->foto_profil)
                        <button type="button" class="btn btn-danger" onclick="deleteAvatar()">
                            <i class="fas fa-trash"></i> Hapus Foto
                        </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

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
    // Fungsi untuk menampilkan loading spinner
    function showLoading() {
        const spinner = document.getElementById('loadingSpinner');
        if (spinner) spinner.style.display = 'flex';
    }

    function hideLoading() {
        const spinner = document.getElementById('loadingSpinner');
        if (spinner) spinner.style.display = 'none';
    }

    // Fungsi untuk switch tab
    function switchTab(tabId) {
        // Hide all tabs
        document.querySelectorAll('.profile-tab').forEach(tab => {
            tab.classList.remove('active');
        });
        
        // Show selected tab
        document.getElementById(tabId).classList.add('active');
        
        // Update menu items
        document.querySelectorAll('.profile-menu-item').forEach(item => {
            item.classList.remove('active');
            if (item.dataset.tab === tabId) {
                item.classList.add('active');
            }
        });
        
        // Scroll to top of content
        document.querySelector('.profile-content').scrollTop = 0;
    }

    // Event listeners for menu items
    document.querySelectorAll('.profile-menu-item').forEach(item => {
        item.addEventListener('click', function() {
            const tabId = this.dataset.tab;
            switchTab(tabId);
        });
    });

    // Form submission for edit profile
    document.getElementById('editProfileForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!confirm('Apakah Anda yakin ingin menyimpan perubahan?')) {
            return;
        }
        
        showLoading();
        
        const formData = new FormData(this);
        
        fetch('{{ route("profile.update") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
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
            hideLoading();
            
            if (data.success) {
                alert(data.message || 'Profil berhasil diperbarui!');
                location.reload();
            } else {
                // Show validation errors
                if (data.errors) {
                    let errorMessage = 'Terdapat kesalahan:\n';
                    Object.values(data.errors).forEach(error => {
                        errorMessage += `• ${error[0]}\n`;
                    });
                    alert(errorMessage);
                } else {
                    alert('Gagal memperbarui profil: ' + (data.message || 'Terjadi kesalahan'));
                }
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memperbarui profil. Silakan coba lagi.');
        });
    });

    // Form submission for change password
    document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('new_password_confirmation').value;
        
        if (newPassword !== confirmPassword) {
            alert('Password baru dan konfirmasi password tidak cocok!');
            return;
        }
        
        if (!confirm('Apakah Anda yakin ingin mengubah password?')) {
            return;
        }
        
        showLoading();
        
        const formData = new FormData(this);
        
        fetch('{{ route("profile.password") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
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
            hideLoading();
            
            if (data.success) {
                alert(data.message || 'Password berhasil diubah!');
                document.getElementById('changePasswordForm').reset();
                switchTab('profile-info');
            } else {
                // Show validation errors
                if (data.errors) {
                    let errorMessage = 'Terdapat kesalahan:\n';
                    Object.values(data.errors).forEach(error => {
                        errorMessage += `• ${error[0]}\n`;
                    });
                    alert(errorMessage);
                } else {
                    alert('Gagal mengubah password: ' + (data.message || 'Terjadi kesalahan'));
                }
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengubah password. Silakan coba lagi.');
        });
    });

    // Password strength checker
    function checkPasswordStrength(password) {
        const strengthBar = document.getElementById('passwordStrengthBar');
        const strengthText = document.getElementById('passwordStrengthText');
        
        let strength = 0;
        let text = 'Kekuatan password: ';
        
        // Check length
        if (password.length >= 8) strength += 25;
        if (password.length >= 12) strength += 15;
        
        // Check for uppercase letters
        if (/[A-Z]/.test(password)) strength += 20;
        
        // Check for lowercase letters
        if (/[a-z]/.test(password)) strength += 20;
        
        // Check for numbers
        if (/[0-9]/.test(password)) strength += 20;
        
        // Check for special characters
        if (/[^A-Za-z0-9]/.test(password)) strength += 20;
        
        // Update bar and text
        strengthBar.style.width = strength + '%';
        
        if (strength < 40) {
            strengthBar.className = 'strength-fill strength-weak';
            text += 'Lemah';
        } else if (strength < 70) {
            strengthBar.className = 'strength-fill strength-fair';
            text += 'Cukup';
        } else if (strength < 90) {
            strengthBar.className = 'strength-fill strength-good';
            text += 'Baik';
        } else {
            strengthBar.className = 'strength-fill strength-strong';
            text += 'Sangat Kuat';
        }
        
        strengthText.textContent = text;
    }

    // Avatar modal functions
    function openAvatarModal() {
        document.getElementById('avatarModal').classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeAvatarModal() {
        document.getElementById('avatarModal').classList.remove('show');
        document.body.style.overflow = '';
    }

    function previewAvatar(event) {
        const input = event.target;
        const preview = document.getElementById('avatarPreview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Avatar form submission
    document.getElementById('avatarForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const fileInput = document.getElementById('foto_profil');
        if (!fileInput.files[0]) {
            alert('Silakan pilih foto terlebih dahulu!');
            return;
        }
        
        // Check file size (max 2MB)
        if (fileInput.files[0].size > 2 * 1024 * 1024) {
            alert('Ukuran file terlalu besar! Maksimal 2MB.');
            return;
        }
        
        // Check file type
        const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!validTypes.includes(fileInput.files[0].type)) {
            alert('Format file tidak didukung! Gunakan JPG, PNG, atau GIF.');
            return;
        }
        
        showLoading();
        
        const formData = new FormData(this);
        
        fetch('{{ route("profile.avatar") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
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
            hideLoading();
            
            if (data.success) {
                alert(data.message || 'Foto profil berhasil diperbarui!');
                location.reload();
            } else {
                alert('Gagal mengubah foto profil: ' + (data.message || 'Terjadi kesalahan'));
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengubah foto profil. Silakan coba lagi.');
        });
    });

    // Delete avatar
    function deleteAvatar() {
        if (!confirm('Apakah Anda yakin ingin menghapus foto profil?')) {
            return;
        }
        
        showLoading();
        
        fetch('{{ route("profile.avatar.delete") }}', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            hideLoading();
            
            if (data.success) {
                alert(data.message || 'Foto profil berhasil dihapus!');
                location.reload();
            } else {
                alert('Gagal menghapus foto profil: ' + (data.message || 'Terjadi kesalahan'));
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus foto profil. Silakan coba lagi.');
        });
    }

    // Update cart count in header
    function updateCartCount(count) {
        const cartCountElement = document.querySelector('.dimsum-cart-count');
        if (cartCountElement) {
            cartCountElement.textContent = count;
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Update cart count from session
        updateCartCountFromSession();
        
        // Add animation to profile cards
        document.querySelectorAll('.profile-sidebar, .profile-content').forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
        
        // Close modal on outside click
        document.getElementById('avatarModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAvatarModal();
            }
        });
        
        // Close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAvatarModal();
            }
        });
    });

    // Function to fetch cart count from session
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
    // Fungsi untuk update cart count
function updateCartCount(count) {
    const cartCountElement = document.querySelector('.dimsum-cart-count');
    if (cartCountElement) {
        cartCountElement.textContent = count;
    }
}

// Fetch cart count on page load
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

// Update on page load
document.addEventListener('DOMContentLoaded', function() {
    updateCartCountFromSession();
});
    </script>
</body>
</html>