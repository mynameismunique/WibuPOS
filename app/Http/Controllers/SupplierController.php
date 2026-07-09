<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SuppliersExport;
use Barryvdh\DomPDF\Facade\Pdf;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->paginate(10);
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'contact_person' => 'required|max:100',
            'phone' => 'required|max:20',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable',
        ]);

        Supplier::create($request->all());
        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil ditambahkan!');
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required|max:100',
            'contact_person' => 'required|max:100',
            'phone' => 'required|max:20',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable',
        ]);

        $supplier->update($request->all());
        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil diupdate!');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil dihapus!');
    }

    public function exportExcel()
    {
        $suppliers = Supplier::latest()->get();
        return Excel::download(new SuppliersExport($suppliers), 'laporan-supplier-' . date('Y-m-d') . '.xlsx');
    }

    public function exportPdf()
    {
        $suppliers = Supplier::latest()->get();
        $pdf = Pdf::loadView('exports.supplier-pdf', compact('suppliers'));
        return $pdf->download('laporan-supplier-' . date('Y-m-d') . '.pdf');
    }
}