<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - Dimsum Time</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Baloo+2:wght@600&family=Baloo&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- PHP Functions for Timeline -->
    @php
        // Fungsi untuk menghitung progress berdasarkan metode pengiriman
        function calculateProgress($order) {
            $progressMapDelivery = [
                'menunggu_pembayaran' => 0,
                'dikonfirmasi' => 25,
                'diproses' => 50,
                'diantar' => 75,
                'selesai' => 100,
                'dibatalkan' => 0
            ];
            
            $progressMapPickup = [
                'menunggu_pembayaran' => 0,
                'dikonfirmasi' => 25,
                'dimasak' => 50,
                'siap_diantar' => 75,
                'selesai' => 100,
                'dibatalkan' => 0
            ];
            
            if (($order->jenis_pengiriman ?? $order->metode_pengiriman ?? 'delivery') == 'pickup') {
                return $progressMapPickup[$order->status] ?? 0;
            }
            
            return $progressMapDelivery[$order->status] ?? 0;
        }

        // Fungsi untuk menentukan apakah step aktif
        function isStepActive($currentStatus, $stepStatus, $method = 'delivery') {
            // Urutan untuk delivery
            $statusOrderDelivery = [
                'menunggu_pembayaran' => 1,
                'dikonfirmasi' => 2,
                'diproses' => 3,
                'diantar' => 4,
                'selesai' => 5
            ];
            
            // Urutan untuk pickup
            $statusOrderPickup = [
                'menunggu_pembayaran' => 1,
                'dikonfirmasi' => 2,
                'dimasak' => 3,
                'siap_diantar' => 4,
                'selesai' => 5
            ];
            
            if ($method == 'pickup') {
                return ($statusOrderPickup[$currentStatus] ?? 0) == ($statusOrderPickup[$stepStatus] ?? 0);
            }
            
            return ($statusOrderDelivery[$currentStatus] ?? 0) == ($statusOrderDelivery[$stepStatus] ?? 0);
        }

        // Fungsi untuk menentukan apakah step sudah selesai
        function isStepCompleted($currentStatus, $stepStatus, $method = 'delivery') {
            // Urutan untuk delivery
            $statusOrderDelivery = [
                'menunggu_pembayaran' => 1,
                'dikonfirmasi' => 2,
                'diproses' => 3,
                'diantar' => 4,
                'selesai' => 5
            ];
            
            // Urutan untuk pickup
            $statusOrderPickup = [
                'menunggu_pembayaran' => 1,
                'dikonfirmasi' => 2,
                'dimasak' => 3,
                'siap_diantar' => 4,
                'selesai' => 5
            ];
            
            if ($method == 'pickup') {
                return ($statusOrderPickup[$currentStatus] ?? 0) > ($statusOrderPickup[$stepStatus] ?? 0);
            }
            
            return ($statusOrderDelivery[$currentStatus] ?? 0) > ($statusOrderDelivery[$stepStatus] ?? 0);
        }
    @endphp
    
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
            --delivery-color: #4caf50;
            --pickup-color: #2196f3;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'DM Sans', sans-serif;
            background-color: #f8f9fa;
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

        /* Orders Page Styles */
        .orders-section {
            padding: 30px 0 60px;
            background: linear-gradient(to bottom, #fff9f0, #fff);
            min-height: calc(100vh - 180px);
        }

        .orders-title {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 15px;
        }

        .orders-title h1 {
            font-family: 'Baloo', cursive;
            font-size: 40px;
            line-height: 1.2;
            color: var(--text-dark);
            margin: 0 0 10px 0;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.08);
        }

        .orders-title p {
            font-size: 16px;
            color: var(--text-muted);
            margin: 0;
            max-width: 500px;
            margin: 0 auto;
        }

        .orders-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--primary-color);
            border-radius: 2px;
        }

        /* Tabs alternatif - lebih modern */
.orders-tabs {
    display: flex;
    gap: 1px;
    margin-bottom: 25px;
    background: #f8f9fa;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    border: 1px solid #dee2e6;
}

.orders-tab {
    padding: 10px 15px;
    background: white;
    border: none;
    font-size: 13px;
    font-weight: 500;
    color: #495057;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 1;
    min-width: 0;
    border-right: 1px solid #f1f3f5;
    height: 40px;
}

.orders-tab:last-child {
    border-right: none;
}

.orders-tab:hover {
    color: #e53935;
    background: #fff5f5;
}

.orders-tab.active {
    color: white;
    background: linear-gradient(135deg, #e53935, #d32f2f);
    font-weight: 600;
    box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
}

.badge-count {
    background: #e9ecef;
    color: #495057;
    border-radius: 10px;
    padding: 2px 6px;
    font-size: 11px;
    margin-left: 6px;
    display: inline-block;
    min-width: 20px;
    text-align: center;
    font-weight: 600;
}

.orders-tab:hover .badge-count {
    background: #dee2e6;
}

.orders-tab.active .badge-count {
    background: rgba(255, 255, 255, 0.3);
    color: white;
}
        /* Orders List - PERBAIKAN UTAMA */
        .orders-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            max-width: 900px;
            margin: 0 auto;
            padding: 0 10px;
        }

        .no-orders {
            text-align: center;
            padding: 50px 20px;
            background: white;
            border-radius: 14px;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.08);
            margin-top: 20px;
            transform: translateY(0);
            transition: transform 0.3s ease;
        }

        .no-orders:hover {
            transform: translateY(-3px);
        }

        .no-orders-icon {
            font-size: 70px;
            color: #ffd54f;
            margin-bottom: 15px;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        .no-orders h3 {
            font-size: 24px;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .no-orders p {
            color: var(--text-muted);
            margin-bottom: 25px;
            font-size: 15px;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: linear-gradient(135deg, var(--primary-color), #c62828);
            color: white;
            padding: 12px 28px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 3px 12px rgba(229, 57, 53, 0.25);
            min-height: 44px;
            min-width: 140px;
            text-align: center;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(229, 57, 53, 0.35);
        }

        /* Order Card - PERBAIKAN UTAMA (Kotak lebih kecil) */
        .order-card {
            background: white;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            border: 1px solid rgba(0,0,0,0.03);
            max-width: 100%;
            margin: 0 auto;
        }

        .order-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
        }

        .order-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            opacity: 0.8;
        }

        .order-card-header {
            padding: 18px 20px;
            background: linear-gradient(135deg, #f9f9f9, #ffffff);
            border-bottom: 1px solid rgba(0,0,0,0.04);
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 12px;
            position: relative;
        }

        .order-info {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .order-number {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .order-number::before {
            content: '📦';
            font-size: 16px;
        }

        .order-date {
            font-size: 13px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .order-date::before {
            content: '📅';
            font-size: 11px;
        }

        .order-method {
            font-size: 13px;
            padding: 3px 10px;
            border-radius: 16px;
            font-weight: 600;
            margin-left: 8px;
        }

        .method-delivery {
            background: rgba(76, 175, 80, 0.1);
            color: var(--delivery-color);
            border: 1px solid rgba(76, 175, 80, 0.2);
        }

        .method-pickup {
            background: rgba(33, 150, 243, 0.1);
            color: var(--pickup-color);
            border: 1px solid rgba(33, 150, 243, 0.2);
        }

        .order-status {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 5px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }

        .status-icon {
            font-size: 12px;
        }

        .status-menunggu {
            background: linear-gradient(135deg, #ffecb5, #ffd54f);
            color: #7a6b0d;
        }

        .status-dikonfirmasi {
            background: linear-gradient(135deg, #b3e5fc, #4fc3f7);
            color: #0d47a1;
        }

        .status-diproses {
            background: linear-gradient(135deg, #c8e6c9, #81c784);
            color: #1b5e20;
        }

        .status-dimasak {
            background: linear-gradient(135deg, #ffccbc, #ff8a65);
            color: #bf360c;
        }

        .status-siap {
            background: linear-gradient(135deg, #fff9c4, #fff176);
            color: #f57f17;
        }

        .status-diantar {
            background: linear-gradient(135deg, #d1c4e9, #9575cd);
            color: #311b92;
        }

        .status-selesai {
            background: linear-gradient(135deg, #c8e6c9, #66bb6a);
            color: #1b5e20;
            box-shadow: 0 3px 12px rgba(102, 187, 106, 0.25);
        }

        .status-dibatalkan {
            background: linear-gradient(135deg, #ffcdd2, #ef5350);
            color: #b71c1c;
        }

        .order-card-body {
            padding: 20px;
            max-height: 500px;
            overflow-y: auto;
        }

        .order-card-body::-webkit-scrollbar {
            width: 5px;
        }

        .order-card-body::-webkit-scrollbar-track {
            background: #f8f8f8;
            border-radius: 3px;
        }

        .order-card-body::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 3px;
        }

        .order-items {
            margin-bottom: 20px;
            max-height: 250px;
            overflow-y: auto;
        }

        .order-items::-webkit-scrollbar {
            width: 4px;
        }

        .order-items::-webkit-scrollbar-track {
            background: #f5f5f5;
        }

        .order-items::-webkit-scrollbar-thumb {
            background: #e0e0e0;
            border-radius: 2px;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid rgba(0,0,0,0.03);
            transition: background-color 0.2s ease;
        }

        .order-item:hover {
            background: rgba(0,0,0,0.01);
            border-radius: 6px;
            padding: 10px 12px;
            margin: 0 -12px;
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .order-item-info {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .item-image {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            overflow: hidden;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .item-details {
            flex: 1;
            min-width: 0;
        }

        .order-item-name {
            font-weight: 600;
            margin-bottom: 3px;
            color: var(--text-dark);
            font-size: 14px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .order-item-details {
            font-size: 12px;
            color: var(--text-muted);
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .order-item-qty {
            font-size: 13px;
            color: var(--text-muted);
            background: #f5f5f5;
            padding: 3px 10px;
            border-radius: 16px;
            font-weight: 600;
            white-space: nowrap;
        }

        .order-item-price {
            font-weight: 700;
            color: var(--text-dark);
            min-width: 90px;
            text-align: right;
            font-size: 15px;
            white-space: nowrap;
        }

        .order-summary {
            border-top: 2px solid rgba(0,0,0,0.03);
            padding-top: 18px;
            background: #fafafa;
            border-radius: 8px;
            padding: 16px;
            margin-top: 8px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 1px dashed rgba(0,0,0,0.08);
        }

        .summary-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .summary-label {
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
        }

        .summary-value {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 14px;
        }

        .summary-total {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary-color);
            padding-top: 10px;
            margin-top: 6px;
            border-top: 2px solid rgba(0,0,0,0.08);
        }

        /* Order Timeline */
        .order-timeline {
            margin-top: 20px;
            padding: 16px;
            background: linear-gradient(135deg, #f9f9f9, #ffffff);
            border-radius: 10px;
            border: 1px solid rgba(0,0,0,0.03);
            position: relative;
        }

        .timeline-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(0,0,0,0.03);
        }

        .timeline-title {
            font-weight: 700;
            font-size: 15px;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .timeline-icon {
            font-size: 18px;
        }

        .timeline-percentage {
            font-size: 24px;
            font-weight: 800;
            color: var(--primary-color);
            text-shadow: 1px 1px 3px rgba(0,0,0,0.1);
        }

        .timeline-container {
            position: relative;
            padding: 15px 0;
        }

        .timeline-progress {
            height: 6px;
            background: #e8e8e8;
            border-radius: 3px;
            position: relative;
            margin: 15px 0 35px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            position: absolute;
            left: 0;
            top: 0;
            border-radius: 3px;
            transition: width 1s ease;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }

        .timeline-steps {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin-top: -28px;
        }

        .timeline-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
            width: 20%;
        }

        .step-icon {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            margin-bottom: 8px;
            border: 3px solid #e0e0e0;
            transition: all 0.3s ease;
            box-shadow: 0 3px 8px rgba(0,0,0,0.08);
        }

        .step-label {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-muted);
            text-align: center;
            max-width: 70px;
            line-height: 1.3;
        }

        .step-active .step-icon {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
            transform: scale(1.1);
            box-shadow: 0 5px 12px rgba(229, 57, 53, 0.25);
        }

        .step-active .step-label {
            color: var(--primary-color);
            font-weight: 700;
        }

        .step-completed .step-icon {
            background: #4caf50;
            color: white;
            border-color: #4caf50;
        }

        .step-completed .step-label {
            color: #4caf50;
        }

        .timeline-status-info {
            text-align: center;
            margin-top: 20px;
            padding: 12px;
            background: linear-gradient(135deg, #fff3e0, #ffe0b2);
            border-radius: 8px;
            border-left: 3px solid var(--secondary-color);
        }

        .status-message {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .status-estimasi {
            font-size: 12px;
            color: var(--text-muted);
        }

        /* PERBAIKAN UTAMA: Footer dengan tombol yang lebih baik */
        .order-card-footer {
            padding: 18px 20px;
            background: linear-gradient(135deg, #f9f9f9, #ffffff);
            border-top: 1px solid rgba(0,0,0,0.04);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .customer-info {
            display: flex;
            flex-direction: column;
            gap: 6px;
            flex: 1;
            min-width: 200px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--text-dark);
        }

        .info-icon {
            color: var(--primary-color);
            width: 16px;
            text-align: center;
            flex-shrink: 0;
        }

        /* PERBAIKAN UTAMA: Tombol-tombol agar tidak menyatu dengan teks */
        .order-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
            justify-content: flex-end;
        }

        /* Style untuk semua tombol */
        .btn-secondary,
        .btn-danger,
        .btn-primary {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 8px !important;
            padding: 10px 20px !important;
            border-radius: 8px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            min-height: 40px !important;
            min-width: 110px !important;
            text-align: center !important;
            border: none !important;
            position: relative !important;
            overflow: hidden !important;
            white-space: nowrap !important;
            line-height: 1.2 !important;
            box-sizing: border-box !important;
        }

        /* Tambahkan efek hover yang lebih baik */
        .btn-secondary::before,
        .btn-danger::before,
        .btn-primary::before {
            content: '' !important;
            position: absolute !important;
            top: 0 !important;
            left: -100% !important;
            width: 100% !important;
            height: 100% !important;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent) !important;
            transition: 0.5s !important;
        }

        .btn-secondary:hover::before,
        .btn-danger:hover::before,
        .btn-primary:hover::before {
            left: 100% !important;
        }

        /* Style untuk tombol secondary */
        .btn-secondary {
            background: white !important;
            border: 2px solid var(--border-color) !important;
            color: var(--text-dark) !important;
        }

        .btn-secondary:hover {
            background: #f8f8f8 !important;
            border-color: var(--primary-color) !important;
            color: var(--primary-color) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 3px 10px rgba(229, 57, 53, 0.15) !important;
        }

        /* Style untuk tombol danger */
        .btn-danger {
            background: linear-gradient(135deg, #ff5252, #d32f2f) !important;
            color: white !important;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #ff6b6b, #e53935) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 3px 12px rgba(211, 47, 47, 0.25) !important;
        }

        /* Style untuk tombol primary */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), #c62828) !important;
            color: white !important;
            box-shadow: 0 3px 10px rgba(229, 57, 53, 0.25) !important;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #ef5350, #b71c1c) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(229, 57, 53, 0.3) !important;
        }

        /* Loading Spinner */
        .loading-spinner {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.92);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(4px);
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Alert Messages */
        .alert {
            padding: 14px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideIn 0.4s ease;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
        }

        @keyframes slideIn {
            from { transform: translateY(-15px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
            border-left: 3px solid #28a745;
        }

        .alert-error {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
            border-left: 3px solid #dc3545;
        }

        /* Footer Styles */
        .dimsum-footer {
            background: linear-gradient(135deg, var(--bg-dark), #3e2723);
            color: var(--text-footer);
            padding: 50px 0 25px;
            margin-top: 50px;
        }

        .dimsum-footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .dimsum-footer-top {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 35px;
            margin-bottom: 35px;
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
            gap: 16px;
        }

        .dimsum-footer-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            font-weight: 700;
            font-size: 22px;
        }

        .dimsum-footer-description {
            color: var(--text-footer-muted);
            line-height: 1.6;
            font-size: 14px;
        }

        .dimsum-footer-heading {
            color: white;
            font-size: 16px;
            margin-bottom: 12px;
            position: relative;
            padding-bottom: 8px;
        }

        .dimsum-footer-heading::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 35px;
            height: 2px;
            background: var(--primary-color);
        }

        .dimsum-footer-links {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .dimsum-footer-links a {
            color: var(--text-footer);
            transition: all 0.3s ease;
            padding: 3px 0;
            position: relative;
            padding-left: 0;
            font-size: 14px;
        }

        .dimsum-footer-links a:hover {
            color: white;
            padding-left: 8px;
        }

        .dimsum-footer-links a:hover::before {
            content: '›';
            position: absolute;
            left: 0;
        }

        .dimsum-instagram-gallery {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }

        .dimsum-instagram-gallery img {
            width: 100%;
            height: 90px;
            object-fit: cover;
            border-radius: 6px;
            transition: transform 0.3s ease;
        }

        .dimsum-instagram-gallery img:hover {
            transform: scale(1.05);
        }

        .dimsum-footer-bottom {
            display: flex;
            flex-direction: column;
            gap: 18px;
            justify-content: space-between;
            align-items: center;
            padding-top: 25px;
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
            font-size: 13px;
        }

        .dimsum-payment-methods {
            display: flex;
            align-items: center;
            gap: 8px;
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
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 11px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .dimsum-payment-icon:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 6px rgba(0,0,0,0.15);
        }

        .dimsum-footer-socials {
            display: flex;
            gap: 8px;
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
            transform: translateY(-2px) rotate(360deg);
        }

        /* Responsive Improvements */
        @media (max-width: 768px) {
            .orders-section {
                padding: 20px 0 40px;
            }
            
            .orders-title h1 {
                font-size: 32px;
            }
            
            .orders-title p {
                font-size: 15px;
            }
            
            .orders-tabs {
                font-size: 13px;
            }
            
            .orders-tab {
                padding: 8px 14px;
            }
            
            .badge-count {
                font-size: 10px;
                padding: 1px 5px;
                min-width: 20px;
            }
            
            .orders-container {
                gap: 15px;
                padding: 0 5px;
            }
            
            .order-card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .order-status {
                align-self: flex-start;
            }
            
            .order-card-footer {
                flex-direction: column;
                align-items: stretch;
                gap: 15px;
            }
            
            .customer-info {
                min-width: 100%;
            }
            
            .order-actions {
                width: 100%;
                justify-content: stretch;
            }
            
            .btn-secondary,
            .btn-danger,
            .btn-primary {
                flex: 1;
                min-width: 0;
            }
            
            .timeline-steps {
                overflow-x: auto;
                padding-bottom: 10px;
            }
            
            .timeline-step {
                min-width: 70px;
            }
            
            .step-label {
                font-size: 10px;
            }
            
            .item-image {
                width: 45px;
                height: 45px;
            }
        }

        @media (max-width: 480px) {
            .orders-title h1 {
                font-size: 26px;
            }
            
            .orders-title p {
                font-size: 14px;
            }
            
            .orders-tab {
                padding: 7px 12px;
                font-size: 12px;
            }
            
            .order-item-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
            
            .order-item {
                flex-direction: column;
                align-items: stretch;
                gap: 8px;
            }
            
            .order-item-price {
                text-align: left;
                align-self: flex-start;
            }
            
            .timeline-step {
                min-width: 65px;
            }
            
            .step-icon {
                width: 40px;
                height: 40px;
                font-size: 16px;
                border-width: 2px;
            }
            
            .btn-secondary,
            .btn-danger,
            .btn-primary {
                font-size: 12px !important;
                padding: 8px 16px !important;
                min-height: 38px !important;
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

    <!-- Orders Section -->
    <section class="orders-section">
        <div class="container">
            <div class="orders-title">
                <h1>Riwayat Pesanan</h1>
                <p>Lihat dan kelola semua pesanan Anda di satu tempat</p>
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

           <!-- Tabs Lengkap - Text lengkap tapi tetap rapi -->
<div class="orders-tabs">
    <button class="orders-tab active" data-status="semua">
        Semua Pesanan 
        <span class="badge-count">{{ $statusCounts['semua'] ?? 0 }}</span>
    </button>
    <button class="orders-tab" data-status="menunggu_pembayaran">
        Menunggu Bayar 
        <span class="badge-count">{{ $statusCounts['menunggu_pembayaran'] ?? 0 }}</span>
    </button>
    <button class="orders-tab" data-status="dikonfirmasi">
        Dikonfirmasi 
        <span class="badge-count">{{ $statusCounts['dikonfirmasi'] ?? 0 }}</span>
    </button>
    
    <button class="orders-tab" data-status="selesai">
        Selesai 
        <span class="badge-count">{{ $statusCounts['selesai'] ?? 0 }}</span>
    </button>
    <button class="orders-tab" data-status="dibatalkan">
        Dibatalkan 
        <span class="badge-count">{{ $statusCounts['dibatalkan'] ?? 0 }}</span>
    </button>
</div>
            <!-- Orders List -->
            <div class="orders-container">
                @if(isset($pesanan) && count($pesanan) > 0)
                    @foreach($pesanan as $order)
                    @php
                        $method = $order->jenis_pengiriman ?? $order->metode_pengiriman ?? 'delivery';
                    @endphp
                    <div class="order-card" data-status="{{ $order->status }}" data-method="{{ $method }}">
                        <div class="order-card-header">
                            <div class="order-info">
                                <div class="order-number">
                                    Pesanan #{{ $order->nomor_pesanan }}
                                    <span class="order-method {{ $method == 'pickup' ? 'method-pickup' : 'method-delivery' }}">
                                        {{ $method == 'pickup' ? 'Pickup' : 'Delivery' }}
                                    </span>
                                </div>
                                <div class="order-date">
                                    {{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d F Y, H:i') }}
                                </div>
                            </div>
                            <div class="order-status status-{{ str_replace('_', '', $order->status) }}">
                                <i class="fas 
                                    @if($order->status == 'menunggu_pembayaran') fa-clock 
                                    @elseif($order->status == 'dikonfirmasi') fa-check-circle 
                                    @elseif($order->status == 'diproses') fa-sync-alt 
                                    @elseif($order->status == 'dimasak') fa-utensils 
                                    @elseif($order->status == 'siap_diantar') fa-box 
                                    @elseif($order->status == 'diantar') fa-shipping-fast 
                                    @elseif($order->status == 'selesai') fa-check-double 
                                    @elseif($order->status == 'dibatalkan') fa-times-circle 
                                    @endif status-icon">
                                </i>
                                @switch($order->status)
                                    @case('menunggu_pembayaran')
                                        Menunggu Pembayaran
                                        @break
                                    @case('dikonfirmasi')
                                        Dikonfirmasi
                                        @break
                                    @case('diproses')
                                        Diproses
                                        @break
                                    @case('dimasak')
                                        Dimasak
                                        @break
                                    @case('siap_diantar')
                                        Siap Diantar
                                        @break
                                    @case('diantar')
                                        Diantar
                                        @break
                                    @case('selesai')
                                        Selesai
                                        @break
                                    @case('dibatalkan')
                                        Dibatalkan
                                        @break
                                    @default
                                        {{ ucfirst($order->status) }}
                                @endswitch
                            </div>
                        </div>

                        <div class="order-card-body">
                            <!-- GANTI bagian order-items di dalam foreach loop -->
<div class="order-items">
    @if(isset($order->details) && count($order->details) > 0)
        @foreach($order->details as $item)
        @php
            // Ambil data dari varian atau gunakan fallback
            $namaMenu = $item->varian->menu->nama_menu ?? 'Dimsum';
            $ukuran = $item->varian->ukuran ?? 'Reguler';
            $jumlahPcs = $item->varian->jumlah_pcs ?? 6;
            $harga = $item->harga_per_unit ?? $item->varian->harga ?? 25000;
            $gambar = $item->varian->menu->gambar ?? ($item->varian->gambar ?? 'images/menu-placeholder.jpg');
            
            // Tentukan gambar berdasarkan nama menu
            if (str_contains(strtolower($namaMenu), 'ekado')) {
                $gambar = 'images/ekado-dimsum.jpg';
            } elseif (str_contains(strtolower($namaMenu), 'original') || str_contains(strtolower($namaMenu), 'ayam')) {
                $gambar = 'images/dimsum-original.jpg';
            } elseif (str_contains(strtolower($namaMenu), 'udang')) {
                $gambar = 'images/dimsum-udang.jpg';
            } elseif (str_contains(strtolower($namaMenu), 'sapi')) {
                $gambar = 'images/dimsum-sapi.jpg';
            } else {
                $gambar = $gambar ?: 'images/dimsum-placeholder.jpg';
            }
        @endphp
        <div class="order-item">
            <div class="order-item-info">
                <div class="item-image">
                    <img src="{{ asset($gambar) }}" 
                         alt="{{ $namaMenu }}"
                         onerror="this.src='{{ asset('images/dimsum-placeholder.jpg') }}'">
                </div>
                <div class="item-details">
                    <div class="order-item-name">{{ $namaMenu }}</div>
                    <div class="order-item-details">
                        <span>{{ $ukuran }}</span>
                        <span>•</span>
                        <span>{{ $jumlahPcs }} pcs</span>
                        @if($item->catatan)
                            <span>•</span>
                            <span>Catatan: {{ $item->catatan }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="order-item-qty">× {{ $item->jumlah }}</div>
            <div class="order-item-price">Rp{{ number_format($harga, 0, ',', '.') }}</div>
        </div>
        @endforeach
    @else
        <!-- Fallback jika detail tidak ada -->
        <div class="order-item">
            <div class="order-item-info">
                <div class="item-image">
                    <img src="{{ asset('images/dimsum-placeholder.jpg') }}" alt="Dimsum">
                </div>
                <div class="item-details">
                    <div class="order-item-name">Dimsum Special</div>
                    <div class="order-item-details">Reguler • 6 pcs</div>
                </div>
            </div>
            <div class="order-item-qty">× 1</div>
            <div class="order-item-price">Rp25.000</div>
        </div>
    @endif
</div>
                            <!-- Di bagian order-summary, HAPUS bagian pajak -->
<div class="order-summary">
    <div class="summary-row">
        <span class="summary-label">
            <i class="fas fa-receipt"></i> Subtotal
        </span>
        <span class="summary-value">Rp{{ number_format($order->subtotal, 0, ',', '.') }}</span>
    </div>
    <div class="summary-row">
        <span class="summary-label">
            <i class="fas fa-truck"></i> Biaya Pengiriman
        </span>
        <span class="summary-value">
            @if($order->biaya_pengiriman > 0)
                Rp{{ number_format($order->biaya_pengiriman, 0, ',', '.') }}
            @else
                GRATIS
            @endif
        </span>
    </div>
    @if($order->diskon > 0)
    <div class="summary-row">
        <span class="summary-label">
            <i class="fas fa-tag"></i> Diskon
        </span>
        <span class="summary-value" style="color: var(--success);">-Rp{{ number_format($order->diskon, 0, ',', '.') }}</span>
    </div>
    @endif
    <!-- HAPUS bagian pajak -->
    <div class="summary-row summary-total">
        <span class="summary-label">
            <i class="fas fa-wallet"></i> Total
        </span>
        <span class="summary-value">Rp{{ number_format($order->total_bayar, 0, ',', '.') }}</span>
    </div>
</div>
                            <!-- Order Timeline -->
                            <div class="order-timeline">
                                <div class="timeline-header">
                                    <div class="timeline-title">
                                        <i class="fas fa-stream timeline-icon"></i>
                                        Proses Pesanan
                                    </div>
                                    <div class="timeline-percentage">{{ calculateProgress($order) }}%</div>
                                </div>
                                
                                <div class="timeline-container">
                                    <!-- Timeline untuk Delivery -->
                                    @if($method == 'delivery')
                                    <div class="timeline-progress">
                                        <div class="progress-fill" style="width: {{ calculateProgress($order) }}%"></div>
                                    </div>
                                    
                                    <div class="timeline-steps">
                                        @php
                                            $deliverySteps = [
                                                ['icon' => 'fa-clock', 'label' => 'Menunggu<br>Pembayaran', 'status' => 'menunggu_pembayaran'],
                                                ['icon' => 'fa-check-circle', 'label' => 'Dikonfirmasi', 'status' => 'dikonfirmasi'],
                                                ['icon' => 'fa-sync-alt', 'label' => 'Diproses', 'status' => 'diproses'],
                                                ['icon' => 'fa-shipping-fast', 'label' => 'Diantar', 'status' => 'diantar'],
                                                ['icon' => 'fa-check-double', 'label' => 'Selesai', 'status' => 'selesai']
                                            ];
                                        @endphp
                                        
                                        @foreach($deliverySteps as $step)
                                        @php
                                            $isActive = isStepActive($order->status, $step['status'], 'delivery');
                                            $isCompleted = isStepCompleted($order->status, $step['status'], 'delivery');
                                            $stepClass = '';
                                            if ($isCompleted) $stepClass = 'step-completed';
                                            elseif ($isActive) $stepClass = 'step-active';
                                        @endphp
                                        <div class="timeline-step {{ $stepClass }}">
                                            <div class="step-icon">
                                                <i class="fas {{ $step['icon'] }}"></i>
                                            </div>
                                            <div class="step-label">{!! $step['label'] !!}</div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @else
                                    <!-- Timeline untuk Pickup -->
                                    <div class="timeline-progress">
                                        <div class="progress-fill" style="width: {{ calculateProgress($order) }}%"></div>
                                    </div>
                                    
                                    <div class="timeline-steps">
                                        @php
                                            $pickupSteps = [
                                                ['icon' => 'fa-clock', 'label' => 'Menunggu<br>Pembayaran', 'status' => 'menunggu_pembayaran'],
                                                ['icon' => 'fa-check-circle', 'label' => 'Dikonfirmasi', 'status' => 'dikonfirmasi'],
                                                ['icon' => 'fa-utensils', 'label' => 'Dimasak', 'status' => 'dimasak'],
                                                ['icon' => 'fa-box', 'label' => 'Siap<br>Diambil', 'status' => 'siap_diantar'],
                                                ['icon' => 'fa-check-double', 'label' => 'Selesai', 'status' => 'selesai']
                                            ];
                                        @endphp
                                        
                                        @foreach($pickupSteps as $step)
                                        @php
                                            $isActive = isStepActive($order->status, $step['status'], 'pickup');
                                            $isCompleted = isStepCompleted($order->status, $step['status'], 'pickup');
                                            $stepClass = '';
                                            if ($isCompleted) $stepClass = 'step-completed';
                                            elseif ($isActive) $stepClass = 'step-active';
                                        @endphp
                                        <div class="timeline-step {{ $stepClass }}">
                                            <div class="step-icon">
                                                <i class="fas {{ $step['icon'] }}"></i>
                                            </div>
                                            <div class="step-label">{!! $step['label'] !!}</div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                                
                                <div class="timeline-status-info">
                                    <div class="status-message">
                                        @switch($order->status)
                                            @case('menunggu_pembayaran')
                                                ⏳ Pesanan menunggu pembayaran
                                                @break
                                            @case('dikonfirmasi')
                                                ✅ Pesanan telah dikonfirmasi
                                                @break
                                            @case('diproses')
                                                🚚 Pesanan sedang diproses
                                                @break
                                            @case('dimasak')
                                                👨‍🍳 Dimsum sedang dimasak
                                                @break
                                            @case('siap_diantar')
                                                @if($method == 'pickup')
                                                    📦 Pesanan siap diambil di toko
                                                @else
                                                    📦 Pesanan siap diantar
                                                @endif
                                                @break
                                            @case('diantar')
                                                🛵 Kurir sedang dalam perjalanan
                                                @break
                                            @case('selesai')
                                                🎉 Pesanan telah selesai
                                                @break
                                            @case('dibatalkan')
                                                ❌ Pesanan dibatalkan
                                                @break
                                        @endswitch
                                    </div>
                                    
                                    @if($order->status == 'diantar' && $order->tanggal_pengiriman)
                                        <div class="status-estimasi">
                                            <i class="fas fa-clock"></i> Estimasi sampai: {{ \Carbon\Carbon::parse($order->tanggal_pengiriman)->addMinutes(30)->format('H:i') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="order-card-footer">
                            <div class="customer-info">
                                <div class="info-item">
                                    <i class="fas fa-user info-icon"></i>
                                    <span>{{ $order->nama_penerima }}</span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-phone info-icon"></i>
                                    <span>{{ $order->nomor_telepon }}</span>
                                </div>
                                @if($order->catatan_pelanggan)
                                <div class="info-item">
                                    <i class="fas fa-sticky-note info-icon"></i>
                                    <span>{{ $order->catatan_pelanggan }}</span>
                                </div>
                                @endif
                            </div>

                            <div class="order-actions">
                                @if($order->status == 'menunggu_pembayaran')
                                    <button class="btn-primary" onclick="bayarPesanan('{{ $order->id_pesanan }}')">
                                        <i class="fas fa-credit-card"></i> Bayar Sekarang
                                    </button>
                                    <button class="btn-danger" onclick="batalkanPesanan('{{ $order->id_pesanan }}')">
                                        <i class="fas fa-times"></i> Batalkan
                                    </button>
                                @elseif($order->status == 'diantar')
                                    <button class="btn-primary" onclick="konfirmasiSelesai('{{ $order->id_pesanan }}')">
                                        <i class="fas fa-check"></i> Pesanan Diterima
                                    </button>
                                @elseif($order->status == 'selesai')
                                    <button class="btn-secondary" onclick="pesanUlang('{{ $order->id_pesanan }}')">
                                        <i class="fas fa-redo"></i> Pesan Ulang
                                    </button>
                                @endif
                                
                                @if($order->status != 'dibatalkan')
                                    <button class="btn-secondary" onclick="lihatDetail('{{ $order->id_pesanan }}')">
                                        <i class="fas fa-eye"></i> Detail
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="no-orders">
                        <div class="no-orders-icon">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <h3>Belum ada pesanan</h3>
                        <p>Mulai pesan dimsum lezat favorit Anda sekarang!</p>
                        <a href="{{ route('menu') }}" class="btn-primary">
                            <i class="fas fa-utensils"></i> Pesan Sekarang
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
    // Fungsi untuk menampilkan loading spinner
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

    // Fungsi untuk filter pesanan berdasarkan tab
    document.querySelectorAll('.orders-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            // Update tab aktif
            document.querySelectorAll('.orders-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            const status = this.dataset.status;
            const orderCards = document.querySelectorAll('.order-card');
            
            orderCards.forEach(card => {
                if (status === 'semua' || card.dataset.status === status) {
                    card.style.display = 'block';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 10);
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });
            
            // Update URL dengan parameter status
            const url = new URL(window.location);
            if (status === 'semua') {
                url.searchParams.delete('status');
            } else {
                url.searchParams.set('status', status);
            }
            window.history.pushState({}, '', url);
        });
    });

    // Fungsi untuk membatalkan pesanan
    function batalkanPesanan(orderId) {
        if (!confirm('Apakah Anda yakin ingin membatalkan pesanan ini?\nPesanan yang sudah dibatalkan tidak dapat dikembalikan.')) {
            return;
        }
        
        showLoading();
        
        fetch(`/pesanan/${orderId}/batal`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
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
                alert(data.message);
                if (data.redirect_url) {
                    window.location.href = data.redirect_url;
                } else {
                    location.reload();
                }
            } else {
                alert('Gagal membatalkan pesanan: ' + (data.message || 'Terjadi kesalahan'));
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            alert('Terjadi kesalahan saat membatalkan pesanan. Silakan coba lagi.');
        });
    }

    // Fungsi untuk membayar pesanan
    function bayarPesanan(orderId) {
        if (!confirm('Apakah Anda ingin melanjutkan pembayaran?')) {
            return;
        }
        
        console.log('Memproses pembayaran untuk orderId:', orderId);
        console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        
        showLoading();
        
        // Coba endpoint yang berbeda
        const endpoint = `/pesanan/${orderId}/bayar`;
        console.log('Endpoint:', endpoint);
        
        fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({ _method: 'POST' })
        })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);
            
            if (!response.ok) {
                console.error('Response not OK:', response.statusText);
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            hideLoading();
            
            if (data.success) {
                if (data.message) {
                    alert(data.message);
                }
                if (data.redirect_url) {
                    console.log('Redirecting to:', data.redirect_url);
                    window.location.href = data.redirect_url;
                } else {
                    console.log('Reloading page...');
                    location.reload();
                }
            } else {
                console.error('Server error:', data.message);
                alert('Gagal memproses pembayaran: ' + (data.message || 'Terjadi kesalahan'));
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            hideLoading();
            alert('Terjadi kesalahan saat memproses pembayaran. Detail: ' + error.message);
        });
    }

    // Fungsi untuk mengkonfirmasi pesanan selesai
    function konfirmasiSelesai(orderId) {
        if (!confirm('Apakah Anda sudah menerima pesanan ini?\nSetelah dikonfirmasi selesai, Anda tidak dapat mengajukan komplain.')) {
            return;
        }
        
        showLoading();
        
        fetch(`/pesanan/${orderId}/selesai`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
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
                alert(data.message || 'Pesanan berhasil dikonfirmasi selesai.');
                location.reload();
            } else {
                alert('Gagal mengkonfirmasi pesanan: ' + (data.message || 'Terjadi kesalahan'));
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengkonfirmasi pesanan. Silakan coba lagi.');
        });
    }

    // Fungsi untuk memesan ulang
    function pesanUlang(orderId) {
        showLoading();
        
        fetch(`/pesanan/${orderId}/ulang`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
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
                alert(data.message || 'Pesanan berhasil ditambahkan ke keranjang!');
                
                // Update cart count in header
                if (data.cart_count !== undefined) {
                    updateCartCount(data.cart_count);
                    
                    // Show cart count badge
                    const cartCountElement = document.querySelector('.dimsum-cart-count');
                    if (cartCountElement) {
                        cartCountElement.style.display = 'flex';
                    }
                }
                
                // Redirect ke keranjang
                setTimeout(() => {
                    window.location.href = '/keranjang';
                }, 1000);
                
            } else {
                alert('Gagal memesan ulang: ' + (data.message || 'Terjadi kesalahan'));
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memesan ulang. Silakan coba lagi.');
        });
    }

    // Fungsi untuk melihat detail pesanan
    function lihatDetail(orderId) {
        // Redirect ke halaman detail pesanan
        window.location.href = `/pesanan/${orderId}/detail`;
    }

    // Fungsi untuk setup button listeners
    function setupButtonListeners() {
        document.querySelectorAll('.btn-secondary, .btn-danger, .btn-primary').forEach(button => {
            button.addEventListener('click', function(e) {
                if (this.classList.contains('disabled') || this.disabled) {
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                }
                
                // Tambahkan loading state untuk tombol
                const originalHTML = this.innerHTML;
                const originalWidth = this.offsetWidth;
                
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
                this.style.width = originalWidth + 'px';
                this.disabled = true;
                
                // Reset setelah 3 detik jika ada masalah
                setTimeout(() => {
                    this.innerHTML = originalHTML;
                    this.style.width = '';
                    this.disabled = false;
                }, 3000);
            });
        });
    }

    // Fungsi untuk format status pesanan
    function getStatusText(status) {
        const statusMap = {
            'menunggu_pembayaran': 'Menunggu Pembayaran',
            'dikonfirmasi': 'Dikonfirmasi',
            'diproses': 'Diproses',
            'dimasak': 'Dimasak',
            'siap_diantar': 'Siap Diantar',
            'diantar': 'Diantar',
            'selesai': 'Selesai',
            'dibatalkan': 'Dibatalkan'
        };
        return statusMap[status] || status;
    }

    // Animasi untuk timeline progress
    function animateTimelines() {
        document.querySelectorAll('.progress-fill').forEach(progressFill => {
            const currentWidth = progressFill.style.width;
            progressFill.style.width = '0';
            
            setTimeout(() => {
                progressFill.style.transition = 'width 1.5s cubic-bezier(0.4, 0, 0.2, 1)';
                progressFill.style.width = currentWidth;
            }, 300);
        });
        
        // Animate step icons
        document.querySelectorAll('.step-active .step-icon').forEach((icon, index) => {
            setTimeout(() => {
                icon.style.transform = 'scale(1.1) rotate(360deg)';
                setTimeout(() => {
                    icon.style.transform = 'scale(1.1)';
                }, 300);
            }, index * 200);
        });
    }

    // Inisialisasi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        // Jika ada parameter status di URL, aktifkan tab yang sesuai
        const urlParams = new URLSearchParams(window.location.search);
        const statusParam = urlParams.get('status');
        
        if (statusParam) {
            const tab = document.querySelector(`.orders-tab[data-status="${statusParam}"]`);
            if (tab) {
                tab.click();
            }
        }
        
        // Setup button listeners
        setupButtonListeners();
        
        // Add animation to order cards
        document.querySelectorAll('.order-card').forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
        
        // Initialize timeline animations
        animateTimelines();
        
        // Add hover effects to order items
        document.querySelectorAll('.order-item').forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(5px)';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
            });
        });
        
        // Update cart count on page load
        updateCartCountFromSession();
        
        // Check pending orders for auto-refresh
        checkPendingOrders();
    });

    // Fungsi untuk mengambil jumlah cart dari session
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

    // Fungsi untuk refresh otomatis jika ada pesanan menunggu pembayaran
    function checkPendingOrders() {
        const pendingOrders = document.querySelectorAll('.order-card[data-status="menunggu_pembayaran"]');
        if (pendingOrders.length > 0) {
            // Refresh setiap 30 detik untuk pesanan menunggu pembayaran
            setTimeout(() => {
                location.reload();
            }, 30000);
        }
    }

    // Handle back/forward browser buttons
    window.addEventListener('popstate', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const statusParam = urlParams.get('status');
        
        if (statusParam) {
            const tab = document.querySelector(`.orders-tab[data-status="${statusParam}"]`);
            if (tab) {
                tab.click();
            }
        } else {
            const allTab = document.querySelector('.orders-tab[data-status="semua"]');
            if (allTab) {
                allTab.click();
            }
        }
    });
    </script>
</body>
</html>