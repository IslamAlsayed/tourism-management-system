<?php

namespace App\Models;

use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasSearch;

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
        'timezone',
        'region_id',
        'subregion_id',
        'country_id',
        'city_id',
    ];

    public function getRelationshipNames()
    {
        return ['region', 'subregion', 'country', 'city'];
    }

    public function getExcludedColumns()
    {
        return ['region_id', 'subregion_id', 'country_id', 'city_id'];
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

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}