<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWishlist extends Model
{
    protected $table = 'user_wishlists';

    protected $fillable = [
        'user_id',
        'product_id',
        'product_variant_id',
    ];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
