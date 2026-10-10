<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\OrderDeliveryMethod;
use App\Enums\OrderPaymentMethod;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'tracking_token',
        'status',
        'payment_status',
        'customer_name',
        'customer_phone',
        'customer_email',
        'delivery_address',
        'comment',
        'subtotal',
        'delivery_cost',
        'delivery_method',
        'payment_method',
        'discount',
        'total',
    ];

    protected function casts(): array
{
    return [
        'status' => OrderStatus::class,
        'delivery_method' => OrderDeliveryMethod::class,
        'payment_method' => OrderPaymentMethod::class,
        'subtotal' => 'decimal:2',
        'delivery_cost' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
    ];
}

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}