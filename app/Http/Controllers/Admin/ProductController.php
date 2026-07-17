<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        if ($request->filled('seo')) {
            if ($request->get('seo') === 'complete') {
                $query->whereNotNull('meta_title')->whereNotNull('meta_description');
            } elseif ($request->get('seo') === 'missing') {
                $query->where(function ($q) {
                    $q->whereNull('meta_title')->orWhereNull('meta_description');
                });
            }
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
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['image', 'max:2048'],
            'primary_image_id' => ['nullable', 'integer'],
            'price' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'brand_id' => ['required', 'exists:brands,id'],
            'is_active' => ['boolean'],
            'meta_title' => ['nullable', 'string', 'max:70'],
            'meta_description' => ['nullable', 'string', 'max:320'],
            'seo_tags' => ['nullable', 'string', 'max:1000'],
            'canonical_url' => ['nullable', 'url', 'max:255'],
        ], [
            'slug.unique' => 'این شناسه (slug) قبلاً برای محصول دیگری استفاده شده است.',
            'meta_title.max' => 'عنوان سئو نباید بیشتر از :max حرف باشد.',
            'meta_description.max' => 'توضیح متا نباید بیشتر از :max حرف باشد.',
            'canonical_url.url' => 'آدرس canonical باید یک لینک معتبر باشد (مثال: https://example.com/product).',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Product::generateUniqueSlug($validated['name']);
        }

        $mainImagePath = null;
        if ($request->hasFile('image')) {
            $mainImagePath = $request->file('image')->store('products/'.$validated['slug'], 'public');
            $validated['image'] = $mainImagePath;
        }

        $validated['is_active'] = $request->boolean('is_active');

        $product = Product::create($validated);

        $this->storeGalleryImages($product, $request);
        $this->syncPrimaryImage($product, $request->input('primary_image_id'), $mainImagePath, true);

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
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug,'.$product->id],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['image', 'max:2048'],
            'primary_image_id' => ['nullable', 'integer'],
            'price' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'brand_id' => ['required', 'exists:brands,id'],
            'is_active' => ['boolean'],
            'meta_title' => ['nullable', 'string', 'max:70'],
            'meta_description' => ['nullable', 'string', 'max:320'],
            'seo_tags' => ['nullable', 'string', 'max:1000'],
            'canonical_url' => ['nullable', 'url', 'max:255'],
        ], [
            'slug.unique' => 'این شناسه (slug) قبلاً برای محصول دیگری استفاده شده است.',
            'meta_title.max' => 'عنوان سئو نباید بیشتر از :max حرف باشد.',
            'meta_description.max' => 'توضیح متا نباید بیشتر از :max حرف باشد.',
            'canonical_url.url' => 'آدرس canonical باید یک لینک معتبر باشد (مثال: https://example.com/product).',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Product::generateUniqueSlug($validated['name'], $product->id);
        }

        $mainImagePath = null;
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $mainImagePath = $request->file('image')->store('products/'.$validated['slug'], 'public');
            $validated['image'] = $mainImagePath;
        }

        $validated['is_active'] = $request->boolean('is_active');

        $product->update($validated);

        $this->storeGalleryImages($product, $request);
        $this->syncPrimaryImage($product, $request->input('primary_image_id'), $mainImagePath, false);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'محصول با موفقیت به‌روزرسانی شد.');
    }

    public function destroy(Product $product)
    {
        $paths = $product->productImages->pluck('image_path')->all();

        if ($product->image) {
            $paths[] = $product->image;
        }

        Storage::disk('public')->delete(array_values(array_unique(array_filter($paths))));

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'محصول حذف شد.');
    }

    private function storeGalleryImages(Product $product, Request $request): void
    {
        $galleryImages = $request->file('gallery_images', []);

        if (! is_array($galleryImages) || empty($galleryImages)) {
            return;
        }

        $nextSortOrder = (int) $product->productImages()->max('sort_order') + 1;

        foreach ($galleryImages as $galleryImage) {
            if (! $galleryImage) {
                continue;
            }

            $imagePath = $galleryImage->store('products/'.$product->slug, 'public');

            $product->productImages()->create([
                'image_path' => $imagePath,
                'is_primary' => false,
                'sort_order' => $nextSortOrder,
            ]);

            $nextSortOrder++;
        }
    }

    private function syncPrimaryImage(Product $product, mixed $primaryImageId, ?string $mainImagePath, bool $isCreate): void
    {
        if ($mainImagePath) {
            $product->productImages()->update(['is_primary' => false]);
            $product->forceFill(['image' => $mainImagePath])->save();

            return;
        }

        if (! empty($primaryImageId)) {
            $selectedImage = $product->productImages()->whereKey($primaryImageId)->first();

            if ($selectedImage) {
                $product->productImages()->update(['is_primary' => false]);
                $selectedImage->update(['is_primary' => true]);
                $product->forceFill(['image' => $selectedImage->image_path])->save();

                return;
            }
        }

        if (($isCreate || blank($product->image)) && $product->productImages()->exists()) {
            $firstImage = $product->productImages()->orderBy('sort_order')->first();

            if ($firstImage) {
                $product->productImages()->update(['is_primary' => false]);
                $firstImage->update(['is_primary' => true]);
                $product->forceFill(['image' => $firstImage->image_path])->save();
            }
        }
    }
}
