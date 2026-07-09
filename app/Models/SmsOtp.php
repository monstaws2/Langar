<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsOtp extends Model
{
    protected $fillable = ['phone', 'code', 'expires_at', 'is_used'];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'is_used' => 'boolean',
        ];
    }
}