<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductFeature extends Model
{
    protected $table = 'product_features';

    protected $fillable = [
        'product_id',
        'feature_id',
        'value',
        'short_order',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function features()
    {
        return $this->belongsTo(Feature::class);
    }
}
