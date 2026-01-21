<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'order_id',
        'category_id',
        'category_name',
        'product_id',
        'product_name',
        'sku_code',
        'product_image',
        'variant_id',
        'variant_name',
        'variant_qty',
        'unit_mrp',
        'unit_price',
        'qty',
        'base_discount',
        'incremental_discount',
        'max_discount',
        'total_discount_amount',
        'total_price',
        'status',
        'product_status'
    ];
    
    public function Order() 
    {
        return $this->belongsTo('App\Models\Order', 'order_id', 'id');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
    
    public function Product() 
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    public function ProductVariant() 
    {
        return $this->belongsTo('App\Models\ProductVariant', 'variant_id', 'id');
    }
}
