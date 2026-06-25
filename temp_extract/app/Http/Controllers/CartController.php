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
            $products = Product::whereIn('id', array_keys($cart))->get();

            foreach ($products as $product) {
                $quantity = (int) ($cart[$product->id] ?? 0);
                if ($quantity < 1) {
                    continue;
                }

                $lineTotal = $product->price * $quantity;
                $total += $lineTotal;

                $cartItems[] = (object) [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'line_total' => $lineTotal,
                ];
            }
        }

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $cart = session('cart', []);
        $cart[$product->id] = ($cart[$product->id] ?? 0) + 1;
        session(['cart' => $cart]);

        return redirect()->back()->with('success', 'محصول به سبد خرید اضافه شد.');
    }

    public function remove(Product $product)
    {
        $cart = session('cart', []);
        unset($cart[$product->id]);
        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', 'محصول از سبد خرید حذف شد.');
    }
}
