<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerPaymentProfile extends Model
{
    protected $fillable = [
        'user_id',
        'customer_profile_id',
        'payment_profile_id',
        'card_type',
        'card_last_four',
        'default',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
