<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Product::with(['category', 'supplier'])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Kode',
            'Nama Produk',
            'Kategori',
            'Supplier',
            'Harga Beli',
            'Harga Jual',
            'Stok',
            'Minimal Stok',
            'Deskripsi',
            'Dibuat',
        ];
    }

    public function map($product): array
    {
        return [
            $product->id,
            $product->code,
            $product->name,
            $product->category->name ?? '-',
            $product->supplier->name ?? '-',
            $product->purchase_price,
            $product->selling_price,
            $product->stock,
            $product->min_stock,
            $product->description ?? '-',
            $product->created_at->format('d/m/Y H:i'),
        ];
    }
}