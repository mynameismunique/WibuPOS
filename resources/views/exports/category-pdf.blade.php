<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Kategori</title>
    <style>
        body { font-family: 'Arial', sans-serif; margin: 20px; font-size: 12px; }
        h2 { text-align: center; color: #ff6b9d; margin-bottom: 5px; }
        .sub-title { text-align: center; font-size: 14px; color: #666; margin-top: 0; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .footer { text-align: center; margin-top: 30px; font-size: 11px; color: #888; border-top: 1px solid #ddd; padding-top: 15px; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h2>LAPORAN KATEGORI</h2>
    <p class="sub-title">Tanggal: {{ date('d/m/Y H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th class="text-center">Jumlah Produk</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->description ?? '-' }}</td>
                <td class="text-center">{{ $category->products()->count() }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        <p>Total: {{ count($categories) }} kategori | Dicetak oleh: {{ Auth::user()->name ?? 'Sistem' }}</p>
        <p>© {{ date('Y') }} Wibu-POS</p>
    </div>
</body>
</html>