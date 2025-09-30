<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourGuideType extends Model
{
    protected $fillable = [
        'id',
        'type',
        'price',
        'currency_id',
        'country_id',
        'state_id',
        'city_id',
        'region_id',
        'subregion_id',
        'multi_states',
        'multi_cities',
    ];

    public function getRelationshipNames()
    {
        return [
            'currency',
            'country',
            'state',
            'city',
            'region',
            'subregion',
        ];
    }

    public function getExcludedColumns()
    {
        return [
            'currency_id',
            'country_id',
            'state_id',
            'city_id',
            'region_id',
            'subregion_id',
        ];
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
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

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function subregion()
    {
        return $this->belongsTo(Subregion::class);
    }
}