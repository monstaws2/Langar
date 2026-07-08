<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display the customer dashboard with order summary.
     */
    public function dashboard()
    {
        $user = Auth::user();

        $orders = Order::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'total_orders' => Order::where('user_id', $user->id)->count(),
            'pending_orders' => Order::where('user_id', $user->id)->where('status', 'pending')->count(),
            'delivered_orders' => Order::where('user_id', $user->id)->where('status', 'delivered')->count(),
            'total_spent' => Order::where('user_id', $user->id)
                ->whereIn('status', ['paid', 'shipped', 'delivered'])
                ->sum('total_price'),
        ];

        return view('dashboard', compact('orders', 'stats'));
    }

    /**
     * Display a listing of the user's orders.
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Security: user can only view their own orders
        if ($order->user_id !== Auth::id()) {
            abort(403, 'شما اجازه دسترسی به این سفارش را ندارید.');
        }

        $order->load('items');

        return view('orders.show', compact('order'));
    }
}
