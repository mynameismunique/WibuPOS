<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PurchasesExport;
use Barryvdh\DomPDF\Facade\Pdf;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with(['supplier', 'user'])->latest()->paginate(10);
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('purchases.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'notes' => 'nullable',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $lastPurchase = Purchase::orderBy('id', 'desc')->first();
            $nextNumber = $lastPurchase ? intval(substr($lastPurchase->purchase_number, -4)) + 1 : 1;
            $purchaseNumber = 'PO-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            $totalAmount = 0;
            foreach ($request->products as $item) {
                $subtotal = $item['quantity'] * $item['price'];
                $totalAmount += $subtotal;
            }

            $purchase = Purchase::create([
                'purchase_number' => $purchaseNumber,
                'supplier_id' => $request->supplier_id,
                'user_id' => Auth::id(),
                'total_amount' => $totalAmount,
                'purchase_date' => $request->purchase_date,
                'notes' => $request->notes,
            ]);

            foreach ($request->products as $item) {
                $subtotal = $item['quantity'] * $item['price'];
                PurchaseDetail::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $subtotal,
                ]);

                $product = Product::find($item['product_id']);
                $product->stock += $item['quantity'];
                $product->save();
            }

            DB::commit();
            return redirect()->route('purchases.index')
                ->with('success', 'Pembelian berhasil! Stok produk telah diperbarui. 📦');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Purchase $purchase)
    {
        $purchase->load(['supplier', 'user', 'details.product']);
        return view('purchases.show', compact('purchase'));
    }

    public function edit(Purchase $purchase)
    {
        // Tidak diizinkan
        return redirect()->route('purchases.index')->with('error', 'Edit pembelian tidak diizinkan.');
    }

    public function update(Request $request, Purchase $purchase)
    {
        return redirect()->route('purchases.index')->with('error', 'Update pembelian tidak diizinkan.');
    }

    public function destroy(Purchase $purchase)
    {
        DB::beginTransaction();
        try {
            foreach ($purchase->details as $detail) {
                $product = $detail->product;
                $product->stock -= $detail->quantity;
                $product->save();
                $detail->delete();
            }
            $purchase->delete();
            DB::commit();
            return redirect()->route('purchases.index')
                ->with('success', 'Pembelian berhasil dihapus dan stok dikembalikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    public function exportExcel()
    {
        $purchases = Purchase::with(['supplier', 'user'])->latest()->get();
        return Excel::download(new PurchasesExport($purchases), 'laporan-pembelian-' . date('Y-m-d') . '.xlsx');
    }

    public function exportPdf()
    {
        $purchases = Purchase::with(['supplier', 'user', 'details'])->latest()->get();
        $pdf = Pdf::loadView('exports.purchase-pdf', compact('purchases'));
        return $pdf->download('laporan-pembelian-' . date('Y-m-d') . '.pdf');
    }
}