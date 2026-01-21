<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    public function Product() 
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }
}
