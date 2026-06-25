<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        // TODO: Get cart items from session/database
        $cartItems = [];
        $total = 0;

        return view('cart.index', compact('cartItems', 'total'));
    }
}
