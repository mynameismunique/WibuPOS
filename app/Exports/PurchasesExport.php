<?php

namespace App\Exports;

use App\Models\Purchase;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PurchasesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $purchases;

    public function __construct($purchases = null)
    {
        $this->purchases = $purchases;
    }

    public function collection()
    {
        return $this->purchases ?? Purchase::with(['supplier', 'user'])->latest()->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'No. Pembelian',
            'Supplier',
            'User',
            'Total',
            'Tanggal Pembelian',
            'Catatan',
            'Jumlah Item'
        ];
    }

    public function map($purchase): array
    {
        return [
            $purchase->id,
            $purchase->purchase_number,
            $purchase->supplier->name ?? '-',
            $purchase->user->name ?? '-',
            number_format($purchase->total_amount, 2, ',', '.'),
            $purchase->purchase_date->format('d/m/Y H:i'),
            $purchase->notes ?? '-',
            $purchase->details()->count()
        ];
    }
}