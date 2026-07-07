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
        $minPrice = $request->get('min_price', '');
        $maxPrice = $request->get('max_price', '');

        $productsQuery = Product::where('is_active', 1);

        if ($query) {
            $productsQuery->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            });
        }

        if ($category) {
            $productsQuery->where('category_id', $category);
        }

        if ($brand) {
            $productsQuery->where('brand_id', $brand);
        }

        if ($minPrice !== '' && is_numeric($minPrice)) {
            $productsQuery->where('price', '>=', (int) $minPrice);
        }

        if ($maxPrice !== '' && is_numeric($maxPrice)) {
            $productsQuery->where('price', '<=', (int) $maxPrice);
        }

        $products = $productsQuery->with(['category', 'brand'])->paginate(12)->withQueryString();
        $categories = Category::where('is_active', true)->get();
        $brands = Brand::all();

        return view('search.index', compact('products', 'query', 'category', 'brand', 'minPrice', 'maxPrice', 'categories', 'brands'));
    }
}
