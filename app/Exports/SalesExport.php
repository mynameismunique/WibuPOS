<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $sales;

    public function __construct($sales = null)
    {
        $this->sales = $sales;
    }

    public function collection()
    {
        if ($this->sales) {
            return $this->sales;
        }
        return Sale::with(['user', 'details'])->latest()->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Invoice',
            'Kasir',
            'Pelanggan',
            'Total',
            'Diskon',
            'Pajak',
            'Grand Total',
            'Bayar',
            'Kembalian',
            'Metode Bayar',
            'Tanggal',
        ];
    }

    public function map($sale): array
    {
        return [
            $sale->id,
            $sale->invoice_number,
            $sale->user->name ?? '-',
            $sale->customer_name,
            number_format($sale->total_amount, 2, ',', '.'),
            number_format($sale->discount, 2, ',', '.'),
            number_format($sale->tax, 2, ',', '.'),
            number_format($sale->grand_total, 2, ',', '.'),
            number_format($sale->payment_amount, 2, ',', '.'),
            number_format($sale->change_amount, 2, ',', '.'),
            strtoupper($sale->payment_method),
            $sale->sale_date->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}