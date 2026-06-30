<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $today = today()->startOfDay();

        // Task 1: Dashboard Stats
        $todayOrders = Order::whereDate('created_at', $today)->count();

        $todayRevenue = Order::whereDate('created_at', $today)->sum('total');

        $totalProducts = Product::where('is_active', 1)->count();

        $lowStockCount = Product::where('stock_quantity', '<', 5)->count();

        // Recent Orders
        $recentOrders = Order::with(['user', 'orderItems.product'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Low Stock Products
        $lowStockProducts = Product::where('stock_quantity', '<', 5)
            ->with('images') // Assuming you have a relationship named 'images'
            ->orderBy('stock_quantity', 'asc')
            ->take(5) // Take top 5 low stock products for display
            ->get();

        // Sales Chart Data (Last 7 Days Revenue)
        $salesChartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i)->startOfDay();
            $revenue = Order::whereDate('created_at', $date)->sum('total');
            $salesChartData[] = ['date' => $date->format('Y-m-d'), 'revenue' => (int) $revenue];
        }

        // Ensure the user is an admin before accessing the dashboard
        if (Auth::check() && Auth::user()->is_admin !== 1) {
            abort(403, 'شما دسترسی ندارید');
        }

        return view('admin.dashboard', compact(
            'todayOrders',
            'todayRevenue',
            'totalProducts',
            'lowStockCount',
            'recentOrders',
            'lowStockProducts',
            'salesChartData'
        ));
    }
}