<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $query = Brand::withCount('products');

        if ($search = $request->get('q')) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->get('status') === 'active');
        }

        $brands = $query->latest()->paginate(15)->withQueryString();

        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:brands,slug'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'is_active' => ['boolean'],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('brands', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        Brand::create($validated);

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'برند با موفقیت ایجاد شد.');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:brands,slug,' . $brand->id],
            'logo' => ['nullable', 'image', 'max:2048'],
            'is_active' => ['boolean'],
        ]);

        if ($request->hasFile('logo')) {
            if ($brand->logo) {
                Storage::disk('public')->delete($brand->logo);
            }
            $validated['logo'] = $request->file('logo')->store('brands', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        $brand->update($validated);

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'برند با موفقیت به‌روزرسانی شد.');
    }

    public function destroy(Brand $brand)
    {
        if ($brand->products()->exists()) {
            return redirect()
                ->route('admin.brands.index')
                ->with('error', 'این برند دارای محصول است و قابل حذف نیست.');
        }

        if ($brand->logo) {
            Storage::disk('public')->delete($brand->logo);
        }

        $brand->delete();

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'برند حذف شد.');
    }
}
