@extends('layouts.app')

@section('title', 'Register - Wibu-POS')

@section('content')
<style>
    .register-wrapper {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .register-card {
        background: var(--wibu-card-bg, #ffffff);
        border-radius: 30px !important;
        box-shadow: 0 20px 60px rgba(184, 169, 201, 0.25) !important;
        border: none !important;
        overflow: hidden;
        transition: all 0.3s ease;
        padding: 20px;
    }

    .register-card .card-header {
        background: linear-gradient(135deg, var(--wibu-pink, #ff6b9d), var(--wibu-lavender, #b8a9c9)) !important;
        padding: 20px 30px;
        border-bottom: none;
        text-align: center;
        border-radius: 30px 30px 0 0 !important;
        margin: -20px -20px 20px -20px;
    }

    .register-card .card-header h4 {
        color: white;
        font-weight: 700;
        margin: 0;
        text-shadow: 0 2px 10px rgba(0,0,0,0.1);
        font-size: 1.5rem;
    }

    .register-card .card-header h4 i {
        margin-right: 10px;
    }

    .register-card .card-body {
        padding: 10px 20px 20px;
    }

    .register-card .form-control {
        border-radius: 50px !important;
        padding: 12px 20px;
        border: 2px solid var(--wibu-border, #dee2e6);
        background-color: var(--wibu-bg, #fff5f7);
        color: var(--wibu-text, #212529);
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .register-card .form-control:focus {
        border-color: var(--wibu-pink, #ff6b9d);
        box-shadow: 0 0 0 0.25rem rgba(255, 107, 157, 0.2);
        background-color: var(--wibu-card-bg, #ffffff);
    }

    .register-card .form-label {
        font-weight: 600;
        color: var(--wibu-text, #212529);
        margin-bottom: 5px;
    }

    .btn-register {
        background: linear-gradient(135deg, var(--wibu-pink, #ff6b9d), var(--wibu-lavender, #b8a9c9)) !important;
        border: none !important;
        border-radius: 50px !important;
        padding: 12px 35px !important;
        font-weight: 700 !important;
        color: white !important;
        transition: all 0.3s ease;
        width: 100%;
        font-size: 1.1rem;
        letter-spacing: 1px;
    }

    .btn-register:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 25px rgba(255, 107, 157, 0.3);
        color: white !important;
    }

    .register-card .login-link {
        color: var(--wibu-blue, #00d4ff);
        font-weight: 600;
        text-decoration: none;
        transition: 0.2s;
    }

    .register-card .login-link:hover {
        color: #00b8e0;
        text-decoration: underline;
    }

    .register-emoji {
        font-size: 3rem;
        text-align: center;
        display: block;
        margin-bottom: 5px;
        filter: drop-shadow(0 4px 10px rgba(255,107,157,0.2));
    }

    [data-bs-theme="dark"] .register-card .form-control {
        background-color: #2a2a40;
        border-color: #444466;
        color: #f0ecff;
    }

    [data-bs-theme="dark"] .register-card .form-control:focus {
        background-color: #333355;
        border-color: #ff7eb3;
        box-shadow: 0 0 0 0.25rem rgba(255, 126, 179, 0.2);
    }
</style>

<div class="register-wrapper">
    <div class="col-md-6 col-lg-5">
        <div class="card register-card">
            <div class="card-header">
                <h4><i class="bi bi-person-plus"></i> Daftar Wibu-POS</h4>
            </div>

            <div class="card-body">
                <span class="register-emoji">🎌</span>
                <p class="text-center text-muted" style="font-weight: 500; margin-top: -5px; margin-bottom: 20px;">
                    Bergabunglah dengan komunitas Otaku!
                </p>

                <form method="POST" action="{{ route('register') }}" id="registerForm">
                    @csrf

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">
                            <i class="bi bi-person-fill" style="color: var(--wibu-pink, #ff6b9d);"></i> Nama Lengkap
                        </label>
                        <input id="name" type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               name="name" value="{{ old('name') }}" 
                               required autocomplete="name" autofocus
                               placeholder="Nama kamu...">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="bi bi-envelope-fill" style="color: var(--wibu-pink, #ff6b9d);"></i> Email Address
                        </label>
                        <input id="email" type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               name="email" value="{{ old('email') }}" 
                               required autocomplete="email"
                               placeholder="otaku@example.com">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <i class="bi bi-lock-fill" style="color: var(--wibu-pink, #ff6b9d);"></i> Password
                        </label>
                        <input id="password" type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               name="password" required autocomplete="new-password"
                               placeholder="Minimal 8 karakter">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <label for="password-confirm" class="form-label">
                            <i class="bi bi-check-circle-fill" style="color: var(--wibu-pink, #ff6b9d);"></i> Konfirmasi Password
                        </label>
                        <input id="password-confirm" type="password" 
                               class="form-control" 
                               name="password_confirmation" required autocomplete="new-password"
                               placeholder="Ulangi password">
                    </div>

                    <!-- Tombol Register -->
                    <button type="submit" class="btn btn-register" id="registerBtn">
                        <i class="bi bi-person-plus"></i> Daftar Sekarang
                    </button>
                </form>

                <!-- Link Login -->
                <div class="text-center mt-3">
                    <span class="text-muted" style="font-weight: 500;">Sudah punya akun?</span>
                    <a href="{{ route('login') }}" class="login-link">
                        Login <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk validasi & notifikasi -->
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('registerForm');
        const btn = document.getElementById('registerBtn');

        // Tampilkan error dari server pakai SweetAlert2
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#ff6b9d',
                background: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#1e1e30' : '#fff',
                color: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#e4e4f0' : '#212529',
            });
        @endif

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#ff6b9d',
                background: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#1e1e30' : '#fff',
                color: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#e4e4f0' : '#212529',
            });
        @endif

        form.addEventListener('submit', function(e) {
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const passwordConfirm = document.getElementById('password-confirm').value;

            if (name.length < 3) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Nama terlalu pendek',
                    text: 'Nama minimal 3 karakter ya, Otaku!',
                    confirmButtonColor: '#ff6b9d',
                    background: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#1e1e30' : '#fff',
                    color: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#e4e4f0' : '#212529',
                });
                return;
            }

            // Validasi email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Email tidak valid',
                    text: 'Masukkan email yang benar, contoh: otaku@example.com',
                    confirmButtonColor: '#ff6b9d',
                    background: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#1e1e30' : '#fff',
                    color: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#e4e4f0' : '#212529',
                });
                return;
            }

            // Validasi password
            if (password.length < 8) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Password terlalu pendek',
                    text: 'Password minimal 8 karakter ya!',
                    confirmButtonColor: '#ff6b9d',
                    background: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#1e1e30' : '#fff',
                    color: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#e4e4f0' : '#212529',
                });
                return;
            }

            // Validasi konfirmasi password
            if (password !== passwordConfirm) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Password tidak cocok',
                    text: 'Konfirmasi password harus sama dengan password!',
                    confirmButtonColor: '#ff6b9d',
                    background: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#1e1e30' : '#fff',
                    color: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#e4e4f0' : '#212529',
                });
                return;
            }

            // Tampilkan loading saat submit
            btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mendaftar...';
            btn.disabled = true;
        });
    });
</script>
@endpush
@endsection