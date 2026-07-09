@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<div class="card card-wibu p-4">
    <h4><i class="bi bi-plus-circle"></i> Tambah Kategori</h4>
    <form action="{{ route('categories.store') }}" method="POST" id="createForm">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Kategori</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                   value="{{ old('name') }}" id="categoryName" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
        </div>
        <button type="button" class="btn btn-wibu-primary" onclick="confirmStore()">Simpan</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

@push('scripts')
<script>
    function confirmStore() {
        const form = document.getElementById('createForm');
        const name = document.getElementById('categoryName').value;

        if (!name.trim()) {
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