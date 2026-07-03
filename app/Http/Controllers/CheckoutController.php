<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);

        $cartItems = [];
        $total = 0;

        if (!empty($cart)) {
            $products = \App\Models\Product::with('category')->whereIn('id', array_keys($cart))->get();

            foreach ($products as $product) {
                $quantity = (int) ($cart[$product->id] ?? 0);
                if ($quantity < 1) {
                    continue;
                }

                $lineTotal = $product->price * $quantity;
                $total += $lineTotal;

                $cartItems[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'line_total' => $lineTotal,
                    'image' => $product->image,
                    'category_icon' => $product->category?->icon ?? 'package',
                ];
            }
        }

        return view('checkout.index', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
        ], [
            'name.required' => 'لطفاً نام و نام خانوادگی خود را وارد کنید.',
            'phone.required' => 'لطفاً شماره تماس خود را وارد کنید.',
            'address.required' => 'لطفاً آدرس خود را وارد کنید.',
            'city.required' => 'لطفاً شهر خود را وارد کنید.',
            'postal_code.required' => 'لطفاً کد پستی خود را وارد کنید.',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'سبد خرید شما خالی است.');
        }

        // Calculate total from cart
        $products = \App\Models\Product::whereIn('id', array_keys($cart))->get();
        $total = 0;
        $orderItemsData = [];

        foreach ($products as $product) {
            $quantity = (int) ($cart[$product->id] ?? 0);
            if ($quantity < 1) {
                continue;
            }

            $lineTotal = $product->price * $quantity;
            $total += $lineTotal;

            $orderItemsData[] = [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'total_price' => $lineTotal,
            ];
        }

        // Create order
        $order = Order::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'total_price' => $total,
            'status' => 'pending',
        ]);

        // Create order items
        foreach ($orderItemsData as $itemData) {
            OrderItem::create(array_merge($itemData, ['order_id' => $order->id]));
        }

        // Clear cart
        session(['cart' => []]);

        return redirect()->route('checkout.confirmation', ['order' => $order->id])
            ->with('success', 'سفارش شما با موفقیت ثبت شد.');
    }

    public function confirmation(Order $order)
    {
        // Verify user owns this order (if logged in) or allow guest access
        if (auth()->check() && $order->user_id && $order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items');
        return view('checkout.confirmation', compact('order'));
    }
}