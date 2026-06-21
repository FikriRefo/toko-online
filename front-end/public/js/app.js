// API BASE URL - Backend (sesuaikan dengan port backend)
const API_BASE_URL = 'http://127.0.0.1:8000/api';

// Utility untuk request API dengan JWT
async function apiRequest(endpoint, options = {}) {
    const headers = {
        'Content-Type': 'application/json',
        ...options.headers
    };
    
    const token = localStorage.getItem('access_token');
    if (token) {
        headers['Authorization'] = `Bearer ${token}`;
    }
    
    const response = await fetch(`${API_BASE_URL}${endpoint}`, {
        ...options,
        headers,
        mode: 'cors'
    });
    
    if (!response.ok) {
        let errorData = {};
        try {
            errorData = await response.json();
        } catch (e) {
            // ignore if no json
        }
        throw new Error(errorData.message || 'Terjadi kesalahan');
    }
    
    if (response.status === 204) {
        return { success: true };
    }
    
    return await response.json();
}

// Autentikasi
function login(email, password) {
    return apiRequest('/login', {
        method: 'POST',
        body: JSON.stringify({ email, password })
    });
}

function register(name, email, password, passwordConfirmation, role) {
    return apiRequest('/register', {
        method: 'POST',
        body: JSON.stringify({
            name,
            email,
            password,
            password_confirmation: passwordConfirmation,
            role
        })
    });
}

function logout() {
    return apiRequest('/logout', {
        method: 'POST'
    });
}

// Produk
function getProducts(search = '') {
    let url = '/products';
    if (search) {
        url += `?search=${encodeURIComponent(search)}`;
    }
    return apiRequest(url);
}

function getProduct(id) {
    return apiRequest(`/products/${id}`);
}

function createProduct(data) {
    return apiRequest('/products', {
        method: 'POST',
        body: JSON.stringify(data)
    });
}

function updateProduct(id, data) {
    return apiRequest(`/products/${id}`, {
        method: 'PUT',
        body: JSON.stringify(data)
    });
}

function deleteProduct(id) {
    return apiRequest(`/products/${id}`, {
        method: 'DELETE'
    });
}

// Order
function checkoutOrder(items) {
    return apiRequest('/checkout', {
        method: 'POST',
        body: JSON.stringify({ items })
    });
}

function getMyOrders() {
    return apiRequest('/my-orders');
}

function getAllOrders(status = '') {
    let url = '/orders';
    if (status) {
        url += `?status=${encodeURIComponent(status)}`;
    }
    return apiRequest(url);
}

function updateOrderStatus(id, status) {
    return apiRequest(`/orders/${id}/status`, {
        method: 'PUT',
        body: JSON.stringify({ status })
    });
}

function getSalesReport() {
    return apiRequest('/sales-report');
}

// Helper untuk format rupiah
function formatRupiah(number) {
    // Pastikan number adalah angka
    let num = Number(number);
    if (isNaN(num)) num = 0;
    
    // Format dengan titik ribuan
    return 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

// Helper untuk simpan auth data ke localStorage
function saveAuth(authData) {
    localStorage.setItem('access_token', authData.access_token);
    localStorage.setItem('user', JSON.stringify(authData.user));
}

function clearAuth() {
    localStorage.removeItem('access_token');
    localStorage.removeItem('user');
}

function getCurrentUser() {
    const user = localStorage.getItem('user');
    return user ? JSON.parse(user) : null;
}

function isLoggedIn() {
    return !!localStorage.getItem('access_token');
}

function getCartKey() {
    const user = getCurrentUser();
    if (!user || !user.id) {
        return null;
    }
    return `cart_${user.id}`;
}

function getCart() {
    const key = getCartKey();
    if (!key) {
        return [];
    }
    return JSON.parse(localStorage.getItem(key) || '[]');
}

function saveCart(cart) {
    const key = getCartKey();
    if (!key) {
        return;
    }
    localStorage.setItem(key, JSON.stringify(cart));
}

function clearCart() {
    const key = getCartKey();
    if (!key) {
        return;
    }
    localStorage.removeItem(key);
}
