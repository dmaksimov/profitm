<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndustryType extends Model
{

    use SoftDeletes;
    
    protected $table = 'industry_types';

    protected $fillable = ['title', 'status'];
}

