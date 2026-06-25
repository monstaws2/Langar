<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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

        // Categories — the `icon` column stores a Lucide icon name.
        $categories = [
            ['name' => 'قطعات موتور', 'slug' => 'motor-parts', 'icon' => 'cog', 'is_active' => true],
            ['name' => 'سیستم ترمز', 'slug' => 'brake-system', 'icon' => 'disc-3', 'is_active' => true],
            ['name' => 'روغن و فیلتر', 'slug' => 'oil-filter', 'icon' => 'droplet', 'is_active' => true],
            ['name' => 'روشنایی', 'slug' => 'lighting', 'icon' => 'lightbulb', 'is_active' => true],
            ['name' => 'موتور برق', 'slug' => 'electrical', 'icon' => 'zap', 'is_active' => true],
            ['name' => 'تایر و رینگ', 'slug' => 'tires-wheels', 'icon' => 'circle-dot', 'is_active' => true],
        ];

        $createdCategories = [];
        foreach ($categories as $cat) {
            $createdCategories[$cat['slug']] = Category::create($cat);
        }

        // Brands — `slug` matches well-known brand identifiers for logo lookups.
        $brands = [
            ['name' => 'هوندا', 'slug' => 'honda', 'is_active' => true],
            ['name' => 'یاماها', 'slug' => 'yamaha', 'is_active' => true],
            ['name' => 'سوزوکی', 'slug' => 'suzuki', 'is_active' => true],
            ['name' => 'کاوازاکی', 'slug' => 'kawasaki', 'is_active' => true],
        ];

        $createdBrands = [];
        foreach ($brands as $brand) {
            $createdBrands[$brand['slug']] = Brand::create($brand);
        }

        // Products
        $products = [
            [
                'name' => 'صفحه کلاچ هوندا CG125',
                'slug' => 'honda-cg125-clutch-plate',
                'description' => 'صفحه کلاچ اصل و با کیفیت بالا، مناسب برای موتورسیکلت‌های هوندا CG125 و CD70.',
                'price' => 125000,
                'stock' => 50,
                'category_id' => $createdCategories['motor-parts']->id,
                'brand_id' => $createdBrands['honda']->id,
                'is_active' => true,
            ],
            [
                'name' => 'لنت ترمز یاماها YZF150',
                'slug' => 'yamaha-yzf150-brake-pads',
                'description' => 'لنت ترمز مرغوب و دوام‌دار با قدرت توقف بالا.',
                'price' => 85000,
                'stock' => 30,
                'category_id' => $createdCategories['brake-system']->id,
                'brand_id' => $createdBrands['yamaha']->id,
                'is_active' => true,
            ],
            [
                'name' => 'فیلتر روغن سوزوکی GS150',
                'slug' => 'suzuki-gs150-oil-filter',
                'description' => 'فیلتر روغن اصل برای حفظ سلامت موتور.',
                'price' => 45000,
                'stock' => 100,
                'category_id' => $createdCategories['oil-filter']->id,
                'brand_id' => $createdBrands['suzuki']->id,
                'is_active' => true,
            ],
            [
                'name' => 'تایر یاماها ۹۰/۹۰-۱۸',
                'slug' => 'yamaha-tire-90-90-18',
                'description' => 'تایر باکیفیت با چسبندگی بالا برای موتورسیکلت.',
                'price' => 350000,
                'stock' => 20,
                'category_id' => $createdCategories['tires-wheels']->id,
                'brand_id' => $createdBrands['yamaha']->id,
                'is_active' => true,
            ],
            [
                'name' => 'لامپ هد لایت کاوازاکی',
                'slug' => 'kawasaki-headlight-bulb',
                'description' => 'لامپ روشنایی جلوی موتورسیکلت با نور سفید و پرقدرت.',
                'price' => 60000,
                'stock' => 80,
                'category_id' => $createdCategories['lighting']->id,
                'brand_id' => $createdBrands['kawasaki']->id,
                'is_active' => true,
            ],
            [
                'name' => 'دینام (آلترناتور) هوندا CG125',
                'slug' => 'honda-cg125-alternator',
                'description' => 'دینام اصل با عملکرد پایدار و عمر طولانی.',
                'price' => 280000,
                'stock' => 15,
                'category_id' => $createdCategories['electrical']->id,
                'brand_id' => $createdBrands['honda']->id,
                'is_active' => true,
            ],
            [
                'name' => 'پیستون و رینگ سوزوکی GS150',
                'slug' => 'suzuki-gs150-piston-kit',
                'description' => 'کیت کامل پیستون و رینگ با کیفیت کارخانه‌ای.',
                'price' => 195000,
                'stock' => 25,
                'category_id' => $createdCategories['motor-parts']->id,
                'brand_id' => $createdBrands['suzuki']->id,
                'is_active' => true,
            ],
            [
                'name' => 'روغن موتور ۱۰W-۴۰ نیمه‌سینتتیک',
                'slug' => 'engine-oil-10w40',
                'description' => 'روغن موتور نیمه‌سینتتیک یک لیتری مخصوص موتورسیکلت.',
                'price' => 70000,
                'stock' => 120,
                'category_id' => $createdCategories['oil-filter']->id,
                'brand_id' => $createdBrands['honda']->id,
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
