<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dimsum Time - Tentang Kami</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Baloo&family=Baloo+2:wght@600&family=DM+Sans:wght@400;500;700&family=Fredoka:wght@500&family=Nunito:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary-red: #e53935;
      --primary-yellow: #fbc02d;
      --primary-orange: #ff9800;
      --text-dark: #2c2f24;
      --text-medium: #414536;
      --text-light: #adb29e;
      --text-white: #f9f9f7;
      --bg-main: #fff3e0;
      --bg-card: #f9f9f7;
      --bg-footer: #5c4033;
      --border-light: #dbdfd0;
      --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      --shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.12);
    }
  
    body {
      margin: 0;
      font-family: 'DM Sans', sans-serif;
      background-color: var(--bg-main);
      color: var(--text-dark);
      overflow-x: hidden;
      line-height: 1.6;
    }
  
    * {
      box-sizing: border-box;
    }
  
    .container {
      width: 100%;
      max-width: 1200px;
      margin-left: auto;
      margin-right: auto;
      padding-left: 24px;
      padding-right: 24px;
    }
  
    a {
      text-decoration: none;
      color: inherit;
      transition: all 0.3s ease;
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
  
    h1, h2, h3, h4, h5, h6, p {
      margin: 0;
    }
    
    /* Animations */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    @keyframes float {
      0%, 100% {
        transform: translateY(0);
      }
      50% {
        transform: translateY(-10px);
      }
    }
    
    .animate-on-scroll {
      opacity: 0;
      transform: translateY(20px);
      transition: opacity 0.6s ease, transform 0.6s ease;
    }
    
    .animate-on-scroll.visible {
      opacity: 1;
      transform: translateY(0);
    }
    
    /* Header Styles */
    .dimsum-header {
      background: white;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
  
    .dimsum-top-bar {
      background: linear-gradient(135deg, var(--primary-red) 0%, #c62828 100%);
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
      border-bottom: 1px solid var(--border-light);
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
      color: var(--primary-red);
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
      color: var(--primary-red);
    }
  
    .dimsum-nav-links a.active::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      height: 2px;
      background: var(--primary-red);
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
      background: var(--primary-red);
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
      background: var(--border-light);
      margin: 8px 0;
    }
    
    /* About Section */
    .about-section {
      padding: 100px 0;
      background: linear-gradient(135deg, #fff8f1 0%, #fff3e0 100%);
      position: relative;
      overflow: hidden;
    }
    
    .about-section::before {
      content: '';
      position: absolute;
      top: -50%;
      right: -20%;
      width: 500px;
      height: 500px;
      background: radial-gradient(circle, rgba(251, 192, 45, 0.1) 0%, rgba(251, 192, 45, 0) 70%);
      z-index: 0;
    }
    
    .about-container {
      display: flex;
      align-items: center;
      gap: 60px;
      position: relative;
      z-index: 1;
    }
    
    .about-image-wrapper {
      flex: 1;
      position: relative;
      animation: float 3s ease-in-out infinite;
    }
    
    .about-image-frame {
      background: linear-gradient(145deg, #ffffff, #f0f0f0);
      border-radius: 20px;
      padding: 20px;
      box-shadow: var(--shadow);
      border: 8px solid white;
      position: relative;
      overflow: hidden;
      transition: transform 0.5s ease, box-shadow 0.5s ease;
    }
    
    .about-image-frame:hover {
      transform: translateY(-10px) rotate(2deg);
      box-shadow: var(--shadow-hover);
    }
    
    .about-image-frame::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
      transform: rotate(45deg);
      transition: transform 0.6s ease;
    }
    
    .about-image-frame:hover::before {
      transform: rotate(45deg) translate(50%, 50%);
    }
    
    .about-image {
      width: 100%;
      border-radius: 12px;
      transition: transform 0.5s ease;
    }
    
    .about-image-frame:hover .about-image {
      transform: scale(1.05);
    }
    
    .about-content {
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 30px;
      padding: 20px;
    }
    
    .about-title {
      font-family: 'Fredoka', sans-serif;
      font-weight: 600;
      font-size: 48px;
      line-height: 1.2;
      color: var(--text-dark);
      position: relative;
      padding-bottom: 15px;
    }
    
    .about-title::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 80px;
      height: 4px;
      background: linear-gradient(90deg, var(--primary-red), var(--primary-orange));
      border-radius: 2px;
    }
    
    .about-description {
      font-family: 'Nunito', sans-serif;
      font-weight: 500;
      font-size: 18px;
      line-height: 1.7;
      color: var(--text-dark);
      background: rgba(255, 255, 255, 0.7);
      padding: 25px;
      border-radius: 15px;
      border-left: 5px solid var(--primary-orange);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .about-description-secondary {
      font-family: 'Nunito', sans-serif;
      font-weight: 400;
      font-size: 16px;
      line-height: 1.8;
      color: var(--text-medium);
      background: rgba(255, 255, 255, 0.7);
      padding: 25px;
      border-radius: 15px;
      border-left: 5px solid var(--primary-yellow);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .about-stats {
      display: flex;
      gap: 30px;
      margin-top: 20px;
      flex-wrap: wrap;
    }
    
    .stat-item {
      text-align: center;
      flex: 1;
      min-width: 120px;
    }
    
    .stat-number {
      font-family: 'Baloo', cursive;
      font-size: 42px;
      font-weight: 700;
      color: var(--primary-red);
      line-height: 1;
      margin-bottom: 5px;
    }
    
    .stat-label {
      font-size: 14px;
      color: var(--text-medium);
      font-weight: 500;
    }
    
    /* Testimonials Section */
    .testimonials-section {
      background: linear-gradient(135deg, #f9f9f7 0%, #f5f5f2 100%);
      padding: 100px 0;
      position: relative;
      overflow: hidden;
    }
    
    .testimonials-section::before {
      content: '';
      position: absolute;
      bottom: -100px;
      left: -100px;
      width: 300px;
      height: 300px;
      background: radial-gradient(circle, rgba(229, 57, 53, 0.1) 0%, rgba(229, 57, 53, 0) 70%);
      z-index: 0;
    }
    
    .testimonials-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 50px;
      position: relative;
      z-index: 1;
    }
    
    .testimonials-title {
      font-family: 'Baloo', cursive;
      font-weight: 600;
      font-size: 48px;
      line-height: 1.1;
      color: var(--text-dark);
      text-align: center;
      position: relative;
      padding-bottom: 20px;
    }
    
    .testimonials-title::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 100px;
      height: 4px;
      background: linear-gradient(90deg, var(--primary-orange), var(--primary-yellow));
      border-radius: 2px;
    }
    
    .testimonials-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 30px;
      width: 100%;
    }
    
    .testimonial-card {
      background-color: white;
      border-radius: 20px;
      padding: 40px 35px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      gap: 30px;
      box-shadow: var(--shadow);
      transition: all 0.4s ease;
      border: 1px solid rgba(0, 0, 0, 0.05);
      position: relative;
      overflow: hidden;
    }
    
    .testimonial-card:hover {
      transform: translateY(-15px);
      box-shadow: var(--shadow-hover);
      border-color: rgba(255, 152, 0, 0.2);
    }
    
    .testimonial-card::before {
      content: '❝';
      position: absolute;
      top: 20px;
      right: 25px;
      font-size: 60px;
      color: rgba(255, 152, 0, 0.1);
      font-family: serif;
      line-height: 1;
    }
    
    .testimonial-content {
      display: flex;
      flex-direction: column;
      gap: 25px;
    }
    
    .testimonial-quote {
      font-family: 'DM Sans', sans-serif;
      font-weight: 700;
      font-size: 24px;
      line-height: 1.3;
      color: var(--primary-red);
      letter-spacing: -0.5px;
    }
    
    .testimonial-text {
      font-family: 'DM Sans', sans-serif;
      font-weight: 400;
      font-size: 16px;
      line-height: 1.8;
      color: var(--text-medium);
    }
    
    .testimonial-divider {
      border: none;
      height: 1px;
      background: linear-gradient(90deg, transparent, var(--border-light), transparent);
      margin: 10px 0;
    }
    
    .testimonial-user {
      display: flex;
      align-items: center;
      gap: 20px;
    }
    
    .user-avatar {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid white;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }
    
    .testimonial-card:hover .user-avatar {
      transform: scale(1.1);
    }
    
    .user-info {
      display: flex;
      flex-direction: column;
      gap: 5px;
    }
    
    .user-name {
      font-weight: 700;
      font-size: 18px;
      color: var(--text-dark);
    }
    
    .user-location {
      font-weight: 400;
      font-size: 14px;
      color: var(--text-light);
      display: flex;
      align-items: center;
      gap: 5px;
    }
    
    .user-location::before {
      content: '📍';
      font-size: 12px;
    }
    
    .rating {
      display: flex;
      gap: 5px;
      margin-top: 5px;
    }
    
    .rating i {
      color: var(--primary-yellow);
      font-size: 14px;
    }
    
    /* CTA Section */
    .cta-section {
      padding: 80px 0;
      background: linear-gradient(135deg, var(--primary-red), var(--primary-orange));
      color: white;
      text-align: center;
      position: relative;
      overflow: hidden;
    }
    
    .cta-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none"><path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="%23ffffff"/></svg>');
      background-size: 100% 100px;
      background-position: bottom;
      background-repeat: no-repeat;
    }
    
    .cta-content {
      max-width: 700px;
      margin: 0 auto;
      position: relative;
      z-index: 1;
    }
    
    .cta-title {
      font-family: 'Fredoka', sans-serif;
      font-size: 42px;
      margin-bottom: 20px;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
    
    .cta-text {
      font-size: 18px;
      margin-bottom: 30px;
      opacity: 0.9;
    }
    
    .cta-buttons {
      display: flex;
      gap: 20px;
      justify-content: center;
      flex-wrap: wrap;
    }
    
    .cta-button {
      padding: 16px 32px;
      border-radius: 50px;
      font-weight: 600;
      font-size: 16px;
      cursor: pointer;
      transition: all 0.3s ease;
      border: none;
      font-family: 'DM Sans', sans-serif;
      min-width: 180px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }
    
    .cta-button-primary {
      background-color: white;
      color: var(--primary-red);
    }
    
    .cta-button-primary:hover {
      background-color: #f0f0f0;
      transform: translateY(-3px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }
    
    .cta-button-secondary {
      background-color: transparent;
      color: white;
      border: 2px solid white;
    }
    
    .cta-button-secondary:hover {
      background-color: white;
      color: var(--primary-red);
      transform: translateY(-3px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }
    
    /* Footer Styles */
    .dimsum-footer {
      background-color: var(--bg-footer);
      color: var(--text-white);
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
      color: var(--text-light);
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
      color: var(--text-white);
      transition: color 0.3s ease;
    }

    .dimsum-footer-links a:hover {
      color: var(--primary-yellow);
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
      color: var(--text-light);
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
      background: var(--primary-red);
      transform: translateY(-3px);
    }
    
    /* Responsive Styles */
    @media (max-width: 1200px) {
      .dimsum-footer-top {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 992px) {
      .about-container {
        flex-direction: column;
        text-align: center;
        gap: 50px;
      }
      
      .about-content {
        align-items: center;
      }
      
      .about-title::after {
        left: 50%;
        transform: translateX(-50%);
      }
      
      .about-stats {
        justify-content: center;
      }
      
      .testimonials-grid {
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
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
    }
    
    @media (max-width: 768px) {
      .about-section,
      .testimonials-section {
        padding: 60px 0;
      }
      
      .about-title,
      .testimonials-title {
        font-size: 36px;
      }
      
      .about-description {
        font-size: 16px;
      }
      
      .stat-number {
        font-size: 36px;
      }
      
      .testimonial-card {
        padding: 30px 25px;
      }
      
      .cta-title {
        font-size: 32px;
      }
      
      .cta-buttons {
        flex-direction: column;
        align-items: center;
      }
      
      .cta-button {
        width: 100%;
        max-width: 300px;
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

      .container {
        padding-left: 16px;
        padding-right: 16px;
      }
    }
    
    @media (max-width: 480px) {
      .about-title,
      .testimonials-title {
        font-size: 28px;
      }
      
      .about-description,
      .about-description-secondary {
        padding: 20px;
      }
      
      .testimonial-card {
        padding: 25px 20px;
      }
      
      .cta-title {
        font-size: 28px;
      }

      .dimsum-nav-links {
        flex-direction: column;
        align-items: center;
        gap: 10px;
      }

      .dimsum-header-actions {
        flex-wrap: wrap;
        justify-content: center;
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
            <li><a href="{{ route('home') }}">Beranda</a></li>
            <li><a href="{{ route('tentang') }}" class="active">Tentang</a></li>
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

  <main>
    <section id="about" class="about-section">
      <div class="container about-container">
        <div class="about-image-wrapper animate-on-scroll">
          <div class="about-image-frame">
            <img src="{{ asset('images/ea100a0f426f4a6b916df29cb8be0da8e23645df.png') }}" alt="Dimsum lezat" class="about-image" onerror="this.src='https://images.unsplash.com/photo-1563245372-f21724e3856d?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'">
          </div>
        </div>
        <div class="about-content animate-on-scroll">
          <h2 class="about-title">Kami menghadirkan kelezatan setiap gigitan.</h2>
          <p class="about-description">Dimsum Time adalah brand yang berfokus menghadirkan dimsum lezat, praktis, dan berkualitas untuk dinikmati kapan pun dan di mana pun. Setiap dimsum kami dibuat dari bahan-bahan segar pilihan dengan cita rasa autentik khas Asia yang disukai semua kalangan.</p>
          <p class="about-description-secondary">Kami percaya bahwa menikmati dimsum tak harus menunggu waktu khusus cukup hangatkan, santap, dan rasakan kelezatan yang membuat harimu lebih istimewa. Dengan beragam varian rasa dan kemasan yang praktis, Dimsum Time siap jadi teman di setiap momenmu.</p>
          
          <div class="about-stats">
            <div class="stat-item">
              <div class="stat-number">10K+</div>
              <div class="stat-label">Pelanggan Puas</div>
            </div>
            <div class="stat-item">
              <div class="stat-number">50+</div>
              <div class="stat-label">Varian Rasa</div>
            </div>
            <div class="stat-item">
              <div class="stat-number">100%</div>
              <div class="stat-label">Bahan Segar</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="testimonials" class="testimonials-section">
      <div class="container testimonials-container">
        <h2 class="testimonials-title animate-on-scroll">APA KATA PELANGGAN KAMI?</h2>
        <div class="testimonials-grid">
          <div class="testimonial-card animate-on-scroll">
            <div class="testimonial-content">
              <h3 class="testimonial-quote">"Creamy Banget"</h3>
              <p class="testimonial-text">Nggak nyangka topping saos mentainya beneran creamy dan gurih. Pas banget buat yang suka rasa pedas manis. Langsung jadi menu favorit tiap kali ngemil sore!</p>
            </div>
            <hr class="testimonial-divider">
            <div class="testimonial-user">
              <img src="{{ asset('images/438_1666.svg') }}" alt="Avatar of Rani Oktaviani" class="user-avatar" onerror="this.src='https://ui-avatars.com/api/?name=Rani+Oktaviani&background=e53935&color=fff'">
              <div class="user-info">
                <p class="user-name">Rani Oktaviani</p>
                <p class="user-location">Depok, Jawa Barat</p>
                <div class="rating">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                </div>
              </div>
            </div>
          </div>
          
          <div class="testimonial-card animate-on-scroll">
            <div class="testimonial-content">
              <h3 class="testimonial-quote">"Juicy Parah"</h3>
              <p class="testimonial-text">Gyoza udang kulitnya tipis, isi udangnya berasa banget, dan teksturnya lembut waktu dikunyah. Disajikan panas-panas, rasanya mirip di resto Jepang.</p>
            </div>
            <hr class="testimonial-divider">
            <div class="testimonial-user">
              <img src="{{ asset('images/438_1678.svg') }}" alt="Avatar of Aditya Pramono" class="user-avatar" onerror="this.src='https://ui-avatars.com/api/?name=Aditya+Pramono&background=e53935&color=fff'">
              <div class="user-info">
                <p class="user-name">Aditya Pramono</p>
                <p class="user-location">Yogyakarta</p>
                <div class="rating">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
                </div>
              </div>
            </div>
          </div>
          
          <div class="testimonial-card animate-on-scroll">
            <div class="testimonial-content">
              <h3 class="testimonial-quote">"Ekado-nya Crunchy"</h3>
              <p class="testimonial-text">Suka banget sama Ekado dari Dimsum Time! Gurihnya pas, udangnya berasa, dan kulit tahunya garing tapi nggak keras. Anakku aja sampai rebutan.</p>
            </div>
            <hr class="testimonial-divider">
            <div class="testimonial-user">
              <img src="{{ asset('images/438_1690.svg') }}" alt="Avatar of Rika Santoso" class="user-avatar" onerror="this.src='https://ui-avatars.com/api/?name=Rika+Santoso&background=e53935&color=fff'">
              <div class="user-info">
                <p class="user-name">Rika Santoso</p>
                <p class="user-location">Bandung, Jawa Barat</p>
                <div class="rating">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
      <div class="container">
        <div class="cta-content animate-on-scroll">
          <h2 class="cta-title">Siap Menikmati Dimsum Terbaik?</h2>
          <p class="cta-text">Jangan lewatkan kesempatan untuk merasakan kelezatan dimsum autentik yang dibuat dengan bahan premium dan cinta. Pesan sekarang dan rasakan pengalaman kuliner yang tak terlupakan!</p>
          <div class="cta-buttons">
            <a href="{{ route('menu') }}" class="cta-button cta-button-primary">
              <i class="fas fa-utensils"></i> Jelajahi Menu
            </a>
            <a href="{{ route('kontak') }}" class="cta-button cta-button-secondary">
              <i class="fas fa-phone-alt"></i> Hubungi Kami
            </a>
          </div>
        </div>
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
            <img src="{{ asset('images/fb05b4fb74e829d3f6d99dffe090e08af8bcfb9f.png') }}" alt="Instagram post 1" onerror="this.src='https://images.unsplash.com/photo-1563245372-f21724e3856d?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80'">
            <img src="{{ asset('images/121c2dcceec8aa39a8b0c3768cde9c78f03c3ba6.png') }}" alt="Instagram post 2" onerror="this.src='https://images.unsplash.com/photo-1586190848861-99aa4a171e90?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80'">
            <img src="{{ asset('images/5078258e7740f3b78ef25ac57cef10d1e8426663.png') }}" alt="Instagram post 3" onerror="this.src='https://images.unsplash.com/photo-1563245372-f21724e3856d?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80'">
            <img src="{{ asset('images/372cef40f35f774bd9ba4110538c35c370a5762f.png') }}" alt="Instagram post 4" onerror="this.src='https://images.unsplash.com/photo-1586190848861-99aa4a171e90?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80'">
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
      // Animation on scroll
      const animateElements = document.querySelectorAll('.animate-on-scroll');
      
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            observer.unobserve(entry.target);
          }
        });
      }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
      });
      
      animateElements.forEach(element => {
        observer.observe(element);
      });

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
      
      // Hover effect for testimonial cards
      const testimonialCards = document.querySelectorAll('.testimonial-card');
      testimonialCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
          this.style.transform = 'translateY(-15px)';
        });
        
        card.addEventListener('mouseleave', function() {
          this.style.transform = 'translateY(0)';
        });
      });

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