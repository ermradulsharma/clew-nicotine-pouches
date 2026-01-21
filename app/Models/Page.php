<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public function Banners()
    {
        return $this->hasMany('App\Models\PageBanner', 'page_id');
    }
}
