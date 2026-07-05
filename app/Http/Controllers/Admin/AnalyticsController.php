<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    /**
     * Show the analytics dashboard.
     */
    public function index(Request $request)
    {
        $period = $request->get('period', '30');
        $startDate = match($period) {
            '7' => Carbon::now()->subDays(7),
            '30' => Carbon::now()->subDays(30),
            '90' => Carbon::now()->subDays(90),
            '365' => Carbon::now()->subYear(),
            default => Carbon::now()->subDays(30),
        };

        // ===== KEY METRICS =====
        $totalProducts = Product::where('is_active', true)->count();
        $totalOrders = Order::count();
        $totalCustomers = User::where('is_admin', false)->count();
        $totalRevenue = Order::whereIn('status', ['paid', 'shipped', 'delivered'])->sum('total_price');

        // Period-based metrics
        $periodOrders = Order::whereDate('created_at', '>=', $startDate)->count();
        $periodRevenue = Order::whereDate('created_at', '>=', $startDate)
            ->whereIn('status', ['paid', 'shipped', 'delivered'])
            ->sum('total_price');
        $periodCustomers = User::where('is_admin', false)
            ->whereDate('created_at', '>=', $startDate)
            ->count();

        // ===== ORDERS BY STATUS =====
        $ordersByStatus = Order::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $statusLabels = [
            'pending' => 'در انتظار',
            'paid' => 'پرداخت شده',
            'shipped' => 'ارسال شده',
            'delivered' => 'تحویل شده',
            'cancelled' => 'لغو شده',
        ];

        // ===== MONTHLY SALES DATA (last 6 months) =====
        $monthlySalesData = [];
        $monthlyLabels = [];
        $monthlyOrderCounts = [];
        $now = Carbon::now();

        for ($i = 5; $i >= 0; $i--) {
            $month = $now->copy()->subMonths($i);
            $sales = Order::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->whereIn('status', ['paid', 'shipped', 'delivered'])
                ->sum('total_price');
            $orderCount = Order::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            $monthlyLabels[] = $month->translatedFormat('F Y');
            $monthlySalesData[] = (int) $sales;
            $monthlyOrderCounts[] = (int) $orderCount;
        }

        // Calculate monthly growth
        $currentMonthSales = $monthlySalesData[5] ?? 0;
        $previousMonthSales = $monthlySalesData[4] ?? 0;
        $monthlyGrowth = $previousMonthSales > 0
            ? round((($currentMonthSales - $previousMonthSales) / $previousMonthSales) * 100, 1)
            : 0;

        // ===== TOP SELLING PRODUCTS =====
        $topProducts = OrderItem::selectRaw('product_name, SUM(quantity) as total_qty, SUM(total_price) as total_revenue')
            ->whereHas('order', function($q) {
                $q->whereIn('status', ['paid', 'shipped', 'delivered']);
            })
            ->groupBy('product_name')
            ->orderByDesc('total_qty')
            ->take(8)
            ->get();

        // ===== RECENT ACTIVITIES =====
        $recentOrders = Order::with('user')->latest()->take(8)->get();
        $recentActivities = [];

        foreach ($recentOrders as $order) {
            $statusColors = [
                'pending' => 'text-amber-500',
                'paid' => 'text-blue-500',
                'shipped' => 'text-indigo-500',
                'delivered' => 'text-green-500',
                'cancelled' => 'text-red-500',
            ];
            $recentActivities[] = [
                'title' => 'سفارش #' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
                'description' => 'از ' . $order->name . ' — ' . \App\Support\Format::price($order->total_price) . ' تومان',
                'time' => $order->created_at->diffForHumans(),
                'icon' => 'shopping-cart',
                'color' => $statusColors[$order->status] ?? 'text-gray-500',
            ];
        }

        // ===== DAILY REVENUE DATA (for the selected period) =====
        $dailyLabels = [];
        $dailyRevenue = [];
        $dailyOrderCounts = [];

        $daysCount = min((int) $period, 30);
        for ($i = $daysCount - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $rev = Order::whereDate('created_at', $date)
                ->whereIn('status', ['paid', 'shipped', 'delivered'])
                ->sum('total_price');
            $count = Order::whereDate('created_at', $date)->count();

            $dailyLabels[] = $date->translatedFormat('j F');
            $dailyRevenue[] = (int) $rev;
            $dailyOrderCounts[] = (int) $count;
        }

        // ===== LOW STOCK PRODUCTS =====
        $lowStockProducts = Product::where('stock', '<', 5)
            ->where('is_active', true)
            ->orderBy('stock')
            ->take(5)
            ->get();

        return view('admin.analytics.index', compact(
            'totalProducts',
            'totalOrders',
            'totalCustomers',
            'totalRevenue',
            'periodOrders',
            'periodRevenue',
            'periodCustomers',
            'period',
            'ordersByStatus',
            'statusLabels',
            'monthlySalesData',
            'monthlyLabels',
            'monthlyOrderCounts',
            'monthlyGrowth',
            'topProducts',
            'recentActivities',
            'dailyLabels',
            'dailyRevenue',
            'dailyOrderCounts',
            'lowStockProducts',
        ));
    }
}
