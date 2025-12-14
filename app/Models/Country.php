<?php

namespace App\Models;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\FiltersByUserRole;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasSearch, HasUuid, FiltersByUserRole, BroadcastsRecordEvents;

    protected $fillable = [
        'id',
        'uuid',
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
        'latitude',
        'longitude',
        'population',
        'area',
        'is_active',
        'is_independent',
        'is_developed',
        'is_landlocked',
        'timezone_id',
        'language_id',
        'currency_id',
        'region_id',
        'subregion_id',
    ];

    /**
     * Get relationship names for eager loading
     */
    public function getRelationshipNames()
    {
        return ['timezone', 'language', 'currency', 'region', 'subregion'];
    }

    /**
     * Get columns to exclude from search/display
     */
    public function getExcludedColumns()
    {
        return ['timezone_id', 'language_id', 'currency_id', 'region_id', 'subregion_id'];
    }

    public function timezone()
    {
        return $this->belongsTo(Timezone::class);
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

    // One-to-Many: Country has many States
    public function states()
    {
        return $this->hasMany(State::class);
    }

    // One-to-Many: Country has many Cities
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}