@extends('layouts.app')

@section('title', 'Dashboard - Otaku POS')

@section('content')
<div class="row g-4">
    <div class="col-md-3">
        <div class="card card-wibu p-3 text-center">
            <h5><i class="bi bi-box-fill text-primary"></i> Produk</h5>
            <h2 class="fw-bold">{{ $totalProducts }}</h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-wibu p-3 text-center">
            <h5><i class="bi bi-tags-fill text-success"></i> Kategori</h5>
            <h2 class="fw-bold">{{ $totalCategories }}</h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-wibu p-3 text-center">
            <h5><i class="bi bi-people-fill text-warning"></i> Supplier</h5>
            <h2 class="fw-bold">{{ $totalSuppliers }}</h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-wibu p-3 text-center">
            <h5><i class="bi bi-cart-fill text-info"></i> Transaksi</h5>
            <h2 class="fw-bold">{{ $totalSales }}</h2>
        </div>
    </div>
</div>

<div class="row g-4 mt-3">
    <div class="col-md-4">
        <div class="card card-wibu p-3">
            <h6><i class="bi bi-calendar-day text-danger"></i> Penjualan Hari Ini</h6>
            <h3 class="fw-bold">Rp {{ number_format($todaySales, 0, ',', '.') }}</h3>
            <small>{{ $todayCount }} transaksi</small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-wibu p-3">
            <h6><i class="bi bi-calendar-month text-primary"></i> Penjualan Bulan Ini</h6>
            <h3 class="fw-bold">Rp {{ number_format($monthSales, 0, ',', '.') }}</h3>
            <small>{{ $monthCount }} transaksi</small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-wibu p-3">
            <h6><i class="bi bi-exclamation-triangle text-warning"></i> Stok Menipis</h6>
            <h3 class="fw-bold">{{ $lowStock }}</h3>
            <small>produk perlu restock</small>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card card-wibu p-4">
            <h5 class="mb-3"><i class="bi bi-graph-up-arrow text-success"></i> Grafik Penjualan 7 Hari Terakhir</h5>
            <div style="position: relative; height: 400px; width: 100%;">
                <canvas id="salesChart" style="height: 100% !important; width: 100% !important;"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($dates),
                datasets: [{
                    label: 'Total Penjualan (Rp)',
                    data: @json($salesData),
                    backgroundColor: 'rgba(255, 107, 157, 0.2)',
                    borderColor: '#ff6b9d',
                    borderWidth: 3,
                    tension: 0.3,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            font: { family: 'Zen Maru Gothic' }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush