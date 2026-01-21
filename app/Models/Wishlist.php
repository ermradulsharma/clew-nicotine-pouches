<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    public function Product() 
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }
    
    public function User() 
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
