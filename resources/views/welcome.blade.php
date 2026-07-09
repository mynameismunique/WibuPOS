@extends('layouts.app')

@section('title', 'Wibu-POS')

@section('content')

<style>
    .fade-in {
        animation: fadeInUp 1s ease forwards;
        opacity: 0;
    }

    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(40px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card-stagger-1 { animation-delay: 0.2s; }
    .card-stagger-2 { animation-delay: 0.5s; }
    .card-stagger-3 { animation-delay: 0.8s; }

    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-12px); }
        100% { transform: translateY(0px); }
    }
    .float-animation {
        animation: float 3s ease-in-out infinite;
    }

    @keyframes pulseGlow {
        0% {
            box-shadow: 0 0 0 0 rgba(0, 212, 255, 0.6);
            transform: scale(1);
        }
        50% {
            box-shadow: 0 0 30px 10px rgba(0, 212, 255, 0.3);
            transform: scale(1.03);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(0, 212, 255, 0);
            transform: scale(1);
        }
    }
    .btn-pulse {
        animation: pulseGlow 2.5s ease-in-out infinite;
    }

    .hero-wibu {
        position: relative;
        overflow: hidden;
    }
    .hero-wibu::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle at 30% 40%, rgba(255, 107, 157, 0.08) 0%, transparent 60%),
                    radial-gradient(circle at 70% 60%, rgba(0, 212, 255, 0.06) 0%, transparent 50%);
        animation: rotateGlow 20s linear infinite;
        pointer-events: none;
        z-index: 0;
    }
    @keyframes rotateGlow {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .hero-wibu > * {
        position: relative;
        z-index: 1;
    }

    .sakura-particles {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 0;
        overflow: hidden;
    }
    .sakura {
        position: absolute;
        color: #ff6b9d;
        font-size: 20px;
        animation: fall linear infinite;
        opacity: 0.6;
    }
    @keyframes fall {
        0% {
            transform: translateY(-10vh) rotate(0deg) scale(0.8);
            opacity: 0.2;
        }
        10% { opacity: 0.8; }
        90% { opacity: 0.8; }
        100% {
            transform: translateY(110vh) rotate(720deg) scale(1.2);
            opacity: 0;
        }
    }

    .card-wibu {
        transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), 
                    box-shadow 0.4s ease;
        cursor: default;
        background-color: var(--wibu-card-bg);
        color: var(--wibu-text);
        border-radius: 20px;
        overflow: hidden;
    }
    .card-wibu:hover {
        transform: translateY(-12px) scale(1.02);
        box-shadow: 0 20px 50px rgba(184, 169, 201, 0.4);
    }

    [data-bs-theme="dark"] .hero-wibu {
        background: rgba(30, 30, 60, 0.9);
    }
    [data-bs-theme="dark"] .sakura {
        color: #ff7eb3;
        opacity: 0.4;
    }

    .badge-wibu {
        background-color: var(--wibu-pink);
        color: white;
        padding: 8px 16px;
        border-radius: 30px;
        font-weight: bold;
    }

    /* Gaya untuk ikon kategori */
    .category-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--wibu-pink), var(--wibu-lavender));
        font-size: 3.5rem;
        margin: 0 auto 1rem;
        box-shadow: 0 8px 25px rgba(255, 107, 157, 0.2);
        transition: transform 0.3s ease;
        color: white;
    }

    .card-wibu:hover .category-icon {
        transform: scale(1.1) rotate(-5deg);
    }

    [data-bs-theme="dark"] .category-icon {
        background: linear-gradient(135deg, #ff7eb3, #c9b8dd);
        box-shadow: 0 8px 25px rgba(255, 126, 179, 0.2);
    }
</style>

<div class="sakura-particles" id="sakura-container"></div>

<!-- HERO -->
<div class="hero-wibu text-center p-5 mb-5 fade-in position-relative" style="z-index:1;">
    <div class="float-animation" style="font-size: 4rem; display: inline-block; filter: drop-shadow(0 8px 20px rgba(255,107,157,0.3));">
        🌸
    </div>
    <h1 class="display-3 fw-bold" style="color: #ff6b9d; text-shadow: 0 4px 20px rgba(255,107,157,0.2);">
        いらっしゃいませ！
    </h1>
    <h2 class="display-6" style="color: #b8a9c9; font-weight: 400;">
        Selamat Datang di <span style="font-weight: bold; color: #ff6b9d;">Wibu-POS</span>
    </h2>
    <p class="lead mt-3" style="color: #2d2a3e; max-width: 600px; margin: 0 auto;">
        Kelola penjualan produk wibu dengan mudah dan cepat! 
        <br><small class="text-muted">Dari Figure, Manga, sampai Merchandise Imut</small>
    </p>
    <a href="{{ route('login') }}" class="btn btn-wibu-accent btn-lg mt-4 btn-pulse" style="padding: 12px 40px;">
        <i class="bi bi-lightning-fill"></i> Mulai Bertransaksi
    </a>
    <div class="mt-3">
        <span class="badge bg-primary bg-opacity-10 text-primary p-2 px-3">
            <i class="bi bi-shield-check"></i> Aman & Terpercaya
        </span>
        <span class="badge bg-success bg-opacity-10 text-success p-2 px-3 ms-2">
            <i class="bi bi-clock"></i> 24/7 Support
        </span>
    </div>
</div>

<div class="row g-4">
    @forelse($products as $index => $product)
        <div class="col-md-4 fade-in card-stagger-{{ $index + 1 }}">
            <div class="card card-wibu h-100 text-center p-4">
                <!-- Ikon Kategori (besar) -->
                <div class="category-icon">
                    @switch($product->category->name ?? '')
                        @case('Action Figure') 🎎 @break
                        @case('Manga') 📚 @break
                        @case('Anime DVD') 🎬 @break
                        @case('Merchandise') 🎁 @break
                        @case('Poster') 🖼️ @break
                        @case('Dakimakura') 🛏️ @break
                        @default 🎌
                    @endswitch
                </div>

                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text text-muted">
                        {{ $product->category->name ?? 'Tanpa Kategori' }}
                        <br>
                        <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }}">
                            Stok: {{ $product->stock }}
                        </span>
                    </p>
                    <span class="badge-wibu">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <h4 class="text-muted">Belum ada produk nih 😢</h4>
            <p class="text-muted">Yuk tambahkan produk dulu melalui menu Produk (Admin).</p>
        </div>
    @endforelse
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('sakura-container');
        const sakuraChars = ['🌸', '🌸', '🌸', '🌸', '🌸', '✿', '🌸', '🌸'];
        const total = 20;

        for (let i = 0; i < total; i++) {
            const el = document.createElement('div');
            el.className = 'sakura';
            el.textContent = sakuraChars[Math.floor(Math.random() * sakuraChars.length)];
            el.style.left = Math.random() * 100 + '%';
            el.style.fontSize = (12 + Math.random() * 20) + 'px';
            el.style.animationDuration = (8 + Math.random() * 12) + 's';
            el.style.animationDelay = (Math.random() * 10) + 's';
            el.style.opacity = 0.3 + Math.random() * 0.4;
            container.appendChild(el);
        }
    });
</script>
@endpush
@endsection