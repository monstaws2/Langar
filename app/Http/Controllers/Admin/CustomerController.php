<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::where('is_admin', false);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by customer activity
        if ($request->filled('filter')) {
            switch ($request->filter) {
                case 'with_orders':
                    $query->has('orders');
                    break;
                case 'without_orders':
                    $query->doesntHave('orders');
                    break;
                case 'recent':
                    $query->where('created_at', '>=', now()->subDays(30));
                    break;
            }
        }

        $customers = $query->withCount('orders')
            ->withSum('orders as total_spent', 'total_price')
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        // Summary stats
        $totalCustomers = User::where('is_admin', false)->count();
        $newThisMonth = User::where('is_admin', false)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $withOrders = User::where('is_admin', false)->has('orders')->count();
        $totalRevenue = Order::whereIn('status', ['paid', 'shipped', 'delivered'])->sum('total_price');

        return view('admin.customers.index', compact(
            'customers',
            'totalCustomers',
            'newThisMonth',
            'withOrders',
            'totalRevenue'
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $customer)
    {
        $customer->load(['orders' => function($query) {
            $query->withCount('items')->latest();
        }]);

        $totalOrders = $customer->orders->count();
        $totalSpent = $customer->orders
            ->whereIn('status', ['paid', 'shipped', 'delivered'])
            ->sum('total_price');
        $averageOrderValue = $totalOrders > 0 ? round($totalSpent / $totalOrders) : 0;

        $ordersByStatus = $customer->orders->groupBy('status')
            ->map(fn($group) => $group->count())
            ->toArray();

        return view('admin.customers.show', compact(
            'customer',
            'totalOrders',
            'totalSpent',
            'averageOrderValue',
            'ordersByStatus'
        ));
    }
}
