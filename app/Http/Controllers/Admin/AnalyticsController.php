<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    /**
     * Show the analytics dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Get basic stats
        $totalProducts = Product::where('is_active', true)->count();
        $totalOrders = Order::count();
        $totalCustomers = User::where('is_admin', false)->count();
        $totalRevenue = Order::whereIn('status', ['paid', 'shipped', 'delivered'])->sum('total_price');

        // Get recent orders for activity feed
        $recentOrders = Order::with(['user'])->latest()->take(10)->get();

        // Get top selling products
        $topProducts = Product::withCount('items as sales_count')
            ->orderByDesc('sales_count')
            ->take(5)
            ->get();

        // Get orders by status for chart
        $ordersByStatus = Order::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Get monthly sales for the last 6 months
        $monthlySalesData = [];
        $monthlyLabels = [];
        $now = Carbon::now();

        for ($i = 5; $i >= 0; $i--) {
            $month = $now->copy()->subMonths($i);
            $sales = Order::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->whereIn('status', ['paid', 'shipped', 'delivered'])
                ->sum('total_price');

            $monthlyLabels[] = $month->format('M Y');
            $monthlySalesData[] = (int) $sales;
        }

        // Prepare recent activities for the activity feed
        $recentActivities = [];

        // Add recent orders as activities
        foreach ($recentOrders->take(5) as $order) {
            $recentActivities[] = [
                'title' => 'سفارش جدید از ' . $order->name,
                'description' => 'مبلغ ' . \App\Support\Format::price($order->total_price) . ' تومان',
                'time' => $order->created_at->diffForHumans(),
                'icon' => 'shopping-cart',
                'color' => 'text-brand-red'
            ];
        }

        // Add some sample activities if we don't have enough
        if (count($recentActivities) < 3) {
            $sampleActivities = [
                [
                    'title' => 'سیستم بروز شده',
                    'description' => 'نسخ جدید لنگر موتور نصب شد',
                    'time' => '2 ساعت پیش',
                    'icon' => 'update-arrow',
                    'color' => 'text-blue-500'
                ],
                [
                    'title' => 'نسخ پشتیبان گرفته شد',
                    'description' => 'نسخ خودکار پایگاه داده انجام شد',
                    'time' => '1 روز پیش',
                    'icon' => 'save',
                    'color' => 'text-green-500'
                ]
            ];

            $recentActivities = array_merge($sampleActivities, $recentActivities);
        }

        return view('admin.analytics.index', compact(
            'totalProducts',
            'totalOrders',
            'totalCustomers',
            'totalRevenue',
            'recentOrders',
            'topProducts',
            'ordersByStatus',
            'monthlySalesData',
            'monthlyLabels',
            'recentActivities'
        ));
    }
}