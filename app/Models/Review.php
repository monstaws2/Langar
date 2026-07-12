<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'order_item_id',
        'rating',
        'title',
        'body',
        'is_approved',
        'is_verified_purchase',
        'admin_reply',
        'approved_at',
    ];

    protected $casts = [
        'rating'               => 'integer',
        'is_approved'          => 'boolean',
        'is_verified_purchase' => 'boolean',
        'approved_at'          => 'datetime',
    ];

    /* ------------------------------------------------------------------ */
    /*  Relationships                                                        */
    /* ------------------------------------------------------------------ */

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    /* ------------------------------------------------------------------ */
    /*  Scopes                                                               */
    /* ------------------------------------------------------------------ */

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }
}
