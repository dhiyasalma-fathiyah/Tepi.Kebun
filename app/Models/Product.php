<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'product_name',
        'category',
        'grade',
        'ripeness_percentage',
        'weight_per_box',
        'price_per_box',
        'stock',
        'description',
        'image',
    ];

    protected function casts(): array
    {
        return [
            'ripeness_percentage' => 'integer',
            'weight_per_box' => 'decimal:2',
            'price_per_box' => 'decimal:2',
            'stock' => 'integer',
            'deleted_at' => 'datetime',
        ];
    }
}