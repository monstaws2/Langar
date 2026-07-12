<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', 1)->with(['category', 'brand']);

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }

        $sort = $request->get('sort', 'latest');
        match ($sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name'       => $query->orderBy('name', 'asc'),
            default      => $query->latest(),
        };

        $products   = $query->paginate(12)->withQueryString();
        $categories = Category::where('is_active', true)->get();
        $brands     = Brand::all();

        return view('products.index', compact('products', 'categories', 'brands', 'sort'));
    }

    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)
            ->with(['category', 'brand'])
            ->firstOrFail();

        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        // Approved reviews paginated (8 per page)
        $reviews = $product->reviews()
            ->with('user')
            ->where('is_approved', true)
            ->latest()
            ->paginate(8, ['*'], 'reviews_page');

        $averageRating = $product->averageRating();
        $reviewsCount  = $product->reviewsCount();

        // Star-distribution for approved reviews (5 down to 1)
        $ratingDistribution = [];
        if ($reviewsCount > 0) {
            for ($i = 5; $i >= 1; $i--) {
                $count = $product->approvedReviews()->where('rating', $i)->count();
                $ratingDistribution[$i] = [
                    'count'   => $count,
                    'percent' => (int) round(($count / $reviewsCount) * 100),
                ];
            }
        }

        // Determine review eligibility for authenticated users
        $userReview          = null;
        $canReview           = false;
        $isVerifiedPurchaser = false;

        if (Auth::check()) {
            $user                = Auth::user();
            $userReview          = $user->reviews()->where('product_id', $product->id)->first();
            $canReview           = $userReview === null;
            $isVerifiedPurchaser = $user->hasPurchased($product);
        }

        return view('products.show', compact(
            'product',
            'related',
            'reviews',
            'averageRating',
            'reviewsCount',
            'ratingDistribution',
            'userReview',
            'canReview',
            'isVerifiedPurchaser',
        ));
    }
}
