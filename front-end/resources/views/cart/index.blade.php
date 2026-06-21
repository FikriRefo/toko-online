@extends('components.app')

@section('title', 'Keranjang - Toko Online')

@section('content')
    <div class="container" style="padding: 32px 0;">
        <h1>Keranjang Anda</h1>
        
        <div id="cart-container" style="margin-top: 32px;">
            <div style="text-align: center; padding: 40px;">Loading...</div>
        </div>
        
        <div id="checkout-button" style="margin-top: 32px; text-align: right; display: none;">
            <button class="btn btn-primary btn-lg" onclick="checkout()">Checkout Sekarang</button>
        </div>
    </div>

    <script>
        function loadCart() {
            const container = document.getElementById('cart-container');
            const checkoutBtn = document.getElementById('checkout-button');
            let cart = window.getCart();
            
            if (cart.length === 0) {
                container.innerHTML = `
                    <div style="text-align: center; padding: 80px;">
                        <h3>Keranjang Anda kosong</h3>
                        <a href="/" class="btn btn-primary" style="margin-top: 16px;">Belanja Sekarang</a>
                    </div>
                `;
                checkoutBtn.style.display = 'none';
                return;
            }
            
            let total = 0;
            container.innerHTML = cart.map((item, index) => {
                const itemTotal = item.price * item.quantity;
                total += itemTotal;
                
                return `
                    <div class="cart-item">
                        <img src="https://picsum.photos/80/80?random=${item.id}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                        <div style="flex-grow: 1;">
                            <h4 style="margin: 0 0 4px;">${item.name}</h4>
                            <p style="color: #6b7280; margin: 0 0 8px;">${window.formatRupiah(item.price)} x ${item.quantity}</p>
                            <p style="font-weight: bold; margin: 0;">${window.formatRupiah(itemTotal)}</p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <button class="btn btn-danger" onclick="removeFromCart(${index})">Hapus</button>
                        </div>
                    </div>
                `;
            }).join('');
            
            container.innerHTML += `
                <div class="cart-total">
                    Total: ${window.formatRupiah(total)}
                </div>
            `;
            
            checkoutBtn.style.display = 'block';
        }
        
        function removeFromCart(index) {
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Produk ini akan dihapus dari keranjang!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    let cart = window.getCart();
                    cart.splice(index, 1);
                    window.saveCart(cart);
                    loadCart();
                    Swal.fire({
                        icon: 'success',
                        title: 'Dihapus!',
                        text: 'Produk berhasil dihapus dari keranjang',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        }
        
        async function checkout() {
            let cart = window.getCart();
            if (cart.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Keranjang Anda kosong!'
                });
                return;
            }
            
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Anda akan checkout produk di keranjang!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Checkout!',
                cancelButtonText: 'Batal'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const items = cart.map(item => ({
                            product_id: item.id,
                            quantity: item.quantity
                        }));
                        
                        const order = await window.checkoutOrder(items);
                        window.clearCart();
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Checkout Berhasil!',
                            text: `Order #${order.id} berhasil dibuat!`,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = '/';
                        });
                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Checkout Gagal!',
                            text: error.message || 'Kesalahan tidak diketahui'
                        });
                        console.error(error);
                    }
                }
            });
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            loadCart();
        });
    </script>
@endsection
