<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'short_description',
        'image',
        'price',
        'qty',
        'is_active'
    ];

    public function category() // related category
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function brand() // related brand
    {
        return $this->belongsTo(Brand::class, 'category_id');
    }

    public function images() // multiple images
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItems::class, 'product_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItems::class, 'product_id');
    }

    public function productFeatures()
    {
        return $this->hasMany(ProductFeature::class, 'product_id');
    }

    public function productOffer() 
    {
        return $this->hasMany(ProductOffer::class, 'product_id');
    }
}
