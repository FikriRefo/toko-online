<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Tambahkan ini -->
    <title>@yield('title', 'Toko Online')</title>
    <link rel="stylesheet" href="/css/app.css">
    <!-- Sweet Alert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    @if(!request()->is('admin*'))
        <header class="header">
            <div class="container">
                <div class="logo">🛒 TokoKu</div>
                <nav class="nav">
                    <a href="/"><i class="fas fa-home"></i></></a>
                    @php $currentUser = json_decode(session('user', 'null')); @endphp
                    @if($currentUser && property_exists($currentUser, 'role') && $currentUser->role === 'customer')
                        <a href="/cart"><i class="fas fa-cart-shopping"></i></a></a>
                    @endif
                    @if($currentUser)
                        @if($currentUser->role === 'admin')
                            <a href="/admin">Dashboard Admin</a>
                        @endif
                        <a href="/logout" onclick="event.preventDefault(); window.clearAuth(); document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="/logout" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <a href="/login">Login</a>
                        <a href="/register">Register</a>
                    @endif
                </nav>
            </div>
        </header>
    @endif
    
    <!-- Muat app.js terlebih dahulu sebelum konten -->
    <script src="/js/app.js"></script>
    
    <main>
        @yield('content')
    </main>
</body>

</html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
