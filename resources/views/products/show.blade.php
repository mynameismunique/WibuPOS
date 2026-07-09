@extends('layouts.app')

@section('title', 'Detail Produk: ' . $product->name)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-wibu p-4">
            <h4><i class="bi bi-box-fill"></i> Detail Produk</h4>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Kode Produk:</strong> <span class="badge bg-secondary">{{ $product->code }}</span></p>
                    <p><strong>Nama Produk:</strong> {{ $product->name }}</p>
                    <p><strong>Kategori:</strong> {{ $product->category->name ?? '-' }}</p>
                    <p><strong>Supplier:</strong> {{ $product->supplier->name ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Harga Beli:</strong> Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</p>
                    <p><strong>Harga Jual:</strong> Rp {{ number_format($product->selling_price, 0, ',', '.') }}</p>
                    <p>
                        <strong>Stok:</strong>
                        @if($product->stock <= $product->min_stock)
                            <span class="badge bg-danger">{{ $product->stock }} (Habis!)</span>
                        @else
                            <span class="badge bg-success">{{ $product->stock }}</span>
                        @endif
                    </p>
                    <p><strong>Minimal Stok:</strong> {{ $product->min_stock }}</p>
                </div>
            </div>
            @if($product->description)
            <div class="mt-3">
                <strong>Deskripsi:</strong>
                <p>{{ $product->description }}</p>
            </div>
            @endif
            <div class="mt-3">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
                <a href="{{ route('products.edit', $product) }}" class="btn btn-wibu-primary">Edit</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-wibu p-4 text-center">
            <h5><i class="bi bi-qr-code"></i> QR Code Produk</h5>
            <hr>
            <div class="d-flex justify-content-center">
                {!! QrCode::size(200)->generate($product->code) !!}
            </div>
            <p class="text-muted mt-2 small">Scan untuk tambah ke keranjang</p>
            <p class="text-muted small">Kode: {{ $product->code }}</p>
        </div>
    </div>
</div>

@endsection