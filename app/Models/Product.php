<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

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
        ];
    }

    /** Relasi: satu produk bisa memiliki banyak pesan/permintaan penawaran. */
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    /** Scope: cari berdasarkan nama atau kategori. */
    public function scopeSearch(Builder $query, ?string $keyword): Builder
    {
        return $query->when($keyword, fn (Builder $q) => $q->where(
            fn (Builder $w) => $w->where('product_name', 'like', "%{$keyword}%")
                ->orWhere('category', 'like', "%{$keyword}%")
        ));
    }

    /** Scope: filter berdasarkan grade (A/B). */
    public function scopeGrade(Builder $query, ?string $grade): Builder
    {
        return $query->when($grade, fn (Builder $q) => $q->where('grade', $grade));
    }

    /** Accessor: harga dalam format Rupiah. */
    protected function formattedPrice(): Attribute
    {
        return Attribute::get(fn () => 'Rp ' . number_format((float) $this->price_per_box, 0, ',', '.'));
    }

    /** Accessor: kelas warna kartu sesuai jenis buah. */
    protected function cardColor(): Attribute
    {
        return Attribute::get(function () {
            $text = strtolower($this->product_name . ' ' . $this->category);

            return match (true) {
                str_contains($text, 'pisang') => 'banana',
                str_contains($text, 'jeruk') => 'orange',
                str_contains($text, 'mangga') => 'mango',
                str_contains($text, 'stroberi'), str_contains($text, 'strawberry') => 'strawberry',
                default => 'grape',
            };
        });
    }
}
