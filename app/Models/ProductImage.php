<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'image',
        'is_primary',
        'is_active'
    ];

    public function product() // related product
    {
        return $this->belongsTo(Product::class, 'produc_id');
    }
}
