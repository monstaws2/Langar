<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        $category = $request->get('category', '');
        $brand = $request->get('brand', '');

        $products = Product::where('is_active', 1);

        if ($query) {
            $products->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            });
        }

        if ($category) {
            $products->where('category_id', $category);
        }

        if ($brand) {
            $products->where('brand_id', $brand);
        }

        $products = $products->with(['category', 'brand'])->get();
        $categories = Category::all();
        $brands = Brand::all();

        return view('search.index', compact('products', 'query', 'category', 'brand', 'categories', 'brands'));
    }
}
