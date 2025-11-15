<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasSearch;

class AirTransport extends Model
{
    use HasFactory, HasSearch;

    protected $fillable = [
        'id',
        'lid',
        'icao',
        'iata',
        'airport_name',
        'airport_name_ar',
        'subd',
        'region_id',
        'subregion_id',
        'country_id',
        'state_id',
        'city_id',
        'elevation',
        'latitude',
        'longitude',
        'timezone',
        'local_phone_number',
        'international_phone_number',
        'website',
    ];

    protected $casts = [
        'elevation' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    /**
     * Get relationship names for search functionality
     */
    public function getRelationshipNames(): array
    {
        return [
            'region',
            'subregion',
            'country',
            'state',
            'city',
        ];
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
            'created_at',
            'updated_at',
        ];
    }

    /**
     * Relationship with Region
     */
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * Relationship with Subregion
     */
    public function subregion()
    {
        return $this->belongsTo(Subregion::class);
    }

    /**
     * Relationship with Country
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Relationship with State
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /**
     * Relationship with City
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get display name (localized)
     */
    public function getDisplayNameAttribute()
    {
        return app()->getLocale() === 'ar' && $this->airport_name_ar
            ? $this->airport_name_ar
            : $this->airport_name;
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