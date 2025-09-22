<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RateDetail extends Model
{
    protected $fillable = [
        'rate_id',
        'room_type_id',
        'price',
        'price_type',
    ];
}