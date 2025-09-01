<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccommodationSeason extends Model
{
    protected $fillable = [
        'accommodation_id',
        'season_name',
        'is_special',
        'special_type',
        'start_date',
        'end_date',
    ];
}