<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Order extends Model
{
    use SoftDeletes;

    /** status => [label, warna badge Bootstrap] */
    public const STATUSES = [
        'pending' => ['Menunggu', 'warning'],
        'processing' => ['Diproses', 'info'],
        'shipped' => ['Dikirim', 'primary'],
        'completed' => ['Selesai', 'success'],
        'cancelled' => ['Dibatalkan', 'danger'],
    ];

    public const PAYMENT_METHODS = [
        'transfer' => 'Transfer Bank',
        'cod' => 'Bayar di Tempat (COD)',
    ];

    protected $fillable = [
        'order_code',
        'customer_name',
        'phone',
        'email',
        'address',
        'city',
        'postal_code',
        'notes',
        'payment_method',
        'status',
        'total_amount',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'float',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            $order->order_code ??= static::generateCode();
        });
    }

    public function getRouteKeyName(): string
    {
        return 'order_code';
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateCode(): string
    {
        do {
            $code = 'TK-'.now()->format('ymd').'-'.Str::upper(Str::random(5));
        } while (static::withTrashed()->where('order_code', $code)->exists());

        return $code;
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status][0] ?? ucfirst($this->status);
    }

    public function getStatusColorAttribute(): string
    {
        return self::STATUSES[$this->status][1] ?? 'secondary';
    }

    public function getPaymentLabelAttribute(): string
    {
        return self::PAYMENT_METHODS[$this->payment_method] ?? $this->payment_method;
    }
}
