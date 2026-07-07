<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'مدیر سیستم',
            'email' => 'admin@langarmotor.ir',
            'is_admin' => true,
        ]);

        // Create test customer
        $customer = User::factory()->create([
            'name' => 'محمد رضایی',
            'email' => 'mohammad@example.com',
        ]);

        // Create categories
        $categories = [
            ['name' => 'قطعات موتور', 'slug' => 'motor-parts', 'icon' => 'cog'],
            ['name' => 'سیستم ترمز', 'slug' => 'brake-system', 'icon' => 'octagon'],
            ['name' => 'روشنایی', 'slug' => 'lighting', 'icon' => 'lightbulb'],
            ['name' => 'تایر و رینگ', 'slug' => 'tires-wheels', 'icon' => 'circle'],
            ['name' => 'سیستم سوخت', 'slug' => 'fuel-system', 'icon' => 'fuel'],
            ['name' => 'بدنه و کاور', 'slug' => 'body-cover', 'icon' => 'shield'],
        ];

        $createdCategories = [];
        foreach ($categories as $cat) {
            $createdCategories[] = Category::create($cat);
        }

        // Create brands
        $brands = [
            ['name' => 'هوندا', 'slug' => 'honda'],
            ['name' => 'یاماها', 'slug' => 'yamaha'],
            ['name' => 'سوزوکی', 'slug' => 'suzuki'],
            ['name' => 'کاوازاکی', 'slug' => 'kawasaki'],
        ];

        $createdBrands = [];
        foreach ($brands as $brand) {
            $createdBrands[] = Brand::create($brand);
        }

        // Create products
        $productsData = [
            [
                'name' => 'صفحه کلاچ هوندا CG125',
                'slug' => 'honda-cg125-clutch-plate',
                'description' => 'صفحه کلاچ اصل هوندا با کیفیت بالا و دوام طولانی. مناسب برای موتورسیکلت هوندا CG125.',
                'price' => 125000,
                'stock' => 50,
                'category_id' => $createdCategories[0]->id,
                'brand_id' => $createdBrands[0]->id,
                'is_active' => true,
            ],
            [
                'name' => 'لنت ترمز یاماها YZF150',
                'slug' => 'yamaha-yzf150-brake-pads',
                'description' => 'لنت ترمز مرغوب و دوام‌دار یاماها. عملکرد عالی در شرایط مختلف آب و هوایی.',
                'price' => 85000,
                'stock' => 30,
                'category_id' => $createdCategories[1]->id,
                'brand_id' => $createdBrands[1]->id,
                'is_active' => true,
            ],
            [
                'name' => 'لامپ روشنایی جلو هوندا',
                'slug' => 'honda-headlight-bulb',
                'description' => 'لامپ روشنایی جلوی موتورسیکلت هوندا. نوردهی قوی و مصرف بهینه.',
                'price' => 45000,
                'stock' => 100,
                'category_id' => $createdCategories[2]->id,
                'brand_id' => $createdBrands[0]->id,
                'is_active' => true,
            ],
            [
                'name' => 'تایر یاماها 90/90-18',
                'slug' => 'yamaha-tire-90-90-18',
                'description' => 'تایر باکیفیت برای موتورسیکلت یاماها. مقاوم در برابر سایش.',
                'price' => 350000,
                'stock' => 20,
                'category_id' => $createdCategories[3]->id,
                'brand_id' => $createdBrands[1]->id,
                'is_active' => true,
            ],
            [
                'name' => 'کاربراتور هوندا CD70',
                'slug' => 'honda-cd70-carburetor',
                'description' => 'کاربراتور اصل هوندا CD70. تنظیم دقیق و مصرف سوخت بهینه.',
                'price' => 280000,
                'stock' => 15,
                'category_id' => $createdCategories[4]->id,
                'brand_id' => $createdBrands[0]->id,
                'is_active' => true,
            ],
            [
                'name' => 'کاور موتور سوزوکی GS150',
                'slug' => 'suzuki-gs150-engine-cover',
                'description' => 'کاور موتور اصل سوزوکی GS150. مقاوم در برابر حرارت و ضربه.',
                'price' => 195000,
                'stock' => 12,
                'category_id' => $createdCategories[5]->id,
                'brand_id' => $createdBrands[2]->id,
                'is_active' => true,
            ],
            [
                'name' => 'دیسک ترمز جلو هوندا',
                'slug' => 'honda-front-brake-disc',
                'description' => 'دیسک ترمز جلوی موتورسیکلت هوندا. ساخته شده از فولاد ضد زنگ.',
                'price' => 210000,
                'stock' => 8,
                'category_id' => $createdCategories[1]->id,
                'brand_id' => $createdBrands[0]->id,
                'is_active' => true,
            ],
            [
                'name' => 'شمع موتور NGK CR8HSA',
                'slug' => 'ngk-cr8hsa-spark-plug',
                'description' => 'شمع موتور باکیفیت NGK. ساخت ژاپن. سازگار با اکثر موتورسیکلت‌های هوندا و یاماها.',
                'price' => 38000,
                'stock' => 200,
                'category_id' => $createdCategories[0]->id,
                'brand_id' => $createdBrands[0]->id,
                'is_active' => true,
            ],
            [
                'name' => 'زنجیر دینام هوندا CDI',
                'slug' => 'honda-cdi-chain',
                'description' => 'زنجیر دینام اصل هوندا CDI. کیفیت بالا و طول عمر مناسب.',
                'price' => 95000,
                'stock' => 5,
                'category_id' => $createdCategories[0]->id,
                'brand_id' => $createdBrands[0]->id,
                'is_active' => true,
            ],
            [
                'name' => 'آینه بغل یاماها YZF',
                'slug' => 'yamaha-yzf-side-mirror',
                'description' => 'آینه بغل اصل یاماها YZF. دید وسیع و نصب آسان.',
                'price' => 72000,
                'stock' => 18,
                'category_id' => $createdCategories[5]->id,
                'brand_id' => $createdBrands[1]->id,
                'is_active' => true,
            ],
            [
                'name' => 'لنت ترمز جلو کاوازاکی',
                'slug' => 'kawasaki-front-brake-pads',
                'description' => 'لنت ترمز جلوی اصل کاوازاکی. مقاوم در برابر حرارت بالا.',
                'price' => 110000,
                'stock' => 25,
                'category_id' => $createdCategories[1]->id,
                'brand_id' => $createdBrands[3]->id,
                'is_active' => true,
            ],
            [
                'name' => 'چراغ عقب سوزوکی',
                'slug' => 'suzuki-tail-light',
                'description' => 'چراغ عقب اصل سوزوکی. نوردهی عالی و دوام بالا.',
                'price' => 65000,
                'stock' => 3,
                'category_id' => $createdCategories[2]->id,
                'brand_id' => $createdBrands[2]->id,
                'is_active' => true,
            ],
        ];

        foreach ($productsData as $product) {
            Product::create($product);
        }

        // Sample orders with new schema
        $ordersData = [
            [
                'user_id' => $customer->id,
                'name' => 'محمد رضایی',
                'phone' => '09121234567',
                'address' => 'تهران، خیابان آزادی، کوچه اول',
                'city' => 'تهران',
                'postal_code' => '1234567890',
                'total_price' => 210000,
                'status' => 'delivered',
                'created_at' => Carbon::today()->subDays(10),
                'updated_at' => Carbon::today()->subDays(8),
            ],
            [
                'user_id' => $customer->id,
                'name' => 'محمد رضایی',
                'phone' => '09121234567',
                'address' => 'تهران، خیابان آزادی، کوچه اول',
                'city' => 'تهران',
                'postal_code' => '1234567890',
                'total_price' => 163000,
                'status' => 'shipped',
                'created_at' => Carbon::today()->subDays(5),
                'updated_at' => Carbon::today()->subDays(4),
            ],
            [
                'user_id' => $customer->id,
                'name' => 'محمد رضایی',
                'phone' => '09121234567',
                'address' => 'تهران، خیابان آزادی، کوچه اول',
                'city' => 'تهران',
                'postal_code' => '1234567890',
                'total_price' => 350000,
                'status' => 'pending',
                'created_at' => Carbon::today()->subDays(2),
                'updated_at' => Carbon::today()->subDays(2),
            ],
            [
                'user_id' => null,
                'name' => 'علی محمدی',
                'phone' => '09139876543',
                'address' => 'اصفهان، خیابان امام',
                'city' => 'اصفهان',
                'postal_code' => '6543210987',
                'total_price' => 125000,
                'status' => 'pending',
                'created_at' => Carbon::today()->subDays(1),
                'updated_at' => Carbon::today()->subDays(1),
            ],
            [
                'user_id' => null,
                'name' => 'زهرا کریمی',
                'phone' => '09155678901',
                'address' => 'شیراز، خیابان زند',
                'city' => 'شیراز',
                'postal_code' => '9876543210',
                'total_price' => 85000,
                'status' => 'cancelled',
                'created_at' => Carbon::today()->subDays(3),
                'updated_at' => Carbon::today()->subDays(3),
            ],
        ];

        foreach ($ordersData as $orderData) {
            $order = Order::create($orderData);

            // Add order items based on order
            if ($order->total_price == 210000) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => 7,
                    'product_name' => 'دیسک ترمز جلو هوندا',
                    'price' => 210000,
                    'quantity' => 1,
                    'total_price' => 210000,
                ]);
            } elseif ($order->total_price == 163000) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => 1,
                    'product_name' => 'صفحه کلاچ هوندا CG125',
                    'price' => 125000,
                    'quantity' => 1,
                    'total_price' => 125000,
                ]);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => 3,
                    'product_name' => 'لامپ روشنایی جلو هوندا',
                    'price' => 45000,
                    'quantity' => 1,
                    'total_price' => 38000,
                ]);
            } elseif ($order->total_price == 350000) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => 4,
                    'product_name' => 'تایر یاماها 90/90-18',
                    'price' => 350000,
                    'quantity' => 1,
                    'total_price' => 350000,
                ]);
            } elseif ($order->total_price == 125000) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => 1,
                    'product_name' => 'صفحه کلاچ هوندا CG125',
                    'price' => 125000,
                    'quantity' => 1,
                    'total_price' => 125000,
                ]);
            } elseif ($order->total_price == 85000) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => 2,
                    'product_name' => 'لنت ترمز یاماها YZF150',
                    'price' => 85000,
                    'quantity' => 1,
                    'total_price' => 85000,
                ]);
            }
        }
    }
}
