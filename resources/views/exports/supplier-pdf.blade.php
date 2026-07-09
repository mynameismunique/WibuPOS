<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Supplier</title>
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
    </style>
</head>
<body>
    <h2>LAPORAN SUPPLIER</h2>
    <p class="sub-title">Tanggal: {{ date('d/m/Y H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Supplier</th>
                <th>Contact Person</th>
                <th>Telepon</th>
                <th>Email</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($suppliers as $supplier)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $supplier->name }}</td>
                <td>{{ $supplier->contact_person }}</td>
                <td>{{ $supplier->phone }}</td>
                <td>{{ $supplier->email ?? '-' }}</td>
                <td>{{ $supplier->address ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        <p>Total: {{ count($suppliers) }} supplier | Dicetak oleh: {{ Auth::user()->name ?? 'Sistem' }}</p>
        <p>© {{ date('Y') }} Wibu-POS</p>
    </div>
</body>
</html>