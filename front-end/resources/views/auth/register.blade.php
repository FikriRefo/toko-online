@extends('components.app')

@section('title', 'Register - Toko Online')

@section('content')

<style>
    body{
        background:#f5f7fb;
    }

    .register-container{
        max-width:420px;
        margin:60px auto;
        padding:0 20px;
    }

    .register-card{
        background:#fff;
        padding:35px;
        border-radius:18px;
        box-shadow:0 10px 30px rgba(0,0,0,.08);
    }

    .register-title{
        text-align:center;
        margin-bottom:30px;
        color:#1f2937;
        font-size:30px;
        font-weight:bold;
    }

    .register-title i{
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

    .input-wrapper input,
    .input-wrapper select{
        width:100%;
        padding:12px 45px 12px 45px;
        border:1px solid #d1d5db;
        border-radius:10px;
        font-size:15px;
        outline:none;
        transition:.3s;
        box-sizing:border-box;
    }

    .input-wrapper input:focus,
    .input-wrapper select:focus{
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

    .register-btn{
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

    .register-btn:hover{
        background:#1d4ed8;
    }

    .register-btn i{
        margin-right:8px;
    }

    .login-link{
        text-align:center;
        margin-top:20px;
        color:#6b7280;
    }

    .login-link a{
        color:#2563eb;
        text-decoration:none;
        font-weight:600;
    }

    .login-link a:hover{
        text-decoration:underline;
    }
</style>

<div class="register-container">

    <div class="register-card">

        <h1 class="register-title">
            <i class="fas fa-user-plus"></i>
            Register
        </h1>

        <form id="register-form">

            <div class="form-group">

                <label>Nama</label>

                <div class="input-wrapper">

                    <i class="fas fa-user input-icon"></i>

                    <input
                        type="text"
                        id="name"
                        placeholder="Masukkan nama"
                        required>

                </div>

            </div>

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
                        data-target="password">

                        <i class="fas fa-eye"></i>

                    </button>

                </div>

            </div>

            <div class="form-group">

                <label>Konfirmasi Password</label>

                <div class="input-wrapper">

                    <i class="fas fa-lock input-icon"></i>

                    <input
                        type="password"
                        id="password_confirmation"
                        placeholder="Konfirmasi password"
                        required>

                    <button
                        type="button"
                        class="toggle-password"
                        data-target="password_confirmation">

                        <i class="fas fa-eye"></i>

                    </button>

                </div>

            </div>

            <div hidden>

                <select id="role">
                    <option value="customer" selected>Customer</option>
                    <option value="admin">Admin</option>
                </select>

            </div>

            <button
                type="submit"
                class="register-btn">

                <i class="fas fa-user-plus"></i>
                Register

            </button>

        </form>

        <div class="login-link">

            Sudah punya akun?

            <a href="/login">
                <i class="fas fa-right-to-bracket"></i>
                Login di sini
            </a>

        </div>

    </div>

</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<script>

// Show / Hide Password
document.querySelectorAll('.toggle-password').forEach(button => {

    button.addEventListener('click', function () {

        const target = document.getElementById(this.dataset.target);
        const icon = this.querySelector('i');

        if (target.type === 'password') {

            target.type = 'text';

            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');

        } else {

            target.type = 'password';

            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');

        }

    });

});

// Register
document.getElementById('register-form').addEventListener('submit', async (e) => {

    e.preventDefault();

    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const passwordConfirmation = document.getElementById('password_confirmation').value;
    const role = document.getElementById('role').value;

    try {

        const authData = await window.register(
            name,
            email,
            password,
            passwordConfirmation,
            role
        );

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

            title: 'Register Berhasil!',

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

            title: 'Register Gagal!',

            text: error.message || 'Kesalahan tidak diketahui'

        });

    }

});

</script>

@endsection