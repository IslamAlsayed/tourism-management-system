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
        'name',
        'name_ar',
        'code',
        'description',
        'type',
        'service_type',
        'is_active',
        'is_international',
        'is_domestic',
        'established_date',
        'hub_airport',
        'fleet_size',
        'aircraft_types',
        'passenger_capacity',
        'cargo_capacity',
        'phone',
        'email',
        'website',
        'booking_phone',
        'customer_service_phone',
        'address',
        'postal_code',
        'latitude',
        'longitude',
        'region_id',
        'subregion_id',
        'country_id',
        'state_id',
        'city_id',
        'license_number',
        'tax_number',
        'certifications',
        'destinations',
        'services',
        'cabin_classes',
        'has_frequent_flyer',
        'frequent_flyer_program',
        'annual_revenue',
        'annual_passengers',
        'on_time_performance',
        'safety_rating',
        'safety_rating_agency',
        'accident_count',
        'last_safety_audit',
        'alliance',
        'partnerships',
        'codeshare_agreements',
        'status',
        'notes',
        'created_by',
        'updated_by',
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
            'creator',
            'updater'
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
            'description',
            'notes',
            'aircraft_types',
            'certifications',
            'destinations',
            'services',
            'cabin_classes',
            'partnerships',
            'codeshare_agreements'
        ];
    }

    protected $casts = [
        'aircraft_types' => 'array',
        'certifications' => 'array',
        'destinations' => 'array',
        'services' => 'array',
        'cabin_classes' => 'array',
        'partnerships' => 'array',
        'codeshare_agreements' => 'array',
        'is_active' => 'boolean',
        'is_international' => 'boolean',
        'is_domestic' => 'boolean',
        'has_frequent_flyer' => 'boolean',
        'established_date' => 'date',
        'last_safety_audit' => 'date',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'annual_revenue' => 'decimal:2',
        'on_time_performance' => 'decimal:2',
        'safety_rating' => 'decimal:1',
    ];

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
     * Relationship with Creator (User)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relationship with Updater (User)
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope for active air transports
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->where('status', 'active');
    }

    /**
     * Scope for airlines only
     */
    public function scopeAirlines($query)
    {
        return $query->where('type', 'airline');
    }

    /**
     * Scope for charter companies only
     */
    public function scopeCharter($query)
    {
        return $query->where('type', 'charter_company');
    }

    /**
     * Scope for cargo airlines only
     */
    public function scopeCargo($query)
    {
        return $query->where('type', 'cargo_airline');
    }

    /**
     * Scope for international service
     */
    public function scopeInternational($query)
    {
        return $query->where('is_international', true);
    }

    /**
     * Scope for domestic service
     */
    public function scopeDomestic($query)
    {
        return $query->where('is_domestic', true);
    }

    /**
     * Scope for by type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope for by service type
     */
    public function scopeOfServiceType($query, $serviceType)
    {
        return $query->where('service_type', $serviceType);
    }

    /**
     * Scope for by status
     */
    public function scopeOfStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Get display name (localized)
     */
    public function getDisplayNameAttribute()
    {
        return app()->getLocale() === 'ar' && $this->name_ar
            ? $this->name_ar
            : $this->name;
    }

    /**
     * Get display description (localized)
     */
    public function getDisplayDescriptionAttribute()
    {
        return app()->getLocale() === 'ar' && $this->description_ar
            ? $this->description_ar
            : $this->description;
    }

    /**
     * Get display address (localized)
     */
    public function getDisplayAddressAttribute()
    {
        return app()->getLocale() === 'ar' && $this->address_ar
            ? $this->address_ar
            : $this->address;
    }

    /**
     * Get display notes (localized)
     */
    public function getDisplayNotesAttribute()
    {
        return app()->getLocale() === 'ar' && $this->notes_ar
            ? $this->notes_ar
            : $this->notes;
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

    /**
     * Get type label
     */
    public function getTypeLabel()
    {
        $types = [
            'airline' => __('main.airline'),
            'charter_company' => __('main.charter_company'),
            'cargo_airline' => __('main.cargo_airline'),
            'aircraft_operator' => __('main.aircraft_operator'),
            'aircraft_manufacturer' => __('main.aircraft_manufacturer'),
        ];

        return $types[$this->type] ?? $this->type;
    }

    /**
     * Get service type label
     */
    public function getServiceTypeLabel()
    {
        $serviceTypes = [
            'scheduled' => __('main.scheduled'),
            'charter' => __('main.charter'),
            'cargo' => __('main.cargo'),
            'private' => __('main.private'),
            'mixed' => __('main.mixed'),
        ];

        return $serviceTypes[$this->service_type] ?? $this->service_type;
    }

    /**
     * Get status label
     */
    public function getStatusLabel()
    {
        $statuses = [
            'active' => __('main.active'),
            'inactive' => __('main.inactive'),
            'suspended' => __('main.suspended'),
            'merged' => __('main.merged'),
            'bankrupt' => __('main.bankrupt'),
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * Get formatted fleet size
     */
    public function getFormattedFleetSizeAttribute()
    {
        if (!$this->fleet_size)
            return __('main.not_specified');

        return number_format($this->fleet_size) . ' ' . __('main.aircraft');
    }

    /**
     * Get formatted passenger capacity
     */
    public function getFormattedPassengerCapacityAttribute()
    {
        if (!$this->passenger_capacity)
            return __('main.not_specified');

        return number_format($this->passenger_capacity) . ' ' . __('main.passengers');
    }

    /**
     * Get formatted on-time performance
     */
    public function getFormattedOnTimePerformanceAttribute()
    {
        if (!$this->on_time_performance)
            return __('main.not_specified');

        return $this->on_time_performance . '%';
    }

    /**
     * Get age in years
     */
    public function getAgeAttribute()
    {
        if (!$this->established_date)
            return null;

        return now()->diffInYears($this->established_date);
    }
}