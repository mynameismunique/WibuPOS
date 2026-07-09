@extends('layouts.app')

@section('title', 'Daftar Kategori')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-tags-fill"></i> Daftar Kategori</h2>
    <div>
        <a href="{{ route('categories.create') }}" class="btn btn-wibu-primary">
            <i class="bi bi-plus-circle"></i> Tambah Kategori
        </a>
        <a href="{{ route('categories.export.excel') }}" class="btn btn-success">
            <i class="bi bi-file-earmark-excel"></i> Excel
        </a>
        <a href="{{ route('categories.export.pdf') }}" class="btn btn-danger">
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
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><span class="badge bg-primary">{{ $category->name }}</span></td>
                    <td>{{ $category->description ?? '-' }}</td>
                    <td>{{ $category->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div class="d-flex gap-1 flex-wrap">
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $category->id }}, '{{ $category->name }}')">
                                <i class="bi bi-trash"></i>
                            </button>
                            <form id="delete-form-{{ $category->id }}" action="{{ route('categories.destroy', $category) }}" method="POST" style="display: none;">
                                @csrf @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4">Belum ada kategori.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
        <div class="text-muted small">
            Menampilkan {{ $categories->firstItem() ?? 0 }} - {{ $categories->lastItem() ?? 0 }} dari {{ $categories->total() }} kategori
        </div>
        <div>
            {{ $categories->appends(request()->query())->links('pagination::bootstrap-5', ['class' => 'pagination-sm']) }}
        </div>
    </div>
</div>

@push('scripts')
<script>
    function confirmDelete(categoryId, categoryName) {
        Swal.fire({
            title: 'Yakin hapus kategori ini?',
            html: `Kategori <strong>${categoryName}</strong> akan dihapus secara permanen!`,
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
                document.getElementById('delete-form-' + categoryId).submit();
            }
        });
    }
</script>
@endpush
@endsection