<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'amount',
        'currency',
        'status',
        'payment_method',
        'transaction_id',
        'authorization_code',
        'response_code',
        'response_message',
        'paid_at',
    ];

    protected $dates = ['paid_at'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function logs()
    {
        return $this->hasMany(PaymentLog::class);
    }
}
