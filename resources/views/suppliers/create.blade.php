@extends('layouts.app')

@section('title', 'Tambah Supplier')

@section('content')
<div class="card card-wibu p-4">
    <h4><i class="bi bi-plus-circle"></i> Tambah Supplier</h4>
    <form action="{{ route('suppliers.store') }}" method="POST" id="createForm">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nama Supplier <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Contact Person <span class="text-danger">*</span></label>
                <input type="text" name="contact_person" class="form-control @error('contact_person') is-invalid @enderror" value="{{ old('contact_person') }}" required>
                @error('contact_person') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Telepon <span class="text-danger">*</span></label>
                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required>
                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12 mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
            </div>
        </div>
        <button type="button" class="btn btn-wibu-primary" onclick="confirmSubmit()">Simpan</button>
        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

@push('scripts')
<script>
    function confirmSubmit() {
        const form = document.getElementById('createForm');
        const name = document.querySelector('input[name="name"]').value;
        const contact = document.querySelector('input[name="contact_person"]').value;
        const phone = document.querySelector('input[name="phone"]').value;

        if (!name || !contact || !phone) {
            Swal.fire({
                icon: 'error',
                title: 'Data Belum Lengkap',
                text: 'Harap isi semua field yang wajib!',
                confirmButtonColor: '#ff6b9d',
                background: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#1e1e30' : '#fff',
                color: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#e4e4f0' : '#212529',
            });
            return;
        }

        Swal.fire({
            title: 'Konfirmasi Data',
            html: `
                <p>Apakah data berikut sudah benar?</p>
                <div style="text-align: left; max-width: 300px; margin: 0 auto;">
                    <p><strong>Nama:</strong> ${name}</p>
                    <p><strong>Contact Person:</strong> ${contact}</p>
                    <p><strong>Telepon:</strong> ${phone}</p>
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
                form.submit();
            }
        });
    }
</script>
@endpush
@endsection