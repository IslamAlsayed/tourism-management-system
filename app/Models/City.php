<?php

namespace App\Models;

use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasSearch;

    protected $fillable = [
        'id',
        'name',
        'name_ar',
        'latitude',
        'longitude',
        'timezone',
        'wiki_data_id',
        'population',
        'region_id',
        'subregion_id',
        'country_id',
        'state_id',
    ];

    public function getRelationshipNames()
    {
        return ['region', 'subregion', 'country', 'state'];
    }

    public function getExcludedColumns()
    {
        return ['region_id', 'subregion_id', 'country_id', 'state_id'];
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
}