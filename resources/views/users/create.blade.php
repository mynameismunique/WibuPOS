@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<div class="card card-wibu p-4">
    <h4><i class="bi bi-person-plus"></i> Tambah User</h4>
    <form action="{{ route('users.store') }}" method="POST" id="userForm">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nama <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Password <span class="text-danger">*</span></label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Role <span class="text-danger">*</span></label>
                <select name="role" id="role" class="form-select" required>
                    <option value="cashier">Kasir</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-wibu-primary" id="submitBtn">Simpan</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('userForm');
        const submitBtn = document.getElementById('submitBtn');

        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Tahan submit

            // Ambil nilai input
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const role = document.getElementById('role').value;
            const roleText = role === 'admin' ? 'Admin' : 'Kasir';

            // Tampilkan konfirmasi dengan SweetAlert2
            Swal.fire({
                title: 'Konfirmasi Data',
                html: `
                    <p>Apakah data berikut sudah benar?</p>
                    <div style="text-align: left; max-width: 300px; margin: 0 auto;">
                        <p><strong>Nama:</strong> ${name}</p>
                        <p><strong>Email:</strong> ${email}</p>
                        <p><strong>Password:</strong> ${'*'.repeat(password.length)}</p>
                        <p><strong>Role:</strong> ${roleText}</p>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ff6b9d',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal',
                background: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#1e1e30' : '#fff',
                color: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#e4e4f0' : '#212529',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika dikonfirmasi, submit form
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
@endsection