<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->take(3)->get();
        return view('welcome', compact('products'));
    }
}