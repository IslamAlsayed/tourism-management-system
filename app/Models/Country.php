<?php

namespace App\Models;

use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasSearch;

    protected $fillable = [
        'id',
        'photo',
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
        'population',
        'continent',
        'area',
        'is_active',
        'is_independent',
        'is_developed',
        'is_landlocked',
        'language_id',
        'currency_id',
        'region_id',
        'subregion_id',
        'state_id',
        'city_id',
    ];

    public function getRelationshipNames()
    {
        return ['language', 'currency', 'region', 'subregion', 'state', 'city'];
    }

    public function getExcludedColumns()
    {
        return ['language_id', 'currency_id', 'region_id', 'subregion_id', 'state_id', 'city_id'];
    }
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function subregion()
    {
        return $this->belongsTo(Subregion::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}