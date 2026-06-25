<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::where('is_active', 1)->with(['category', 'brand'])->get();
        $categories = Category::all();
        $brands = Brand::all();

        return view('products.index', compact('products', 'categories', 'brands'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->with(['category', 'brand'])->firstOrFail();
        $related = Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->take(4)->get();

        return view('products.show', compact('product', 'related'));
    }
}
