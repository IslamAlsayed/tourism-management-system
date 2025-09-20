<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccommodationSeason extends Model
{
    protected $fillable = [
        'season_name',
        'season_from',
        'season_to',
        'is_special',
        'special_type',
        'accommodation_id',
    ];
}