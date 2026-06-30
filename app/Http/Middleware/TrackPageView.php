<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use App\Models\Product;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class TrackPageView
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track successful responses
        if ($response->status() === 200) {
            // Check if we're on a product page
            $productId = null;
            if (Route::currentRouteName() === 'products.show') {
                $product = $request->route('product');
                if ($product instanceof Product) {
                    $productId = $product->id;
                } elseif (is_string($product)) {
                    // If slug is passed, try to find product
                    $productModel = Product::where('slug', $product)->first();
                    if ($productModel) {
                        $productId = $productModel->id;
                    }
                }
            }

            // Create page view record
            PageView::create([
                'page_url' => $request->fullUrl(),
                'product_id' => $productId,
                'user_id' => $request->user()?->id,
                'ip_address' => $request->ip(),
                'visited_at' => now(),
            ]);
        }

        return $response;
    }
}