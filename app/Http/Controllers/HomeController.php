<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)->get();
        $brands = Brand::all();
        $latestProducts = Product::where('is_active', true)
            ->with(['brand', 'category'])
            ->latest()
            ->limit(8)
            ->get();

        return view('home.index', compact('categories', 'brands', 'latestProducts'));
    }
}