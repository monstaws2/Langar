<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotorcycleModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'name',
        'year_from',
        'year_to',
        'is_active',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_motorcycle_models');
    }
}