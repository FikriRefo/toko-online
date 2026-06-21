@extends('components.app')

@section('title', 'Login - Toko Online')

@section('content')

<style>
    body{
        background:#f5f7fb;
    }

    .login-container{
        max-width:420px;
        margin:60px auto;
        padding:0 20px;
    }

    .login-card{
        background:#fff;
        padding:35px;
        border-radius:18px;
        box-shadow:0 10px 30px rgba(0,0,0,.08);
    }

    .login-title{
        text-align:center;
        margin-bottom:30px;
        color:#1f2937;
        font-size:30px;
        font-weight:bold;
    }

    .login-title i{
        color:#2563eb;
        margin-right:8px;
    }

    .form-group{
        margin-bottom:20px;
    }

    .form-group label{
        display:block;
        margin-bottom:8px;
        font-weight:600;
        color:#374151;
    }

    .input-wrapper{
        position:relative;
    }

    .input-wrapper input{
        width:100%;
        padding:12px 45px 12px 45px;
        border:1px solid #d1d5db;
        border-radius:10px;
        font-size:15px;
        outline:none;
        transition:.3s;
        box-sizing:border-box;
    }

    .input-wrapper input:focus{
        border-color:#2563eb;
        box-shadow:0 0 0 3px rgba(37,99,235,.15);
    }

    .input-icon{
        position:absolute;
        left:15px;
        top:50%;
        transform:translateY(-50%);
        color:#6b7280;
    }

    .toggle-password{
        position:absolute;
        right:15px;
        top:50%;
        transform:translateY(-50%);
        border:none;
        background:none;
        cursor:pointer;
        color:#6b7280;
        font-size:18px;
    }

    .toggle-password:hover{
        color:#2563eb;
    }

    .login-btn{
        width:100%;
        padding:13px;
        border:none;
        border-radius:10px;
        background:#2563eb;
        color:#fff;
        font-size:16px;
        font-weight:bold;
        cursor:pointer;
        transition:.3s;
    }

    .login-btn:hover{
        background:#1d4ed8;
    }

    .login-btn i{
        margin-right:8px;
    }

    .register-link{
        text-align:center;
        margin-top:20px;
        color:#6b7280;
    }

    .register-link a{
        color:#2563eb;
        text-decoration:none;
        font-weight:600;
    }

    .register-link a:hover{
        text-decoration:underline;
    }
</style>

<div class="login-container">

    <div class="login-card">

        <h1 class="login-title">
            <i class="fas fa-right-to-bracket"></i>
            Login
        </h1>

        <form id="login-form">

            <div class="form-group">

                <label>Email</label>

                <div class="input-wrapper">

                    <i class="fas fa-envelope input-icon"></i>

                    <input
                        type="email"
                        id="email"
                        placeholder="Masukkan email"
                        required>

                </div>

            </div>

            <div class="form-group">

                <label>Password</label>

                <div class="input-wrapper">

                    <i class="fas fa-lock input-icon"></i>

                    <input
                        type="password"
                        id="password"
                        placeholder="Masukkan password"
                        required>

                    <button
                        type="button"
                        class="toggle-password"
                        id="togglePassword">

                        <i class="fas fa-eye"></i>

                    </button>

                </div>

            </div>

            <button
                type="submit"
                class="login-btn">

                <i class="fas fa-sign-in-alt"></i>
                Login

            </button>

        </form>

        <div class="register-link">

            Belum punya akun?

            <a href="/register">
                <i class="fas fa-user-plus"></i>
                Register di sini
            </a>

        </div>

    </div>

</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<script>

// Show / Hide Password
const togglePassword = document.getElementById('togglePassword');
const passwordInput = document.getElementById('password');

togglePassword.addEventListener('click', function () {

    const icon = this.querySelector('i');

    if (passwordInput.type === 'password') {

        passwordInput.type = 'text';

        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');

    } else {

        passwordInput.type = 'password';

        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');

    }

});

// Login
document.getElementById('login-form').addEventListener('submit', async (e) => {

    e.preventDefault();

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    try {

        const authData = await window.login(email, password);

        window.saveAuth(authData);

        localStorage.setItem('user', JSON.stringify(authData.user));
        sessionStorage.setItem('user', JSON.stringify(authData.user));

        await fetch('/set-session', {

            method: 'POST',

            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },

            body: JSON.stringify({

                user: authData.user,
                access_token: authData.access_token

            }),

            credentials: 'same-origin'

        });

        Swal.fire({

            icon: 'success',

            title: 'Login Berhasil!',

            text: `Selamat datang ${authData.user.name}!`,

            timer: 1500,

            showConfirmButton: false

        }).then(() => {

            if (authData.user.role === 'admin') {

                window.location.href = '/admin';

            } else {

                window.location.href = '/';

            }

        });

    } catch (error) {

        Swal.fire({

            icon: 'error',

            title: 'Login Gagal!',

            text: error.message || 'Kesalahan tidak diketahui'

        });

    }

});

</script>

@endsection