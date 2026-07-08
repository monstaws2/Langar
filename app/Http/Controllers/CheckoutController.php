<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);

        $cartItems = [];
        $total = 0;

        if (!empty($cart)) {
            $products = Product::with('category')->whereIn('id', array_keys($cart))->get();

            foreach ($products as $product) {
                $quantity = (int) ($cart[$product->id] ?? 0);
                if ($quantity < 1) {
                    continue;
                }

                // Skip out of stock items
                if ($product->stock < 1) {
                    continue;
                }

                // Cap quantity at available stock
                $quantity = min($quantity, $product->stock);

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

        // If cart is empty after filtering, redirect
        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'سبد خرید شما خالی است یا محصولات ناموجود شده‌اند.');
        }

        return view('checkout.index', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
                $request->validate([
            'name' => 'required|string|max:255',
            'phone' => ['required', 'string', 'regex:/^09[0-9]{9}$/'],
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'postal_code' => ['required', 'string', 'regex:/^[0-9]{10}$/'],
        ], [
            'name.required' => 'لطفاً نام و نام خانوادگی خود را وارد کنید.',
            'phone.required' => 'لطفاً شماره تماس خود را وارد کنید.',
            'phone.regex' => 'شماره موبایل باید ۱۱ رقم باشد و با ۰۹ شروع شود.',
            'address.required' => 'لطفاً آدرس خود را وارد کنید.',
            'city.required' => 'لطفاً شهر خود را وارد کنید.',
            'postal_code.required' => 'لطفاً کد پستی خود را وارد کنید.',
            'postal_code.regex' => 'کد پستی باید دقیقاً ۱۰ رقم باشد.',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'سبد خرید شما خالی است.');
        }

        // Validate stock and calculate totals within a transaction
        $products = Product::whereIn('id', array_keys($cart))->lockForUpdate()->get();
        $total = 0;
        $orderItemsData = [];

        foreach ($products as $product) {
            $quantity = (int) ($cart[$product->id] ?? 0);
            if ($quantity < 1) {
                continue;
            }

            // Check stock availability
            if ($product->stock < $quantity) {
                return redirect()->route('cart.index')
                    ->with('error', 'موجودی محصول «' . $product->name . '» کافی نیست. موجودی فعلی: ' . \App\Support\Format::digits($product->stock) . ' عدد');
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

        if (empty($orderItemsData)) {
            return redirect()->route('cart.index')->with('error', 'سبد خرید شما خالی است.');
        }

        // Create order and items in a transaction
        $order = DB::transaction(function () use ($request, $total, $orderItemsData, $cart) {
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

            // Generate order number after we have the ID
            $order->update([
                'order_number' => 'LM-' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
            ]);

            // Create order items
            foreach ($orderItemsData as $itemData) {
                OrderItem::create(array_merge($itemData, ['order_id' => $order->id]));

                // Decrement product stock
                Product::where('id', $itemData['product_id'])->decrement('stock', $itemData['quantity']);
            }

            return $order;
        });

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
