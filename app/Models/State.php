<?php

namespace App\Models;

use App\Traits\FiltersByUserRole;
use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasSearch, FiltersByUserRole;

    protected $fillable = [
        'id',
        'name',
        'name_ar',
        'iso2',
        'iso3',
        'fips_code',
        'type',
        'level',
        'latitude',
        'longitude',
        'is_active',
        'is_independent',
        'is_developed',
        'is_landlocked',
        'timezone_id',
        'region_id',
        'subregion_id',
        'country_id',
        'city_id',
    ];

    /**
     * Get relationship names for eager loading
     */
    public function getRelationshipNames()
    {
        return ['timezone', 'region', 'subregion', 'country'];
    }

    /**
     * Get columns to exclude from search/display
     */
    public function getExcludedColumns()
    {
        return ['timezone_id', 'region_id', 'subregion_id', 'country_id'];
    }

    public function timezone()
    {
        return $this->belongsTo(Timezone::class);
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

    public function cities()
    {
        if (!$this->city_id)
            return [];
        return City::whereIn('id', explode(',', $this->city_id))->get()->toArray();
    }

    public function getCityListAttribute()
    {
        if (!$this->city_id)
            return [];
        return City::whereIn('id', explode(',', $this->city_id))->get(['id', 'name'])->toArray();
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