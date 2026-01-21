<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    public function Country() 
    {
        return $this->belongsTo('App\Models\Country', 'country_id', 'id');
    }
}
