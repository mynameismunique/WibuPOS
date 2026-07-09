@extends('layouts.app')

@section('title', 'Daftar Supplier')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-people-fill"></i> Daftar Supplier</h2>
    <div>
        <a href="{{ route('suppliers.create') }}" class="btn btn-wibu-primary">
          	<i class="bi bi-plus-circle"></i> Tambah Supplier
        </a>
        <a href="{{ route('suppliers.export.excel') }}" class="btn btn-success">
            <i class="bi bi-file-earmark-excel"></i> Excel
        </a>
        <a href="{{ route('suppliers.export.pdf') }}" class="btn btn-danger">
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

<div class="card card-wibu p-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Supplier</th>
                    <th>Contact Person</th>
                    <th>Telepon</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $supplier)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $supplier->name }}</strong></td>
                    <td>{{ $supplier->contact_person }}</td>
                    <td>{{ $supplier->phone }}</td>
                    <td>{{ $supplier->email ?? '-' }}</td>
                    <td>
                        <div class="d-flex gap-1 flex-wrap">
                            <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $supplier->id }}, '{{ $supplier->name }}')">
                                <i class="bi bi-trash"></i>
                            </button>
                            <form id="delete-form-{{ $supplier->id }}" action="{{ route('suppliers.destroy', $supplier) }}" method="POST" style="display: none;">
                                @csrf @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4">Belum ada data supplier.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
        <div class="text-muted small">
            Menampilkan {{ $suppliers->firstItem() ?? 0 }} - {{ $suppliers->lastItem() ?? 0 }} dari {{ $suppliers->total() }} supplier
        </div>
        <div>
            {{ $suppliers->appends(request()->query())->links('pagination::bootstrap-5', ['class' => 'pagination-sm']) }}
        </div>
    </div>
</div>

@push('scripts')
<script>
    function confirmDelete(supplierId, supplierName) {
        Swal.fire({
            title: 'Yakin hapus supplier ini?',
            html: `Supplier <strong>${supplierName}</strong> akan dihapus secara permanen!`,
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
                document.getElementById('delete-form-' + supplierId).submit();
            }
        });
    }
</script>
@endpush
@endsection