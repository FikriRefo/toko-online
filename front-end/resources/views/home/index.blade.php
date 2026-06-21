@extends('components.app')

@section('title', 'Toko Online - Beranda')

@section('content')
@php
    $currentUser = json_decode(session('user', 'null'));
    $isLoggedIn = $currentUser && property_exists($currentUser, 'id');
    $isCustomer = $isLoggedIn && property_exists($currentUser, 'role') && $currentUser->role === 'customer';
@endphp

<style>
    .home-page {
        padding: 32px 0 64px;
    }

    .home-hero {
        text-align: center;
        max-width: 640px;
        margin: 0 auto 48px;
    }

    .home-hero__badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: #eff6ff;
        color: var(--primary-dark);
        border-radius: 999px;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 20px;
    }

    .home-hero h1 {
        font-size: clamp(28px, 5vw, 42px);
        font-weight: 800;
        color: var(--text-color);
        line-height: 1.2;
        margin: 0 0 12px;
    }

    .home-hero h1 span {
        color: var(--primary-color);
    }

    .home-hero p {
        color: var(--text-light);
        font-size: 17px;
        margin: 0;
    }

    .products-section {
        margin-top: 8px;
    }

    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }

    .section-header h2 {
        font-size: 22px;
        font-weight: 700;
        margin: 0;
        color: var(--text-color);
    }

    .section-header p {
        margin: 4px 0 0;
        color: var(--text-light);
        font-size: 14px;
    }

    .search-bar {
        position: relative;
        max-width: 360px;
        width: 100%;
    }

    .search-bar i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-light);
        pointer-events: none;
    }

    .search-bar input {
        width: 100%;
        padding: 12px 16px 12px 44px;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        background: var(--card-bg);
        font-size: 15px;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .search-bar input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 24px;
    }

    .home-product-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .home-product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(15, 23, 42, 0.08);
    }

    .home-product-card__image {
        position: relative;
        aspect-ratio: 4 / 3;
        overflow: hidden;
        background: #f3f4f6;
    }

    .home-product-card__image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .stock-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        color: #fff;
    }

    .stock-badge--available {
        background: var(--secondary-color);
    }

    .stock-badge--empty {
        background: var(--danger-color);
    }

    .home-product-card__body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .home-product-card__name {
        font-size: 18px;
        font-weight: 700;
        margin: 0 0 8px;
        color: var(--text-color);
        line-height: 1.35;
    }

    .home-product-card__desc {
        color: var(--text-light);
        font-size: 14px;
        line-height: 1.5;
        margin: 0 0 16px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 42px;
    }

    .home-product-card__price {
        font-size: 22px;
        font-weight: 800;
        color: var(--primary-color);
        margin: 0 0 16px;
    }

    .home-product-card__footer {
        margin-top: auto;
    }

    .cart-controls {
        display: flex;
        gap: 10px;
        align-items: stretch;
    }

    .cart-controls input {
        width: 72px;
        padding: 10px;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        text-align: center;
        font-size: 15px;
        outline: none;
    }

    .cart-controls input:focus {
        border-color: var(--primary-color);
    }

    .btn-add-cart {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 16px;
        border: none;
        border-radius: 10px;
        background: var(--primary-color);
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }

    .btn-add-cart:hover {
        background: var(--primary-dark);
    }

    .btn-add-cart:disabled {
        background: #9ca3af;
        cursor: not-allowed;
    }

    .stock-info {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        width: 100%;
        justify-content: center;
    }

    .stock-info--available {
        background: #ecfdf5;
        color: #047857;
    }

    .stock-info--empty {
        background: #fef2f2;
        color: #b91c1c;
    }

    .state-panel {
        text-align: center;
        padding: 56px 24px;
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        max-width: 520px;
        margin: 0 auto;
    }

    .state-panel--wide {
        max-width: 100%;
    }

    .state-panel__icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }

    .state-panel__icon--info {
        background: #eff6ff;
        color: var(--primary-color);
    }

    .state-panel__icon--muted {
        background: #f3f4f6;
        color: var(--text-light);
    }

    .state-panel__icon--error {
        background: #fef2f2;
        color: var(--danger-color);
    }

    .state-panel h3 {
        margin: 0 0 8px;
        font-size: 20px;
        color: var(--text-color);
    }

    .state-panel p {
        margin: 0 0 20px;
        color: var(--text-light);
        line-height: 1.6;
    }

    .state-panel__actions {
        display: flex;
        gap: 12px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-outline {
        background: transparent;
        color: var(--primary-color);
        border: 1px solid var(--primary-color);
    }

    .btn-outline:hover {
        background: #eff6ff;
        transform: none;
        box-shadow: none;
    }

    .loading-spinner {
        width: 36px;
        height: 36px;
        margin: 0 auto 16px;
        border: 3px solid #e5e7eb;
        border-top-color: var(--primary-color);
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    @media (max-width: 768px) {
        .home-page {
            padding: 24px 0 48px;
        }

        .section-header {
            flex-direction: column;
            align-items: stretch;
        }

        .search-bar {
            max-width: none;
        }

        .products-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container home-page">
    <section class="home-hero">
        <div class="home-hero__badge">
            <i class="fas fa-store"></i>
            Toko Online Terpercaya
        </div>
        <h1>Selamat Datang di <span>TokoKu</span></h1>
        <p>Temukan berbagai produk terbaik dengan harga terbaik, langsung dari gudang kami.</p>
    </section>

    @if($isLoggedIn)
        <section class="products-section">
            <div class="section-header">
                <div>
                    <h2>Daftar Produk</h2>
                    <p>Pilih produk favorit Anda dan tambahkan ke keranjang.</p>
                </div>
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input
                        type="text"
                        id="search"
                        placeholder="Cari produk..."
                        onkeyup="searchProducts()">
                </div>
            </div>

            <div id="products-container">
                <div class="state-panel state-panel--wide">
                    <div class="loading-spinner"></div>
                    <p style="margin: 0;">Memuat produk...</p>
                </div>
            </div>
        </section>
    @else
        <div class="state-panel">
            <div class="state-panel__icon state-panel__icon--info">
                <i class="fas fa-lock"></i>
            </div>
            <h3>Login Diperlukan</h3>
            <p>Silahkan login terlebih dahulu untuk melihat list product.</p>
            <div class="state-panel__actions">
                <a href="/login" class="btn btn-primary">
                    <i class="fas fa-right-to-bracket"></i> Login
                </a>
                <a href="/register" class="btn btn-outline">
                    <i class="fas fa-user-plus"></i> Daftar
                </a>
            </div>
        </div>
    @endif
</div>

<script>
let allProducts = [];
const isCustomer = @json($isCustomer);

function renderStatePanel({ icon, iconClass, title, message, wide = false }) {
    return `
        <div class="state-panel ${wide ? 'state-panel--wide' : ''}">
            <div class="state-panel__icon state-panel__icon--${iconClass}">
                <i class="fas fa-${icon}"></i>
            </div>
            ${title ? `<h3>${title}</h3>` : ''}
            <p style="${title ? '' : 'margin: 0;'}">${message}</p>
        </div>
    `;
}

function renderLoading() {
    return `
        <div class="state-panel state-panel--wide">
            <div class="loading-spinner"></div>
            <p style="margin: 0;">Memuat produk...</p>
        </div>
    `;
}

function renderProductCard(product) {
    const inStock = product.stock > 0;
    const stockBadge = inStock
        ? `<span class="stock-badge stock-badge--available">Stok ${product.stock}</span>`
        : `<span class="stock-badge stock-badge--empty">Habis</span>`;

    let footer = '';
    if (isCustomer) {
        footer = `
            <div class="cart-controls">
                <input
                    type="number"
                    id="qty-${product.id}"
                    value="1"
                    min="1"
                    max="${product.stock}"
                    ${inStock ? '' : 'disabled'}>
                <button
                    class="btn-add-cart"
                    onclick="addToCart(${product.id})"
                    ${inStock ? '' : 'disabled'}>
                    <i class="fas fa-cart-plus"></i> Tambah
                </button>
            </div>
        `;
    } else {
        footer = `
            <div class="stock-info ${inStock ? 'stock-info--available' : 'stock-info--empty'}">
                <i class="fas fa-${inStock ? 'check-circle' : 'times-circle'}"></i>
                ${inStock ? `Stok tersedia: ${product.stock}` : 'Stok habis'}
            </div>
        `;
    }

    return `
        <article class="home-product-card">
            <div class="home-product-card__image">
                <img src="https://picsum.photos/500/350?random=${product.id}" alt="${product.name}">
                ${stockBadge}
            </div>
            <div class="home-product-card__body">
                <h3 class="home-product-card__name">${product.name}</h3>
                <p class="home-product-card__desc">${product.description ?? 'Tidak ada deskripsi.'}</p>
                <p class="home-product-card__price">${window.formatRupiah(product.price)}</p>
                <div class="home-product-card__footer">${footer}</div>
            </div>
        </article>
    `;
}

async function loadProducts(search = '') {
    const container = document.getElementById('products-container');
    container.innerHTML = renderLoading();

    try {
        const data = await window.getProducts(search);
        allProducts = data.data || data;

        if (!allProducts || allProducts.length === 0) {
            container.innerHTML = renderStatePanel({
                icon: 'box-open',
                iconClass: 'muted',
                title: 'Produk Tidak Ditemukan',
                message: search
                    ? `Tidak ada produk yang cocok dengan pencarian "${search}".`
                    : 'Belum ada produk tersedia saat ini.',
                wide: true
            });
            return;
        }

        container.innerHTML = `<div class="products-grid">${allProducts.map(renderProductCard).join('')}</div>`;
    } catch (error) {
        container.innerHTML = renderStatePanel({
            icon: 'triangle-exclamation',
            iconClass: 'error',
            title: 'Gagal Memuat Produk',
            message: 'Terjadi kesalahan saat memuat data. Silakan muat ulang halaman.',
            wide: true
        });
        console.error(error);
    }
}

function searchProducts() {
    loadProducts(document.getElementById('search').value);
}

function addToCart(productId) {
    const qtyInput = document.getElementById(`qty-${productId}`);
    const qty = parseInt(qtyInput.value, 10);
    let cart = window.getCart();
    const product = allProducts.find(p => p.id === productId);

    if (!product) {
        Swal.fire({ icon: 'error', title: 'Produk tidak ditemukan' });
        return;
    }

    const existing = cart.find(item => item.id === productId);
    if (existing) {
        existing.quantity += qty;
    } else {
        cart.push({ ...product, quantity: qty });
    }

    window.saveCart(cart);

    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Produk ditambahkan ke keranjang',
        timer: 1500,
        showConfirmButton: false
    });
}

document.addEventListener('DOMContentLoaded', () => {
    @if($isLoggedIn)
    loadProducts();
    @endif
});
</script>
@endsection
