<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponUser extends Model
{
    protected $fillable = [
        'coupan_id',
        'user_id',
        'order_id'
    ];

    public function coupan()
    {
        return $this->belongsTo(CouponCode::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
