<?php

namespace App\Exports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SuppliersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $suppliers;

    public function __construct($suppliers = null)
    {
        $this->suppliers = $suppliers;
    }

    public function collection()
    {
        return $this->suppliers ?? Supplier::latest()->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Supplier',
            'Contact Person',
            'Telepon',
            'Email',
            'Alamat',
            'Jumlah Produk',
            'Tanggal Dibuat'
        ];
    }

    public function map($supplier): array
    {
        return [
            $supplier->id,
            $supplier->name,
            $supplier->contact_person,
            $supplier->phone,
            $supplier->email ?? '-',
            $supplier->address ?? '-',
            $supplier->products()->count(),
            $supplier->created_at->format('d/m/Y H:i')
        ];
    }
}