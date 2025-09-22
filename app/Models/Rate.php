<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $fillable = [
        'price',
        'currency_id',
        'accommodation_id',
        'season_id',
        'room_type_id',
    ];
}