<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create categories
        $categories = [
            ['name' => 'قطعات موتور', 'slug' => 'motor-parts', 'icon' => '⚙️'],
            ['name' => 'سیستم ترمز', 'slug' => 'brake-system', 'icon' => '🛑'],
            ['name' => 'روشنایی', 'slug' => 'lighting', 'icon' => '💡'],
            ['name' => 'تایر و رینگ', 'slug' => 'tires-wheels', 'icon' => '🛞'],
        ];

        $createdCategories = [];
        foreach ($categories as $cat) {
            $createdCategories[] = Category::create($cat);
        }

        // Create brands
        $brands = [
            ['name' => 'هوندا', 'slug' => 'honda'],
            ['name' => 'یاماها', 'slug' => 'yamaha'],
        ];

        $createdBrands = [];
        foreach ($brands as $brand) {
            $createdBrands[] = Brand::create($brand);
        }

        // Create products
        $products = [
            [
                'name' => 'صفحه کلاچ هوندا CG125',
                'slug' => 'honda-cg125-clutch-plate',
                'description' => 'صفحه کلاچ اصل و با کیفیت بالا',
                'price' => 125000,
                'stock' => 50,
                'category_id' => $createdCategories[0]->id,
                'brand_id' => $createdBrands[0]->id,
                'is_active' => true,
            ],
            [
                'name' => 'لنت ترمز یاماها YZF150',
                'slug' => 'yamaha-yzf150-brake-pads',
                'description' => 'لنت ترمز مرغوب و دوام‌دار',
                'price' => 85000,
                'stock' => 30,
                'category_id' => $createdCategories[1]->id,
                'brand_id' => $createdBrands[1]->id,
                'is_active' => true,
            ],
            [
                'name' => 'لامپ روشنایی جلو هوندا',
                'slug' => 'honda-headlight-bulb',
                'description' => 'لامپ روشنایی جلوی موتورسیکلت',
                'price' => 45000,
                'stock' => 100,
                'category_id' => $createdCategories[2]->id,
                'brand_id' => $createdBrands[0]->id,
                'is_active' => true,
            ],
            [
                'name' => 'تایر یاماها 90/90-18',
                'slug' => 'yamaha-tire-90-90-18',
                'description' => 'تایر باکیفیت برای موتورسیکلت',
                'price' => 350000,
                'stock' => 20,
                'category_id' => $createdCategories[3]->id,
                'brand_id' => $createdBrands[1]->id,
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
