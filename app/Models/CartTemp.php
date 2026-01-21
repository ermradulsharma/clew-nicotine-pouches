<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartTemp extends Model
{
    public function Product() 
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    public function ProductVariant() 
    {
        return $this->belongsTo('App\Models\ProductVariant', 'variant_id', 'id');
    }
}
