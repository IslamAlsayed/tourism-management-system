<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country_id',
        'country_code',
        'country_name',
        'iso2',
        'iso3166_2',
        'fips_code',
        'type',
        'level',
        'parent_id',
        'latitude',
        'longitude',
        'timezone'
    ];
}