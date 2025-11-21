<?php

namespace App\Models;

use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    use HasSearch;

    protected $fillable = [
        'id',
        'name',
        'name_ar',
        'is_active',
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
        return ['region', 'subregion', 'country'];
    }

    /**
     * Get columns to exclude from search/display
     */
    public function getExcludedColumns()
    {
        return ['region_id', 'subregion_id', 'country_id'];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
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