@extends('layouts.app')

@section('title', 'Login - Wibu-POS')

@section('content')
<style>
    .login-wrapper {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-card {
        background: var(--wibu-card-bg, #ffffff);
        border-radius: 30px !important;
        box-shadow: 0 20px 60px rgba(184, 169, 201, 0.25) !important;
        border: none !important;
        overflow: hidden;
        transition: all 0.3s ease;
        padding: 20px;
    }

    .login-card .card-header {
        background: linear-gradient(135deg, var(--wibu-pink, #ff6b9d), var(--wibu-lavender, #b8a9c9)) !important;
        padding: 20px 30px;
        border-bottom: none;
        text-align: center;
        border-radius: 30px 30px 0 0 !important;
        margin: -20px -20px 20px -20px;
    }

    .login-card .card-header h4 {
        color: white;
        font-weight: 700;
        margin: 0;
        text-shadow: 0 2px 10px rgba(0,0,0,0.1);
        font-size: 1.5rem;
    }

    .login-card .card-header h4 i {
        margin-right: 10px;
    }

    .login-card .card-body {
        padding: 10px 20px 20px;
    }

    .login-card .form-control {
        border-radius: 50px !important;
        padding: 12px 20px;
        border: 2px solid var(--wibu-border, #dee2e6);
        background-color: var(--wibu-bg, #fff5f7);
        color: var(--wibu-text, #212529);
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .login-card .form-control:focus {
        border-color: var(--wibu-pink, #ff6b9d);
        box-shadow: 0 0 0 0.25rem rgba(255, 107, 157, 0.2);
        background-color: var(--wibu-card-bg, #ffffff);
    }

    .login-card .form-label {
        font-weight: 600;
        color: var(--wibu-text, #212529);
        margin-bottom: 5px;
    }

    .btn-login {
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

    .btn-login:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 25px rgba(255, 107, 157, 0.3);
        color: white !important;
    }

    .login-card .form-check-label {
        color: var(--wibu-text, #212529);
        font-weight: 500;
    }

    .login-card .forgot-link {
        color: var(--wibu-pink, #ff6b9d);
        font-weight: 600;
        text-decoration: none;
        transition: 0.2s;
    }

    .login-card .forgot-link:hover {
        color: #e55a8a;
        text-decoration: underline;
    }

    .login-card .register-info {
        color: var(--wibu-text, #888);
        font-weight: 500;
        font-size: 0.95rem;
    }

    .login-emoji {
        font-size: 3rem;
        text-align: center;
        display: block;
        margin-bottom: 5px;
        filter: drop-shadow(0 4px 10px rgba(255,107,157,0.2));
    }

    [data-bs-theme="dark"] .login-card .form-control {
        background-color: #2a2a40;
        border-color: #444466;
        color: #f0ecff;
    }

    [data-bs-theme="dark"] .login-card .form-control:focus {
        background-color: #333355;
        border-color: #ff7eb3;
        box-shadow: 0 0 0 0.25rem rgba(255, 126, 179, 0.2);
    }

    [data-bs-theme="dark"] .login-card .forgot-link {
        color: #ff7eb3;
    }

    [data-bs-theme="dark"] .login-card .forgot-link:hover {
        color: #ff9ec7;
    }

    [data-bs-theme="dark"] .login-card .register-info {
        color: #aaaaaa;
    }
</style>

<div class="login-wrapper">
    <div class="col-md-6 col-lg-5">
        <div class="card login-card">
            <div class="card-header">
                <h4><i class="bi bi-stars"></i> Login Wibu-POS</h4>
            </div>

            <div class="card-body">
                <span class="login-emoji">🌸</span>
                <p class="text-center text-muted" style="font-weight: 500; margin-top: -5px; margin-bottom: 20px;">
                    Selamat datang, silahkan login untuk masuk ke dalam sistem WibuPOS
                </p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="bi bi-envelope-fill" style="color: var(--wibu-pink, #ff6b9d);"></i> Email Address
                        </label>
                        <input id="email" type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               name="email" value="{{ old('email') }}" 
                               required autocomplete="email" autofocus
                               placeholder="user@wibupos.com">
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
                               name="password" required autocomplete="current-password"
                               placeholder="••••••••">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" 
                                   {{ old('remember') ? 'checked' : '' }}
                                   style="border-color: var(--wibu-pink, #ff6b9d);">
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                        @if (Route::has('password.request'))
                            <a class="forgot-link" href="{{ route('password.request') }}">
                                <i class="bi bi-question-circle"></i> Lupa Password?
                            </a>
                        @endif
                    </div>

                    <!-- Tombol Login -->
                    <button type="submit" class="btn btn-login">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection