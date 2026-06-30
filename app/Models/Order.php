<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_phone',
        'product_name',
        'amount',
        'status',
        'ordered_at',
    ];

    protected $casts = [
        'ordered_at' => 'date',
        'amount' => 'integer',
    ];

    public function statusLabel(): string
    {
        return match ($this->status) {
            'pending' => 'در انتظار',
            'shipped' => 'ارسال شد',
            'completed' => 'تکمیل',
            'cancelled' => 'لغو شده',
            default => $this->status,
        };
    }

    public function statusColor(): string
    {
        return match ($this->status) {
            'pending' => 'amber',
            'shipped' => 'blue',
            'completed' => 'green',
            'cancelled' => 'red',
            default => 'gray',
        };
    }
}
