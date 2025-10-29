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
        return ['language', 'currency', 'region', 'subregion'];
    }

    public function getExcludedColumns()
    {
        return ['language_id', 'currency_id', 'region_id', 'subregion_id'];
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

    public function states()
    {
        if (!$this->state_id)
            return [];
        return State::whereIn('id', explode(',', $this->state_id))->get()->toArray();
    }

    public function cities()
    {
        if (!$this->city_id)
            return [];
        return City::whereIn('id', explode(',', $this->city_id))->get()->toArray();
    }

    public function getStateListAttribute()
    {
        if (!$this->state_id)
            return [];
        return State::whereIn('id', explode(',', $this->state_id))->get(['id', 'name'])->toArray();
    }

    public function getCityListAttribute()
    {
        if (!$this->city_id)
            return [];
        return City::whereIn('id', explode(',', $this->city_id))->get(['id', 'name'])->toArray();
    }

    public function getStateIdAttribute($value)
    {
        return $value ?: "";
    }

    public function setStateIdAttribute($value)
    {
        $this->attributes['state_id'] = is_array($value) ? implode(',', $value) : $value;
    }

    public function getCityIdAttribute($value)
    {
        return $value ?: "";
    }

    public function setCityIdAttribute($value)
    {
        $this->attributes['city_id'] = is_array($value) ? implode(',', $value) : $value;
    }
}