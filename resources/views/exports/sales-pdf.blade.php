<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Laporan Penjualan</h2>
    <table>
        <thead>
            <tr>
                <th>Invoice</th>
                <th>Kasir</th>
                <th>Pelanggan</th>
                <th>Total</th>
                <th>Grand Total</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr>
                <td>{{ $sale->invoice_number }}</td>
                <td>{{ $sale->user->name ?? '-' }}</td>
                <td>{{ $sale->customer_name }}</td>
                <td>{{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                <td>{{ number_format($sale->grand_total, 0, ',', '.') }}</td>
                <td>{{ $sale->sale_date->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>