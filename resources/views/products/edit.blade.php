@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="card card-wibu p-4">
    <h4><i class="bi bi-pencil"></i> Edit Produk</h4>
    <form action="{{ route('products.update', $product) }}" method="POST" id="editForm">
        @csrf @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Kode Produk <span class="text-danger">*</span></label>
                <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" 
                       value="{{ old('code', $product->code) }}" required>
                @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Nama Produk <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name', $product->name) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Supplier <span class="text-danger">*</span></label>
                <select name="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror" required>
                    <option value="">Pilih Supplier</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ old('supplier_id', $product->supplier_id) == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
                @error('supplier_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Harga Beli (Rp) <span class="text-danger">*</span></label>
                <input type="number" name="purchase_price" class="form-control @error('purchase_price') is-invalid @enderror" 
                       value="{{ old('purchase_price', $product->purchase_price) }}" required>
                @error('purchase_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Harga Jual (Rp) <span class="text-danger">*</span></label>
                <input type="number" name="selling_price" class="form-control @error('selling_price') is-invalid @enderror" 
                       value="{{ old('selling_price', $product->selling_price) }}" required>
                @error('selling_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Stok <span class="text-danger">*</span></label>
                <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" 
                       value="{{ old('stock', $product->stock) }}" required>
                @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Minimal Stok (Peringatan)</label>
                <input type="number" name="min_stock" class="form-control @error('min_stock') is-invalid @enderror" 
                       value="{{ old('min_stock', $product->min_stock) }}">
                @error('min_stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="2">{{ old('description', $product->description) }}</textarea>
            </div>
        </div>

        <button type="button" class="btn btn-wibu-primary" onclick="confirmUpdate()">Update</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

@push('scripts')
<script>
    function confirmUpdate() {
        const form = document.getElementById('editForm');
        const name = document.querySelector('input[name="name"]').value;
        const code = document.querySelector('input[name="code"]').value;
        const price = document.querySelector('input[name="selling_price"]').value;
        const stock = document.querySelector('input[name="stock"]').value;

        Swal.fire({
            title: 'Konfirmasi Update',
            html: `
                <p>Apakah data produk berikut sudah benar?</p>
                <div style="text-align: left; max-width: 300px; margin: 0 auto;">
                    <p><strong>Kode:</strong> ${code}</p>
                    <p><strong>Nama:</strong> ${name}</p>
                    <p><strong>Harga Jual:</strong> Rp ${parseInt(price).toLocaleString('id-ID')}</p>
                    <p><strong>Stok:</strong> ${stock}</p>
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