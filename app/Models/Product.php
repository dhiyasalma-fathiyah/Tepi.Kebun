<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'product_name',
        'slug',
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
            'weight_per_box' => 'float',
            'price_per_box' => 'float',
            'stock' => 'integer',
        ];
    }

    // ---------- Relasi ----------

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // ---------- Scope ----------

    public function scopeInStock(Builder $query): Builder
    {
        return $query->where('stock', '>', 0);
    }

    // ---------- Accessor ----------

    /**
     * URL foto produk, atau null bila belum ada (view menampilkan fallback).
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }

    // ---------- Helper ----------

    /**
     * Slug unik dari nama produk (memperhitungkan data yang sudah di-soft delete).
     */
    public static function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 2;

        while (static::withTrashed()
            ->where('slug', $slug)
            ->when($ignoreId, fn (Builder $q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
