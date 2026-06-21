<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Admin - TokoKu</title>
    <link rel="stylesheet" href="/css/app.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --sidebar-active: #1d4ed8;
            --sidebar-text: #94a3b8;
            --sidebar-text-active: #ffffff;
            --page-bg: #f1f5f9;
            --surface: #ffffff;
            --border: #e2e8f0;
            --text: #0f172a;
            --text-muted: #64748b;
            --primary: #2563eb;
            --success: #059669;
            --warning: #d97706;
            --danger: #dc2626;
            --radius: 14px;
            --shadow: 0 1px 3px rgba(15, 23, 42, 0.06), 0 1px 2px rgba(15, 23, 42, 0.04);
            --shadow-lg: 0 10px 25px rgba(15, 23, 42, 0.08);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--page-bg);
            color: var(--text);
            line-height: 1.5;
        }

        /* Sidebar */
        .admin-sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 200;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 18px;
            flex-shrink: 0;
        }

        .sidebar-brand h1 {
            font-size: 18px;
            font-weight: 800;
            color: #fff;
            line-height: 1.2;
        }

        .sidebar-brand p {
            font-size: 12px;
            color: var(--sidebar-text);
            margin-top: 2px;
        }

        .sidebar-menu {
            padding: 16px 12px;
            flex: 1;
        }

        .menu-section {
            font-size: 11px;
            font-weight: 700;
            color: #475569;
            padding: 8px 12px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            margin-bottom: 4px;
            color: var(--sidebar-text);
            text-decoration: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            transition: background 0.2s, color 0.2s;
        }

        .menu-item i {
            width: 18px;
            text-align: center;
            font-size: 15px;
        }

        .menu-item:hover {
            background: var(--sidebar-hover);
            color: #e2e8f0;
        }

        .menu-item.active {
            background: rgba(37, 99, 235, 0.2);
            color: var(--sidebar-text-active);
        }

        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-footer a {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #94a3b8;
            text-decoration: none;
            font-size: 14px;
            padding: 10px 12px;
            border-radius: 10px;
            transition: background 0.2s, color 0.2s;
        }

        .sidebar-footer a:hover {
            background: var(--sidebar-hover);
            color: #fca5a5;
        }

        /* Main layout */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
        }

        .topbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .menu-toggle {
            display: none;
            width: 40px;
            height: 40px;
            border: 1px solid var(--border);
            border-radius: 10px;
            background: var(--surface);
            color: var(--text);
            font-size: 18px;
            cursor: pointer;
        }

        .page-heading h2 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text);
        }

        .page-heading p {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .topbar-date {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            background: #f8fafc;
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 13px;
            color: var(--text-muted);
        }

        .user-chip {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 12px 6px 6px;
            background: #f8fafc;
            border: 1px solid var(--border);
            border-radius: 999px;
        }

        .user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 700;
        }

        .user-chip span {
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
        }

        .content-wrapper {
            padding: 28px 32px 40px;
        }

        /* Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 22px;
            box-shadow: var(--shadow);
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .stat-card-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .stat-card.income .stat-icon { background: #fef3c7; color: var(--warning); }
        .stat-card.stock .stat-icon { background: #fee2e2; color: var(--danger); }
        .stat-card.sold .stat-icon { background: #d1fae5; color: var(--success); }
        .stat-card.categories .stat-icon { background: #dbeafe; color: var(--primary); }

        .stat-value {
            font-size: 26px;
            font-weight: 800;
            color: var(--text);
            line-height: 1.2;
        }

        .stat-label {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .stat-meta {
            font-size: 12px;
            color: var(--text-muted);
            padding-top: 12px;
            border-top: 1px solid #f1f5f9;
        }

        /* Quick stats row */
        .quick-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .quick-stat {
            display: flex;
            align-items: center;
            gap: 14px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 16px 20px;
            box-shadow: var(--shadow);
        }

        .quick-stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .quick-stat-icon.danger { background: #fef2f2; color: var(--danger); }
        .quick-stat-icon.success { background: #ecfdf5; color: var(--success); }

        .quick-stat-label {
            font-size: 13px;
            color: var(--text-muted);
        }

        .quick-stat-value {
            font-size: 22px;
            font-weight: 800;
            color: var(--text);
        }

        /* Cards grid */
        .cards-grid {
            display: grid;
            grid-template-columns: 1.4fr 1fr 1fr;
            gap: 20px;
            margin-bottom: 24px;
        }

        .panel {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .panel-header {
            padding: 18px 22px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .panel-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text);
        }

        .panel-subtitle {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .panel-badge {
            font-size: 12px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 999px;
            background: #ecfdf5;
            color: var(--success);
        }

        .panel-body {
            padding: 22px;
        }

        .chart-container {
            height: 220px;
            position: relative;
        }

        .today-summary {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .today-item-label {
            font-size: 12px;
            color: var(--text-muted);
            margin-bottom: 4px;
        }

        .today-item-value {
            font-size: 20px;
            font-weight: 800;
            color: var(--text);
        }

        /* Best seller */
        .best-seller-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .best-seller-chart {
            width: 100%;
            max-height: 180px;
        }

        .best-seller-legend {
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 100%;
        }

        .legend-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 8px 12px;
            background: #f8fafc;
            border-radius: 10px;
            font-size: 13px;
        }

        .legend-item-left {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .legend-name {
            font-weight: 600;
            color: var(--text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .legend-value {
            font-weight: 700;
            color: var(--success);
            flex-shrink: 0;
        }

        /* Stock list */
        .stock-list {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .stock-item-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .stock-item-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 8px;
        }

        .stock-item-qty {
            font-size: 13px;
            font-weight: 700;
            color: var(--primary);
        }

        .stock-bar {
            height: 6px;
            background: #e2e8f0;
            border-radius: 999px;
            overflow: hidden;
        }

        .stock-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #2563eb, #60a5fa);
            border-radius: 999px;
            transition: width 0.4s ease;
        }

        /* Orders table */
        .orders-section .panel-header {
            flex-wrap: wrap;
        }

        .table-wrap {
            overflow-x: auto;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
        }

        .orders-table th,
        .orders-table td {
            padding: 14px 22px;
            text-align: left;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
        }

        .orders-table th {
            background: #f8fafc;
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .orders-table tbody tr {
            transition: background 0.15s;
        }

        .orders-table tbody tr:hover {
            background: #f8fafc;
        }

        .orders-table tbody tr:last-child td {
            border-bottom: none;
        }

        .order-id {
            font-weight: 700;
            color: var(--primary);
        }

        .order-amount {
            font-weight: 700;
            color: var(--text);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }

        .status-badge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .status-badge.pending { background: #fffbeb; color: #b45309; }
        .status-badge.completed { background: #ecfdf5; color: #047857; }
        .status-badge.cancelled { background: #fef2f2; color: #b91c1c; }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border: none;
            border-radius: 8px;
            background: var(--primary);
            color: #fff;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-action:hover {
            background: #1d4ed8;
        }

        .empty-state {
            text-align: center;
            padding: 32px 16px;
            color: var(--text-muted);
            font-size: 14px;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.5);
            z-index: 150;
        }

        @media (max-width: 1200px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .cards-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .admin-sidebar.open { transform: translateX(0); }
            .sidebar-overlay.open { display: block; }

            .main-content { margin-left: 0; }
            .menu-toggle { display: flex; align-items: center; justify-content: center; }

            .content-wrapper { padding: 20px 16px 32px; }
            .topbar { padding: 14px 16px; }
            .topbar-date { display: none; }
            .stats-grid { grid-template-columns: 1fr; }
            .quick-stats { grid-template-columns: 1fr; }
            .today-summary { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
@php
    $currentUser = json_decode(session('user', 'null'));
    $adminName = ($currentUser && property_exists($currentUser, 'name')) ? $currentUser->name : 'Admin';
    $adminInitial = strtoupper(substr($adminName, 0, 1));
@endphp

    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar(false)"></div>

    <aside class="admin-sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo-icon"><i class="fas fa-store"></i></div>
            <div class="sidebar-brand">
                <h1>TokoKu</h1>
                <p>Panel Admin</p>
            </div>
        </div>

        <nav class="sidebar-menu">
            <div class="menu-section">Navigasi</div>
            <a href="/admin" class="menu-item active">
                <i class="fas fa-chart-pie"></i> Dashboard
            </a>
            <a href="/admin/products" class="menu-item">
                <i class="fas fa-boxes-stacked"></i> Master Barang
            </a>
        </nav>

        <div class="sidebar-footer">
            <a href="/logout" onclick="event.preventDefault(); window.clearAuth(); document.getElementById('logout-form').submit();">
                <i class="fas fa-right-from-bracket"></i> Keluar
            </a>
            <form id="logout-form" action="/logout" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </aside>

    <div class="main-content">
        <header class="topbar">
            <div class="topbar-left">
                <button class="menu-toggle" type="button" onclick="toggleSidebar()" aria-label="Toggle menu">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="page-heading">
                    <h2>Dashboard</h2>
                    <p>Ringkasan penjualan dan stok toko</p>
                </div>
            </div>
            <div class="topbar-right">
                <div class="topbar-date">
                    <i class="far fa-calendar"></i>
                    <span id="current-date"></span>
                </div>
                <div class="user-chip">
                    <div class="user-avatar">{{ $adminInitial }}</div>
                    <span>{{ $adminName }}</span>
                </div>
            </div>
        </header>

        <div class="content-wrapper">
            <div class="stats-grid">
                <div class="stat-card income">
                    <div class="stat-card-top">
                        <div class="stat-icon"><i class="fas fa-sack-dollar"></i></div>
                    </div>
                    <div>
                        <div class="stat-value" id="total-income">Rp 0</div>
                        <div class="stat-label">Total Pendapatan</div>
                    </div>
                    <div class="stat-meta">Dari pesanan selesai</div>
                </div>
                <div class="stat-card stock">
                    <div class="stat-card-top">
                        <div class="stat-icon"><i class="fas fa-warehouse"></i></div>
                    </div>
                    <div>
                        <div class="stat-value" id="total-stock">0</div>
                        <div class="stat-label">Total Stok Barang</div>
                    </div>
                    <div class="stat-meta">Unit tersedia di gudang</div>
                </div>
                <div class="stat-card sold">
                    <div class="stat-card-top">
                        <div class="stat-icon"><i class="fas fa-cart-shopping"></i></div>
                    </div>
                    <div>
                        <div class="stat-value" id="total-sold">0</div>
                        <div class="stat-label">Barang Terjual</div>
                    </div>
                    <div class="stat-meta">Total unit terjual</div>
                </div>
                <div class="stat-card categories">
                    <div class="stat-card-top">
                        <div class="stat-icon"><i class="fas fa-tags"></i></div>
                    </div>
                    <div>
                        <div class="stat-value" id="total-products">0</div>
                        <div class="stat-label">Jenis Barang</div>
                    </div>
                    <div class="stat-meta">Produk terdaftar</div>
                </div>
            </div>

            <div class="quick-stats">
                <div class="quick-stat">
                    <div class="quick-stat-icon danger"><i class="fas fa-circle-exclamation"></i></div>
                    <div>
                        <div class="quick-stat-label">Stok Habis</div>
                        <div class="quick-stat-value" id="out-of-stock">0</div>
                    </div>
                </div>
                <div class="quick-stat">
                    <div class="quick-stat-icon success"><i class="fas fa-arrow-trend-up"></i></div>
                    <div>
                        <div class="quick-stat-label">Unit Terjual (Semua)</div>
                        <div class="quick-stat-value" id="sold-today">0</div>
                    </div>
                </div>
            </div>

            <div class="cards-grid">
                <div class="panel">
                    <div class="panel-header">
                        <div>
                            <div class="panel-title">Penjualan per Bulan</div>
                            <div class="panel-subtitle">6 bulan terakhir (dalam ribuan rupiah)</div>
                        </div>
                        <span class="panel-badge"><i class="fas fa-chart-line"></i> Live</span>
                    </div>
                    <div class="panel-body">
                        <div class="chart-container">
                            <canvas id="salesChart"></canvas>
                        </div>
                        <div class="today-summary">
                            <div>
                                <div class="today-item-label">Pendapatan Hari Ini</div>
                                <div class="today-item-value" id="today-income">Rp 0</div>
                            </div>
                            <div>
                                <div class="today-item-label">Transaksi Hari Ini</div>
                                <div class="today-item-value" id="today-transactions">0</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-header">
                        <div>
                            <div class="panel-title">Best Seller</div>
                            <div class="panel-subtitle">Top 5 produk terlaris</div>
                        </div>
                    </div>
                    <div class="panel-body best-seller-wrap">
                        <canvas id="bestSellerChart" class="best-seller-chart"></canvas>
                        <div class="best-seller-legend" id="bestSellerLegend">
                            <div class="empty-state">Memuat data...</div>
                        </div>
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-header">
                        <div>
                            <div class="panel-title">Stok Barang</div>
                            <div class="panel-subtitle">5 produk dengan stok tertinggi</div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="stock-list" id="stock-list">
                            <div class="empty-state">Memuat data...</div>
                        </div>
                    </div>
                </div>
            </div>

            <section class="orders-section">
                <div class="panel">
                    <div class="panel-header">
                        <div>
                            <div class="panel-title">Pesanan Terbaru</div>
                            <div class="panel-subtitle">5 pesanan terakhir masuk</div>
                        </div>
                    </div>
                    <div class="table-wrap">
                        <table class="orders-table">
                            <thead>
                                <tr>
                                    <th>ID Pesanan</th>
                                    <th>Pelanggan</th>
                                    <th>Tanggal</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="orders-table-body">
                                <tr>
                                    <td colspan="6" class="empty-state">Memuat data...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script src="/js/app.js"></script>
    <script>
        let ordersData = [];
        let productsData = [];
        let salesChartInstance = null;
        let bestSellerChartInstance = null;

        const statusLabels = {
            pending: 'Menunggu',
            completed: 'Selesai',
            cancelled: 'Dibatalkan'
        };

        function setCurrentDate() {
            const el = document.getElementById('current-date');
            if (el) {
                el.textContent = new Date().toLocaleDateString('id-ID', {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
            }
        }

        async function loadDashboard() {
            try {
                const stats = await window.getSalesReport();
                const products = await window.getProducts();
                const ordersResponse = await window.getAllOrders();

                ordersData = ordersResponse.data || ordersResponse || [];
                productsData = products.data || products || [];

                document.getElementById('total-income').textContent = window.formatRupiah(stats.total_revenue || 0);
                document.getElementById('total-stock').textContent = productsData.reduce((sum, p) => sum + p.stock, 0);
                document.getElementById('total-products').textContent = productsData.length;

                const totalSoldItems = calculateTotalSoldItems();
                document.getElementById('total-sold').textContent = totalSoldItems;
                document.getElementById('out-of-stock').textContent = productsData.filter(p => p.stock === 0).length;
                document.getElementById('sold-today').textContent = totalSoldItems;

                const todayData = calculateTodayData();
                document.getElementById('today-income').textContent = window.formatRupiah(todayData.income);
                document.getElementById('today-transactions').textContent = todayData.transactions;

                renderStockList();
                renderOrdersTable();
                renderCharts();
            } catch (error) {
                console.error('Error loading dashboard:', error);
            }
        }

        function calculateTotalSoldItems() {
            let total = 0;
            ordersData.forEach(order => {
                if (order.order_items) {
                    order.order_items.forEach(item => {
                        total += item.quantity;
                    });
                }
            });
            return total;
        }

        function calculateTodayData() {
            const now = new Date();
            const todayDate = `${now.getFullYear()}-${String(now.getMonth() + 1).padStart(2, '0')}-${String(now.getDate()).padStart(2, '0')}`;

            let income = 0;
            let transactions = 0;

            ordersData.forEach(order => {
                if (!order.created_at) return;

                const orderDate = new Date(order.created_at);
                const orderDateStr = `${orderDate.getFullYear()}-${String(orderDate.getMonth() + 1).padStart(2, '0')}-${String(orderDate.getDate()).padStart(2, '0')}`;

                if (orderDateStr === todayDate) {
                    income += Number(order.total_amount);
                    transactions++;
                }
            });

            return { income, transactions };
        }

        function getMonthlySalesData() {
            const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            const monthlyTotals = new Array(12).fill(0);

            ordersData.forEach(order => {
                if (!order.created_at) return;
                const orderDate = new Date(order.created_at);
                monthlyTotals[orderDate.getMonth()] += order.total_amount;
            });

            const currentMonth = new Date().getMonth();
            const labels = [];
            const data = [];

            for (let i = 5; i >= 0; i--) {
                const monthIndex = (currentMonth - i + 12) % 12;
                labels.push(monthNames[monthIndex]);
                data.push(monthlyTotals[monthIndex] / 1000);
            }

            return { labels, data };
        }

        function getBestSellerData() {
            const productSales = {};

            ordersData.forEach(order => {
                if (order.order_items) {
                    order.order_items.forEach(item => {
                        const productName = item.product ? item.product.name : `Produk ${item.product_id}`;
                        productSales[productName] = (productSales[productName] || 0) + item.quantity;
                    });
                }
            });

            const sortedProducts = Object.entries(productSales)
                .sort(([, a], [, b]) => b - a)
                .slice(0, 5);

            const labels = sortedProducts.map(([name]) => name);
            const data = sortedProducts.map(([, count]) => count);
            const colors = ['#2563eb', '#059669', '#d97706', '#dc2626', '#7c3aed'];

            return { labels, data, colors };
        }

        function renderStockList() {
            const container = document.getElementById('stock-list');

            if (productsData.length === 0) {
                container.innerHTML = '<div class="empty-state">Belum ada produk</div>';
                return;
            }

            const maxStock = productsData.reduce((max, p) => Math.max(max, p.stock), 0);
            const sortedProducts = [...productsData].sort((a, b) => b.stock - a.stock).slice(0, 5);

            container.innerHTML = sortedProducts.map(product => {
                const percentage = maxStock > 0 ? (product.stock / maxStock) * 100 : 0;
                return `
                    <div class="stock-item">
                        <div class="stock-item-row">
                            <span class="stock-item-name">${product.name}</span>
                            <span class="stock-item-qty">${product.stock} unit</span>
                        </div>
                        <div class="stock-bar">
                            <div class="stock-bar-fill" style="width: ${Math.min(percentage, 100)}%;"></div>
                        </div>
                    </div>
                `;
            }).join('');
        }

        function renderOrdersTable() {
            const tableBody = document.getElementById('orders-table-body');

            if (ordersData.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="6" class="empty-state">Belum ada pesanan</td>
                    </tr>
                `;
                return;
            }

            tableBody.innerHTML = ordersData.slice(0, 5).map(order => {
                const orderDate = order.created_at
                    ? new Date(order.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })
                    : '-';
                const status = order.status || 'pending';
                const statusLabel = statusLabels[status] || status;

                return `
                    <tr>
                        <td><span class="order-id">#${order.id}</span></td>
                        <td>${order.user ? order.user.name : 'Customer ' + (order.user_id || '-')}</td>
                        <td>${orderDate}</td>
                        <td class="order-amount">${window.formatRupiah(order.total_amount || 0)}</td>
                        <td><span class="status-badge ${status}">${statusLabel}</span></td>
                        <td>
                            ${status === 'pending' ? `
                                <button class="btn-action" onclick="updateStatus(${order.id}, 'completed')">
                                    <i class="fas fa-check"></i> Selesaikan
                                </button>
                            ` : '<span style="color:#94a3b8;font-size:13px;">—</span>'}
                        </td>
                    </tr>
                `;
            }).join('');
        }

        function renderCharts() {
            const salesData = getMonthlySalesData();
            const salesCtx = document.getElementById('salesChart').getContext('2d');

            if (salesChartInstance) salesChartInstance.destroy();

            salesChartInstance = new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: salesData.labels,
                    datasets: [{
                        label: 'Penjualan (Ribu)',
                        data: salesData.data,
                        fill: true,
                        backgroundColor: 'rgba(37, 99, 235, 0.08)',
                        borderColor: '#2563eb',
                        tension: 0.4,
                        borderWidth: 2.5,
                        pointBackgroundColor: '#2563eb',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: '#64748b', font: { size: 12 } }
                        },
                        y: {
                            grid: { color: '#f1f5f9' },
                            ticks: { color: '#64748b', font: { size: 12 } },
                            beginAtZero: true
                        }
                    }
                }
            });

            const bestSellerData = getBestSellerData();
            const pieCtx = document.getElementById('bestSellerChart').getContext('2d');

            if (bestSellerChartInstance) bestSellerChartInstance.destroy();

            bestSellerChartInstance = new Chart(pieCtx, {
                type: 'doughnut',
                data: {
                    labels: bestSellerData.labels,
                    datasets: [{
                        data: bestSellerData.data.length ? bestSellerData.data : [1],
                        backgroundColor: bestSellerData.data.length ? bestSellerData.colors : ['#e2e8f0'],
                        borderWidth: 0,
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    cutout: '68%'
                }
            });

            const legendContainer = document.getElementById('bestSellerLegend');
            if (bestSellerData.labels.length === 0) {
                legendContainer.innerHTML = '<div class="empty-state">Belum ada penjualan</div>';
            } else {
                legendContainer.innerHTML = bestSellerData.labels.map((name, i) => `
                    <div class="legend-item">
                        <div class="legend-item-left">
                            <span class="legend-dot" style="background:${bestSellerData.colors[i]}"></span>
                            <span class="legend-name">${name}</span>
                        </div>
                        <span class="legend-value">${bestSellerData.data[i]} unit</span>
                    </div>
                `).join('');
            }
        }

        async function updateStatus(id, status) {
            Swal.fire({
                title: 'Ubah status pesanan?',
                text: `Status akan diubah menjadi "${statusLabels[status] || status}"`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Ubah',
                cancelButtonText: 'Batal'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        await window.updateOrderStatus(id, status);
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Status pesanan berhasil diperbarui',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        loadDashboard();
                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Gagal mengubah status: ' + error.message
                        });
                    }
                }
            });
        }

        function toggleSidebar(force) {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const isOpen = typeof force === 'boolean' ? force : !sidebar.classList.contains('open');
            sidebar.classList.toggle('open', isOpen);
            overlay.classList.toggle('open', isOpen);
        }

        document.addEventListener('DOMContentLoaded', function() {
            setCurrentDate();
            loadDashboard();
        });
    </script>
</body>
</html>
