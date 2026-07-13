<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'description', 'image',
        'price', 'stock', 'category_id', 'brand_id', 'is_active',
        'meta_title', 'meta_description', 'seo_tags', 'canonical_url',
    ];

    /* ------------------------------------------------------------------ */
    /*  Relationships */
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

    /** Motorcycle models this product is compatible with (used for SEO tag fallback). */
    public function motorcycleModels()
    {
        return $this->belongsToMany(MotorcycleModel::class, 'product_motorcycle_models');
    }

    /* ------------------------------------------------------------------ */
    /*  Aggregate helpers */
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

    /* ------------------------------------------------------------------ */
    /*  SEO helpers */
    /* */
    /*  These fields are all optional (nullable) — a store owner does not */
    /*  have to fill them in. Every method below returns a safe fallback */
    /*  built from real product data so every product always has usable */
    /*  SEO output, even if the admin left the SEO section empty. */
    /* ------------------------------------------------------------------ */

    /** SEO title: falls back to the product name. */
    public function seoTitle(): string
    {
        return $this->meta_title ?: $this->name;
    }

    /** SEO meta description: falls back to a summary built from name, brand, category and description. */
    public function seoMetaDescription(): string
    {
        if (! empty($this->meta_description)) {
            return $this->meta_description;
        }

        $parts = array_filter([
            $this->name,
            $this->brand?->name,
            $this->category?->name,
        ]);

        $summary = implode(' - ', $parts);

        if (! empty($this->description)) {
            $summary .= ' | '.Str::limit(strip_tags($this->description), 100);
        }

        return Str::limit($summary, 160);
    }

    /**
     * SEO tags/keywords: falls back to a comma-separated list built from the
     * product name, brand, category and compatible motorcycle models.
     */
    public function seoTagsList(): string
    {
        if (! empty($this->seo_tags)) {
            return $this->seo_tags;
        }

        $tags = array_filter([
            $this->name,
            $this->brand?->name,
            $this->category?->name,
        ]);

        foreach ($this->motorcycleModels as $model) {
            $tags[] = $model->name;
        }

        return implode('، ', array_unique(array_filter($tags)));
    }

    /** Canonical URL: falls back to the product's own storefront URL. */
    public function seoCanonicalUrl(): string
    {
        return $this->canonical_url ?: route('products.show', $this->slug);
    }

    /** Whether the store owner has filled in the core SEO fields for this product. */
    public function hasCompleteSeo(): bool
    {
        return ! empty($this->meta_title) && ! empty($this->meta_description);
    }

    /** Auto-generate a unique slug from the product name (used when the admin leaves slug empty). */
    public static function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'product';
        $slug = $base;
        $i = 2;

        while (
            static::withTrashed()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base.'-'.$i;
            $i++;
        }

        return $slug;
    }
}
