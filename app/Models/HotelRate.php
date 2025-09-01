<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelRate extends Model
{
    protected $fillable = [
        'accommodation_id',
        'room_type',
        'meal_plan',
        'price',
        'currency_id',
        'hotel_id',
        'season_id',
        'hotel_season_id',
        'room_type_id',
        'rate_per_person',
        'single_supplement',
    ];
}