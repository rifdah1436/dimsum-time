<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kasir - Dimsum Time</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Baloo+2:wght@600;700&family=Baloo&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --primary: #e53935;
            --primary-dark: #c62828;
            --primary-light: #ffcdd2;
            --primary-gradient: linear-gradient(135deg, #e53935, #c62828);
            --secondary: #ff9800;
            --success: #4caf50;
            --success-dark: #388e3c;
            --success-gradient: linear-gradient(135deg, #4caf50, #388e3c);
            --info: #2196f3;
            --info-gradient: linear-gradient(135deg, #2196f3, #1565c0);
            --warning: #ffc107;
            --danger: #f44336;
            --light: #ffffff;
            --light-bg: #f8fafc;
            --dark: #1e293b;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --border: var(--gray-200);
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --radius-sm: 0.375rem;
            --radius: 0.5rem;
            --radius-md: 0.75rem;
            --radius-lg: 1rem;
            --transition: all 0.2s ease-in-out;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--light-bg);
            color: var(--dark);
            min-height: 100vh;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Modern Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--gray-100);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }

        /* Header - Clean & Modern */
        .header {
            background: var(--light);
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 3px solid var(--primary);
        }

        .header-content {
            max-width: 1600px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            transition: var(--transition);
        }

        .logo:hover {
            transform: translateY(-2px);
        }

        .logo-img {
            height: 40px;
            width: 40px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid var(--primary);
            padding: 2px;
            background: white;
        }

        .logo-text {
            font-family: 'Baloo', cursive;
            font-size: 24px;
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .logo-badge {
            background: var(--primary-gradient);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            box-shadow: var(--shadow-sm);
        }

        .user-section {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 16px;
            background: var(--light);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            transition: var(--transition);
            cursor: pointer;
        }

        .user-profile:hover {
            background: var(--gray-100);
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 16px;
            border: 2px solid var(--light);
            box-shadow: var(--shadow-sm);
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            font-size: 14px;
            color: var(--dark);
        }

        .user-role {
            font-size: 12px;
            color: var(--gray-500);
            font-weight: 500;
        }

        .logout-btn {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: var(--radius);
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
            font-size: 14px;
            box-shadow: var(--shadow);
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* Main Container */
        .main-container {
            max-width: 1600px;
            margin: 24px auto;
            padding: 0 24px;
        }

        /* Welcome Section - Minimal */
        .welcome-section {
            background: var(--light);
            border-radius: var(--radius-md);
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
        }

        .welcome-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .welcome-text {
            flex: 1;
        }

        .welcome-title {
            font-family: 'Baloo', cursive;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .welcome-subtitle {
            font-size: 14px;
            color: var(--gray-600);
            opacity: 0.9;
            max-width: 600px;
        }

        .welcome-stats {
            display: flex;
            gap: 24px;
            background: var(--gray-100);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 16px 24px;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            background: var(--light);
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: var(--primary);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
        }

        .stat-info h4 {
            font-size: 12px;
            color: var(--gray-500);
            margin-bottom: 2px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-value {
            font-size: 20px;
            font-weight: 700;
            color: var(--dark);
        }

        /* Quick Actions */
        .quick-actions {
            display: flex;
            gap: 16px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .quick-action-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 20px;
            background: var(--light);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            color: var(--dark);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: var(--transition);
            flex: 1;
            min-width: 180px;
            justify-content: center;
            box-shadow: var(--shadow-sm);
        }

        .quick-action-btn:hover {
            background: var(--gray-100);
            transform: translateY(-2px);
            box-shadow: var(--shadow);
            border-color: var(--primary);
        }

        .quick-action-btn i {
            color: var(--primary);
            font-size: 16px;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--light);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 20px;
            transition: var(--transition);
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary);
        }

        .stat-card-content {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .stat-icon-wrapper {
            width: 50px;
            height: 50px;
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: white;
            flex-shrink: 0;
            box-shadow: var(--shadow);
        }

        .stat-card.orders .stat-icon-wrapper {
            background: var(--info-gradient);
        }

        .stat-card.pending .stat-icon-wrapper {
            background: linear-gradient(135deg, var(--warning), #ff9800);
        }

        .stat-card.completed .stat-icon-wrapper {
            background: var(--success-gradient);
        }

        .stat-card.revenue .stat-icon-wrapper {
            background: var(--primary-gradient);
        }

        .stat-content {
            flex: 1;
        }

        .stat-title {
            font-size: 13px;
            color: var(--gray-500);
            margin-bottom: 4px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-number {
            font-size: 24px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 2px;
        }

        .stat-detail {
            font-size: 12px;
            color: var(--gray-500);
            opacity: 0.8;
        }

        /* Filter Section */
        .filter-section {
            background: var(--light);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 24px;
            margin-bottom: 32px;
            box-shadow: var(--shadow);
        }

        .filter-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-title i {
            color: var(--primary);
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .filter-label {
            font-size: 13px;
            font-weight: 500;
            color: var(--gray-600);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .filter-select,
        .filter-input {
            padding: 10px 14px;
            background: var(--light);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            font-size: 14px;
            color: var(--dark);
            transition: var(--transition);
            width: 100%;
            font-family: 'DM Sans', sans-serif;
        }

        .filter-select:focus,
        .filter-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(229, 57, 53, 0.1);
        }

        .filter-actions {
            display: flex;
            gap: 10px;
            align-items: flex-end;
        }

        .btn {
            padding: 10px 20px;
            border-radius: var(--radius);
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            border: none;
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: white;
            box-shadow: var(--shadow);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-secondary {
            background: var(--light);
            color: var(--dark);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background: var(--gray-100);
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
        }

        /* Orders Section */
        .orders-section {
            background: var(--light);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            overflow: hidden;
            margin-bottom: 40px;
            box-shadow: var(--shadow);
        }

        .section-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            background: var(--gray-100);
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: var(--primary);
        }

        .section-info {
            font-size: 13px;
            color: var(--gray-500);
            background: var(--light);
            padding: 4px 12px;
            border-radius: 20px;
            border: 1px solid var(--border);
        }

        /* Orders Table */
        .orders-table-container {
            overflow-x: auto;
            padding: 0;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1200px;
        }

        .orders-table thead {
            background: var(--gray-100);
        }

        .orders-table th {
            padding: 16px;
            text-align: left;
            font-weight: 600;
            color: var(--gray-600);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        .orders-table tbody tr {
            transition: var(--transition);
            border-bottom: 1px solid var(--border);
        }

        .orders-table tbody tr:hover {
            background: var(--primary-light);
        }

        .orders-table td {
            padding: 16px;
            vertical-align: middle;
            color: var(--dark);
            font-size: 14px;
        }

        /* Status Badges */
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-align: center;
            display: inline-block;
            white-space: nowrap;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-menunggu_pembayaran {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-dikonfirmasi {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        .status-diproses {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-dimasak {
            background: #ffccbc;
            color: #bf360c;
            border: 1px solid #ffab91;
        }

        .status-siap_diambil {
            background: #fff9c4;
            color: #f57f17;
            border: 1px solid #fff176;
        }

        .status-diantar {
            background: #d1c4e9;
            color: #311b92;
            border: 1px solid #b39ddb;
        }

        .status-selesai {
            background: var(--success);
            color: white;
        }

        .status-dibatalkan {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Payment Badges */
        .payment-badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 10px;
            font-weight: 600;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .payment-menunggu {
            background: var(--warning);
            color: var(--dark);
        }

        .payment-menunggu_verifikasi {
            background: var(--info);
            color: white;
        }

        .payment-dibayar {
            background: var(--success);
            color: white;
        }

        .payment-gagal {
            background: var(--danger);
            color: white;
        }

        .payment-dibatalkan {
            background: var(--gray-500);
            color: white;
        }

        /* Payment Method Badges */
        .method-badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
            background: var(--gray-100);
            color: var(--dark);
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .method-cod {
            background: var(--danger);
            color: white;
        }

        .method-cash {
            background: var(--success);
            color: white;
        }

        .method-ovo {
            background: #4c3af2;
            color: white;
        }

        .method-gopay {
            background: #00a94f;
            color: white;
        }

        .method-dana {
            background: #108ee9;
            color: white;
        }

        .method-shopeepay {
            background: #ff5314;
            color: white;
        }

        .method-transfer {
            background: #6f42c1;
            color: white;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn-sm {
            padding: 8px 12px;
            font-size: 12px;
            border-radius: var(--radius-sm);
            font-weight: 500;
        }

        .btn-info {
            background: var(--info);
            color: white;
            border: none;
        }

        .btn-info:hover {
            background: #1565c0;
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .btn-warning {
            background: var(--warning);
            color: var(--dark);
            border: none;
        }

        .btn-warning:hover {
            background: #ff9800;
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .btn-success {
            background: var(--success);
            color: white;
            border: none;
        }

        .btn-success:hover {
            background: var(--success-dark);
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .btn-danger {
            background: var(--danger);
            color: white;
            border: none;
        }

        .btn-danger:hover {
            background: #d32f2f;
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .btn-secondary {
            background: var(--light);
            color: var(--dark);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background: var(--gray-100);
            transform: translateY(-1px);
        }

        /* Dropdown Menu */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-toggle {
            padding: 8px 16px;
            background: var(--light);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 500;
            color: var(--dark);
            transition: var(--transition);
        }

        .dropdown-toggle:hover {
            background: var(--gray-100);
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            background: var(--light);
            min-width: 180px;
            box-shadow: var(--shadow-lg);
            border-radius: var(--radius);
            z-index: 1000;
            display: none;
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .dropdown-item {
            padding: 10px 15px;
            display: block;
            color: var(--dark);
            text-decoration: none;
            transition: var(--transition);
            border-bottom: 1px solid var(--border);
            font-size: 13px;
        }

        .dropdown-item:hover {
            background: var(--gray-100);
            color: var(--primary);
        }

        .dropdown-item:last-child {
            border-bottom: none;
        }

        /* Modal Overlay */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            padding: 20px;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-container {
            background: var(--light);
            border-radius: var(--radius-md);
            width: 100%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: var(--shadow-lg);
            animation: slideUp 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid var(--border);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--primary-gradient);
            border-radius: var(--radius-md) var(--radius-md) 0 0;
        }

        .modal-title {
            font-size: 18px;
            font-weight: 600;
            color: white;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .close-modal {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: white;
            font-size: 18px;
            transition: var(--transition);
        }

        .close-modal:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 24px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--gray-600);
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            background: var(--light);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            font-size: 14px;
            color: var(--dark);
            transition: var(--transition);
            font-family: 'DM Sans', sans-serif;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(229, 57, 53, 0.1);
        }

        /* Loading Overlay */
        .loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(4px);
            z-index: 3000;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 20px;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 3px solid var(--gray-200);
            border-top: 3px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loading-text {
            font-size: 14px;
            font-weight: 500;
            color: var(--gray-600);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--gray-500);
        }

        .empty-icon {
            font-size: 60px;
            margin-bottom: 20px;
            color: var(--gray-300);
            opacity: 0.5;
        }

        .empty-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .empty-text {
            font-size: 14px;
            max-width: 400px;
            margin: 0 auto 30px;
            opacity: 0.8;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .main-container {
                padding: 0 20px;
            }
            
            .filter-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .quick-action-btn {
                min-width: 180px;
            }
        }

        @media (max-width: 768px) {
            .header-content {
                padding: 16px;
                height: auto;
                gap: 16px;
            }
            
            .welcome-content {
                flex-direction: column;
                text-align: center;
            }
            
            .welcome-stats {
                flex-direction: column;
                gap: 16px;
                width: 100%;
            }
            
            .filter-grid {
                grid-template-columns: 1fr;
            }
            
            .filter-actions {
                flex-direction: column;
            }
            
            .section-header {
                flex-direction: column;
                align-items: stretch;
            }
            
            .orders-table {
                font-size: 13px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .quick-actions {
                flex-direction: column;
            }
            
            .quick-action-btn {
                min-width: 100%;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .modal-container {
                margin: 10px;
            }
            
            .modal-body {
                padding: 20px;
            }
            
            .logo-text {
                font-size: 20px;
            }
            
            .welcome-title {
                font-size: 24px;
            }
        }

        /* Animation Classes */
        .fade-in {
            animation: fadeIn 0.5s ease;
        }

        .slide-up {
            animation: slideUp 0.5s ease;
        }
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
        <div class="loading-text">Memproses...</div>
    </div>

    <!-- Order Detail Modal -->
    <div class="modal-overlay" id="orderModal">
        <div class="modal-container" style="max-width: 700px;">
            <div class="modal-header">
                <h3 class="modal-title">
                    <i class="fas fa-file-invoice"></i>
                    Detail Pesanan
                </h3>
                <button class="close-modal" onclick="closeModal('orderModal')">&times;</button>
            </div>
            
            <div class="modal-body">
                <div id="orderDetailContent">
                    <!-- Content akan diisi via JavaScript -->
                </div>
            </div>
            
            <div class="modal-footer" style="padding: 20px; border-top: 1px solid var(--border);">
                <button class="btn btn-secondary" onclick="closeModal('orderModal')">
                    <i class="fas fa-times"></i> Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal-overlay" id="paymentModal">
        <div class="modal-container">
            <div class="modal-header">
                <h3 class="modal-title">
                    <i class="fas fa-credit-card"></i>
                    Kelola Pembayaran
                </h3>
                <button class="close-modal" onclick="closeModal('paymentModal')">&times;</button>
            </div>
            
            <form id="paymentForm">
                <div class="modal-body">
                    <div class="payment-summary" id="paymentSummary">
                        <!-- Summary akan diisi via JavaScript -->
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Metode Pembayaran</label>
                        <select class="form-control" name="metode_pembayaran" id="paymentMethod" required>
                            @foreach($paymentMethods as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Status Pembayaran</label>
                        <select class="form-control" name="status_pembayaran" id="paymentStatus" required>
                            @foreach($paymentStatusOptions as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">ID Transaksi (opsional)</label>
                        <input type="text" class="form-control" name="id_transaksi" id="transactionId" placeholder="Contoh: TRX-00123">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Catatan (opsional)</label>
                        <textarea class="form-control" name="catatan" id="paymentNote" rows="3" placeholder="Contoh: Pembayaran via transfer BCA..."></textarea>
                    </div>
                </div>
                
                <div class="modal-footer" style="padding: 20px; border-top: 1px solid var(--border); display: flex; gap: 10px; flex-wrap: wrap;">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('paymentModal')">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="button" class="btn btn-success" id="processCashBtn" onclick="processCashPayment()">
                        <i class="fas fa-money-bill-wave"></i> Proses Cash/COD
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Status Update Modal -->
    <div class="modal-overlay" id="statusModal">
        <div class="modal-container" style="max-width: 500px;">
            <div class="modal-header">
                <h3 class="modal-title">
                    <i class="fas fa-exchange-alt"></i>
                    Update Status Pesanan
                </h3>
                <button class="close-modal" onclick="closeModal('statusModal')">&times;</button>
            </div>
            
            <form id="statusForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Pilih Status Baru</label>
                        <select class="form-control" name="status" id="newStatus" required>
                            @foreach($statusOptions as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Catatan (opsional)</label>
                        <textarea class="form-control" name="catatan" id="statusNote" rows="3" placeholder="Contoh: Pesanan sedang dimasak..."></textarea>
                    </div>
                </div>
                
                <div class="modal-footer" style="padding: 20px; border-top: 1px solid var(--border);">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('statusModal')">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check"></i> Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div class="logo-section">
                <a href="{{ route('kasir.dashboard') }}" class="logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Dimsum Time" class="logo-img" 
                         onerror="this.src='{{ asset('images/logo-placeholder.png') }}'">
                    <span class="logo-text">DIMSUM TIME</span>
                </a>
                <span class="logo-badge">KASIR</span>
            </div>
            
            <div class="user-section">
                <div class="user-profile">
                    <div class="user-avatar" id="userInitials">
                        {{ substr(Auth::user()->nama_lengkap ?? 'K', 0, 1) }}
                    </div>
                    <div class="user-info">
                        <div class="user-name">{{ Auth::user()->nama_lengkap ?? 'Kasir' }}</div>
                        <div class="user-role">Kasir</div>
                    </div>
                </div>
                
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-container">
        <!-- Welcome Section -->
        <section class="welcome-section">
            <div class="welcome-content">
                <div class="welcome-text">
                    <h1 class="welcome-title">Halo, {{ Auth::user()->nama_lengkap ?? 'Kasir' }}! 👋</h1>
                    <p class="welcome-subtitle">Kelola pesanan dan pembayaran dengan mudah. Pantau status pesanan secara real-time.</p>
                </div>
                
                <div class="welcome-stats">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-info">
                            <h4>WAKTU</h4>
                            <div class="stat-value" id="currentTime">{{ now()->format('H:i') }}</div>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div class="stat-info">
                            <h4>TANGGAL</h4>
                            <div class="stat-value">{{ now()->translatedFormat('d/m/Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <a href="{{ route('kasir.report.daily') }}" class="quick-action-btn">
                <i class="fas fa-chart-bar"></i>
                Laporan Harian
            </a>
            <a href="{{ route('kasir.menu.index') }}" class="quick-action-btn">
                <i class="fas fa-utensils"></i>
                Daftar Menu
            </a>
            <a href="{{ route('kasir.stock.index') }}" class="quick-action-btn">
                <i class="fas fa-boxes"></i>
                Stok Produk
            </a>
            <a href="{{ route('kasir.orders.by_status', 'menunggu_pembayaran') }}" class="quick-action-btn">
                <i class="fas fa-exclamation-circle"></i>
                Perlu Pembayaran
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card orders">
                <div class="stat-card-content">
                    <div class="stat-icon-wrapper">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-title">Total Pesanan</div>
                        <div class="stat-number">{{ $statistik['total_pesanan'] }}</div>
                        <div class="stat-detail">Semua waktu</div>
                    </div>
                </div>
            </div>
            
            <div class="stat-card pending">
                <div class="stat-card-content">
                    <div class="stat-icon-wrapper">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-title">Menunggu Bayar</div>
                        <div class="stat-number">{{ $statistik['menunggu_pembayaran'] }}</div>
                        <div class="stat-detail">Perlu penanganan</div>
                    </div>
                </div>
            </div>
            
            <div class="stat-card completed">
                <div class="stat-card-content">
                    <div class="stat-icon-wrapper">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-title">Selesai Hari Ini</div>
                        <div class="stat-number">{{ $statistik['selesai'] }}</div>
                        <div class="stat-detail">Pesanan sukses</div>
                    </div>
                </div>
            </div>
            
            <div class="stat-card revenue">
                <div class="stat-card-content">
                    <div class="stat-icon-wrapper">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-title">Pendapatan Hari Ini</div>
                        <div class="stat-number">Rp{{ number_format($statistik['pendapatan_hari_ini'], 0, ',', '.') }}</div>
                        <div class="stat-detail">Total transaksi hari ini</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <section class="filter-section">
            <div class="filter-title">
                <i class="fas fa-filter"></i>
                Filter Pesanan
            </div>
            
            <form method="GET" action="{{ route('kasir.dashboard') }}" class="filter-grid">
                <div class="filter-group">
                    <label class="filter-label">Status Pesanan</label>
                    <select name="status" class="filter-select" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        @foreach($statusOptions as $key => $label)
                            <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="filter-group">
                    <label class="filter-label">Status Pembayaran</label>
                    <select name="payment_status" class="filter-select" onchange="this.form.submit()">
                        <option value="">Semua Status Bayar</option>
                        @foreach($paymentStatusOptions as $key => $label)
                            <option value="{{ $key }}" {{ request('payment_status') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="filter-group">
                    <label class="filter-label">Metode Pengiriman</label>
                    <select name="delivery_method" class="filter-select" onchange="this.form.submit()">
                        <option value="">Semua Metode</option>
                        <option value="delivery" {{ request('delivery_method') == 'delivery' ? 'selected' : '' }}>Delivery</option>
                        <option value="pickup" {{ request('delivery_method') == 'pickup' ? 'selected' : '' }}>Pickup</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label class="filter-label">Tanggal</label>
                    <input type="date" name="date" class="filter-input" value="{{ request('date') }}" onchange="this.form.submit()">
                </div>
                
                <div class="filter-group">
                    <label class="filter-label">Cari Pesanan</label>
                    <input type="text" name="search" class="filter-input" placeholder="No. Pesanan / Nama / Telepon" value="{{ request('search') }}">
                </div>
                
                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Terapkan Filter
                    </button>
                    <a href="{{ route('kasir.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </div>
            </form>
        </section>

        <!-- Orders Section -->
        <section class="orders-section">
            <div class="section-header">
                <div>
                    <h2 class="section-title">
                        <i class="fas fa-list-ul"></i>
                        Daftar Pesanan
                    </h2>
                    <div class="section-info">
                        Menampilkan {{ $pesanan->count() }} dari {{ $pesanan->total() }} pesanan
                    </div>
                </div>
            </div>
            
            <div class="orders-table-container">
                @if($pesanan->count() > 0)
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th>No. Pesanan</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Bayar</th>
                                <th>Metode</th>
                                <th>Pengiriman</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pesanan as $order)
                            <tr class="fade-in">
                                <td>
                                    <div style="font-weight: 600; color: var(--primary); font-size: 13px;">
                                        {{ $order->nomor_pesanan }}
                                    </div>
                                    <div style="font-size: 11px; color: var(--gray-500);">
                                        ID: {{ $order->id_pesanan }}
                                    </div>
                                </td>
                                
                                <td>
                                    <div style="font-weight: 500; font-size: 13px;">{{ $order->nama_penerima }}</div>
                                    <div style="font-size: 11px; color: var(--gray-500);">
                                        <i class="fas fa-phone" style="font-size: 9px;"></i> {{ $order->nomor_telepon }}
                                    </div>
                                    @if($order->catatan_pelanggan)
                                    <div style="font-size: 10px; color: var(--gray-500); font-style: italic; margin-top: 2px;">
                                        "{{ Str::limit($order->catatan_pelanggan, 25) }}"
                                    </div>
                                    @endif
                                </td>
                                
                                <td style="font-weight: 600; font-size: 14px;">
                                    Rp{{ number_format($order->total_bayar, 0, ',', '.') }}
                                </td>
                                
                                <td>
                                    <span class="status-badge status-{{ $order->status }}">
                                        {{ $statusOptions[$order->status] ?? $order->status }}
                                    </span>
                                </td>
                                
                                <td>
                                    @if($order->pembayaran)
                                        <span class="payment-badge payment-{{ $order->pembayaran->status_pembayaran }}">
                                            {{ $paymentStatusOptions[$order->pembayaran->status_pembayaran] ?? $order->pembayaran->status_pembayaran }}
                                        </span>
                                    @else
                                        <span class="payment-badge payment-menunggu">Belum Dibayar</span>
                                    @endif
                                </td>
                                
                                <td>
                                    @if($order->pembayaran)
                                        @php
                                            $method = $order->pembayaran->metode_pembayaran;
                                            $methodClass = '';
                                            if ($method == 'cod') $methodClass = 'method-cod';
                                            elseif ($method == 'cash') $methodClass = 'method-cash';
                                            elseif ($method == 'ovo') $methodClass = 'method-ovo';
                                            elseif ($method == 'gopay') $methodClass = 'method-gopay';
                                            elseif ($method == 'dana') $methodClass = 'method-dana';
                                            elseif ($method == 'shopeepay') $methodClass = 'method-shopeepay';
                                            elseif (in_array($method, ['bca', 'mandiri', 'bri', 'bni'])) $methodClass = 'method-transfer';
                                        @endphp
                                        <span class="method-badge {{ $methodClass }}">
                                            {{ $paymentMethods[$method] ?? $method }}
                                        </span>
                                    @else
                                        <span class="method-badge">-</span>
                                    @endif
                                </td>
                                
                                <td>
                                    @if($order->jenis_pengiriman == 'delivery')
                                        <span style="background: rgba(33, 150, 243, 0.1); color: var(--info); padding: 4px 10px; border-radius: 12px; font-size: 10px; font-weight: 600;">
                                            <i class="fas fa-truck"></i> Delivery
                                        </span>
                                    @else
                                        <span style="background: rgba(76, 175, 80, 0.1); color: var(--success); padding: 4px 10px; border-radius: 12px; font-size: 10px; font-weight: 600;">
                                            <i class="fas fa-store"></i> Pickup
                                        </span>
                                    @endif
                                </td>
                                
                                <td>
                                    <div style="font-size: 12px; font-weight: 500;">
                                        {{ $order->created_at->format('d/m') }}
                                    </div>
                                    <div style="font-size: 11px; color: var(--gray-500);">
                                        {{ $order->created_at->format('H:i') }}
                                    </div>
                                </td>
                                
                                <td>
                                    <div class="action-buttons">
                                        <button onclick="openOrderModal('{{ $order->id_pesanan }}')" 
                                                class="btn btn-info btn-sm" title="Detail Pesanan">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        
                                        <button onclick="openPaymentModal('{{ $order->id_pesanan }}')" 
                                                class="btn btn-warning btn-sm" title="Kelola Pembayaran">
                                            <i class="fas fa-credit-card"></i>
                                        </button>
                                        
                                        <div class="dropdown">
                                            <button class="dropdown-toggle" title="Ubah Status">
                                                <i class="fas fa-cog"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                @foreach($statusOptions as $key => $label)
                                                    @if($key != $order->status)
                                                        <a class="dropdown-item" 
                                                           href="#" 
                                                           onclick="openStatusModal('{{ $order->id_pesanan }}', '{{ $key }}')">
                                                            Ubah ke {{ $label }}
                                                        </a>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <!-- Pagination -->
                    @if($pesanan->hasPages())
                    <div class="pagination-container">
                        {{ $pesanan->links() }}
                    </div>
                    @endif
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h3 class="empty-title">Tidak Ada Pesanan</h3>
                        <p class="empty-text">
                            @if(request()->hasAny(['status', 'payment_status', 'search', 'date']))
                                Tidak ditemukan pesanan dengan filter yang dipilih.
                            @else
                                Belum ada pesanan yang tercatat.
                            @endif
                        </p>
                        @if(request()->hasAny(['status', 'payment_status', 'search', 'date']))
                            <a href="{{ route('kasir.dashboard') }}" class="btn btn-primary">
                                <i class="fas fa-redo"></i> Reset Filter
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </section>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // DOM Elements
        const loadingOverlay = document.getElementById('loadingOverlay');
        let currentOrderId = null;
        let currentStatus = null;

        // Update current time
        function updateCurrentTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', { 
                hour: '2-digit', 
                minute: '2-digit',
                hour12: false 
            });
            document.getElementById('currentTime').textContent = timeString;
        }

        // Initialize
        updateCurrentTime();
        setInterval(updateCurrentTime, 60000);

        // Set user initials
        function getUserInitials() {
            const userName = "{{ Auth::user()->nama_lengkap ?? 'K' }}";
            return userName.split(' ').map(word => word[0]).join('').toUpperCase();
        }
        document.getElementById('userInitials').textContent = getUserInitials();

        // Initialize Select2
        $(document).ready(function() {
            $('#paymentMethod, #paymentStatus, #newStatus').select2({
                theme: 'default',
                width: '100%'
            });
        });

        // Show loading
        function showLoading(message = 'Memproses...') {
            loadingOverlay.querySelector('.loading-text').textContent = message;
            loadingOverlay.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        // Hide loading
        function hideLoading() {
            loadingOverlay.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Open modal
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        // Close modal
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
            document.body.style.overflow = 'auto';
            currentOrderId = null;
            currentStatus = null;
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal('orderModal');
                closeModal('paymentModal');
                closeModal('statusModal');
            }
        });

        // Number formatting utility
        function formatNumber(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Open order detail modal
        async function openOrderModal(orderId) {
            try {
                showLoading('Memuat detail pesanan...');
                
                const response = await fetch(`/kasir/order/${orderId}/detail`);
                const result = await response.json();
                
                if (result.success) {
                    const order = result.data;
                    currentOrderId = order.id_pesanan;
                    
                    // Format order detail HTML
                    let orderDetailHTML = `
                        <div style="margin-bottom: 25px;">
                            <h4 style="color: var(--primary); margin-bottom: 15px; border-bottom: 2px solid var(--primary); padding-bottom: 10px;">
                                <i class="fas fa-info-circle"></i> Informasi Pesanan
                            </h4>
                            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                                <div>
                                    <strong>No. Pesanan:</strong><br>
                                    <span style="font-size: 18px; font-weight: 700; color: var(--primary);">${order.nomor_pesanan}</span>
                                </div>
                                <div>
                                    <strong>Status:</strong><br>
                                    <span class="status-badge status-${order.status}" style="margin-top: 5px;">
                                        {{ $statusOptions['${order.status}'] ?? '${order.status}' }}
                                    </span>
                                </div>
                                <div>
                                    <strong>Pelanggan:</strong><br>
                                    ${order.nama_penerima}
                                </div>
                                <div>
                                    <strong>Telepon:</strong><br>
                                    <i class="fas fa-phone"></i> ${order.nomor_telepon}
                                </div>
                                <div>
                                    <strong>Alamat:</strong><br>
                                    ${order.alamat_pengiriman}
                                </div>
                                <div>
                                    <strong>Pengiriman:</strong><br>
                                    ${order.jenis_pengiriman === 'delivery' ? '<i class="fas fa-truck"></i> Delivery' : '<i class="fas fa-store"></i> Pickup'}
                                </div>
                                ${order.catatan_pelanggan ? `
                                    <div style="grid-column: span 2;">
                                        <strong>Catatan Pelanggan:</strong><br>
                                        <em>${order.catatan_pelanggan}</em>
                                    </div>
                                ` : ''}
                            </div>
                        </div>
                        
                        <div style="margin-bottom: 25px;">
                            <h4 style="color: var(--primary); margin-bottom: 15px; border-bottom: 2px solid var(--primary); padding-bottom: 10px;">
                                <i class="fas fa-list"></i> Detail Pesanan
                            </h4>
                            <div style="background: var(--gray-100); border-radius: var(--radius); padding: 15px;">
                                <table style="width: 100%; border-collapse: collapse;">
                                    <thead>
                                        <tr style="background: var(--gray-200);">
                                            <th style="padding: 10px; text-align: left; font-size: 12px; color: var(--gray-600);">Item</th>
                                            <th style="padding: 10px; text-align: center; font-size: 12px; color: var(--gray-600);">Qty</th>
                                            <th style="padding: 10px; text-align: right; font-size: 12px; color: var(--gray-600);">Harga</th>
                                            <th style="padding: 10px; text-align: right; font-size: 12px; color: var(--gray-600);">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                    `;
                    
                    // Add order items
                    if (order.details && order.details.length > 0) {
                        order.details.forEach(item => {
                            const itemName = item.varian && item.varian.menu 
                                ? item.varian.menu.nama_menu 
                                : (item.varian ? item.varian.nama_varian : 'Produk');
                            
                            orderDetailHTML += `
                                <tr style="border-bottom: 1px solid var(--border);">
                                    <td style="padding: 10px; font-size: 13px;">
                                        <strong>${itemName}</strong><br>
                                        <small style="color: var(--gray-500);">${item.catatan || '-'}</small>
                                    </td>
                                    <td style="padding: 10px; text-align: center; font-size: 13px;">
                                        ${item.jumlah}x
                                    </td>
                                    <td style="padding: 10px; text-align: right; font-size: 13px;">
                                        Rp${formatNumber(item.harga_per_unit)}
                                    </td>
                                    <td style="padding: 10px; text-align: right; font-size: 13px; font-weight: 600;">
                                        Rp${formatNumber(item.subtotal)}
                                    </td>
                                </tr>
                            `;
                        });
                    }
                    
                    // Add order summary
                    orderDetailHTML += `
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div style="margin-bottom: 25px;">
                            <h4 style="color: var(--primary); margin-bottom: 15px; border-bottom: 2px solid var(--primary); padding-bottom: 10px;">
                                <i class="fas fa-money-bill-wave"></i> Ringkasan Pembayaran
                            </h4>
                            <div style="background: var(--gray-100); border-radius: var(--radius); padding: 20px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px dashed var(--border);">
                                    <span>Subtotal:</span>
                                    <span style="font-weight: 600;">Rp${formatNumber(order.subtotal)}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px dashed var(--border);">
                                    <span>Biaya Pengiriman:</span>
                                    <span style="font-weight: 600;">Rp${formatNumber(order.biaya_pengiriman)}</span>
                                </div>
                                ${order.diskon > 0 ? `
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px dashed var(--border);">
                                        <span>Diskon:</span>
                                        <span style="font-weight: 600; color: var(--success);">-Rp${formatNumber(order.diskon)}</span>
                                    </div>
                                ` : ''}
                                <div style="display: flex; justify-content: space-between; margin-top: 15px; padding-top: 15px; border-top: 2px solid var(--border); font-size: 18px; font-weight: 700;">
                                    <span>Total Bayar:</span>
                                    <span style="color: var(--primary);">Rp${formatNumber(order.total_bayar)}</span>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    // Add payment info if exists
                    if (order.pembayaran) {
                        orderDetailHTML += `
                            <div>
                                <h4 style="color: var(--primary); margin-bottom: 15px; border-bottom: 2px solid var(--primary); padding-bottom: 10px;">
                                    <i class="fas fa-credit-card"></i> Informasi Pembayaran
                                </h4>
                                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; background: var(--gray-100); border-radius: var(--radius); padding: 20px;">
                                    <div>
                                        <strong>Metode Pembayaran:</strong><br>
                                        <span class="method-badge" style="margin-top: 5px;">
                                            {{ $paymentMethods['${order.pembayaran.metode_pembayaran}'] ?? '${order.pembayaran.metode_pembayaran}' }}
                                        </span>
                                    </div>
                                    <div>
                                        <strong>Status Pembayaran:</strong><br>
                                        <span class="payment-badge payment-${order.pembayaran.status_pembayaran}" style="margin-top: 5px;">
                                            {{ $paymentStatusOptions['${order.pembayaran.status_pembayaran}'] ?? '${order.pembayaran.status_pembayaran}' }}
                                        </span>
                                    </div>
                                    ${order.pembayaran.id_transaksi ? `
                                        <div>
                                            <strong>ID Transaksi:</strong><br>
                                            ${order.pembayaran.id_transaksi}
                                        </div>
                                    ` : ''}
                                    ${order.pembayaran.tanggal_pembayaran ? `
                                        <div>
                                            <strong>Tanggal Bayar:</strong><br>
                                            ${new Date(order.pembayaran.tanggal_pembayaran).toLocaleDateString('id-ID')}
                                        </div>
                                    ` : ''}
                                    ${order.pembayaran.catatan ? `
                                        <div style="grid-column: span 2;">
                                            <strong>Catatan:</strong><br>
                                            ${order.pembayaran.catatan}
                                        </div>
                                    ` : ''}
                                </div>
                            </div>
                        `;
                    }
                    
                    document.getElementById('orderDetailContent').innerHTML = orderDetailHTML;
                    openModal('orderModal');
                } else {
                    alert('Gagal memuat detail pesanan');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memuat data');
            } finally {
                hideLoading();
            }
        }

        // Open payment modal
        async function openPaymentModal(orderId) {
            try {
                showLoading('Memuat data pembayaran...');
                
                const response = await fetch(`/kasir/payment/${orderId}/detail`);
                const result = await response.json();
                
                if (result.success) {
                    const { pembayaran, pesanan } = result.data;
                    currentOrderId = orderId;
                    
                    // Update payment summary
                    const paymentSummaryHTML = `
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                            <div>
                                <strong style="font-size: 16px;">${pesanan.nomor_pesanan}</strong><br>
                                <span style="color: var(--gray-500); font-size: 13px;">${pesanan.nama_penerima}</span>
                            </div>
                            <div style="text-align: right;">
                                <div style="font-size: 24px; font-weight: 700; color: var(--primary);">
                                    Rp${formatNumber(pesanan.total_bayar)}
                                </div>
                            </div>
                        </div>
                        <div style="display: flex; gap: 15px; margin-top: 15px;">
                            <div style="flex: 1;">
                                <div style="font-size: 12px; color: var(--gray-500);">Status Pesanan</div>
                                <span class="status-badge status-${pesanan.status}" style="margin-top: 5px;">
                                    {{ $statusOptions['${pesanan.status}'] ?? '${pesanan.status}' }}
                                </span>
                            </div>
                            <div style="flex: 1;">
                                <div style="font-size: 12px; color: var(--gray-500);">Status Pembayaran</div>
                                <span class="payment-badge payment-${pembayaran.status_pembayaran}" style="margin-top: 5px;">
                                    {{ $paymentStatusOptions['${pembayaran.status_pembayaran}'] ?? '${pembayaran.status_pembayaran}' }}
                                </span>
                            </div>
                        </div>
                    `;
                    
                    document.getElementById('paymentSummary').innerHTML = paymentSummaryHTML;
                    
                    // Set form values
                    document.getElementById('paymentMethod').value = pembayaran.metode_pembayaran;
                    document.getElementById('paymentStatus').value = pembayaran.status_pembayaran;
                    document.getElementById('transactionId').value = pembayaran.id_transaksi || '';
                    document.getElementById('paymentNote').value = pembayaran.catatan || '';
                    
                    // Update Select2
                    $('#paymentMethod, #paymentStatus').trigger('change');
                    
                    openModal('paymentModal');
                } else {
                    alert('Gagal memuat data pembayaran');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memuat data');
            } finally {
                hideLoading();
            }
        }

        // Open status modal
        function openStatusModal(orderId, status = null) {
            currentOrderId = orderId;
            if (status) {
                document.getElementById('newStatus').value = status;
                $('#newStatus').trigger('change');
            }
            openModal('statusModal');
        }

        // Process cash payment
        async function processCashPayment() {
            if (!currentOrderId) {
                alert('Tidak ada pesanan yang dipilih');
                return;
            }
            
            if (!confirm('Apakah Anda yakin ingin memproses pembayaran tunai/COD untuk pesanan ini?')) {
                return;
            }
            
            try {
                showLoading('Memproses pembayaran...');
                
                const response = await fetch(`/kasir/payment/${currentOrderId}/cash`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    alert('✅ Pembayaran tunai berhasil diproses!');
                    closeModal('paymentModal');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    alert('❌ ' + result.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('❌ Terjadi kesalahan saat memproses pembayaran');
            } finally {
                hideLoading();
            }
        }

        // Payment form submission
        document.getElementById('paymentForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            if (!currentOrderId) {
                alert('Tidak ada pesanan yang dipilih');
                return;
            }
            
            if (!confirm('Apakah Anda yakin ingin menyimpan perubahan pembayaran?')) {
                return;
            }
            
            try {
                showLoading('Menyimpan data pembayaran...');
                
                const formData = new FormData(this);
                
                const response = await fetch(`/kasir/payment/${currentOrderId}/update`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    alert('✅ Data pembayaran berhasil disimpan!');
                    closeModal('paymentModal');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    alert('❌ ' + result.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('❌ Terjadi kesalahan saat menyimpan data');
            } finally {
                hideLoading();
            }
        });

        // Status form submission
        document.getElementById('statusForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            if (!currentOrderId) {
                alert('Tidak ada pesanan yang dipilih');
                return;
            }
            
            if (!confirm('Apakah Anda yakin ingin mengubah status pesanan?')) {
                return;
            }
            
            try {
                showLoading('Mengupdate status pesanan...');
                
                const formData = new FormData(this);
                
                const response = await fetch(`/kasir/order/${currentOrderId}/status`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    alert('✅ Status pesanan berhasil diupdate!');
                    closeModal('statusModal');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    alert('❌ ' + result.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('❌ Terjadi kesalahan saat mengupdate status');
            } finally {
                hideLoading();
            }
        });

        // Auto-refresh orders every 30 seconds
        let autoRefreshInterval = null;
        
        function startAutoRefresh() {
            if (autoRefreshInterval) {
                clearInterval(autoRefreshInterval);
            }
            
            if (window.location.pathname === '/kasir/dashboard') {
                autoRefreshInterval = setInterval(() => {
                    const isModalOpen = 
                        document.getElementById('orderModal').style.display === 'flex' ||
                        document.getElementById('paymentModal').style.display === 'flex' ||
                        document.getElementById('statusModal').style.display === 'flex';
                    
                    if (!isModalOpen) {
                        location.reload();
                    }
                }, 30000);
            }
        }

        // Start auto-refresh on page load
        document.addEventListener('DOMContentLoaded', function() {
            startAutoRefresh();
        });

        // Initialize everything when DOM is loaded
        $(document).ready(function() {
            console.log('Dashboard Kasir Dimsum Time siap digunakan!');
            
            // Add subtle animation to cards on load
            $('.stat-card').each(function(i) {
                $(this).delay(i * 100).animate({ opacity: 1 }, 400);
            });
        });
    </script>
</body>
</html>