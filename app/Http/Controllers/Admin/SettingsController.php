<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        $settings = [
            'store_name' => config('app.name', 'لنگر موتور'),
            'items_per_page' => 15,
            'low_stock_threshold' => 5,
            'currency' => 'تومان',
        ];

        $cacheStats = [
            'cache_size' => '—',
            'routes_cached' => file_exists(base_path('bootstrap/cache/routes-v7.php')),
            'config_cached' => file_exists(base_path('bootstrap/cache/config.php')),
            'views_cached' => file_exists(base_path('bootstrap/cache/packages.php')),
        ];

        return view('admin.settings.index', compact('settings', 'cacheStats'));
    }

    /**
     * Clear application cache.
     */
    public function clearCache()
    {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'کش برنامه با موفقیت پاک شد.');
    }
}
