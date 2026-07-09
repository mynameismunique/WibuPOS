@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="card card-wibu p-4">
    <h4><i class="bi bi-pencil"></i> Edit User</h4>
    <form action="{{ route('users.update', $user) }}" method="POST" id="editForm">
        @csrf @method('PUT')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nama <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Password (kosongkan jika tidak diubah)</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Role <span class="text-danger">*</span></label>
                <select name="role" class="form-select" required>
                    <option value="cashier" {{ $user->role == 'cashier' ? 'selected' : '' }}>Kasir</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
        </div>
        <button type="button" class="btn btn-wibu-primary" onclick="confirmUpdate()">Update</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

@push('scripts')
<script>
    function confirmUpdate() {
        const form = document.getElementById('editForm');
        const name = document.querySelector('input[name="name"]').value;
        const email = document.querySelector('input[name="email"]').value;
        const role = document.querySelector('select[name="role"]').value;

        Swal.fire({
            title: 'Konfirmasi Update',
            html: `
                <p>Apakah data user berikut sudah benar?</p>
                <div style="text-align: left; max-width: 300px; margin: 0 auto;">
                    <p><strong>Nama:</strong> ${name}</p>
                    <p><strong>Email:</strong> ${email}</p>
                    <p><strong>Role:</strong> ${role === 'admin' ? 'Admin' : 'Kasir'}</p>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#ff6b9d',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Update!',
            cancelButtonText: 'Batal',
            background: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#1e1e30' : '#fff',
            color: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#e4e4f0' : '#212529',
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
@endpush
@endsection