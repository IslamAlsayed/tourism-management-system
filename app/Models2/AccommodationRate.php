<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccommodationRate extends Model
{
    protected $fillable = [
        'accommodation_id',
        'room_type',
        'meal_plan',
        'price',
        'currency_id',
        'season_id',
    ];
}
