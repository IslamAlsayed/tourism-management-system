<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    use HasFactory;

    protected $fillable = [
        'icao',
        'iata',
        'airport_name',
        'city',
        'subd',
        'country',
        'elevation',
        'latitude',
        'longitude',
        'time_zone',
        'lid',
        'local_phone_number',
        'international_phone_number',
        'website'
    ];
}