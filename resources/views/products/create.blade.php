@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="card card-wibu p-4">
    <h4><i class="bi bi-plus-circle"></i> Tambah Produk Anime</h4>
    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Kode Produk <span class="text-danger">*</span></label>
                <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" 
                       value="{{ old('code') }}" placeholder="PRD-0001" required>
                @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Nama Produk <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name') }}" placeholder="Nendoroid Naruto" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                        <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
                @error('supplier_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Harga Beli (Rp) <span class="text-danger">*</span></label>
                <input type="number" name="purchase_price" class="form-control @error('purchase_price') is-invalid @enderror" 
                       value="{{ old('purchase_price') }}" required>
                @error('purchase_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Harga Jual (Rp) <span class="text-danger">*</span></label>
                <input type="number" name="selling_price" class="form-control @error('selling_price') is-invalid @enderror" 
                       value="{{ old('selling_price') }}" required>
                @error('selling_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Stok <span class="text-danger">*</span></label>
                <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" 
                       value="{{ old('stock', 0) }}" required>
                @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Minimal Stok (Peringatan)</label>
                <input type="number" name="min_stock" class="form-control @error('min_stock') is-invalid @enderror" 
                       value="{{ old('min_stock', 5) }}">
                @error('min_stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-wibu-primary">Simpan</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection