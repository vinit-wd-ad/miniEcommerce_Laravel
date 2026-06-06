<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'short_description',
        'image',
        'price',
        'qty'
    ];

    public function category() // related category
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function images() // multiple images
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
}
