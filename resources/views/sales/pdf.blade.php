<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            font-size: 12px;
        }
        h2 {
            text-align: center;
            color: #ff6b9d;
            margin-bottom: 5px;
        }
        .sub-title {
            text-align: center;
            font-size: 14px;
            color: #666;
            margin-top: 0;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 11px;
            color: #888;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .total-row td {
            border-top: 2px solid #333;
        }
    </style>
</head>
<body>
    <h2>LAPORAN PENJUALAN WIBU-POS</h2>
    <p class="sub-title">Periode: {{ date('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Invoice</th>
                <th>Kasir</th>
                <th>Pelanggan</th>
                <th class="text-right">Grand Total</th>
                <th class="text-right">Bayar</th>
                <th class="text-right">Kembali</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @php $totalGrand = 0; @endphp
            @forelse($sales as $sale)
                @php $totalGrand += $sale->grand_total; @endphp
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td><strong>{{ $sale->invoice_number }}</strong></td>
                    <td>{{ $sale->user->name ?? '-' }}</td>
                    <td>{{ $sale->customer_name }}</td>
                    <td class="text-right">Rp {{ number_format($sale->grand_total, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($sale->payment_amount, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($sale->change_amount, 0, ',', '.') }}</td>
                    <td>{{ $sale->sale_date->format('d/m/Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Belum ada transaksi penjualan.</td>
                </tr>
            @endforelse
        </tbody>
        @if(count($sales) > 0)
            <tfoot>
                <tr class="total-row">
                    <td colspan="4" class="text-right"><strong>TOTAL KESELURUHAN</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format($totalGrand, 0, ',', '.') }}</strong></td>
                    <td colspan="3"></td>
                </tr>
            </tfoot>
        @endif
    </table>

    <div class="footer">
        <p>Dicetak oleh: {{ Auth::user()->name ?? 'Sistem' }} | Terima kasih!</p>
        <p>© {{ date('Y') }} Wibu-POS - Tugas Besar Pemrograman Web 2</p>
    </div>
</body>
</html>