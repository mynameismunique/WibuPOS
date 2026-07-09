<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalSuppliers = Supplier::count();
        $totalSales = Sale::count();
        $totalPurchases = Purchase::count();
        $totalUsers = User::count();

        $todaySales = Sale::whereDate('sale_date', Carbon::today())->sum('grand_total');
        $todayCount = Sale::whereDate('sale_date', Carbon::today())->count();
        $monthCount = Sale::whereMonth('sale_date', Carbon::now()->month)->count();

        $monthSales = Sale::whereMonth('sale_date', Carbon::now()->month)->sum('grand_total');

        $lowStock = Product::whereColumn('stock', '<=', 'min_stock')->count();

        $dates = collect();
        $salesData = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dates->push($date->format('d M'));
            $total = Sale::whereDate('sale_date', $date)->sum('grand_total');
            $salesData->push($total);
        }

        return view('dashboard', compact(
            'totalProducts', 'totalCategories', 'totalSuppliers',
            'totalSales', 'totalPurchases', 'totalUsers',
            'todaySales', 'todayCount', 'monthSales', 'monthCount', 'lowStock',
            'dates', 'salesData'
        ));
    }
}