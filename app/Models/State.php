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
        'parent_id',
        'country_id',
        'region_id',
    ];

    public function getRelationshipNames()
    {
        return ['country', 'region'];
    }

    public function getExcludedColumns()
    {
        return ['country_id', 'region_id'];
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}