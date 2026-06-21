<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Master Barang - TokoKu</title>
    <link rel="stylesheet" href="/css/app.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --sidebar-text: #94a3b8;
            --sidebar-text-active: #ffffff;
            --page-bg: #f1f5f9;
            --surface: #ffffff;
            --border: #e2e8f0;
            --text: #0f172a;
            --text-muted: #64748b;
            --primary: #2563eb;
            --success: #059669;
            --danger: #dc2626;
            --radius: 14px;
            --shadow: 0 1px 3px rgba(15, 23, 42, 0.06), 0 1px 2px rgba(15, 23, 42, 0.04);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--page-bg);
            color: var(--text);
            line-height: 1.5;
        }

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

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .summary-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 18px 20px;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .summary-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .summary-icon.blue { background: #dbeafe; color: var(--primary); }
        .summary-icon.green { background: #d1fae5; color: var(--success); }
        .summary-icon.red { background: #fee2e2; color: var(--danger); }

        .summary-label {
            font-size: 13px;
            color: var(--text-muted);
        }

        .summary-value {
            font-size: 24px;
            font-weight: 800;
            color: var(--text);
            line-height: 1.2;
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
            gap: 16px;
            flex-wrap: wrap;
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

        .panel-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .search-input-wrap {
            position: relative;
        }

        .search-input-wrap i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 14px;
        }

        .search-input {
            padding: 10px 14px 10px 40px;
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 14px;
            outline: none;
            width: 240px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .search-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border: none;
            border-radius: 10px;
            background: var(--success);
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-add:hover {
            background: #047857;
        }

        .table-wrap {
            overflow-x: auto;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
        }

        .products-table th,
        .products-table td {
            padding: 14px 22px;
            text-align: left;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
        }

        .products-table th {
            background: #f8fafc;
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .products-table tbody tr {
            transition: background 0.15s;
        }

        .products-table tbody tr:hover {
            background: #f8fafc;
        }

        .products-table tbody tr:last-child td {
            border-bottom: none;
        }

        .product-id {
            font-weight: 700;
            color: var(--primary);
        }

        .product-name {
            font-weight: 600;
            color: var(--text);
        }

        .product-desc {
            color: var(--text-muted);
            max-width: 280px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product-price {
            font-weight: 700;
            color: var(--success);
        }

        .stock-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }

        .stock-badge.in-stock {
            background: #ecfdf5;
            color: #047857;
        }

        .stock-badge.out-of-stock {
            background: #fef2f2;
            color: #b91c1c;
        }

        .action-group {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
        }

        .btn-icon {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 12px;
            border: none;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .btn-icon.edit {
            background: #eff6ff;
            color: var(--primary);
        }

        .btn-icon.edit:hover { background: #dbeafe; }

        .btn-icon.delete {
            background: #fef2f2;
            color: var(--danger);
        }

        .btn-icon.delete:hover { background: #fee2e2; }

        .empty-state {
            text-align: center;
            padding: 48px 24px;
            color: var(--text-muted);
            font-size: 14px;
        }

        .empty-state i {
            font-size: 40px;
            color: #cbd5e1;
            margin-bottom: 12px;
            display: block;
        }

        /* Modal */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.55);
            justify-content: center;
            align-items: center;
            z-index: 1000;
            padding: 20px;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal-content {
            background: var(--surface);
            width: 100%;
            max-width: 520px;
            border-radius: var(--radius);
            box-shadow: 0 25px 50px rgba(15, 23, 42, 0.2);
            overflow: hidden;
        }

        .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            font-size: 18px;
            font-weight: 700;
            color: var(--text);
        }

        .modal-close {
            width: 36px;
            height: 36px;
            border: none;
            border-radius: 10px;
            background: #f8fafc;
            color: var(--text-muted);
            font-size: 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }

        .modal-close:hover {
            background: #f1f5f9;
            color: var(--text);
        }

        .modal-body {
            padding: 24px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
        }

        .form-group .input,
        .form-group textarea {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            font-family: inherit;
        }

        .form-group .input:focus,
        .form-group textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 90px;
        }

        .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--border);
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            background: #f8fafc;
        }

        .btn-cancel {
            padding: 10px 18px;
            border: 1px solid var(--border);
            border-radius: 10px;
            background: var(--surface);
            color: var(--text-muted);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-cancel:hover {
            background: #f1f5f9;
        }

        .btn-save {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border: none;
            border-radius: 10px;
            background: var(--primary);
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-save:hover {
            background: #1d4ed8;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.5);
            z-index: 150;
        }

        @media (max-width: 992px) {
            .summary-grid { grid-template-columns: 1fr; }
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

            .panel-header { flex-direction: column; align-items: stretch; }
            .panel-actions { flex-direction: column; }
            .search-input { width: 100%; }

            .action-group { flex-direction: column; }
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
            <a href="/admin" class="menu-item">
                <i class="fas fa-chart-pie"></i> Dashboard
            </a>
            <a href="/admin/products" class="menu-item active">
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
                    <h2>Master Barang</h2>
                    <p>Kelola data produk toko Anda</p>
                </div>
            </div>
            <div class="topbar-right">
                <div class="user-chip">
                    <div class="user-avatar">{{ $adminInitial }}</div>
                    <span>{{ $adminName }}</span>
                </div>
            </div>
        </header>

        <div class="content-wrapper">
            <div class="summary-grid">
                <div class="summary-card">
                    <div class="summary-icon blue"><i class="fas fa-box"></i></div>
                    <div>
                        <div class="summary-label">Total Produk</div>
                        <div class="summary-value" id="summary-total">0</div>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon green"><i class="fas fa-warehouse"></i></div>
                    <div>
                        <div class="summary-label">Total Stok</div>
                        <div class="summary-value" id="summary-stock">0</div>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon red"><i class="fas fa-circle-exclamation"></i></div>
                    <div>
                        <div class="summary-label">Stok Habis</div>
                        <div class="summary-value" id="summary-empty">0</div>
                    </div>
                </div>
            </div>

            <div class="panel">
                <div class="panel-header">
                    <div>
                        <div class="panel-title">Daftar Barang</div>
                        <div class="panel-subtitle">Semua produk yang terdaftar di toko</div>
                    </div>
                    <div class="panel-actions">
                        <div class="search-input-wrap">
                            <i class="fas fa-search"></i>
                            <input
                                type="text"
                                id="search-input"
                                class="search-input"
                                placeholder="Cari barang..."
                                onkeyup="filterProducts()">
                        </div>
                        <button class="btn-add" onclick="showAddModal()">
                            <i class="fas fa-plus"></i> Tambah Barang
                        </button>
                    </div>
                </div>

                <div class="table-wrap">
                    <table class="products-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Barang</th>
                                <th>Deskripsi</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th style="text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="products-table">
                            <tr>
                                <td colspan="6" class="empty-state">Memuat data...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modal-title">Tambah Barang</h3>
                <button type="button" class="modal-close" onclick="closeModal()" aria-label="Tutup">&times;</button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="product-id">

                <div class="form-group">
                    <label for="product-name">Nama Barang</label>
                    <input type="text" id="product-name" class="input" required placeholder="Masukkan nama barang">
                </div>

                <div class="form-group">
                    <label for="product-desc">Deskripsi</label>
                    <textarea id="product-desc" rows="3" placeholder="Deskripsi barang (opsional)"></textarea>
                </div>

                <div class="form-group">
                    <label for="product-price">Harga (Rp)</label>
                    <input type="number" id="product-price" class="input" min="0" required placeholder="0">
                </div>

                <div class="form-group">
                    <label for="product-stock">Stok</label>
                    <input type="number" id="product-stock" class="input" min="0" required placeholder="0">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" onclick="closeModal()" class="btn-cancel">Batal</button>
                <button type="button" onclick="saveProduct()" class="btn-save">
                    <i class="fas fa-floppy-disk"></i> Simpan
                </button>
            </div>
        </div>
    </div>

    <script src="/js/app.js"></script>
    <script>
        let productsData = [];
        let filteredProducts = [];

        function updateSummary() {
            const total = productsData.length;
            const totalStock = productsData.reduce((sum, p) => sum + p.stock, 0);
            const emptyStock = productsData.filter(p => p.stock === 0).length;

            document.getElementById('summary-total').textContent = total;
            document.getElementById('summary-stock').textContent = totalStock;
            document.getElementById('summary-empty').textContent = emptyStock;
        }

        function renderProductsTable(products) {
            const tableBody = document.getElementById('products-table');

            if (products.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-box-open"></i>
                                ${productsData.length === 0
                                    ? 'Belum ada barang. Silakan tambah barang baru.'
                                    : 'Tidak ada barang yang cocok dengan pencarian.'}
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }

            tableBody.innerHTML = products.map(p => `
                <tr>
                    <td><span class="product-id">#${p.id}</span></td>
                    <td><span class="product-name">${p.name}</span></td>
                    <td><span class="product-desc">${p.description || '-'}</span></td>
                    <td><span class="product-price">${window.formatRupiah(p.price)}</span></td>
                    <td>
                        <span class="stock-badge ${p.stock > 0 ? 'in-stock' : 'out-of-stock'}">
                            <i class="fas fa-${p.stock > 0 ? 'check' : 'times'}"></i>
                            ${p.stock > 0 ? p.stock + ' unit' : 'Habis'}
                        </span>
                    </td>
                    <td>
                        <div class="action-group">
                            <button class="btn-icon edit" onclick="editProduct(${p.id})">
                                <i class="fas fa-pen"></i> Edit
                            </button>
                            <button class="btn-icon delete" onclick="deleteProductItem(${p.id})">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        async function loadProducts() {
            try {
                const data = await window.getProducts();
                productsData = data.data || data || [];
                filteredProducts = [...productsData];

                updateSummary();
                renderProductsTable(filteredProducts);
            } catch (error) {
                document.getElementById('products-table').innerHTML = `
                    <tr>
                        <td colspan="6">
                            <div class="empty-state" style="color: var(--danger);">
                                <i class="fas fa-triangle-exclamation"></i>
                                Gagal memuat barang: ${error.message}
                            </div>
                        </td>
                    </tr>
                `;
            }
        }

        function filterProducts() {
            const query = document.getElementById('search-input').value.toLowerCase().trim();
            filteredProducts = productsData.filter(p =>
                p.name.toLowerCase().includes(query) ||
                (p.description && p.description.toLowerCase().includes(query))
            );
            renderProductsTable(filteredProducts);
        }

        function showAddModal() {
            document.getElementById('modal-title').innerText = 'Tambah Barang';
            document.getElementById('product-id').value = '';
            document.getElementById('product-name').value = '';
            document.getElementById('product-desc').value = '';
            document.getElementById('product-price').value = '';
            document.getElementById('product-stock').value = '';
            document.getElementById('modal').classList.add('show');
        }

        function editProduct(id) {
            const product = productsData.find(p => p.id === id);
            if (!product) return;

            document.getElementById('modal-title').innerText = 'Edit Barang';
            document.getElementById('product-id').value = id;
            document.getElementById('product-name').value = product.name;
            document.getElementById('product-desc').value = product.description || '';
            document.getElementById('product-price').value = product.price;
            document.getElementById('product-stock').value = product.stock;
            document.getElementById('modal').classList.add('show');
        }

        async function saveProduct() {
            try {
                const id = document.getElementById('product-id').value;
                const data = {
                    name: document.getElementById('product-name').value,
                    description: document.getElementById('product-desc').value,
                    price: parseInt(document.getElementById('product-price').value, 10),
                    stock: parseInt(document.getElementById('product-stock').value, 10)
                };

                if (id) {
                    await window.updateProduct(id, data);
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Barang berhasil diperbarui',
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    await window.createProduct(data);
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Barang berhasil ditambahkan',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }

                closeModal();
                loadProducts();
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Gagal menyimpan barang: ' + error.message
                });
            }
        }

        async function deleteProductItem(id) {
            Swal.fire({
                title: 'Hapus barang?',
                text: 'Barang akan dihapus dan tidak bisa dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        await window.deleteProduct(id);
                        Swal.fire({
                            icon: 'success',
                            title: 'Dihapus',
                            text: 'Barang berhasil dihapus',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        loadProducts();
                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Gagal menghapus barang: ' + error.message
                        });
                    }
                }
            });
        }

        function closeModal() {
            document.getElementById('modal').classList.remove('show');
        }

        function toggleSidebar(force) {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const isOpen = typeof force === 'boolean' ? force : !sidebar.classList.contains('open');
            sidebar.classList.toggle('open', isOpen);
            overlay.classList.toggle('open', isOpen);
        }

        document.addEventListener('DOMContentLoaded', function() {
            loadProducts();
        });

        document.getElementById('modal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    </script>
</body>
</html>
