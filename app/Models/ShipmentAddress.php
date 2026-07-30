<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipmentAddress extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'full_name',
        'phone',
        'alternate_phone',
        'email',
        'address_line_1',
        'address_line_2',
        'landmark',
        'city',
        'state',
        'postal_code',
        'country',
        'address_type',
        'short_order'
    ];

    public function order() 
    {
        return $this->belongsTo(Order::class);
    }

    public function user() 
    {
        return $this->belongsTo(User::class);
    }
}
