<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);

        $cartItems = [];
        $total = 0;

        if (! empty($cart)) {
            $products = Product::with('category')->whereIn('id', array_keys($cart))->get();

            foreach ($products as $product) {
                $quantity = (int) ($cart[$product->id] ?? 0);
                if ($quantity < 1) {
                    continue;
                }

                $lineTotal = $product->price * $quantity;
                $total += $lineTotal;

                $cartItems[] = (object) [
                    'id'             => $product->id,
                    'name'           => $product->name,
                    'slug'           => $product->slug,
                    'price'          => $product->price,
                    'image'          => $product->image,
                    'category_icon'  => $product->category?->icon ?? 'package',
                    'quantity'       => $quantity,
                    'line_total'     => $lineTotal,
                    'stock'          => $product->stock,
                    'out_of_stock'   => $product->stock < 1,
                    'exceeds_stock'  => $quantity > $product->stock,
                ];
            }
        }

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        // Check if product is in stock
        if ($product->stock < 1) {
            return redirect()->back()->with('error', 'متأسفانه این محصول در حال حاضر موجود نیست.');
        }

        $cart = session('cart', []);
        $currentQty = $cart[$product->id] ?? 0;

        // Check if adding one more would exceed stock
        if ($currentQty + 1 > $product->stock) {
            return redirect()->back()->with('warning', 'تعداد درخواستی بیشتر از موجودی انبار است. موجودی فعلی: ' . \App\Support\Format::digits($product->stock) . ' عدد');
        }

        $cart[$product->id] = $currentQty + 1;
        session(['cart' => $cart]);

        return redirect()->back()->with('success', 'محصول به سبد خرید اضافه شد.');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:999',
        ]);

        $requestedQty = (int) $request->quantity;

        // Check stock
        if ($requestedQty > $product->stock) {
            return redirect()->route('cart.index')->with('error', 'تعداد درخواستی بیشتر از موجودی انبار است. موجودی فعلی: ' . \App\Support\Format::digits($product->stock) . ' عدد');
        }

        $cart = session('cart', []);
        $cart[$product->id] = $requestedQty;
        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', 'تعداد محصول به‌روزرسانی شد.');
    }

    public function remove(Product $product)
    {
        $cart = session('cart', []);
        unset($cart[$product->id]);
        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', 'محصول از سبد خرید حذف شد.');
    }

    public function clear()
    {
        session(['cart' => []]);

        return redirect()->route('cart.index')->with('success', 'سبد خرید پاک شد.');
    }
}
