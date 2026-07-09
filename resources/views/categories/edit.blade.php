@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="card card-wibu p-4">
    <h4><i class="bi bi-pencil"></i> Edit Kategori</h4>
    <form action="{{ route('categories.update', $category) }}" method="POST" id="editForm">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label">Nama Kategori</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                   value="{{ old('name', $category->name) }}" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
        </div>
        <button type="button" class="btn btn-wibu-primary" onclick="confirmUpdate()">Update</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

@push('scripts')
<script>
    function confirmUpdate() {
        const form = document.getElementById('editForm');
        const name = document.querySelector('input[name="name"]').value;

        Swal.fire({
            title: 'Konfirmasi Update',
            html: `
                <p>Apakah data kategori berikut sudah benar?</p>
                <div style="text-align: left; max-width: 300px; margin: 0 auto;">
                    <p><strong>Nama:</strong> ${name}</p>
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