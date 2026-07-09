<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Exports\ProductsExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'supplier'])->latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:products|max:20',
            'name' => 'required|max:100',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'description' => 'nullable',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan! 🎌');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'code' => 'required|max:20|unique:products,code,' . $product->id,
            'name' => 'required|max:100',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'description' => 'nullable',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diupdate! 📦');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus! 🗑️');
    }

    public function exportExcel()
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }

    public function exportPDF()
    {
        $products = Product::with(['category', 'supplier'])->get();
        $pdf = Pdf::loadView('exports.products-pdf', compact('products'));
        return $pdf->download('products.pdf');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'supplier']);
        return view('products.show', compact('product'));
    }

    public function getByCode($code)
    {
    $product = Product::where('code', $code)->with(['category', 'supplier'])->first();
    
    if (!$product) {
        return response()->json([
            'success' => false,
            'message' => 'Produk tidak ditemukan!'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'product' => $product
    ]);
    }
}