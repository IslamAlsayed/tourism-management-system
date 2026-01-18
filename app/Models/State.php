<?php

namespace App\Models;

use App\Traits\FiltersByUserRole;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasSearch, HasUuid, FiltersByUserRole;

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'name_ar',
        'iso2',
        'iso3',
        'fips_code',
        'type',
        'level',
        'latitude',
        'longitude',
        'all_cities',
        'is_active',
        'is_independent',
        'is_developed',
        'is_landlocked',
        'description',
        'notes',
        'timezone_id',
        'region_id',
        'subregion_id',
        'country_id',
    ];

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($item) {
            // Auto-fill region_id and subregion_id from country
            if (empty($item->currency_id) && !empty($item->country_id)) {
                $item->currency_id = $item->country?->currency_id;
            }
            if (empty($item->region_id) && !empty($item->country_id)) {
                $item->region_id = $item->country?->region_id;
            }
            if (empty($item->subregion_id) && !empty($item->country_id)) {
                $item->subregion_id = $item->country?->subregion_id;
            }
        });

        static::updating(function ($item) {
            // Auto-fill region_id and subregion_id from country on update too
            if (empty($item->currency_id) && !empty($item->country_id)) {
                $item->currency_id = $item->country?->currency_id;
            }
            if (empty($item->region_id) && !empty($item->country_id)) {
                $item->region_id = $item->country?->region_id;
            }
            if (empty($item->subregion_id) && !empty($item->country_id)) {
                $item->subregion_id = $item->country?->subregion_id;
            }
        });
    }

    public function getRelationshipNames()
    {
        return ['timezone', 'region', 'subregion', 'country', 'city', 'cities'];
    }

    public function getExcludedColumns()
    {
        return ['timezone_id', 'region_id', 'subregion_id', 'country_id', 'description', 'notes'];
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

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function cities()
    {
        return $this->belongsToMany(City::class, 'city_state');
    }
}