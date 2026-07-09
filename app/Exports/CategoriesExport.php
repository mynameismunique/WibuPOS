<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CategoriesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $categories;

    public function __construct($categories = null)
    {
        $this->categories = $categories;
    }

    public function collection()
    {
        return $this->categories ?? Category::latest()->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Kategori',
            'Deskripsi',
            'Jumlah Produk',
            'Tanggal Dibuat'
        ];
    }

    public function map($category): array
    {
        return [
            $category->id,
            $category->name,
            $category->description ?? '-',
            $category->products()->count(),
            $category->created_at->format('d/m/Y H:i')
        ];
    }
}