<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <!-- PWA Meta Tags -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#ff6b9d">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="apple-touch-icon" href="{{ asset('icons/icon-192x192.png') }}">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Wibu-POS')</title>

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zen+Maru+Gothic&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        * { font-family: 'Poppins', sans-serif; }

        :root {
            --wibu-pink: #ff6b9d;
            --wibu-lavender: #b8a9c9;
            --wibu-blue: #00d4ff;
            --wibu-dark: #2d2a3e;
            --wibu-bg: #fff5f7;
            --wibu-card-bg: #ffffff;
            --wibu-text: #212529;
            --wibu-border: #dee2e6;
            --navbar-bg-light: rgba(255, 255, 255, 0.25);
            --navbar-border-light: rgba(255, 255, 255, 0.4);
            --navbar-shadow-light: 0 8px 32px rgba(0, 0, 0, 0.08);
        }

        body {
            background-color: var(--wibu-bg);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: var(--wibu-text);
            transition: background-color 0.3s ease, color 0.3s ease;
            padding-top: 90px;
        }

        [data-bs-theme="dark"] {
            --wibu-bg: #12121a;
            --wibu-card-bg: #1e1e30;
            --wibu-text: #e4e4f0;
            --wibu-border: #3a3a5c;
            --wibu-pink: #ff7eb3;
            --wibu-lavender: #c9b8dd;
            --wibu-blue: #66e4ff;
            --navbar-bg-light: rgba(20, 20, 40, 0.7);
            --navbar-border-light: rgba(255, 255, 255, 0.08);
            --navbar-shadow-light: 0 8px 32px rgba(0, 0, 0, 0.5);
        }

        [data-bs-theme="dark"] body {
            background-color: var(--wibu-bg);
            color: var(--wibu-text);
        }

        [data-bs-theme="dark"] .card-wibu {
            background-color: var(--wibu-card-bg) !important;
            color: var(--wibu-text);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }
        [data-bs-theme="dark"] .card-wibu .card-title,
        [data-bs-theme="dark"] .card-wibu h2,
        [data-bs-theme="dark"] .card-wibu h4,
        [data-bs-theme="dark"] .card-wibu h5,
        [data-bs-theme="dark"] .card-wibu h6 {
            color: #f0ecff;
        }

        [data-bs-theme="dark"] .table {
            color: #e0dcec;
        }
        [data-bs-theme="dark"] .table-hover tbody tr:hover {
            background-color: #2a2a4a;
            color: #ffffff;
        }
        [data-bs-theme="dark"] .table-bordered {
            border-color: var(--wibu-border);
        }
        [data-bs-theme="dark"] .table-bordered th,
        [data-bs-theme="dark"] .table-bordered td {
            border-color: var(--wibu-border);
        }

        [data-bs-theme="dark"] .hero-wibu {
            background: rgba(30, 30, 60, 0.8);
            border-color: #5555aa;
        }

        [data-bs-theme="dark"] .footer-wibu {
            background-color: #0d0d1a;
        }

        [data-bs-theme="dark"] .form-control,
        [data-bs-theme="dark"] .form-select {
            background-color: #2a2a40;
            border-color: #444466;
            color: #f0ecff;
        }
        [data-bs-theme="dark"] .form-control:focus,
        [data-bs-theme="dark"] .form-select:focus {
            background-color: #333355;
            border-color: var(--wibu-blue);
            color: #ffffff;
            box-shadow: 0 0 0 0.25rem rgba(0, 212, 255, 0.25);
        }
        [data-bs-theme="dark"] .form-control::placeholder {
            color: #9999bb;
        }

        [data-bs-theme="dark"] .alert-success {
            background-color: #1e3a2a;
            color: #a3e4b7;
            border-color: #2a6a4a;
        }
        [data-bs-theme="dark"] .alert-danger {
            background-color: #4a1e2a;
            color: #f4a3b7;
            border-color: #6a2a4a;
        }

        [data-bs-theme="dark"] .text-muted {
            color: #aaaaaa !important;
        }
        [data-bs-theme="dark"] .bg-light {
            background-color: #2a2a40 !important;
        }
        [data-bs-theme="dark"] .table-light {
            background-color: #2a2a40;
            color: #eee;
        }

        .btn-wibu-primary {
            background-color: var(--wibu-pink);
            border: none;
            color: white;
            font-weight: bold;
            transition: 0.2s;
        }
        .btn-wibu-primary:hover {
            background-color: #e55a8a;
            color: white;
            transform: scale(1.03);
        }
        .btn-wibu-accent {
            background-color: var(--wibu-blue);
            border: none;
            color: white;
            font-weight: bold;
            transition: 0.2s;
        }
        .btn-wibu-accent:hover {
            background-color: #00b8e0;
            color: white;
            transform: scale(1.03);
        }

        .card-wibu {
            border: none;
            border-radius: 20px;
            background-color: var(--wibu-card-bg);
            color: var(--wibu-text);
            box-shadow: 0 10px 30px rgba(184, 169, 201, 0.2);
            transition: 0.3s, background-color 0.3s, color 0.3s;
        }
        .card-wibu:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(184, 169, 201, 0.4);
        }
        .badge-wibu {
            background-color: var(--wibu-pink);
            color: white;
            padding: 8px 16px;
            border-radius: 30px;
            font-weight: bold;
        }

        .hero-wibu {
            background: linear-gradient(135deg, rgba(255, 107, 157, 0.1), rgba(184, 169, 201, 0.1));
            border-radius: 30px;
            padding: 60px 20px;
            border: 2px dashed var(--wibu-pink);
        }

        .footer-wibu {
            background-color: var(--wibu-dark);
            color: #ccc;
            padding: 15px 0;
            margin-top: auto;
            text-align: center;
        }
        .footer-wibu span { color: var(--wibu-white); }

        .navbar-wibu {
            position: fixed !important;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: calc(100% - 40px);
            max-width: 1400px;
            z-index: 1050;
            background: var(--navbar-bg-light) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
            border-radius: 24px !important;
            padding: 10px 28px !important;
            box-shadow: var(--navbar-shadow-light) !important;
            border: 1px solid var(--navbar-border-light) !important;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94) !important;
            box-sizing: border-box;
        }

        .navbar-wibu.navbar-scrolled {
            top: 12px;
            padding: 6px 20px !important;
            border-radius: 16px !important;
            background: var(--navbar-bg-light) !important;
            backdrop-filter: blur(20px) !important;
            -webkit-backdrop-filter: blur(20px) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12) !important;
            border-color: rgba(255, 255, 255, 0.15) !important;
        }

        .navbar-wibu:hover {
            box-shadow: 0 12px 40px rgba(255, 107, 157, 0.15) !important;
            border-color: rgba(255, 107, 157, 0.3) !important;
        }

        [data-bs-theme="dark"] .navbar-wibu {
            background: rgba(20, 20, 40, 0.7) !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5) !important;
        }
        [data-bs-theme="dark"] .navbar-wibu:hover {
            box-shadow: 0 12px 40px rgba(100, 100, 200, 0.3) !important;
            border-color: rgba(100, 100, 200, 0.3) !important;
        }
        [data-bs-theme="dark"] .navbar-wibu.navbar-scrolled {
            background: rgba(10, 10, 25, 0.8) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.6) !important;
        }

        .navbar-wibu .navbar-brand,
        .navbar-wibu .nav-link {
            color: #2d2a3e !important;
            font-weight: 600;
            transition: color 0.3s;
        }
        .navbar-wibu .navbar-brand {
            font-size: 1.4rem;
            letter-spacing: 0.5px;
        }
        .navbar-wibu .nav-link {
            font-size: 0.95rem;
            padding: 6px 14px;
            border-radius: 30px;
            transition: background 0.2s;
        }
        .navbar-wibu .nav-link:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        [data-bs-theme="dark"] .navbar-wibu .navbar-brand,
        [data-bs-theme="dark"] .navbar-wibu .nav-link {
            color: #f0e6f6 !important;
        }
        [data-bs-theme="dark"] .navbar-wibu .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .btn-theme-toggle {
            background: rgba(255, 255, 255, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.5);
            color: #2d2a3e;
            border-radius: 50px;
            padding: 5px 16px;
            transition: 0.2s;
        }
        .btn-theme-toggle:hover {
            background: rgba(255, 255, 255, 0.5);
            transform: scale(1.05);
        }
        [data-bs-theme="dark"] .btn-theme-toggle {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
            color: #f0e6f6;
        }
        [data-bs-theme="dark"] .btn-theme-toggle:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.3);
        }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(45, 42, 62, 0.8)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        [data-bs-theme="dark"] .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(240, 230, 246, 0.8)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        @media (max-width: 991.98px) {
            .navbar-wibu {
                top: 12px;
                padding: 8px 16px !important;
                border-radius: 18px !important;
                width: calc(100% - 24px);
            }
            body {
                padding-top: 80px;
            }
            .navbar-wibu .navbar-nav {
                padding-top: 10px;
            }
        }
        @media (max-width: 575.98px) {
            .navbar-wibu {
                top: 8px;
                padding: 6px 12px !important;
                border-radius: 14px !important;
            }
            body {
                padding-top: 70px;
            }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-wibu" id="mainNavbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <i class="bi bi-stars"></i> WibuPOS <i class="bi bi-stars"></i>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-2">

                    @auth
                        <!-- Menu untuk user yang sudah login -->
                        <li class="nav-item"><a class="nav-link" href="/dashboard"><i class="bi bi-house-fill"></i> Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('sales.index') }}"><i class="bi bi-cart-fill"></i> Penjualan</a></li>

                        @if(Auth::user()->role == 'admin')
                            <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}"><i class="bi bi-box-fill"></i> Produk</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('categories.index') }}"><i class="bi bi-tags-fill"></i> Kategori</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('suppliers.index') }}"><i class="bi bi-people-fill"></i> Supplier</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('purchases.index') }}"><i class="bi bi-arrow-up-circle-fill"></i> Pembelian</a></li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('users.index') }}">
                                    <i class="bi bi-people-fill"></i> Kelola User
                                </a>
                            </li>
                        @endif

                        <li class="nav-item">
                            <button class="btn btn-theme-toggle" id="theme-toggle" title="Toggle Dark/Light Mode">
                                <i class="bi bi-moon-fill"></i> <span class="d-none d-sm-inline">Mode</span>
                            </button>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-danger" href="#" id="logout-button">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @endauth

                    @guest
                        <!-- Menu untuk user yang belum login -->
                        <li class="nav-item">
                            <button class="btn btn-theme-toggle" id="theme-toggle" title="Toggle Dark/Light Mode">
                                <i class="bi bi-moon-fill"></i> <span class="d-none d-sm-inline">Mode</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                        </li>
                    @endguest

                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5 flex-grow-1">
        @yield('content')
    </div>

    <footer class="footer-wibu">
        <div class="container">
            <p class="mb-0">
                <span>Copyright &copy; 2026 Team WibuPOS. All rights reserved.</span>
            </p>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                once: true,
                offset: 50,
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('theme-toggle');
            const htmlElement = document.documentElement;

            let currentTheme = localStorage.getItem('bs-theme') || 'light';
            htmlElement.setAttribute('data-bs-theme', currentTheme);
            updateIcon(currentTheme);

            toggleBtn.addEventListener('click', function() {
                let theme = htmlElement.getAttribute('data-bs-theme');
                let newTheme = theme === 'dark' ? 'light' : 'dark';
                
                htmlElement.setAttribute('data-bs-theme', newTheme);
                localStorage.setItem('bs-theme', newTheme);
                updateIcon(newTheme);
            });

            function updateIcon(theme) {
                const icon = toggleBtn.querySelector('i');
                if (theme === 'dark') {
                    icon.className = 'bi bi-sun-fill';
                } else {
                    icon.className = 'bi bi-moon-fill';
                }
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.getElementById('mainNavbar');
            let lastScrollY = window.scrollY;

            window.addEventListener('scroll', function() {
                const currentScrollY = window.scrollY;
                if (currentScrollY > 30) {
                    navbar.classList.add('navbar-scrolled');
                } else {
                    navbar.classList.remove('navbar-scrolled');
                }
                lastScrollY = currentScrollY;
            });
        });
    </script>
        
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logoutBtn = document.getElementById('logout-button');
            if (logoutBtn) {
                logoutBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Konfirmasi',
                        text: "Kamu akan keluar dari Wibu-POS!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ff6b9d',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Logout!',
                        cancelButtonText: 'Batal',
                        background: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#1e1e30' : '#fff',
                        color: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#e4e4f0' : '#212529',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('logout-form').submit();
                        }
                    });
                });
            }
        });
    </script>

    @stack('scripts')

<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/serviceworker.js')
                .then(function(registration) {
                    console.log('ServiceWorker registration successful with scope: ', registration.scope);
                })
                .catch(function(err) {
                    console.log('ServiceWorker registration failed: ', err);
                });
        });
    }
</script>
</body>
</html>