<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    public function Product() 
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    public function Strength() 
    {
        return $this->belongsTo('App\Models\Strength', 'strength_id', 'id');
    }

    public function Images()
    {
        return $this->hasMany('App\Models\ProductImage', 'variant_id');
    }
}
