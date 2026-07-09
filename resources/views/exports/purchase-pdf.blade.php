<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Pembelian</title>
    <style>
        body { font-family: 'Arial', sans-serif; margin: 20px; font-size: 11px; }
        h2 { text-align: center; color: #ff6b9d; margin-bottom: 5px; }
        .sub-title { text-align: center; font-size: 14px; color: #666; margin-top: 0; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .footer { text-align: center; margin-top: 30px; font-size: 11px; color: #888; border-top: 1px solid #ddd; padding-top: 15px; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .total-row { font-weight: bold; background-color: #f9f9f9; }
        .total-row td { border-top: 2px solid #333; }
    </style>
</head>
<body>
    <h2>LAPORAN PEMBELIAN</h2>
    <p class="sub-title">Periode: {{ date('d/m/Y H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>No. Pembelian</th>
                <th>Supplier</th>
                <th>User</th>
                <th class="text-right">Total</th>
                <th>Tanggal</th>
                <th class="text-center">Item</th>
            </tr>
        </thead>
        <tbody>
            @php $totalAll = 0; @endphp
            @forelse($purchases as $purchase)
                @php $totalAll += $purchase->total_amount; @endphp
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $purchase->purchase_number }}</td>
                    <td>{{ $purchase->supplier->name ?? '-' }}</td>
                    <td>{{ $purchase->user->name ?? '-' }}</td>
                    <td class="text-right">Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}</td>
                    <td>{{ $purchase->purchase_date->format('d/m/Y H:i') }}</td>
                    <td class="text-center">{{ $purchase->details()->count() }}</td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center">Belum ada pembelian.</td></tr>
            @endforelse
        </tbody>
        @if(count($purchases) > 0)
            <tfoot>
                <tr class="total-row">
                    <td colspan="4" class="text-right"><strong>TOTAL KESELURUHAN</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format($totalAll, 0, ',', '.') }}</strong></td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
        @endif
    </table>
    <div class="footer">
        <p>Total: {{ count($purchases) }} pembelian | Dicetak oleh: {{ Auth::user()->name ?? 'Sistem' }}</p>
        <p>© {{ date('Y') }} Wibu-POS</p>
    </div>
</body>
</html>