<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'description', 'image',
        'price', 'stock', 'category_id', 'brand_id', 'is_active',
    ];

    /* ------------------------------------------------------------------ */
    /*  Relationships                                                        */
    /* ------------------------------------------------------------------ */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    /* ------------------------------------------------------------------ */
    /*  Aggregate helpers                                                    */
    /* ------------------------------------------------------------------ */

    /** Average star rating across approved reviews, rounded to 1 decimal. */
    public function averageRating(): ?float
    {
        $avg = $this->approvedReviews()->avg('rating');
        return $avg ? round((float) $avg, 1) : null;
    }

    /** Count of approved reviews. */
    public function reviewsCount(): int
    {
        return $this->approvedReviews()->count();
    }
}
