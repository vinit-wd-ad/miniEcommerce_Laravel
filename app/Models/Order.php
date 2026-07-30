<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'sub_total',
        'coupan_code_id',
        'coupan_code',
        'coupan_discount',
        'shipping_charge',
        'tax_amount',
        'total_amount',
        'status',
        'shipping_address',
        'payment_status'
    ];


    public function user() {
        return $this->belongsTo(User::class);
    }

    public function coupon()
    {
        return $this->belongsTo(CouponCode::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItems::class, 'order_id');
    }

    public function shipment()
    {
        return $this->hasMany(Shipment::class, 'order_id');
    }

    public function shipmentAddress() 
    {
        return $this->hasMany(ShipmentAddress::class, 'order_id');
    }
}
