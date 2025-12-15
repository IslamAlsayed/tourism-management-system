<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\BroadcastsRecordEvents;
use App\Traits\HasSearch;
use App\Traits\HasUuid;

class Airline extends Model
{
    use HasFactory, HasSearch, HasUuid, BroadcastsRecordEvents;

    protected $fillable = [
        'id',
        'uuid',
        'lid',
        'icao',
        'iata',
        'name',
        'name_ar',
        'subd',
        'region_id',
        'subregion_id',
        'country_id',
        'state_id',
        'city_id',
        'elevation',
        'latitude',
        'longitude',
        'timezone_id',
        'local_phone_number',
        'international_phone_number',
        'website',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'elevation' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'is_active' => 'boolean',
    ];

    /**
     * Get relationship names for search functionality
     */
    public function getRelationshipNames(): array
    {
        return ['region', 'subregion', 'country', 'state', 'city', 'timezone'];
    }

    /**
     * Get excluded columns for table display
     */
    public function getExcludedColumns(): array
    {
        return [
            'region_id',
            'subregion_id',
            'country_id',
            'state_id',
            'city_id',
            'timezone_id',
            'created_at',
            'updated_at',
        ];
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

    public function timezone()
    {
        return $this->belongsTo(Timezone::class);
    }

    /**
     * Get display name (localized)
     */
    public function getDisplayNameAttribute()
    {
        return app()->getLocale() === 'ar' && $this->name_ar ? $this->name_ar : $this->name;
    }

    /**
     * Get full location string
     */
    public function getFullLocationAttribute()
    {
        $location = [];

        if ($this->city)
            $location[] = $this->city->display_name;
        if ($this->state)
            $location[] = $this->state->display_name;
        if ($this->country)
            $location[] = $this->country->display_name;

        return implode(', ', $location);
    }

    /**
     * Get coordinates as string
     */
    public function getCoordinatesAttribute()
    {
        if ($this->latitude && $this->longitude) {
            return $this->latitude . ', ' . $this->longitude;
        }
        return null;
    }
}