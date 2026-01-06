<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kurir - Dimsum Time</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Baloo+2:wght@600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

        /* Header */
        .header {
            background: var(--light);
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 0;
            z-index: 50;
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }

        .header-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 4rem;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: inherit;
        }

        .logo-icon {
            width: 2.5rem;
            height: 2.5rem;
            background: var(--primary-gradient);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
            font-weight: 700;
        }

        .logo-text {
            font-family: 'Baloo 2', cursive;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            letter-spacing: -0.025em;
        }

        .logo-tag {
            background: var(--primary-gradient);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .user-nav {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem;
            border-radius: var(--radius);
            transition: var(--transition);
            cursor: pointer;
        }

        .user-profile:hover {
            background: var(--gray-100);
        }

        .user-avatar {
            width: 2.5rem;
            height: 2.5rem;
            background: var(--primary-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            border: 2px solid white;
            box-shadow: var(--shadow);
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--dark);
        }

        .user-role {
            font-size: 0.75rem;
            color: var(--gray-500);
            font-weight: 500;
        }

        .logout-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--light);
            color: var(--gray-600);
            border: 1px solid var(--border);
            padding: 0.625rem 1rem;
            border-radius: var(--radius);
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .logout-btn:hover {
            background: var(--gray-100);
            color: var(--danger);
            border-color: var(--gray-300);
        }

        /* Main Content */
        .main-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* Hero Section */
        .hero-section {
            margin-bottom: 2rem;
        }

        .hero-card {
            background: var(--primary-gradient);
            color: white;
            border-radius: var(--radius-md);
            padding: 2rem;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
        }

        .hero-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 12rem;
            height: 12rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(30%, -30%);
        }

        .hero-content {
            position: relative;
            z-index: 10;
        }

        .hero-title {
            font-family: 'Baloo 2', cursive;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1rem;
            opacity: 0.9;
            margin-bottom: 1.5rem;
            max-width: 32rem;
        }

        .hero-stats {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .hero-stat {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .hero-stat-icon {
            width: 3rem;
            height: 3rem;
            background: rgba(255, 255, 255, 0.2);
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .hero-stat-content h3 {
            font-size: 0.75rem;
            opacity: 0.8;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.25rem;
        }

        .hero-stat-value {
            font-size: 1.5rem;
            font-weight: 700;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--light);
            border-radius: var(--radius-md);
            padding: 1.5rem;
            box-shadow: var(--shadow);
            transition: var(--transition);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .stat-icon-container {
            width: 4rem;
            height: 4rem;
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .stat-card.delivery .stat-icon-container {
            background: var(--info-gradient);
        }

        .stat-card.completed .stat-icon-container {
            background: var(--success-gradient);
        }

        .stat-card.total .stat-icon-container {
            background: var(--primary-gradient);
        }

        .stat-content {
            flex: 1;
        }

        .stat-title {
            font-size: 0.875rem;
            color: var(--gray-500);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.25rem;
        }

        .stat-value {
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.25rem;
        }

        .stat-trend {
            font-size: 0.75rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .stat-trend.up {
            color: var(--success);
        }

        .stat-trend.neutral {
            color: var(--gray-500);
        }

        /* Orders Section */
        .orders-section {
            background: var(--light);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .section-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-title i {
            color: var(--primary);
        }

        .section-tools {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .search-container {
            position: relative;
        }

        .search-input {
            padding: 0.625rem 1rem 0.625rem 2.5rem;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            font-size: 0.875rem;
            width: 16rem;
            transition: var(--transition);
            background: var(--light);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(229, 57, 53, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-400);
        }

        .refresh-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--light);
            color: var(--gray-600);
            border: 1px solid var(--border);
            padding: 0.625rem 1rem;
            border-radius: var(--radius);
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .refresh-button:hover {
            background: var(--gray-100);
            border-color: var(--gray-300);
        }

        /* Orders Table */
        .table-container {
            overflow-x: auto;
            padding: 1.5rem;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1000px;
        }

        .orders-table thead {
            background: var(--gray-100);
        }

        .orders-table th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--gray-600);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 2px solid var(--border);
            white-space: nowrap;
        }

        .orders-table tbody tr {
            border-bottom: 1px solid var(--border);
            transition: var(--transition);
        }

        .orders-table tbody tr:hover {
            background: var(--gray-50);
        }

        .orders-table td {
            padding: 1rem;
            vertical-align: middle;
        }

        .order-number-cell {
            min-width: 140px;
        }

        .order-number {
            font-weight: 600;
            color: var(--primary);
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .order-number i {
            color: var(--gray-400);
        }

        .customer-cell {
            min-width: 180px;
        }

        .customer-info {
            display: flex;
            flex-direction: column;
            gap: 0.375rem;
        }

        .customer-name {
            font-weight: 600;
            font-size: 0.875rem;
        }

        .customer-contact {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.75rem;
            color: var(--gray-500);
        }

        .customer-contact i {
            color: var(--primary);
            font-size: 0.75rem;
        }

        .customer-note {
            font-size: 0.75rem;
            color: var(--gray-500);
            font-style: italic;
            margin-top: 0.25rem;
        }

        .items-cell {
            min-width: 180px;
        }

        .items-list {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .item-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.5rem 0.75rem;
            background: var(--gray-100);
            border-radius: var(--radius-sm);
            transition: var(--transition);
        }

        .item-row:hover {
            background: var(--gray-200);
        }

        .item-name {
            font-weight: 500;
            font-size: 0.875rem;
        }

        .item-qty {
            background: var(--light);
            padding: 0.125rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--primary);
        }

        .address-cell {
            min-width: 220px;
            max-width: 280px;
        }

        .delivery-address {
            line-height: 1.4;
            font-size: 0.875rem;
            color: var(--dark);
        }

        .delivery-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            background: var(--info-gradient);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-top: 0.5rem;
        }

        .time-cell {
            min-width: 100px;
        }

        .order-time {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .order-date {
            font-size: 0.75rem;
            color: var(--gray-500);
        }

        .order-hour {
            font-weight: 600;
            color: var(--dark);
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .order-hour i {
            color: var(--gray-400);
        }

        .actions-cell {
            min-width: 120px;
        }

        .complete-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--success-gradient);
            color: white;
            border: none;
            padding: 0.625rem 1rem;
            border-radius: var(--radius);
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: var(--transition);
            width: 100%;
            justify-content: center;
        }

        .complete-button:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        /* Empty State */
        .empty-state {
            padding: 4rem 2rem;
            text-align: center;
        }

        .empty-icon {
            font-size: 4rem;
            color: var(--gray-300);
            margin-bottom: 1.5rem;
            opacity: 0.5;
        }

        .empty-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-500);
            margin-bottom: 0.5rem;
        }

        .empty-description {
            color: var(--gray-400);
            max-width: 24rem;
            margin: 0 auto 2rem;
        }

        .empty-action {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: var(--radius);
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .empty-action:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        /* Pagination */
        .pagination-container {
            padding: 1.5rem;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
        }

        .pagination {
            display: flex;
            gap: 0.25rem;
        }

        .page-link {
            padding: 0.5rem 0.75rem;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--gray-600);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.875rem;
            transition: var(--transition);
            background: var(--light);
        }

        .page-link:hover {
            background: var(--gray-100);
            border-color: var(--gray-300);
        }

        .page-link.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .page-link.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Modal */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            animation: fadeIn 0.2s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-container {
            background: var(--light);
            border-radius: var(--radius-md);
            width: 100%;
            max-width: 28rem;
            max-height: calc(100vh - 2rem);
            overflow-y: auto;
            box-shadow: var(--shadow-lg);
            animation: slideUp 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(1rem) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--primary-gradient);
            color: white;
            border-radius: var(--radius-md) var(--radius-md) 0 0;
        }

        .modal-title {
            font-size: 1.125rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .modal-close {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: white;
            font-size: 1.25rem;
            transition: var(--transition);
        }

        .modal-close:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .modal-body {
            padding: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark);
            font-size: 0.875rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            font-size: 0.875rem;
            transition: var(--transition);
            background: var(--light);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(229, 57, 53, 0.1);
        }

        .form-control[readonly] {
            background: var(--gray-100);
            cursor: not-allowed;
        }

        .upload-area {
            border: 2px dashed var(--border);
            border-radius: var(--radius);
            padding: 2.5rem 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            background: var(--light);
            position: relative;
        }

        .upload-area:hover {
            border-color: var(--primary);
            background: var(--gray-50);
        }

        .upload-area.dragover {
            border-color: var(--primary);
            background: var(--gray-100);
        }

        .upload-icon {
            font-size: 2.5rem;
            color: var(--gray-400);
            margin-bottom: 1rem;
        }

        .upload-text {
            color: var(--dark);
            margin-bottom: 0.5rem;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .upload-hint {
            color: var(--gray-500);
            font-size: 0.75rem;
        }

        .upload-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .preview-container {
            margin-top: 1.25rem;
            display: none;
        }

        .preview-image {
            max-width: 100%;
            max-height: 12rem;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
        }

        .modal-footer {
            padding: 1.25rem 1.5rem;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            background: var(--gray-50);
            border-radius: 0 0 var(--radius-md) var(--radius-md);
        }

        .modal-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: var(--radius);
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: var(--transition);
            border: 1px solid transparent;
        }

        .modal-button.cancel {
            background: var(--light);
            color: var(--gray-600);
            border-color: var(--border);
        }

        .modal-button.cancel:hover {
            background: var(--gray-100);
            border-color: var(--gray-300);
        }

        .modal-button.submit {
            background: var(--success-gradient);
            color: white;
            border: none;
        }

        .modal-button.submit:hover:not(:disabled) {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .modal-button.submit:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none !important;
            box-shadow: none !important;
        }

        /* Loading */
        .loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(4px);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 1.5rem;
        }

        .loading-spinner {
            width: 3rem;
            height: 3rem;
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
            font-size: 1rem;
            font-weight: 600;
            color: var(--dark);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-container {
                height: auto;
                padding: 1rem;
                flex-direction: column;
                gap: 1rem;
            }

            .logo-container {
                width: 100%;
                justify-content: space-between;
            }

            .user-nav {
                width: 100%;
                justify-content: space-between;
            }

            .hero-card {
                padding: 1.5rem;
            }

            .hero-title {
                font-size: 1.5rem;
            }

            .hero-stats {
                flex-direction: column;
                gap: 1rem;
            }

            .section-header {
                flex-direction: column;
                align-items: stretch;
                gap: 1rem;
            }

            .section-tools {
                flex-direction: column;
                width: 100%;
            }

            .search-input {
                width: 100%;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .table-container {
                padding: 1rem;
            }

            .orders-table th,
            .orders-table td {
                padding: 0.75rem;
                font-size: 0.75rem;
            }
        }

        @media (max-width: 480px) {
            .main-container {
                padding: 1rem;
            }

            .stat-card {
                flex-direction: column;
                text-align: center;
                padding: 1.25rem;
            }

            .stat-icon-container {
                width: 3rem;
                height: 3rem;
                font-size: 1.25rem;
            }

            .modal-container {
                margin: 0.5rem;
            }

            .modal-body {
                padding: 1rem;
            }

            .modal-footer {
                flex-direction: column;
            }

            .modal-button {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
        <div class="loading-text" id="loadingText">Memproses...</div>
    </div>

    <!-- Completion Modal -->
    <div class="modal-overlay" id="completionModal">
        <div class="modal-container">
            <div class="modal-header">
                <h3 class="modal-title">
                    <i class="fas fa-check-circle"></i>
                    Konfirmasi Pengiriman Selesai
                </h3>
                <button class="modal-close" id="closeModal">&times;</button>
            </div>
            
            <form id="deliveryForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label" for="orderNumber">Nomor Pesanan</label>
                        <input type="text" class="form-control" id="orderNumber" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="customerName">Nama Penerima</label>
                        <input type="text" class="form-control" id="customerName" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="deliveryAddress">Alamat Pengiriman</label>
                        <textarea class="form-control" id="deliveryAddress" rows="3" readonly></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Foto Bukti Pengiriman</label>
                        <div class="upload-area" id="uploadArea">
                            <div class="upload-icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <div class="upload-text">Klik atau tarik file ke sini</div>
                            <div class="upload-hint">Format: JPG, PNG, JPEG (Max. 5MB)</div>
                            <input type="file" class="upload-input" id="photoInput" accept="image/*">
                        </div>
                        <div class="preview-container" id="previewContainer">
                            <img class="preview-image" id="previewImage" alt="Preview">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="deliveryNotes">Catatan Pengiriman (Opsional)</label>
                        <textarea class="form-control" id="deliveryNotes" rows="3" placeholder="Contoh: Diterima oleh keluarga, paket dalam kondisi baik..."></textarea>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="modal-button cancel" id="cancelBtn">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="modal-button submit" id="submitBtn" disabled>
                        <i class="fas fa-check"></i> Konfirmasi Selesai
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Header -->
    <header class="header">
        <div class="header-container">
            <div class="logo-container">
                <div class="logo">
                    <div class="logo-icon">DT</div>
                    <span class="logo-text">Dimsum Time</span>
                </div>
                <span class="logo-tag">Kurir</span>
            </div>
            
            <div class="user-nav">
                <div class="user-profile">
                    <div class="user-avatar" id="userInitials">
                        {{ substr(Auth::user()->nama_lengkap ?? 'K', 0, 1) }}
                    </div>
                    <div class="user-info">
                        <div class="user-name">{{ Auth::user()->nama_lengkap ?? 'Kurir' }}</div>
                        <div class="user-role">Kurir Pengiriman</div>
                    </div>
                </div>
                
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-container">
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-card">
                <div class="hero-content">
                    <h1 class="hero-title">Halo, {{ Auth::user()->nama_lengkap ?? 'Kurir' }}! 🚚</h1>
                    <p class="hero-subtitle">Kelola pengiriman pesanan dengan mudah dan efisien. Pastikan setiap pesanan sampai tepat waktu!</p>
                    
                    <div class="hero-stats">
                        <div class="hero-stat">
                            <div class="hero-stat-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="hero-stat-content">
                                <h3>WAKTU SEKARANG</h3>
                                <div class="hero-stat-value" id="currentTime">{{ now()->format('H:i') }}</div>
                            </div>
                        </div>
                        <div class="hero-stat">
                            <div class="hero-stat-icon">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                            <div class="hero-stat-content">
                                <h3>TANGGAL</h3>
                                <div class="hero-stat-value">{{ now()->translatedFormat('d M Y') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card delivery">
                <div class="stat-icon-container">
                    <i class="fas fa-truck"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-title">Sedang Dikirim</div>
                    <div class="stat-value">{{ $statistik['sedang_dikirim'] }}</div>
                    <div class="stat-trend up">
                        <i class="fas fa-arrow-up"></i>
                        <span>Pesanan aktif</span>
                    </div>
                </div>
            </div>
            
            <div class="stat-card completed">
                <div class="stat-icon-container">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-title">Selesai Hari Ini</div>
                    <div class="stat-value">{{ $statistik['selesai_hari_ini'] }}</div>
                    <div class="stat-trend up">
                        <i class="fas fa-check"></i>
                        <span>Pengiriman sukses</span>
                    </div>
                </div>
            </div>
            
            <div class="stat-card total">
                <div class="stat-icon-container">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-title">Total Pengiriman</div>
                    <div class="stat-value">{{ $statistik['total_pengiriman'] }}</div>
                    <div class="stat-trend neutral">
                        <i class="fas fa-chart-bar"></i>
                        <span>Total keseluruhan</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Section -->
        <section class="orders-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-list-ul"></i>
                    Pesanan yang Perlu Dikirim
                </h2>
                
                <div class="section-tools">
                    <div class="search-container">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="search-input" id="searchInput" 
                               placeholder="Cari nomor pesanan atau nama..." 
                               value="{{ request('search') }}">
                    </div>
                    
                    <button class="refresh-button" onclick="window.location.reload()">
                        <i class="fas fa-redo"></i> Refresh
                    </button>
                </div>
            </div>
            
            <div class="table-container">
                @if($pesanan->count() > 0)
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th>No. Pesanan</th>
                                <th>Pelanggan</th>
                                <th>Pesanan</th>
                                <th>Alamat</th>
                                <th>Waktu Pesan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pesanan as $order)
                            <tr>
                                <td class="order-number-cell">
                                    <div class="order-number">
                                        <i class="fas fa-hashtag"></i>
                                        {{ $order->nomor_pesanan }}
                                    </div>
                                </td>
                                
                                <td class="customer-cell">
                                    <div class="customer-info">
                                        <div class="customer-name">{{ $order->nama_penerima }}</div>
                                        <div class="customer-contact">
                                            <i class="fas fa-phone"></i>
                                            {{ $order->nomor_telepon }}
                                        </div>
                                        @if($order->catatan_pelanggan)
                                        <div class="customer-note">
                                            <i class="fas fa-sticky-note"></i> {{ $order->catatan_pelanggan }}
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                
                                <td class="items-cell">
                                    <div class="items-list">
                                        @foreach($order->details as $item)
                                        <div class="item-row">
                                            <span class="item-name">
                                                @if($item->varian && $item->varian->menu)
                                                    {{ $item->varian->menu->nama_menu }}
                                                @elseif($item->varian && $item->varian->nama_varian)
                                                    {{ $item->varian->nama_varian }}
                                                @else
                                                    Produk {{ $item->id_varian }}
                                                @endif
                                            </span>
                                            <span class="item-qty">{{ $item->jumlah }}x</span>
                                        </div>
                                        @endforeach
                                    </div>
                                </td>
                                
                                <td class="address-cell">
                                    <div class="delivery-address">
                                        {{ Str::limit($order->alamat_pengiriman, 80) }}
                                    </div>
                                    @if($order->jenis_pengiriman == 'delivery')
                                    <div class="delivery-badge">
                                        <i class="fas fa-shipping-fast"></i> Delivery
                                    </div>
                                    @endif
                                </td>
                                
                                <td class="time-cell">
                                    <div class="order-time">
                                        <div class="order-date">
                                            {{ \Carbon\Carbon::parse($order->tanggal_pesanan)->translatedFormat('d M Y') }}
                                        </div>
                                        <div class="order-hour">
                                            <i class="fas fa-clock"></i>
                                            {{ \Carbon\Carbon::parse($order->tanggal_pesanan)->format('H:i') }}
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="actions-cell">
                                    <button class="complete-button" onclick="openCompletionModal('{{ $order->id_pesanan }}')">
                                        <i class="fas fa-check-circle"></i> Selesaikan
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <!-- Pagination -->
                    @if($pesanan->hasPages())
                    <div class="pagination-container">
                        <div class="pagination">
                            {{ $pesanan->links('pagination::simple-bootstrap-4') }}
                        </div>
                    </div>
                    @endif
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-truck-loading"></i>
                        </div>
                        <h3 class="empty-title">Tidak Ada Pesanan</h3>
                        <p class="empty-description">Tidak ada pesanan yang perlu dikirim saat ini. Silakan refresh halaman untuk update terbaru.</p>
                        <button class="empty-action" onclick="window.location.reload()">
                            <i class="fas fa-redo"></i> Refresh Halaman
                        </button>
                    </div>
                @endif
            </div>
        </section>
    </main>

    <script>
        // DOM Elements
        const loadingOverlay = document.getElementById('loadingOverlay');
        const loadingText = document.getElementById('loadingText');
        const completionModal = document.getElementById('completionModal');
        const closeModalBtn = document.getElementById('closeModal');
        const cancelBtn = document.getElementById('cancelBtn');
        const deliveryForm = document.getElementById('deliveryForm');
        const uploadArea = document.getElementById('uploadArea');
        const photoInput = document.getElementById('photoInput');
        const previewContainer = document.getElementById('previewContainer');
        const previewImage = document.getElementById('previewImage');
        const submitBtn = document.getElementById('submitBtn');
        const searchInput = document.getElementById('searchInput');

        let currentOrderId = null;
        let selectedPhoto = null;

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

        // Initialize time
        updateCurrentTime();
        setInterval(updateCurrentTime, 60000);

        // Set user initials
        function getUserInitials() {
            const userName = "{{ Auth::user()->nama_lengkap ?? 'K' }}";
            return userName.split(' ').map(word => word[0]).join('').toUpperCase();
        }
        document.getElementById('userInitials').textContent = getUserInitials();

        // Search functionality
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                const searchTerm = this.value.trim();
                if (searchTerm) {
                    window.location.href = '{{ route("kurir.dashboard") }}?search=' + encodeURIComponent(searchTerm);
                } else {
                    window.location.href = '{{ route("kurir.dashboard") }}';
                }
            }
        });

        // Loading functions
        function showLoading(message = 'Memproses...') {
            loadingText.textContent = message;
            loadingOverlay.style.display = 'flex';
        }

        function hideLoading() {
            loadingOverlay.style.display = 'none';
        }

        // Modal functions
        async function openCompletionModal(orderId) {
            try {
                showLoading('Memuat data pesanan...');
                
                const response = await fetch(`/kurir/order/${orderId}/detail`);
                const result = await response.json();
                
                if (result.success) {
                    const order = result.data;
                    currentOrderId = order.id_pesanan;
                    
                    // Fill form data
                    document.getElementById('orderNumber').value = order.nomor_pesanan;
                    document.getElementById('customerName').value = order.nama_penerima;
                    document.getElementById('deliveryAddress').value = order.alamat_pengiriman;
                    
                    // Reset form
                    previewContainer.style.display = 'none';
                    previewImage.src = '';
                    document.getElementById('deliveryNotes').value = '';
                    selectedPhoto = null;
                    submitBtn.disabled = true;
                    
                    // Show modal
                    completionModal.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                } else {
                    alert('Gagal memuat detail pesanan: ' + (result.message || 'Terjadi kesalahan'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memuat data. Silakan coba lagi.');
            } finally {
                hideLoading();
            }
        }

        function closeModal() {
            completionModal.style.display = 'none';
            document.body.style.overflow = 'auto';
            currentOrderId = null;
            selectedPhoto = null;
        }

        // Event listeners for modal
        closeModalBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);

        // Close modal when clicking outside or pressing Escape
        window.addEventListener('click', (e) => {
            if (e.target === completionModal) closeModal();
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && completionModal.style.display === 'flex') {
                closeModal();
            }
        });

        // Upload functionality
        uploadArea.addEventListener('click', () => photoInput.click());

        photoInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                handleFileUpload(e.target.files[0]);
            }
        });

        // Drag and drop
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            if (e.dataTransfer.files.length > 0) {
                handleFileUpload(e.dataTransfer.files[0]);
            }
        });

        // Handle file upload
        function handleFileUpload(file) {
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            if (!validTypes.includes(file.type)) {
                alert('Hanya file gambar yang diperbolehkan! (JPG, PNG, GIF)');
                return;
            }
            
            if (file.size > 5 * 1024 * 1024) {
                alert('Ukuran file maksimal 5MB!');
                return;
            }
            
            selectedPhoto = file;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.style.display = 'block';
            };
            reader.readAsDataURL(file);
            
            submitBtn.disabled = false;
        }

        // Form submission
        deliveryForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            if (!selectedPhoto) {
                alert('Harap upload foto bukti pengiriman!');
                return;
            }
            
            if (!confirm('Apakah Anda yakin ingin menyelesaikan pengiriman ini?')) {
                return;
            }
            
            try {
                showLoading('Menyelesaikan pengiriman...');
                
                const formData = new FormData();
                formData.append('bukti_pengiriman', selectedPhoto);
                formData.append('catatan_kurir', document.getElementById('deliveryNotes').value);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                
                const response = await fetch(`/kurir/order/${currentOrderId}/complete`, {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    alert('✅ ' + result.message);
                    if (result.redirect) {
                        window.location.href = result.redirect;
                    } else {
                        location.reload();
                    }
                } else {
                    alert('❌ ' + (result.message || 'Gagal menyelesaikan pengiriman'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('❌ Terjadi kesalahan saat mengirim data. Silakan coba lagi.');
            } finally {
                hideLoading();
            }
        });

        // Auto refresh every 60 seconds
        setInterval(() => {
            if (!currentOrderId && loadingOverlay.style.display !== 'flex') {
                window.location.reload();
            }
        }, 60000);

        // Add animations on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Animate table rows
            const tableRows = document.querySelectorAll('.orders-table tbody tr');
            tableRows.forEach((row, index) => {
                row.style.opacity = '0';
                row.style.transform = 'translateY(10px)';
                
                setTimeout(() => {
                    row.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    row.style.opacity = '1';
                    row.style.transform = 'translateY(0)';
                }, index * 50);
            });
            
            // Animate stat cards
            const statCards = document.querySelectorAll('.stat-card');
            statCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 200 + (index * 100));
            });
        });
    </script>
</body>
</html>