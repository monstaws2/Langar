<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a new review.
     * POST /products/{slug}/reviews
     */
    public function store(Request $request, string $slug)
    {
        $product = Product::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $user    = Auth::user();

        // One review per user per product
        if ($user->reviews()->where('product_id', $product->id)->exists()) {
            return back()->with('error', 'شما قبلاً برای این محصول نظر ثبت کرده‌اید.');
        }

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'title'  => ['nullable', 'string', 'max:200'],
            'body'   => ['required', 'string', 'min:10', 'max:2000'],
        ], [
            'rating.required' => 'لطفاً امتیاز محصول را انتخاب کنید.',
            'rating.integer'  => 'امتیاز نامعتبر است.',
            'rating.min'      => 'امتیاز باید بین ۱ تا ۵ باشد.',
            'rating.max'      => 'امتیاز باید بین ۱ تا ۵ باشد.',
            'body.required'   => 'متن نظر الزامی است.',
            'body.min'        => 'نظر شما باید حداقل ۱۰ کاراکتر باشد.',
            'body.max'        => 'نظر شما نباید بیشتر از ۲۰۰۰ کاراکتر باشد.',
            'title.max'       => 'عنوان نظر نباید بیشتر از ۲۰۰ کاراکتر باشد.',
        ]);

        $isVerified = $user->hasPurchased($product);
        $orderItem  = $isVerified ? $user->purchasedOrderItem($product) : null;

        Review::create([
            'product_id'           => $product->id,
            'user_id'              => $user->id,
            'order_item_id'        => $orderItem?->id,
            'rating'               => $validated['rating'],
            'title'                => $validated['title'] ?? null,
            'body'                 => $validated['body'],
            'is_approved'          => false,
            'is_verified_purchase' => $isVerified,
        ]);

        return back()->with('success', 'نظر شما با موفقیت ثبت شد و پس از بررسی مدیر نمایش داده خواهد شد.');
    }
}
