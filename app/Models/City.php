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
        return ['region', 'subregion', 'country'];
    }

    public function getExcludedColumns()
    {
        return ['region_id', 'subregion_id', 'country_id'];
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

    public function states()
    {
        if (!$this->state_id)
            return [];
        return State::whereIn('id', explode(',', $this->state_id))->get()->toArray();
    }

    public function getStateListAttribute()
    {
        if (!$this->state_id)
            return [];
        return State::whereIn('id', explode(',', $this->state_id))->get(['id', 'name'])->toArray();
    }

    public function getStateIdAttribute($value)
    {
        return $value ?: "";
    }

    public function setStateIdAttribute($value)
    {
        $this->attributes['state_id'] = is_array($value) ? implode(',', $value) : $value;
    }
}