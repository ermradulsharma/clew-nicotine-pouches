<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'name',
        'first_name',
        'last_name',
        'email',
        'mobile',
        'apartment',
        'address',
        'city',
        'state',
        'country',
        'pincode',

        'billing_name',
        'billing_first_name',
        'billing_last_name',
        'billing_mobile',
        'billing_apartment',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_country',
        'billing_pincode',

        'sub_total',
        'total',
        'shipping_method',
        'shipping_total',
        'tax',

        'coupon_code',
        'coupon_discount',
        'coupon_amount',
        'grand_total',

        'order_status',
        'payment_status',
        'payment_mode',

        'pg_id',
        'pg_amount',
        'pg_status'
    ];

    public function Cart()
    {
        return $this->hasMany(Cart::class, 'order_id');
    }

    public function carts()
    {
        return $this->belongsToMany(Cart::class);
    }

    public function cartProduct()
    {
        return $this->hasMany(Cart::class, 'order_id');
    }
}
