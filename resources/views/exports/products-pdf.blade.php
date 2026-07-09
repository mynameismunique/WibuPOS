<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Produk</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Daftar Produk</h2>
    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Supplier</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->code }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name ?? '-' }}</td>
                <td>{{ $product->supplier->name ?? '-' }}</td>
                <td>{{ number_format($product->purchase_price, 0, ',', '.') }}</td>
                <td>{{ number_format($product->selling_price, 0, ',', '.') }}</td>
                <td>{{ $product->stock }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>