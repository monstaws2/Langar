<?php

namespace App\Console\Commands;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportProductsFromCsv extends Command
{
    protected $signature = 'products:import
        {--file=khanemotor_products_with_seo.csv : Path to the CSV file, relative to project root}
        {--images=edited : Path to the folder containing per-product image subfolders}
        {--dry-run : Preview changes without saving anything to the database}';

    protected $description = 'Bulk import products (and their images) from a CSV file into the database';

    public function handle(): int
    {
        $csvPath = base_path($this->option('file'));
        $imagesBasePath = base_path($this->option('images'));
        $dryRun = (bool) $this->option('dry-run');

        if (! file_exists($csvPath)) {
            $this->error("CSV file not found at: {$csvPath}");
            return self::FAILURE;
        }

        $handle = fopen($csvPath, 'r');
        $header = fgetcsv($handle);
        // Strip UTF-8 BOM from the first column header if present.
        $header[0] = preg_replace('/^\x{FEFF}/u', '', $header[0]);

        $expected = [
            'slug', 'نام محصول', 'توضیحات', 'قیمت (تومان)', 'موجودی', 'وضعیت',
            'دسته‌بندی', 'برند', 'عنوان سئو (Meta Title)', 'توضیح متا (Meta Description)',
            'کلمات کلیدی (SEO Tags)',
        ];

        $created = 0;
        $updated = 0;
        $imagesAttached = 0;
        $rowNumber = 1;

        while (($row = fgetcsv($handle)) !== false) {
            $rowNumber++;

            if (count($row) < count($expected)) {
                $this->warn("Row {$rowNumber}: skipped, wrong number of columns.");
                continue;
            }

            $data = array_combine($expected, $row);

            $slug = trim($data['slug']);
            if ($slug === '') {
                $this->warn("Row {$rowNumber}: skipped, empty slug.");
                continue;
            }

            $categoryName = trim($data['دسته‌بندی']);
            $brandName = trim($data['برند']);

            $category = Category::firstOrCreate(
                ['name' => $categoryName],
                ['slug' => $this->uniqueSlug(Category::class, $categoryName)]
            );

            $brand = Brand::firstOrCreate(
                ['name' => $brandName],
                ['slug' => $this->uniqueSlug(Brand::class, $brandName)]
            );

            $isActive = trim($data['وضعیت']) === 'فعال';

            $payload = [
                'name' => trim($data['نام محصول']),
                'description' => trim($data['توضیحات']),
                'price' => (int) preg_replace('/\D/', '', $data['قیمت (تومان)']),
                'stock' => (int) preg_replace('/\D/', '', $data['موجودی']),
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'is_active' => $isActive,
                'meta_title' => trim($data['عنوان سئو (Meta Title)']) ?: null,
                'meta_description' => trim($data['توضیح متا (Meta Description)']) ?: null,
                'seo_tags' => trim($data['کلمات کلیدی (SEO Tags)']) ?: null,
            ];

            $this->line("Row {$rowNumber}: {$slug} -> {$payload['name']}");

            if ($dryRun) {
                continue;
            }

            $product = Product::withTrashed()->where('slug', $slug)->first();

            if ($product) {
                $product->update($payload);
                $updated++;
            } else {
                $payload['slug'] = $slug;
                $product = Product::create($payload);
                $created++;
            }

            $imagesAttached += $this->attachImages($product, $imagesBasePath, $slug);
        }

        fclose($handle);

        $this->newLine();
        $this->info("Done. Created: {$created}, Updated: {$updated}, Images attached: {$imagesAttached}.");

        if ($dryRun) {
            $this->comment('This was a dry run — nothing was saved.');
        }

        return self::SUCCESS;
    }

    private function attachImages(Product $product, string $imagesBasePath, string $slug): int
    {
        $sourceDir = $imagesBasePath.DIRECTORY_SEPARATOR.$slug;

        if (! is_dir($sourceDir)) {
            $this->warn("  No image folder found for slug '{$slug}' at {$sourceDir}");
            return 0;
        }

        $files = glob($sourceDir.DIRECTORY_SEPARATOR.'*.webp');
        sort($files);

        if (empty($files)) {
            $this->warn("  No .webp images found in {$sourceDir}");
            return 0;
        }

        // Remove previously imported images for this product so re-running is safe.
        foreach ($product->productImages()->get() ?? [] as $old) {
            Storage::disk('public')->delete($old->image_path);
            $old->delete();
        }

        $count = 0;

        foreach ($files as $index => $filePath) {
            $filename = basename($filePath);
            $destination = "products/{$slug}/{$filename}";

            Storage::disk('public')->put($destination, file_get_contents($filePath));

            $isPrimary = $index === 0;

            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $destination,
                'is_primary' => $isPrimary,
                'sort_order' => $index,
            ]);

            if ($isPrimary) {
                $product->update(['image' => $destination]);
            }

            $count++;
        }

        $this->info("  Attached {$count} image(s) to '{$slug}'.");

        return $count;
    }

    private function uniqueSlug(string $modelClass, string $name): string
    {
        $base = Str::slug($name) ?: 'item-'.substr(md5($name), 0, 8);
        $slug = $base;
        $i = 2;

        while ($modelClass::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$i;
            $i++;
        }

        return $slug;
    }
}