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
        'iso2',
        'iso3',
        'numeric_code',
        'phone_code',
        'capital',
        'tld',
        'native',
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
        'currency_id',
        'region_id',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function hotels()
    {
        return $this->hasMany(Hotel::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}