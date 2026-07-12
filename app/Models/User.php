<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'phone', 'password', 'is_admin'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_admin'          => 'boolean',
        ];
    }

    /* ------------------------------------------------------------------ */
    /*  Relationships                                                        */
    /* ------------------------------------------------------------------ */

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /* ------------------------------------------------------------------ */
    /*  Helpers                                                              */
    /* ------------------------------------------------------------------ */

    public function totalSpent(): int
    {
        return $this->orders()
            ->whereIn('status', ['paid', 'shipped', 'delivered'])
            ->sum('total_price') ?? 0;
    }

    public function formattedTotalSpent(): string
    {
        return \App\Support\Format::price($this->totalSpent());
    }

    /**
     * True when the user has at least one paid/shipped/delivered order
     * that contains the given product.
     */
    public function hasPurchased(Product $product): bool
    {
        return $this->orders()
            ->whereIn('status', ['paid', 'shipped', 'delivered'])
            ->whereHas('items', fn ($q) => $q->where('product_id', $product->id))
            ->exists();
    }

    /**
     * Returns the first matching OrderItem for a verified purchase, or null.
     */
    public function purchasedOrderItem(Product $product): ?OrderItem
    {
        $order = $this->orders()
            ->whereIn('status', ['paid', 'shipped', 'delivered'])
            ->whereHas('items', fn ($q) => $q->where('product_id', $product->id))
            ->latest()
            ->first();

        return $order?->items()->where('product_id', $product->id)->first();
    }
}
