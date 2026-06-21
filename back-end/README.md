# Toko Online API

Laravel API dengan JWT Authentication untuk manajemen toko online.

## Fitur

### Autentikasi
- Register sebagai Admin atau Customer
- Login dengan JWT Token
- Role-based access control

### Manajemen Produk
- List produk dengan pencarian
- CRUD produk (hanya Admin)

### Order & Checkout
- Customer dapat checkout dengan metode pembayaran cash
- Stok produk otomatis berkurang saat checkout
- Admin dapat melihat laporan penjualan

## Instalasi

1. Pastikan PHP dan Composer terinstal
2. Jalankan `composer install`
3. Salin `.env.example` menjadi `.env` dan konfigurasi database
4. Jalankan `php artisan key:generate` dan `php artisan jwt:secret`
5. Jalankan migrasi `php artisan migrate`
6. (Opsional) Jalankan seeder untuk data sampel `php artisan db:seed`

## API Endpoints

### Autentikasi
- `POST /api/register` - Register user baru
- `POST /api/login` - Login user

### Produk (Public setelah login)
- `GET /api/products` - List produk (dengan pencarian: ?search=keyword)
- `GET /api/products/{id}` - Detail produk

### Customer
- `POST /api/checkout` - Checkout produk
  - Body: `{ "items": [ { "product_id": 1, "quantity": 2 } ] }`
- `GET /api/my-orders` - Riwayat order customer

### Admin
- `POST /api/products` - Tambah produk
- `PUT /api/products/{id}` - Update produk
- `DELETE /api/products/{id}` - Hapus produk
- `GET /api/orders` - List semua order
- `PUT /api/orders/{id}/status` - Update status order
- `GET /api/sales-report` - Laporan penjualan

## Contoh Penggunaan

### Register Admin
```bash
POST /api/register
{
  "name": "Admin",
  "email": "admin@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "role": "admin"
}
```

### Login
```bash
POST /api/login
{
  "email": "admin@example.com",
  "password": "password123"
}
```

### Checkout (Customer)
```bash
POST /api/checkout
Authorization: Bearer {token}
{
  "items": [
    { "product_id": 1, "quantity": 2 },
    { "product_id": 2, "quantity": 3 }
  ]
}
```
