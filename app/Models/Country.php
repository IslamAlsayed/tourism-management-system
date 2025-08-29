<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_ar',
        'iso3',
        'iso2',
        'numeric_code',
        'phone_code',
        'capital',
        'currency_id',
        'tld',
        'native',
        'region',
        'region_id',
        'subregion',
        'subregion_id',
        'nationality',
        'timezone',
        'latitude',
        'longitude',
        'emoji',
        'emojiU',
        'population',
        'flag_url',
        'flag_emoji',
        'continent',
        'area',
        'is_active',
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}