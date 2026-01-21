<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    public function Products()
    {
        return $this->hasMany('App\Models\Product', 'label_id');
    }
}
