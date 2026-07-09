<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\WelcomeController;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Auth::routes(['register' => false]);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::middleware(['role:admin'])->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('products', ProductController::class);
        Route::resource('purchases', PurchaseController::class);
        Route::resource('users', 'App\Http\Controllers\UserController');
        


        Route::get('/products/export/excel', [ProductController::class, 'exportExcel'])->name('products.export.excel');
        Route::get('/products/export/pdf', [ProductController::class, 'exportPdf'])->name('products.export.pdf');

        Route::get('/categories/export/excel', [CategoryController::class, 'exportExcel'])->name('categories.export.excel');
        Route::get('/categories/export/pdf', [CategoryController::class, 'exportPdf'])->name('categories.export.pdf');

        Route::get('/suppliers/export/excel', [SupplierController::class, 'exportExcel'])->name('suppliers.export.excel');
        Route::get('/suppliers/export/pdf', [SupplierController::class, 'exportPdf'])->name('suppliers.export.pdf');

        Route::get('/purchases/export/excel', [PurchaseController::class, 'exportExcel'])->name('purchases.export.excel');
        Route::get('/purchases/export/pdf', [PurchaseController::class, 'exportPdf'])->name('purchases.export.pdf');
    });

    Route::resource('sales', SaleController::class);
    Route::get('/products/code/{code}', [ProductController::class, 'getByCode'])->name('products.byCode');

    Route::get('/sales/export/excel', [SaleController::class, 'exportExcel'])->name('sales.export.excel');
    Route::get('/sales/export/pdf', [SaleController::class, 'exportPdf'])->name('sales.export.pdf');

    Route::get('/refresh', function () {
    \Artisan::call('optimize:clear');
    \Artisan::call('config:clear');
    \Artisan::call('route:clear');
    \Artisan::call('view:clear');
    \Artisan::call('cache:clear');
    return 'Cache & autoload refreshed. Sekarang coba akses /users.';
    });

    Route::get('/offline', function () {
    return view('offline');
    })->name('offline');
});