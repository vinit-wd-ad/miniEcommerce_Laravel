<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'logo_url',
        'short_order',
        'is_active',
    ];

    public function product()
    {
        return $this->hasMany(Product::class, 'brand_id');
    }
}
