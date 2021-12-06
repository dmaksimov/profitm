<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'facebook_campaign_id',
        'name',
        'email',
        'phone_no',
        'status'
    ];

    public function appointments()
    {
        return $this->hasMany(FacebookAppointment::class);
    }
}
