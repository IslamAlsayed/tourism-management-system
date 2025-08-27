<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airline extends Model
{
    use HasFactory;

    protected $fillable = [
        'iata_code',
        'icao_code',
        'parent_airline_icao_code',
        'marketing_name',
        'official_full_name',
        'alliance',
        'frequent_flyer_program_name',
        'airline_type',
        'airline_type_code',
        'is_lowcost',
        'airline_home_country',
        'airline_home_country_alpha_2_code',
        'airline_home_country_alpha_3_code',
        'airline_home_city_iata_code',
        'year_of_foundation',
        'email',
        'official_website',
        'baggage_policy_url',
        'web_check_in_url'
    ];
}