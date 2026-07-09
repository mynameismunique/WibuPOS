@extends('layouts.app')

@section('title', 'Daftar Penjualan')

@section('content')
<style>
    /* Dark mode adjustments for buttons and badges */
    [data-bs-theme="dark"] .btn-info {
        background-color: #4a6a8a;
        border-color: #4a6a8a;
        color: #fff;
    }
    [data-bs-theme="dark"] .btn-info:hover {
        background-color: #5a7a9a;
        border-color: #5a7a9a;
    }
    [data-bs-theme="dark"] .btn-danger {
        background-color: #8b2a3a;
        border-color: #8b2a3a;
        color: #fff;
    }
    [data-bs-theme="dark"] .btn-danger:hover {
        background-color: #b33c4a;
        border-color: #b33c4a;
    }
    [data-bs-theme="dark"] .badge.bg-primary {
        background-color: #4a6a9a !important;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-cart-fill"></i> Daftar Penjualan</h2>
    <div>
        <a href="{{ route('sales.create') }}" class="btn btn-wibu-primary">
            <i class="bi bi-plus-circle"></i> Transaksi Baru
        </a>
        <a href="{{ route('sales.export.excel') }}" class="btn btn-success">
            <i class="bi bi-file-earmark-excel"></i> Excel
        </a>
        <a href="{{ route('sales.export.pdf') }}" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf"></i> PDF
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card card-wibu p-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Invoice</th>
                    <th>Kasir</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Bayar</th>
                    <th>Kembali</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><span class="badge bg-primary">{{ $sale->invoice_number }}</span></td>
                    <td>{{ $sale->user->name ?? '-' }}</td>
                    <td>{{ $sale->customer_name }}</td>
                    <td>Rp {{ number_format($sale->grand_total, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($sale->payment_amount, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($sale->change_amount, 0, ',', '.') }}</td>
                    <td>{{ $sale->sale_date->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                            <i class="bi bi-receipt"></i>
                        </a>
                        
                        {{-- Tombol hapus hanya untuk ADMIN --}}
                        @if(Auth::user()->role == 'admin')
                            <button type="button" class="btn btn-sm btn-danger" title="Hapus Transaksi" onclick="confirmDelete({{ $sale->id }}, '{{ $sale->invoice_number }}')">
                                <i class="bi bi-trash"></i>
                            </button>
                            <form id="delete-form-{{ $sale->id }}" action="{{ route('sales.destroy', $sale) }}" method="POST" style="display: none;">
                                @csrf @method('DELETE')
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-4">Belum ada transaksi penjualan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $sales->links() }}
    </div>
</div>

@push('scripts')
<script>
    function confirmDelete(saleId, invoiceNumber) {
        Swal.fire({
            title: 'Yakin hapus transaksi ini?',
            html: `Invoice <strong>${invoiceNumber}</strong> akan dihapus dan stok produk akan dikembalikan.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff6b9d',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            background: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#1e1e30' : '#fff',
            color: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#e4e4f0' : '#212529',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + saleId).submit();
            }
        });
    }
</script>
@endpush
@endsection