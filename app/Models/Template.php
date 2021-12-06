<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $fillable = [
        'industry_type_id',
        'fields'
    ];

    public $casts = [
        'fields' => 'array'
    ];
}
