@extends('layouts.app')

@section('title', 'Daftar Pembelian')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-arrow-up-circle-fill"></i> Daftar Pembelian</h2>
    <div>
        <a href="{{ route('purchases.create') }}" class="btn btn-wibu-primary">
            <i class="bi bi-plus-circle"></i> Tambah Pembelian
        </a>
        <a href="{{ route('purchases.export.excel') }}" class="btn btn-success">
            <i class="bi bi-file-earmark-excel"></i> Excel
        </a>
        <a href="{{ route('purchases.export.pdf') }}" class="btn btn-danger">
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
                    <th>No. Pembelian</th>
                    <th>Supplier</th>
                    <th>Total</th>
                    <th>Tanggal</th>
                    <th>User</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($purchases as $purchase)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><span class="badge bg-secondary">{{ $purchase->purchase_number }}</span></td>
                    <td>{{ $purchase->supplier->name ?? '-' }}</td>
                    <td>Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d/m/Y') }}</td>
                    <td>{{ $purchase->user->name ?? '-' }}</td>
                    <td>
                        <div class="d-flex gap-1 flex-wrap">
                            <a href="{{ route('purchases.show', $purchase) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $purchase->id }}, '{{ $purchase->purchase_number }}')">
                                <i class="bi bi-trash"></i>
                            </button>
                            <form id="delete-form-{{ $purchase->id }}" action="{{ route('purchases.destroy', $purchase) }}" method="POST" style="display: none;">
                                @csrf @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4">Belum ada pembelian.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
        <div class="text-muted small">
            Menampilkan {{ $purchases->firstItem() ?? 0 }} - {{ $purchases->lastItem() ?? 0 }} dari {{ $purchases->total() }} pembelian
        </div>
        <div>
            {{ $purchases->appends(request()->query())->links('pagination::bootstrap-5', ['class' => 'pagination-sm']) }}
        </div>
    </div>
</div>

@push('scripts')
<script>
    function confirmDelete(purchaseId, purchaseNumber) {
        Swal.fire({
            title: 'Yakin hapus pembelian ini?',
            html: `Pembelian <strong>${purchaseNumber}</strong> akan dihapus dan stok produk akan dikurangi.`,
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
                document.getElementById('delete-form-' + purchaseId).submit();
            }
        });
    }
</script>
@endpush
@endsection