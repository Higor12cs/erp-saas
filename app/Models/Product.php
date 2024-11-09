<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'sku',
        'name',
        'cost',
        'price',
    ];

    protected $casts = [
        'cost' => 'decimal:2',
        'price' => 'decimal:2',
    ];
}
