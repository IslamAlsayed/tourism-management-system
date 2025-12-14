<?php

namespace App\Models;

use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class TourGuideType extends Model
{
    use HasSearch, HasUuid;

    protected $fillable = [
        'id',
        'uuid',
        'type',
        'price',
        'all_states',
        'all_cities',
        'currency_id',
        'region_id',
        'subregion_id',
        'country_id',
        'state_id',
        'city_id',
    ];

    /**
     * Get relationship names for eager loading
     */
    public function getRelationshipNames()
    {
        return ['currency', 'region', 'subregion', 'country', 'state', 'city'];
    }

    /**
     * Get columns to exclude from search/display
     */
    public function getExcludedColumns()
    {
        return ['currency_id', 'region_id', 'subregion_id', 'country_id', 'state_id', 'city_id'];
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

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    // public function states()
    // {
    //     if (!$this->state_id)
    //         return [];
    //     return State::whereIn('id', explode(',', $this->state_id))->get()->toArray();
    // }

    // public function cities()
    // {
    //     if (!$this->city_id)
    //         return [];
    //     return City::whereIn('id', explode(',', $this->city_id))->get()->toArray();
    // }

    // public function getStateListAttribute()
    // {
    //     if (!$this->state_id)
    //         return [];
    //     return State::whereIn('id', explode(',', $this->state_id))->get(['id', 'name'])->toArray();
    // }

    // public function getCityListAttribute()
    // {
    //     if (!$this->city_id)
    //         return [];
    //     return City::whereIn('id', explode(',', $this->city_id))->get(['id', 'name'])->toArray();
    // }

    // public function getStateIdAttribute($value)
    // {
    //     return $value ?: "";
    // }

    // public function setStateIdAttribute($value)
    // {
    //     $this->attributes['state_id'] = is_array($value) ? implode(',', $value) : $value;
    // }

    // public function getCityIdAttribute($value)
    // {
    //     return $value ?: "";
    // }

    // public function setCityIdAttribute($value)
    // {
    //     $this->attributes['city_id'] = is_array($value) ? implode(',', $value) : $value;
    // }
}