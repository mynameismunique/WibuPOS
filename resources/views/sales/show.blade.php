@extends('layouts.app')

@section('title', 'Invoice #' . $sale->invoice_number)

@section('content')
<div class="card card-wibu p-4">
    <div class="text-center mb-4">
        <h2><i class="bi bi-receipt"></i> INVOICE</h2>
        <h5 class="text-muted">{{ $sale->invoice_number }}</h5>
        <p>{{ $sale->sale_date->format('d/m/Y H:i') }}</p>
    </div>

    <div class="row">
        <div class="col-md-6">
            <p><strong>Kasir:</strong> {{ $sale->user->name ?? '-' }}</p>
            <p><strong>Pelanggan:</strong> {{ $sale->customer_name }}</p>
        </div>
        <div class="col-md-6 text-end">
            <p><strong>Metode Bayar:</strong> {{ strtoupper($sale->payment_method) }}</p>
            <p><strong>Status:</strong> <span class="badge bg-success">LUNAS</span></p>
        </div>
    </div>

    <table class="table table-bordered mt-3">
        <thead class="table-light">
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
            @foreach($sale->details as $detail)
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
        <tfoot>
            <tr>
                <td colspan="5" class="text-end"><strong>Subtotal</strong></td>
                <td>Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="5" class="text-end"><strong>Diskon</strong></td>
                <td>Rp {{ number_format($sale->discount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="5" class="text-end"><strong>Pajak</strong></td>
                <td>Rp {{ number_format($sale->tax, 0, ',', '.') }}</td>
            </tr>
            <tr class="table-success">
                <td colspan="5" class="text-end"><strong>Grand Total</strong></td>
                <td><strong>Rp {{ number_format($sale->grand_total, 0, ',', '.') }}</strong></td>
            </tr>
            <tr>
                <td colspan="5" class="text-end"><strong>Bayar</strong></td>
                <td>Rp {{ number_format($sale->payment_amount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="5" class="text-end"><strong>Kembalian</strong></td>
                <td>Rp {{ number_format($sale->change_amount, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="d-flex justify-content-between mt-3">
        <a href="{{ route('sales.index') }}" class="btn btn-secondary">Kembali</a>
        <button onclick="window.print()" class="btn btn-wibu-primary">
            <i class="bi bi-printer"></i> Cetak
        </button>
    </div>
</div>
@endsection