<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dimsum Time - Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/logo.png') }}">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700&family=DM+Sans:wght@300;400;500;600&family=Fredoka:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #E63946;
            --primary-dark: #C1121F;
            --secondary-color: #FF7A00;
            --secondary-light: #FF9E6D;
            --accent-color: #FFD166;
            --dark-color: #333333;
            --light-color: #FFFFFF;
            --gray-light: #F8F9FA;
            --gray-medium: #E9ECEF;
            --gray-dark: #6C757D;
            --shadow-soft: 0 2px 15px rgba(0, 0, 0, 0.08);
            --shadow-medium: 0 5px 25px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
            --border-radius: 15px;
            --border-radius-sm: 10px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: linear-gradient(135deg, #FFF8F3 0%, #FFFFFF 100%);
            min-height: 100vh;
            color: var(--dark-color);
            line-height: 1.5;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .top-bar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: var(--light-color);
            padding: 8px 0;
            box-shadow: 0 2px 10px rgba(230, 57, 70, 0.2);
            position: relative;
        }

        .top-bar::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--secondary-color), var(--accent-color));
        }

        .top-bar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .contact-info {
            display: flex;
            gap: 20px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            color: var(--light-color);
            font-size: 13px;
            font-weight: 500;
            transition: var(--transition);
            padding: 5px 10px;
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.1);
        }

        .contact-item:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-1px);
        }

        .contact-item i {
            font-size: 12px;
        }

        .social-links {
            display: flex;
            gap: 8px;
        }

        .social-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            transition: var(--transition);
            color: white;
            text-decoration: none;
        }

        .social-icon:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }

        /* Main Container */
        .login-main-container {
            flex: 1;
            display: flex;
            width: 100%;
            max-width: 1000px;
            margin: 30px auto;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-medium);
            background: var(--light-color);
            min-height: 500px;
            height: 75vh;
            max-height: 600px;
        }

        /* Promo Panel */
        .promo-panel {
            flex: 0.8;
            background: linear-gradient(rgba(230, 57, 70, 0.9), rgba(255, 122, 0, 0.8)),
            url('images/c9a5c5de1dc6770a54a2c50e0a8ad3a7a4675829.png');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: var(--light-color);
            padding: 30px;
            position: relative;
        }

        .promo-content {
            position: relative;
            z-index: 2;
            max-width: 350px;
        }

        .promo-title {
            font-family: 'Baloo 2', cursive;
            font-weight: 600;
            font-size: 32px;
            line-height: 1.2;
            margin-bottom: 15px;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.3);
        }

        .promo-subtitle {
            font-family: 'Fredoka', sans-serif;
            font-weight: 400;
            font-size: 14px;
            line-height: 1.4;
            margin-top: 15px;
            opacity: 0.9;
            background: rgba(0, 0, 0, 0.15);
            padding: 12px;
            border-radius: 8px;
            backdrop-filter: blur(5px);
        }

        .promo-features {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 20px;
            text-align: left;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 12px;
        }

        .feature-icon {
            width: 28px;
            height: 28px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            flex-shrink: 0;
        }

        /* Form Panel */
        .form-panel {
            flex: 1;
            background: var(--light-color);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }

        .form-wrapper {
            width: 100%;
            max-width: 380px;
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .form-header {
            display: flex;
            flex-direction: column;
            gap: 10px;
            text-align: center;
        }

        .form-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 5px;
        }

        .form-logo-icon {
            width: 40px;
            height: 40px;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        .form-logo-text {
            font-family: 'Baloo 2', cursive;
            font-weight: 600;
            font-size: 22px;
            color: var(--primary-color);
        }

        .form-title {
            font-family: 'Baloo 2', cursive;
            font-weight: 600;
            font-size: 28px;
            color: var(--dark-color);
            position: relative;
            display: inline-block;
            margin-bottom: 5px;
        }

        .form-title::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 2px;
            background: var(--secondary-color);
            border-radius: 1px;
        }

        .form-subtitle {
            font-family: 'Fredoka', sans-serif;
            font-weight: 400;
            font-size: 14px;
            color: var(--gray-dark);
            max-width: 300px;
            margin: 0 auto;
        }

        .login-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            font-family: 'Fredoka', sans-serif;
            font-weight: 500;
            font-size: 14px;
            color: var(--dark-color);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .form-group label i {
            color: var(--primary-color);
            font-size: 12px;
        }

        .input-wrapper {
            position: relative;
        }

        .form-group input {
            width: 100%;
            height: 45px;
            border-radius: var(--border-radius-sm);
            border: 1px solid var(--gray-medium);
            background: var(--gray-light);
            padding: 0 40px 0 15px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            transition: var(--transition);
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--secondary-color);
            background: var(--light-color);
            box-shadow: 0 0 0 2px rgba(255, 122, 0, 0.1);
        }

        .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-dark);
            font-size: 14px;
        }

        .password-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 5px;
        }

        .toggle-password {
            background: none;
            border: none;
            color: var(--gray-dark);
            cursor: pointer;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 4px 8px;
            border-radius: 6px;
            transition: var(--transition);
        }

        .toggle-password:hover {
            color: var(--primary-color);
            background: rgba(230, 57, 70, 0.05);
        }

        .forgot-password {
            font-family: 'Fredoka', sans-serif;
            font-weight: 500;
            font-size: 12px;
            color: var(--primary-color);
            text-decoration: none;
            padding: 4px 8px;
            border-radius: 6px;
            transition: var(--transition);
        }

        .forgot-password:hover {
            color: var(--primary-dark);
            background: rgba(230, 57, 70, 0.05);
        }

       .remember-me {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .remember-me input {
            width: 14px;
            height: 14px;
        }

        .remember-me label {
            font-size: 12px;
            color: var(--gray-dark);
        }

        .submit-button {
            height: 45px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: var(--light-color);
            font-family: 'Fredoka', sans-serif;
            font-weight: 600;
            font-size: 15px;
            border: none;
            border-radius: var(--border-radius-sm);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 5px;
        }

        .submit-button:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, #A00D1A 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(230, 57, 70, 0.2);
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 15px 0;
            color: var(--gray-dark);
            font-family: 'Fredoka', sans-serif;
            font-size: 11px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--gray-medium);
        }

        .divider span {
            padding: 0 12px;
        }

        .social-login {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .social-login-btn {
            flex: 1;
            height: 40px;
            border: 1px solid var(--gray-medium);
            border-radius: var(--border-radius-sm);
            background: var(--light-color);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-family: 'DM Sans', sans-serif;
            font-weight: 500;
            font-size: 12px;
            color: var(--dark-color);
            cursor: pointer;
            transition: var(--transition);
        }

        .social-login-btn:hover {
            transform: translateY(-1px);
            border-color: var(--gray-dark);
        }

        .social-login-btn i {
            font-size: 14px;
        }

        .signup-prompt {
            text-align: center;
            font-family: 'Fredoka', sans-serif;
            font-weight: 400;
            font-size: 13px;
            color: var(--gray-dark);
            padding: 15px;
            background: var(--gray-light);
            border-radius: var(--border-radius-sm);
            margin-top: 10px;
        }

        .signup-prompt a {
            font-weight: 600;
            color: var(--secondary-color);
            text-decoration: none;
            padding: 3px 6px;
            border-radius: 6px;
            transition: var(--transition);
        }

        .signup-prompt a:hover {
            color: var(--secondary-color);
            background: rgba(255, 122, 0, 0.08);
        }

        /* Error states */
        .form-group.error input {
            border-color: #FF4444;
            background: rgba(255, 68, 68, 0.03);
        }

        .error-message {
            color: #FF4444;
            font-size: 11px;
            margin-top: 4px;
            display: none;
        }

        .form-group.error .error-message {
            display: block;
        }

        /* Alert messages */
        .alert {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-danger {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-main-container {
                flex-direction: column;
                max-width: 450px;
                height: auto;
                min-height: auto;
                margin: 20px auto;
            }

            .promo-panel {
                flex: none;
                min-height: 200px;
                padding: 20px;
            }

            .promo-content {
                max-width: 100%;
            }

            .promo-title {
                font-size: 24px;
                margin-bottom: 10px;
            }

            .promo-features {
                display: none;
            }

            .form-panel {
                padding: 25px;
            }

            .form-wrapper {
                max-width: 100%;
            }

            .top-bar-container {
                padding: 0 20px;
            }

            .contact-info {
                gap: 10px;
            }

            .contact-item {
                font-size: 11px;
                padding: 4px 8px;
            }

            .social-icon {
                width: 26px;
                height: 26px;
            }
        }

        @media (max-width: 480px) {
            .login-main-container {
                margin: 15px;
                width: calc(100% - 30px);
            }

            .promo-panel {
                min-height: 150px;
            }

            .promo-title {
                font-size: 20px;
            }

            .promo-subtitle {
                font-size: 12px;
                padding: 8px;
                margin-top: 10px;
            }

            .form-panel {
                padding: 20px;
            }

            .form-logo-text {
                font-size: 18px;
            }

            .form-title {
                font-size: 22px;
            }

            .form-subtitle {
                font-size: 12px;
            }

            .top-bar-container {
                flex-direction: column;
                gap: 10px;
                padding: 10px 15px;
            }

            .contact-info {
                flex-direction: column;
                align-items: center;
                width: 100%;
                gap: 8px;
            }

            .contact-item {
                width: 100%;
                justify-content: center;
                font-size: 12px;
            }

            .social-links {
                margin-top: 5px;
            }

            .social-login {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <header class="top-bar">
        <div class="top-bar-container">
            <div class="contact-info">
                <a href="tel:(414) 857 - 0107" class="contact-item">
                    <i class="fas fa-phone"></i>
                    <span>(414) 857 - 0107</span>
                </a>
                <a href="mailto:dimsumtime.id@gmail.com" class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <span>dimsumtime.id@gmail.com</span>
                </a>
            </div>
            <div class="social-links">
                <a href="#" class="social-icon">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="social-icon">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="social-icon">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="social-icon">
                    <i class="fab fa-whatsapp"></i>
                </a>
            </div>
        </div>
    </header>

    <main class="login-main-container">
        <section class="promo-panel">
            <div class="promo-content">
                <h1 class="promo-title">Selamat Datang Kembali</h1>
                <div class="promo-subtitle">
                    Masuk untuk akses semua fitur dan penawaran spesial kami.
                </div>
                <div class="promo-features">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <span>Gratis ongkir jika Pembelian di atas 100.000</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <span>Proses order lebih cepat</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-history"></i>
                        </div>
                        <span>Riwayat pemesanan lengkap</span>
                    </div>
    </div>
    </div>
        </section>

        <section class="form-panel">
            <div class="form-wrapper">
                <div class="form-header">
                    <div class="form-logo">
                        <img src="{{ asset('images/21aa72030e155c4f9f34f27101287b6f2a7240e4.png') }}" alt="Logo" class="form-logo-icon" onerror="this.src='{{ asset('images/logo-placeholder.png') }}'">
                        <span class="form-logo-text">DIMSUM TIME</span>
                    </div>
                    <h2 class="form-title">Masuk</h2>
                    <p class="form-subtitle">
                        Gunakan email dan password akun Anda
                    </p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="login-form" method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="form-group @error('email') error @enderror">
                        <label for="email">
                            <i class="fas fa-envelope"></i> Email
                        </label>
                        <div class="input-wrapper">
                            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required>
                            <span class="input-icon"><i class="fas fa-user"></i></span>
                        </div>
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group @error('password') error @enderror">
                        <label for="password">
                            <i class="fas fa-lock"></i> Password
                        </label>
                        <div class="input-wrapper">
                            <input type="password" id="password" name="password" placeholder="••••••••" required>
                            <span class="input-icon"><i class="fas fa-key"></i></span>
                            <button type="button" class="toggle-password" id="togglePassword">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                        <div class="password-actions">
                            <div class="remember-me">
                                <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember">Ingat saya</label>
                            </div>
                            <a href="#" class="forgot-password">Lupa password?</a>
                        </div>
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="submit-button">
                        <i class="fas fa-sign-in-alt"></i> Masuk
                    </button>

                    <div class="signup-prompt">
                    <p>Belum punya akun?
                        <a href="{{ route('register') }}" class="signup-link">Daftar di sini</a>
                    </p>
                </div>
            </div>
                </form>

                
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Toggle password visibility
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function () {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    const icon = this.querySelector('i');
                    icon.classList.toggle('fa-eye');
                    icon.classList.toggle('fa-eye-slash');
                });
            }

            // Social login buttons
            document.querySelectorAll('.social-login-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    alert(`Login dengan ${this.textContent.trim()} sedang dalam pengembangan.`);
                });
            });

            // Forgot password
            const forgotPassword = document.querySelector('.forgot-password');
            if (forgotPassword) {
                forgotPassword.addEventListener('click', function (e) {
                    e.preventDefault();
                    alert('Fitur reset password akan dikirim ke email terdaftar.');
                });
            }
        });
    </script>
</body>
</html>