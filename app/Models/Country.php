<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function State()
    {
        return $this->hasMany('App\Models\State', 'country_id');
    }
}
