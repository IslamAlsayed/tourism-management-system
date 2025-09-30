<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
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
        'photo',
        'continent',
        'area',
        'is_active',
        'currency_id',
        'region_id',
    ];

    public function getRelationshipNames()
    {
        return ['currency', 'region'];
    }

    public function getExcludedColumns()
    {
        return ['currency_id', 'region_id',];
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}