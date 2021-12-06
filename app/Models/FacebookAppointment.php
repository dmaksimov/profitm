<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacebookAppointment extends Model
{
    protected $fillable = [
        'facebook_campaign_id',
        'customer_id',
        'date',
        'start_time',
        'end_time',
        'status'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }
}
