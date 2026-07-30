<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOffer extends Model
{
    protected $table = 'product_offers';

    protected $fillable = [
        'product_id',
        'title',
        'description',
        'discount_type',
        'discount_value',
        'image',
        'sort_offer',
        'is_banner',
        'is_active',
        'start_date',
        'end_date'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
