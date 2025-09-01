<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelSeason extends Model
{
    protected $fillable = [
        'accommodation_id',
        'season_name',
        'start_date',
        'end_date',
    ];
}
