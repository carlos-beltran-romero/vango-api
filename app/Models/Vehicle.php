<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'brand',
        'price_per_day',
        'description',
        'images',
        'features',
        'capacity',
        'transmission',
        'fuel',
        'is_active',
    ];

    protected $casts = [
        'images' => 'array',
        'features' => 'array',
        'is_active' => 'boolean',
        'price_per_day' => 'decimal:2',
    ];
}