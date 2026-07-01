<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand']);

        if ($search = $request->get('q')) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%");
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->get('category_id'));
        }

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->get('brand_id'));
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->get('status') === 'active');
        }

        $products = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories', 'brands'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $brands = Brand::where('is_active', true)->orderBy('name')->get();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:products,slug'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'price' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'brand_id' => ['required', 'exists:brands,id'],
            'is_active' => ['boolean'],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        Product::create($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'محصول با موفقیت ایجاد شد.');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:products,slug,' . $product->id],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'price' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'brand_id' => ['required', 'exists:brands,id'],
            'is_active' => ['boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        $product->update($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'محصول با موفقیت به‌روزرسانی شد.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'محصول حذف شد.');
    }
}
