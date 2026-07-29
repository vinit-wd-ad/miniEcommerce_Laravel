<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponCode extends Model
{
    protected $fillable = [
        'code',
        'title',
        'description',
        'type',
        'value',
        'max_discount_amount',
        'min_order_amount',
        'usage_limit_per_user',
        'total_uses',
        'starts_at',
        'expires_at',
        'is_active',
        'short_order',
    ];
}
