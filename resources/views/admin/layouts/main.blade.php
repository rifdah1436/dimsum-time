<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Dimsum Time</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Baloo+2&family=Open+Sans:wght@400;700&family=Source+Sans+3:wght@400;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Warna-warna sesuai variabel :root kamu */
        :root {
            --bg-main: #f4f2f2;
            --bg-sidebar: #e53935;
            --bg-content: #fff3e0;
            --bg-card: #ffffff;
            --bg-active: #fbc02d;
            --bg-table-header: #f76c5e;
            --bg-status-pending: #fbc02d;
            --bg-status-selesai: #67de6f;
            --bg-status-gagal: #e53935;

            --text-sidebar: #fff3e0;
            --text-sidebar-active: #ffffff;
            --text-brand: #fbc02d;
            --text-primary: #000000;
            --text-secondary: #090909;
            --text-light: #ffffff;
            --text-logout: #e53935;

            --border-color: #e0e0e0;
            --font-brand: 'Baloo 2', cursive;
            --font-title: 'Open Sans', sans-serif;
            --font-subtitle: 'Source Sans 3', sans-serif;
            --font-data: 'Open Sans', sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            background-color: var(--bg-content);
            color: var(--text-primary);
            line-height: 1.4;
        }

        .dashboard-layout {
            display: flex;
            min-height: 100vh;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Sidebar - DIKECILKAN dengan warna merah */
        .sidebar {
            width: 240px;
            background-color: var(--bg-sidebar);
            padding: 20px 0; /* Diubah: padding kiri-kanan dihilangkan */
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }

        .sidebar-header {
            text-align: center;
            padding: 0 15px; /* Tambahkan padding hanya di header */
        }

        .brand-title {
            font-family: var(--font-brand);
            font-size: 24px;
            color: var(--text-brand);
            margin-bottom: 15px;
        }

        .separator {
            border: none;
            height: 1px;
            background-color: var(--text-light);
            opacity: 0.8;
            margin: 0 15px 30px; /* Tambahkan margin kiri-kanan */
        }

        .sidebar-nav {
            flex-grow: 1;
        }

        .sidebar-nav ul {
            display: flex;
            flex-direction: column;
            gap: 8px;
            list-style-type: none;
            padding: 0; /* Tambahkan: hapus padding default */
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            border-radius: 0; /* Diubah: hilangkan border-radius agar mepet */
            font-size: 16px;
            color: var(--text-sidebar);
            text-decoration: none;
            transition: background-color 0.3s;
            margin: 0; /* Tambahkan: hapus margin */
        }

        .nav-item:hover,
        .nav-item.active {
            background-color: var(--bg-active);
            color: var(--text-sidebar-active);
        }

        .nav-icon {
            width: 24px;
            height: 24px;
            object-fit: contain;
        }

        .logout-button {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 10px 20px;
            background-color: var(--bg-content);
            color: var(--text-logout);
            font-size: 18px;
            border-radius: 8px;
            margin: 15px; /* Tambahkan margin */
            text-decoration: none;
            transition: all 0.3s;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }

        .logout-button:hover {
            background-color: #ffe0b2;
        }

        /* Main Content - DIKECILKAN */
        .main-content {
            flex-grow: 1;
            padding: 20px 25px;
            background-color: var(--bg-content);
        }

        .main-header {
            margin-bottom: 30px;
        }

        .page-title {
            font-family: var(--font-title);
            font-size: 28px;
            color: var(--text-secondary);
            margin-bottom: 5px;
        }

        .page-subtitle {
            font-family: var(--font-subtitle);
            font-size: 16px;
            color: var(--text-primary);
            opacity: 0.9;
        }

        /* Summary Cards - DIKECILKAN */
        .summary-section {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }

        .summary-card {
            background-color: var(--bg-card);
            border-radius: 6px;
            padding: 16px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--border-color);
        }

        .card-title {
            font-family: var(--font-data);
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
        }

        .card-value {
            font-family: var(--font-data);
            font-size: 24px;
            font-weight: 700;
            color: var(--text-secondary);
            margin: 10px 0 15px;
        }

        .card-link {
            display: block;
            background-color: rgba(0, 0, 0, 0.05);
            padding: 8px 0;
            text-align: center;
            font-family: var(--font-data);
            font-size: 13px;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .card-link:hover {
            background-color: rgba(0, 0, 0, 0.1);
        }

        .card-link i {
            margin-left: 5px;
            font-size: 12px;
            color: var(--bg-sidebar);
        }

        /* Orders Section - DIKECILKAN */
        .orders-section {
            background-color: var(--bg-card);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--border-color);
        }

        .section-title {
            font-family: var(--font-title);
            font-size: 20px;
            color: var(--text-secondary);
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--bg-table-header);
        }

        .table-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            font-size: 14px;
            color: var(--text-primary);
        }

        .entries-control,
        .search-control {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .dropdown {
            display: flex;
            align-items: center;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 6px 10px;
            background-color: var(--bg-card);
            cursor: pointer;
        }

        .dropdown-arrow {
            margin-left: 8px;
            font-size: 12px;
            color: var(--text-primary);
        }

        .search-control input {
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 6px 10px;
            font-size: 14px;
            width: 180px;
        }

        .table-container {
            overflow-x: auto;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        th,
        td {
            padding: 12px 10px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap;
        }

        thead {
            background-color: var(--bg-table-header);
        }

        th {
            font-weight: 600;
            color: var(--text-secondary);
        }

        th i {
            margin-left: 4px;
            color: var(--text-primary);
            font-size: 12px;
            opacity: 0.7;
        }

        tbody tr {
            background-color: var(--bg-card);
        }

        tbody tr:hover {
            background-color: #f9f9f9;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            color: var(--text-light);
            font-weight: 700;
            font-size: 12px;
            text-align: center;
            min-width: 70px;
        }

        .status-pending {
            background-color: var(--bg-status-pending);
        }

        .status-selesai {
            background-color: var(--bg-status-selesai);
        }

        .status-gagal {
            background-color: var(--bg-status-gagal);
        }

        .table-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            font-size: 13px;
            color: #666;
            border-top: 1px solid var(--border-color);
        }

        .pagination {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .page-nav,
        .page-num {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 4px;
            text-decoration: none;
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
            background-color: white;
            cursor: pointer;
            transition: all 0.3s;
        }

        .page-nav {
            background-color: var(--bg-table-header);
            color: var(--text-light);
            border: none;
        }

        .page-num {
            background-color: white;
            color: var(--text-secondary);
        }

        .page-num.active {
            background-color: var(--bg-sidebar);
            color: var(--text-light);
            font-weight: bold;
            border-color: var(--bg-sidebar);
        }

        .page-num:hover:not(.active) {
            background-color: #f0f0f0;
        }

        /* Responsive Styles */
        @media (max-width: 1100px) {
            .dashboard-layout {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
                padding: 15px;
            }

            .sidebar-header {
                margin-bottom: 0;
                margin-right: auto;
                padding: 0;
            }

            .separator {
                display: none;
            }

            .sidebar-nav {
                display: none;
            }

            .logout-button {
                margin: 0;
                padding: 8px 16px;
                font-size: 16px;
            }

            .main-content {
                padding: 15px;
            }
        }

        @media (max-width: 768px) {
            .summary-section {
                grid-template-columns: repeat(2, 1fr);
            }

            .table-controls {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .table-footer {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .search-control input {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .summary-section {
                grid-template-columns: 1fr;
            }

            .sidebar {
                flex-direction: column;
                align-items: flex-start;
            }

            .sidebar-header {
                margin-right: 0;
                margin-bottom: 15px;
                width: 100%;
            }

            .logout-button {
                align-self: flex-start;
                margin-top: 15px;
            }
        }

        /* Alert Styles */
        .alert {
            padding: 15px 20px;
            border-radius: 6px;
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

        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        /* Additional Styles for Real Data */
        .status-badge {
            text-transform: capitalize;
        }
        
        .status-menunggu_pembayaran {
            background-color: #ffc107;
        }
        
        .status-dikonfirmasi {
            background-color: #17a2b8;
        }
        
        .status-diproses {
            background-color: #007bff;
        }
        
        .status-dimasak {
            background-color: #6c757d;
        }
        
        .status-siap_diantar {
            background-color: #17a2b8;
        }
        
        .status-diantar {
            background-color: #007bff;
        }
        
        .status-selesai {
            background-color: #28a745;
        }
        
        .status-dibatalkan {
            background-color: #dc3545;
        }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h1 class="brand-title">Dimsum Time</h1>
                <hr class="separator">
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt nav-icon"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.produk.index') }}" class="nav-item {{ request()->routeIs('admin.produk*') ? 'active' : '' }}">
                            <i class="fas fa-box nav-icon"></i>
                            <span>Manajemen Produk</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.pesanan.index') }}" class="nav-item {{ request()->routeIs('admin.pesanan*') ? 'active' : '' }}">
                            <i class="fas fa-shopping-cart nav-icon"></i>
                            <span>Pesanan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.pelanggan.index') }}" class="nav-item {{ request()->routeIs('admin.pelanggan*') ? 'active' : '' }}">
                            <i class="fas fa-users nav-icon"></i>
                            <span>Manajemen Pelanggan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.laporan.index') }}" class="nav-item {{ request()->routeIs('admin.laporan*') ? 'active' : '' }}">
                            <i class="fas fa-chart-bar nav-icon"></i>
                            <span>Laporan Penjualan</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-button">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </aside>

        <main class="main-content">
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

            @yield('content')
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);

        // Search functionality for orders
        $(document).ready(function() {
            $('#searchOrders').on('keyup', function() {
                const value = $(this).val().toLowerCase();
                $('#ordersTable tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });

            // Update table info
            function updateTableInfo() {
                const totalRows = $('#ordersTable tbody tr').length;
                const visibleRows = $('#ordersTable tbody tr:visible').length;
                $('#tableInfo').text(`Menampilkan ${visibleRows} pesanan dari ${totalRows} pesanan`);
            }

            $('#searchOrders').on('keyup', updateTableInfo);
            updateTableInfo();

            // Pagination functionality
            let currentPage = 1;
            const rowsPerPage = 10;

            function renderPagination() {
                const rows = $('#ordersTable tbody tr:visible');
                const totalRows = rows.length;
                const totalPages = Math.ceil(totalRows / rowsPerPage);

                // Clear pagination
                $('.page-num').remove();

                // Create page numbers
                for (let i = 1; i <= totalPages; i++) {
                    const pageNum = $(`<a href="#" class="page-num" data-page="${i}">${i}</a>`);
                    if (i === currentPage) {
                        pageNum.addClass('active');
                    }
                    pageNum.insertBefore('#nextPage');
                }

                // Update page numbers display
                $('.page-num').each(function() {
                    const pageNum = parseInt($(this).data('page'));
                    if (pageNum === 1 || pageNum === totalPages || 
                        (pageNum >= currentPage - 1 && pageNum <= currentPage + 1)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });

                // Show/hide navigation buttons
                $('#prevPage').toggleClass('disabled', currentPage === 1);
                $('#nextPage').toggleClass('disabled', currentPage === totalPages || totalPages === 0);

                // Show rows for current page
                const start = (currentPage - 1) * rowsPerPage;
                const end = start + rowsPerPage;

                rows.each(function(index) {
                    if (index >= start && index < end) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });

                // Update table info
                const showing = Math.min(end, totalRows);
                $('#tableInfo').text(`Menampilkan ${start + 1}-${showing} pesanan dari ${totalRows} pesanan`);
            }

            // Pagination event listeners
            $(document).on('click', '#prevPage', function(e) {
                e.preventDefault();
                if (currentPage > 1) {
                    currentPage--;
                    renderPagination();
                }
            });

            $(document).on('click', '#nextPage', function(e) {
                e.preventDefault();
                const rows = $('#ordersTable tbody tr:visible');
                const totalRows = rows.length;
                const totalPages = Math.ceil(totalRows / rowsPerPage);
                
                if (currentPage < totalPages) {
                    currentPage++;
                    renderPagination();
                }
            });

            $(document).on('click', '.page-num', function(e) {
                e.preventDefault();
                currentPage = parseInt($(this).data('page'));
                renderPagination();
            });

            // Initialize pagination
            renderPagination();

            // Sort table columns
            let sortColumn = 0;
            let sortDirection = 1;

            $('th').click(function() {
                const column = $(this).index();
                const rows = $('#ordersTable tbody tr').toArray();

                // Toggle sort direction if same column
                if (sortColumn === column) {
                    sortDirection = -sortDirection;
                } else {
                    sortColumn = column;
                    sortDirection = 1;
                }

                // Sort rows
                rows.sort(function(a, b) {
                    const aText = $(a).find('td').eq(column).text();
                    const bText = $(b).find('td').eq(column).text();
                    
                    // Try to parse as number
                    const aNum = parseFloat(aText.replace(/[^\d.-]/g, ''));
                    const bNum = parseFloat(bText.replace(/[^\d.-]/g, ''));
                    
                    if (!isNaN(aNum) && !isNaN(bNum)) {
                        return (aNum - bNum) * sortDirection;
                    }
                    
                    return aText.localeCompare(bText) * sortDirection;
                });

                // Reorder table
                $.each(rows, function(index, row) {
                    $('#ordersTable tbody').append(row);
                });

                // Update sort icons
                $('th i').removeClass('fa-sort-up fa-sort-down').addClass('fa-sort');
                const sortIcon = $(this).find('i');
                sortIcon.removeClass('fa-sort');
                sortIcon.addClass(sortDirection === 1 ? 'fa-sort-up' : 'fa-sort-down');

                // Reset to first page after sorting
                currentPage = 1;
                renderPagination();
            });
        });
    </script>
    @stack('scripts')
</body>
</html>