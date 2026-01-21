<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    protected $fillable = ['payment_id', 'event', 'payload'];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
