<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Eager load user for name, orderItems and their products for product names
        $orders = Order::with(['user', 'orderItems.product'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');
                // Search by customer name or product name within order items
                $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    })->orWhereHas('orderItems.product', function ($productQuery) use ($search) {
                        $productQuery->where('name', 'like', "%{$search}%");
                    });
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->input('status'));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Format recent orders for the dashboard view if needed (e.g., extracting first product name)
        $formattedOrders = $orders->map(function ($order) {
            $order->first_product_name = $order->orderItems->first()->product->name ?? 'N/A';
            return $order;
        });

        return view('admin.orders.index', compact('orders', 'formattedOrders'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        // Eager load user, order items, and their products for the detail view
        $order->load(['user', 'orderItems.product']);

        // Define Jalali date formatting for created_at
        $order->formatted_created_at = \Carbon\Carbon::parse($order->created_at)->format('Y/m/d H:i');

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,shipped,delivered,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->route('admin.orders.index')->with('success', 'وضعیت سفارش با موفقیت به‌روزرسانی شد.');
    }
}