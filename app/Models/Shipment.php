<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = [
        'order_id',
        'tracking_number',
        'courier_name',
        'tracking_url',
        'status',
        'shipped_at',
        'estimated_delivery_at',
        'delivered_at',
        'notes',
        'short_order',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
