<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * List reviews with filters.
     * GET /admin/reviews
     */
    public function index(Request $request)
    {
        $query = Review::with(['product', 'user'])->latest();

        if ($request->filled('status')) {
            if ($request->status === 'pending') {
                $query->where('is_approved', false);
            } elseif ($request->status === 'approved') {
                $query->where('is_approved', true);
            }
        }

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->filled('rating')) {
            $query->where('rating', (int) $request->rating);
        }

        if ($request->filled('verified')) {
            $query->where('is_verified_purchase', (bool) $request->verified);
        }

        $reviews      = $query->paginate(20)->withQueryString();
        $products     = Product::orderBy('name')->get(['id', 'name']);
        $pendingCount = Review::where('is_approved', false)->count();

        return view('admin.reviews.index', compact('reviews', 'products', 'pendingCount'));
    }

    /**
     * Show a single review for moderation.
     * GET /admin/reviews/{review}
     */
    public function show(Review $review)
    {
        $review->load(['product', 'user', 'orderItem']);
        return view('admin.reviews.show', compact('review'));
    }

    /**
     * Approve a review.
     * POST /admin/reviews/{review}/approve
     */
    public function approve(Review $review)
    {
        $review->update([
            'is_approved' => true,
            'approved_at' => now(),
        ]);

        return back()->with('success', 'نظر با موفقیت تأیید شد.');
    }

    /**
     * Reject (hide) an approved review.
     * POST /admin/reviews/{review}/reject
     */
    public function reject(Review $review)
    {
        $review->update([
            'is_approved' => false,
            'approved_at' => null,
        ]);

        return back()->with('success', 'نظر رد شد و از نمایش عمومی حذف شد.');
    }

    /**
     * Delete a review permanently.
     * DELETE /admin/reviews/{review}
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'نظر با موفقیت حذف شد.');
    }

    /**
     * Save or update admin reply.
     * POST /admin/reviews/{review}/reply
     */
    public function reply(Request $request, Review $review)
    {
        $validated = $request->validate([
            'admin_reply' => ['required', 'string', 'max:1000'],
        ], [
            'admin_reply.required' => 'متن پاسخ الزامی است.',
            'admin_reply.max'      => 'پاسخ نباید بیشتر از ۱۰۰۰ کاراکتر باشد.',
        ]);

        $review->update(['admin_reply' => $validated['admin_reply']]);

        return back()->with('success', 'پاسخ مدیر با موفقیت ثبت شد.');
    }
}
