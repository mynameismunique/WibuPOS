@extends('layouts.app')

@section('title', 'Detail Pembelian')

@section('content')
<div class="card card-wibu p-4">
    <h4><i class="bi bi-receipt"></i> Detail Pembelian</h4>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <p><strong>No. Pembelian:</strong> {{ $purchase->purchase_number }}</p>
            <p><strong>Supplier:</strong> {{ $purchase->supplier->name ?? '-' }}</p>
            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d/m/Y H:i') }}</p>
        </div>
        <div class="col-md-6">
            <p><strong>User:</strong> {{ $purchase->user->name ?? '-' }}</p>
            <p><strong>Total:</strong> <span class="badge bg-success">Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}</span></p>
            <p><strong>Catatan:</strong> {{ $purchase->notes ?? '-' }}</p>
        </div>
    </div>

    <h5 class="mt-3">Daftar Produk</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Produk</th>
                <th>Kode</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchase->details as $detail)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $detail->product->name ?? '-' }}</td>
                <td>{{ $detail->product->code ?? '-' }}</td>
                <td>{{ $detail->quantity }}</td>
                <td>Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('purchases.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection