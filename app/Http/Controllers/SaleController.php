<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\SalesExport;
use Maatwebsite\Excel\Facades\Excel;

class SaleController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            $sales = Sale::with(['user'])->latest()->paginate(10);
        } else {
            $sales = Sale::with(['user'])
                        ->where('user_id', $user->id)
                        ->latest()
                        ->paginate(10);
        }

        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'nullable|max:100',
            'payment_method' => 'required|in:cash,debit,credit,qris',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'payment_amount' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $totalAmount = 0;
            foreach ($request->products as $item) {
                $subtotal = $item['quantity'] * $item['price'];
                $totalAmount += $subtotal;
            }

            $discount = $request->discount ?? 0;
            $tax = $request->tax ?? 0;
            $grandTotal = $totalAmount - $discount + $tax;
            $paymentAmount = $request->payment_amount;
            $changeAmount = $paymentAmount - $grandTotal;

            if ($changeAmount < 0) {
                return back()->with('error', 'Uang bayar kurang dari total!');
            }

            $lastSale = Sale::orderBy('id', 'desc')->first();
            $nextNumber = $lastSale ? intval(substr($lastSale->invoice_number, -4)) + 1 : 1;
            $invoiceNumber = 'INV-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            $sale = Sale::create([
                'invoice_number' => $invoiceNumber,
                'user_id' => Auth::id(),
                'customer_name' => $request->customer_name ?? 'Umum',
                'total_amount' => $totalAmount,
                'discount' => $discount,
                'tax' => $tax,
                'grand_total' => $grandTotal,
                'payment_amount' => $paymentAmount,
                'change_amount' => $changeAmount,
                'payment_method' => $request->payment_method,
                'sale_date' => Carbon::now(),
            ]);

            foreach ($request->products as $item) {
                $subtotal = $item['quantity'] * $item['price'];
                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $subtotal,
                ]);

                $product = Product::find($item['product_id']);
                if ($product->stock < $item['quantity']) {
                    throw new \Exception('Stok produk ' . $product->name . ' tidak mencukupi!');
                }
                $product->stock -= $item['quantity'];
                $product->save();
            }

            DB::commit();

            return redirect()->route('sales.show', $sale)
                ->with('success', 'Transaksi berhasil! Invoice: ' . $invoiceNumber . ' 🎌');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal transaksi: ' . $e->getMessage());
        }
    }

    public function show(Sale $sale)
    {
        // Kasir hanya boleh melihat transaksinya sendiri
        if (Auth::user()->role !== 'admin' && $sale->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke transaksi ini.');
        }

        $sale->load(['user', 'details.product']);
        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        return redirect()->route('sales.index')->with('error', 'Edit penjualan tidak diizinkan.');
    }

    public function update(Request $request, Sale $sale)
    {
        return redirect()->route('sales.index')->with('error', 'Update penjualan tidak diizinkan.');
    }

    /**
     * Hanya admin yang boleh menghapus transaksi.
     * Kasir tidak diizinkan menghapus transaksi sama sekali.
     */
    public function destroy(Sale $sale)
    {
        // Hanya admin yang boleh menghapus transaksi
        if (Auth::user()->role !== 'admin') {
            return back()->with('error', 'Hanya admin yang dapat menghapus transaksi.');
        }

        DB::beginTransaction();
        try {
            foreach ($sale->details as $detail) {
                $product = $detail->product;
                $product->stock += $detail->quantity;
                $product->save();
                $detail->delete();
            }
            $sale->delete();
            DB::commit();
            return redirect()->route('sales.index')
                ->with('success', 'Penjualan berhasil dihapus! Stok dikembalikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    // ===== EXPORT EXCEL =====
    public function exportExcel()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            $sales = Sale::with(['user'])->latest()->get();
        } else {
            $sales = Sale::with(['user'])
                        ->where('user_id', $user->id)
                        ->latest()
                        ->get();
        }

        return Excel::download(new SalesExport($sales), 'laporan-penjualan-' . date('Y-m-d') . '.xlsx');
    }

    // ===== EXPORT PDF =====
    public function exportPdf()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            $sales = Sale::with(['user', 'details.product'])->latest()->get();
        } else {
            $sales = Sale::with(['user', 'details.product'])
                        ->where('user_id', $user->id)
                        ->latest()
                        ->get();
        }

        $pdf = Pdf::loadView('sales.pdf', compact('sales'));
        return $pdf->download('laporan-penjualan-' . date('Y-m-d') . '.pdf');
    }
}