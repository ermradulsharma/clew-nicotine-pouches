<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['slug'];

    public function Category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

    public function Flavour()
    {
        return $this->belongsTo('App\Models\Flavour', 'flavour_id', 'id');
    }

    public function Images()
    {
        return $this->hasMany('App\Models\ProductImage', 'product_id');
    }

    public function PreferredImage()
    {
        return $this->hasMany('App\Models\ProductImage', 'product_id')->where('preferred', 1)->where('status', 1);
    }

    public function Variants()
    {
        return $this->hasMany('App\Models\ProductVariant', 'product_id');
    }

    public function Similar()
    {
        return $this->hasMany('App\Models\ProductSimilar', 'product_id');
    }

    public function Reviews()
    {
        return $this->hasMany('App\Models\ProductReview', 'product_id');
    }

    public function getSelectedStrengthsAttribute()
    {
        return $this->variants->pluck('strength_id')->unique()->values()->all(); // returns array
    }
}
