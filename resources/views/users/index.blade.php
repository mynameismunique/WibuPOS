@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')
<style>
    /* ===== PERBAIKAN TABEL DI DARK MODE ===== */
    .table-users {
        background-color: var(--wibu-card-bg, #ffffff);
        border-radius: 16px;
        overflow: hidden;
    }

    .table-users .table {
        margin-bottom: 0;
        color: var(--wibu-text, #212529);
    }

    .table-users .table thead th {
        background-color: var(--wibu-bg, #fff5f7);
        color: var(--wibu-text, #212529);
        border-bottom: 2px solid var(--wibu-border, #dee2e6);
        font-weight: 600;
        padding: 12px 16px;
    }

    .table-users .table tbody td {
        padding: 12px 16px;
        border-bottom: 1px solid var(--wibu-border, #dee2e6);
        color: var(--wibu-text, #212529);
        vertical-align: middle;
    }

    .table-users .table tbody tr {
        background-color: var(--wibu-card-bg, #ffffff);
        transition: background-color 0.2s ease;
    }

    .table-users .table tbody tr:hover {
        background-color: var(--wibu-bg, #f8f0f5) !important;
    }

    /* ===== DARK MODE OVERRIDE ===== */
    [data-bs-theme="dark"] .table-users .table thead th {
        background-color: #2a2a40;
        color: #e0dcec;
        border-bottom: 2px solid #444466;
    }

    [data-bs-theme="dark"] .table-users .table tbody td {
        color: #e0dcec;
        border-bottom: 1px solid #3a3a5c;
    }

    [data-bs-theme="dark"] .table-users .table tbody tr {
        background-color: #1e1e30;
    }

    [data-bs-theme="dark"] .table-users .table tbody tr:hover {
        background-color: #2a2a4a !important;
    }

    /* ===== PAGINATION DARK MODE ===== */
    [data-bs-theme="dark"] .pagination .page-link {
        background-color: #2a2a40;
        border-color: #444466;
        color: #e0dcec;
    }

    [data-bs-theme="dark"] .pagination .page-link:hover {
        background-color: #ff7eb3;
        border-color: #ff7eb3;
        color: #fff;
    }

    [data-bs-theme="dark"] .pagination .page-item.active .page-link {
        background-color: #ff6b9d;
        border-color: #ff6b9d;
        color: #fff;
    }

    [data-bs-theme="dark"] .pagination .page-item.disabled .page-link {
        background-color: #1e1e30;
        border-color: #3a3a5c;
        color: #666;
    }

    /* ===== ALERT DARK MODE ===== */
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

    /* ===== BADGE DARK MODE ===== */
    [data-bs-theme="dark"] .badge.bg-danger {
        background-color: #b33c5a !important;
    }

    [data-bs-theme="dark"] .badge.bg-info {
        background-color: #4a6a8a !important;
    }

    /* ===== TOMBOL AKSI DARK MODE ===== */
    [data-bs-theme="dark"] .btn-warning {
        background-color: #b8860b;
        border-color: #b8860b;
        color: #fff;
    }

    [data-bs-theme="dark"] .btn-warning:hover {
        background-color: #d4a017;
        border-color: #d4a017;
        color: #fff;
    }

    [data-bs-theme="dark"] .btn-danger {
        background-color: #8b2a3a;
        border-color: #8b2a3a;
        color: #fff;
    }

    [data-bs-theme="dark"] .btn-danger:hover {
        background-color: #b33c4a;
        border-color: #b33c4a;
        color: #fff;
    }

    [data-bs-theme="dark"] .btn-wibu-primary {
        background-color: #ff7eb3;
    }

    [data-bs-theme="dark"] .btn-wibu-primary:hover {
        background-color: #ff6b9d;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-people-fill"></i> Kelola User</h2>
    <a href="{{ route('users.create') }}" class="btn btn-wibu-primary btn-sm">
        <i class="bi bi-plus-circle"></i> Tambah User
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card card-wibu p-3 table-users">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : 'info' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        @if($user->id !== Auth::id())
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')">
                                <i class="bi bi-trash"></i>
                            </button>
                            <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user) }}" method="POST" style="display: none;">
                                @csrf @method('DELETE')
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-4">Belum ada user.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $users->links() }}
    </div>
</div>

@push('scripts')
<script>
    function confirmDelete(userId, userName) {
        Swal.fire({
            title: 'Yakin hapus user ini?',
            html: `User <strong>${userName}</strong> akan dihapus secara permanen!`,
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
                document.getElementById('delete-form-' + userId).submit();
            }
        });
    }
</script>
@endpush
@endsection