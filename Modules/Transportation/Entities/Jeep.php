<?php

namespace Modules\Transportation\Entities;

use App\Traits\HasUuid;
use App\Traits\HasSearch;
use App\Traits\HasCustomFields;
use Illuminate\Support\Str;
use Modules\Core\Entities\User;
use Modules\Geography\Entities\City;
use Modules\Geography\Entities\State;
use Illuminate\Database\Eloquent\Model;
use Modules\Geography\Entities\Country;
use Modules\Localization\Entities\Currency;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Transportation\Entities\JeepSeason;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jeep extends Model
{
    use HasFactory, SoftDeletes, HasUuid, HasSearch, HasCustomFields;

    protected $fillable = [
        'id',
        'uuid',
        'photo',
        'gallery',
        'route',
        'route_ar',
        'slug',
        'origin_city_id',
        'destination_city_id',
        'country_id',
        'state_id',
        'city_id',
        'company_id',
        'duration',
        'duration_unit',
        'distance',
        'distance_unit',
        'car_seats',
        'price',
        'currency_id',
        'price_type',
        'vehicle_model',
        'model_year',
        'license_plate',
        'has_ac',
        'has_driver',
        'is_4x4',
        'has_camping_gear',
        'status',
        'is_active',
        'is_featured',
        'description',
        'notes',
        'created_by',
        'updated_by',
        'route_itinerary',
    ];

    const PRICE_TYPES = [
        'per_person' => 'Per Person',
        'per_trip' => 'Per Trip',
        'per_vehicle' => 'Per Vehicle',
        'per_hour' => 'Per Hour'
    ];

    const DURATION_UNITS = [
        'minutes' => 'Minutes',
        'hours' => 'Hours',
        'days' => 'Days'
    ];

    const DISTANCE_UNITS = [
        'km' => 'KM',
        'miles' => 'Miles'
    ];

    protected $casts = [
        'has_ac' => 'boolean',
        'has_driver' => 'boolean',
        'is_4x4' => 'boolean',
        'has_camping_gear' => 'boolean',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'gallery' => 'array',
        'duration' => 'float',
        'distance' => 'float',
        'route_itinerary' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->slug) {
                $model->slug = Str::slug($model->route);
            }
        });
        static::updating(function ($model) {
            if (!$model->slug) {
                $model->slug = Str::slug($model->route);
            }
        });
    }

    /**
     * Get relationship names for eager loading
     */
    public function getRelationshipNames()
    {
        return ['currency', 'country', 'city', 'originCity', 'destinationCity', 'creator', 'company'];
    }

    /**
     * Get columns to exclude from search/display
     */
    public function getExcludedColumns()
    {
        return [
            'created_by',
            'updated_by',
            'deleted_at',
            'notes',
            'description',
            'duration_unit',
            'distance_unit',
            'origin_city_id',
            'destination_city_id',
            'country_id',
            'state_id',
            'city_id',
            'company_id',
            'currency_id',
        ];
    }

    public function getRouteItineraryAttribute($value)
    {
        return collect(json_decode($value ?? '[]'));
    }

    public function setRouteItineraryAttribute($value)
    {
        if (is_string($value)) {
            $value = json_decode($value, true);
        }

        $this->attributes['route_itinerary'] = json_encode(collect($value)->map(fn($item) => is_array($item) ? ($item['value'] ?? null) : $item)->filter()->values()->all());
    }

    // Geographical Relations
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

    public function originCity()
    {
        return $this->belongsTo(City::class, 'origin_city_id');
    }

    public function destinationCity()
    {
        return $this->belongsTo(City::class, 'destination_city_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    // New: Company Relation
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function seasons()
    {
        return $this->hasMany(JeepSeason::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
