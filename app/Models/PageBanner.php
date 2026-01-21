<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PageBanner extends Model
{
    public function Page() 
    {
        return $this->belongsTo('App\Models\Page', 'page_id', 'id');
    }
}
