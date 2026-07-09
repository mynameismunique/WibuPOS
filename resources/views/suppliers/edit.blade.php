@extends('layouts.app')

@section('title', 'Edit Supplier')

@section('content')
<div class="card card-wibu p-4">
    <h4><i class="bi bi-pencil"></i> Edit Supplier</h4>
    <form action="{{ route('suppliers.update', $supplier) }}" method="POST" id="editForm">
        @csrf @method('PUT')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nama Supplier <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $supplier->name) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Contact Person <span class="text-danger">*</span></label>
                <input type="text" name="contact_person" class="form-control @error('contact_person') is-invalid @enderror" value="{{ old('contact_person', $supplier->contact_person) }}" required>
                @error('contact_person') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Telepon <span class="text-danger">*</span></label>
                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $supplier->phone) }}" required>
                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $supplier->email) }}">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12 mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="address" class="form-control" rows="2">{{ old('address', $supplier->address) }}</textarea>
            </div>
        </div>
        <button type="button" class="btn btn-wibu-primary" onclick="confirmUpdate()">Update</button>
        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

@push('scripts')
<script>
    function confirmUpdate() {
        const form = document.getElementById('editForm');
        const name = document.querySelector('input[name="name"]').value;
        const contact = document.querySelector('input[name="contact_person"]').value;
        const phone = document.querySelector('input[name="phone"]').value;

        Swal.fire({
            title: 'Konfirmasi Update',
            html: `
                <p>Apakah data supplier berikut sudah benar?</p>
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