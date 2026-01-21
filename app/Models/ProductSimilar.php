<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSimilar extends Model
{
    public function Product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    public function Products()
    {
        return $this->hasMany('App\Models\Product', 'id', 'similar_id')->where('status',1);
    }
}
