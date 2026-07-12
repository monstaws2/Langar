<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $ordersToday  = Order::whereDate('created_at', $today)->count();
        $revenueToday = Order::whereDate('created_at', $today)
            ->whereIn('status', ['paid', 'shipped', 'delivered'])
            ->sum('total_price');
        $productsCount       = Product::count();
        $lowStockCount       = Product::where('stock', '<', 5)->where('is_active', true)->count();
        $pendingReviewsCount = Review::where('is_approved', false)->count();

        $recentOrders     = Order::with('items')->latest('created_at')->take(5)->get();
        $lowStockProducts = Product::where('stock', '<', 5)
            ->where('is_active', true)
            ->take(4)
            ->get();

        // Revenue for last 7 days (chart)
        $revenueByDay = collect(range(6, 0))->map(function ($daysBack) use ($today) {
            $date = $today->copy()->subDays($daysBack);
            return [
                'date'  => $date,
                'label' => $date->translatedFormat('j F'),
                'value' => (int) Order::whereDate('created_at', $date)
                    ->whereIn('status', ['paid', 'shipped', 'delivered'])
                    ->sum('total_price'),
            ];
        });

        return view('admin.dashboard', compact(
            'ordersToday',
            'revenueToday',
            'productsCount',
            'lowStockCount',
            'pendingReviewsCount',
            'recentOrders',
            'lowStockProducts',
            'revenueByDay',
        ));
    }
}
