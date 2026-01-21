<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Flavour extends Model
{
    public function Products()
    {
        return $this->hasMany('App\Models\Product', 'flavour_id');
    }
}
