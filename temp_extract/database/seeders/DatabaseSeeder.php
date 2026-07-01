<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
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

        // Low-stock products for dashboard warnings
        $lowStock = [
            [
                'name' => 'زنجیر دینام هوندا CDI',
                'slug' => 'honda-cdi-chain',
                'description' => 'زنجیر دینام اصل',
                'price' => 95000,
                'stock' => 2,
                'category_id' => $createdCategories[0]->id,
                'brand_id' => $createdBrands[0]->id,
                'is_active' => true,
            ],
            [
                'name' => 'شمع موتور NGK CR8HSA',
                'slug' => 'ngk-cr8hsa-spark-plug',
                'description' => 'شمع موتور باکیفیت NGK',
                'price' => 38000,
                'stock' => 3,
                'category_id' => $createdCategories[0]->id,
                'brand_id' => $createdBrands[0]->id,
                'is_active' => true,
            ],
            [
                'name' => 'دیسک ترمز جلو هوندا',
                'slug' => 'honda-front-brake-disc',
                'description' => 'دیسک ترمز جلوی موتورسیکلت',
                'price' => 210000,
                'stock' => 1,
                'category_id' => $createdCategories[1]->id,
                'brand_id' => $createdBrands[0]->id,
                'is_active' => true,
            ],
            [
                'name' => 'آینه بغل یاماها YZF',
                'slug' => 'yamaha-yzf-side-mirror',
                'description' => 'آینه بغل اصل یاماها',
                'price' => 72000,
                'stock' => 4,
                'category_id' => $createdCategories[2]->id,
                'brand_id' => $createdBrands[1]->id,
                'is_active' => true,
            ],
        ];

        foreach ($lowStock as $product) {
            Product::create($product);
        }

        // Sample orders
        $orders = [
            ['LM-1042', 'محمد رضایی', 'صفحه کلاچ هوندا CG125', 125000, 'pending', Carbon::today()],
            ['LM-1041', 'زهرا کریمی', 'لنت ترمز یاماها YZF150', 85000, 'shipped', Carbon::today()->subDay()],
            ['LM-1040', 'علی محمدی', 'تایر یاماها 90/90-18', 350000, 'completed', Carbon::today()->subDays(2)],
            ['LM-1039', 'فاطمه احمدی', 'لامپ روشنایی جلو هوندا', 45000, 'cancelled', Carbon::today()->subDays(3)],
            ['LM-1038', 'حسین موسوی', 'شمع موتور NGK CR8HSA', 38000, 'completed', Carbon::today()->subDays(4)],
            ['LM-1037', 'مریم حسینی', 'دیسک ترمز جلو هوندا', 210000, 'shipped', Carbon::today()->subDays(5)],
            ['LM-1036', 'رضا قاسمی', 'زنجیر دینام هوندا CDI', 95000, 'completed', Carbon::today()->subDays(6)],
        ];

        foreach ($orders as $o) {
            Order::create([
                'order_number' => $o[0],
                'customer_name' => $o[1],
                'product_name' => $o[2],
                'amount' => $o[3],
                'status' => $o[4],
                'ordered_at' => $o[5],
            ]);
        }
    }
}
