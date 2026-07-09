<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CategoriesExport;
use Barryvdh\DomPDF\Facade\Pdf;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories|max:50',
            'description' => 'nullable',
        ]);

        Category::create($request->all());
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:50|unique:categories,name,' . $category->id,
            'description' => 'nullable',
        ]);

        $category->update($request->all());
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diupdate!');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus!');
    }

    public function exportExcel()
    {
        $categories = Category::latest()->get();
        return Excel::download(new CategoriesExport($categories), 'laporan-kategori-' . date('Y-m-d') . '.xlsx');
    }

    public function exportPdf()
    {
        $categories = Category::latest()->get();
        $pdf = Pdf::loadView('exports.category-pdf', compact('categories'));
        return $pdf->download('laporan-kategori-' . date('Y-m-d') . '.pdf');
    }
}