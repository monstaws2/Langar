<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $products = Product::where('category_id', $category->id)
            ->where('is_active', 1)
            ->with(['category', 'brand'])
            ->get();

        return view('categories.show', compact('category', 'products'));
    }
}
