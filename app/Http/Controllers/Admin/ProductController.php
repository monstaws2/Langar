<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\MotorcycleModel;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(15);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        $motorcycleModels = MotorcycleModel::all();

        return view('admin.products.create', compact('categories', 'brands', 'motorcycleModels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'description_short' => 'nullable|string',
            'description_full' => 'nullable|string',
            'is_active' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120', // 5MB max
            'motorcycle_models' => 'nullable|array',
            'motorcycle_models.*' => 'exists:motorcycle_models,id',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'description_short' => $request->description_short,
            'description_full' => $request->description_full,
            'is_active' => $request->has('is_active'),
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_main' => ($index === 0), // First image is main
                    'sort_order' => $index,
                ]);
            }
        }

        if ($request->has('motorcycle_models')) {
            $product->motorcycleModels()->attach($request->motorcycle_models);
        }

        return redirect()->route('admin.products.index')->with('success', 'محصول با موفقیت ذخیره شد ✓');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands = Brand::all();
        $motorcycleModels = MotorcycleModel::all();
        $productMotorcycleModels = $product->motorcycleModels->pluck('id')->toArray();

        return view('admin.products.edit', compact('product', 'categories', 'brands', 'motorcycleModels', 'productMotorcycleModels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'description_short' => 'nullable|string',
            'description_full' => 'nullable|string',
            'is_active' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120', // 5MB max
            'motorcycle_models' => 'nullable|array',
            'motorcycle_models.*' => 'exists:motorcycle_models,id',
        ]);

        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'description_short' => $request->description_short,
            'description_full' => $request->description_full,
            'is_active' => $request->has('is_active'),
        ]);

        // Handle image updates
        if ($request->hasFile('images')) {
            // Delete existing images
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
            // Upload new images
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_main' => ($index === 0),
                    'sort_order' => $index,
                ]);
            }
        }

        if ($request->has('motorcycle_models')) {
            $product->motorcycleModels()->sync($request->motorcycle_models);
        } else {
            $product->motorcycleModels()->detach();
        }

        return redirect()->route('admin.products.index')->with('success', 'محصول با موفقیت ویرایش شد ✓');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Soft delete the product
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'محصول با موفقیت حذف شد ✓');
    }
}
