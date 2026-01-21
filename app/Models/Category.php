<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = ['slug'];

    public function Subcategories()
    {
        return $this->hasMany('App\Models\Subcategory', 'category_id');
    }

    public function Products()
    {
        return $this->hasMany('App\Models\Product', 'category_id');
    }
}
