<?php

namespace App\Models;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\FiltersByUserRole;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CrossingPort extends Model
{
    use HasSearch, HasUuid, HasRichText, HasFactory, FiltersByUserRole, BroadcastsRecordEvents;

    protected $richTextAttributes = [
        'description',
        'address',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'name_ar',
        'type',
        'code',
        'region_id',
        'subregion_id',
        'country_id',
        'state_id',
        'city_id',
        'description',
        'latitude',
        'longitude',
        'operating_hours',
        'is_24_7',
        'is_active',
        'is_commercial',
        'is_passenger',
        'is_international',
        'allows_visa_on_arrival',
        'nationality_policy',
        'departure_tax',
        'departure_tax_currency',
        'contact_phone',
        'email',
        'website',
        'sort_order',
        'is_major',
        'visa_required',
        'visa_fee',
        'visa_fee_currency',
        'visa_duration',
        'visa_conditions',
        'visa_application_url',
        'visa_policy_source',
        'visa_last_update',
        'notes',
    ];

    /**
     * Get relationship names for eager loading
     */
    public function getRelationshipNames()
    {
        return ['region', 'subregion', 'country', 'state', 'city'];
    }

    /**
     * Get columns to exclude from search/display
     */
    public function getExcludedColumns()
    {
        return ['region_id', 'subregion_id', 'country_id', 'state_id', 'city_id', 'created_by', 'updated_by'];
    }

    /**
     * Get the attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_24_7' => 'boolean',
        'is_active' => 'boolean',
        'is_commercial' => 'boolean',
        'is_passenger' => 'boolean',
        'is_international' => 'boolean',
        'allows_visa_on_arrival' => 'boolean',
        'nationality_policy' => 'array',
        'departure_tax' => 'decimal:2',
        'visa_fee' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'sort_order' => 'integer',
        'is_major' => 'boolean',
        'visa_required' => 'boolean',
        'visa_duration' => 'integer',
        'visa_last_update' => 'datetime',
    ];

    /**
     * Relationships
     */
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

    /**
     * Scopes
     */

    // Filter by crossing port type
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    // 24/7 crossing ports
    public function scope24Hours($query)
    {
        return $query->where('is_24_7', true);
    }

    // International crossing ports only
    public function scopeInternational($query)
    {
        return $query->where('is_international', true);
    }

    // Commercial crossing ports only
    public function scopeCommercial($query)
    {
        return $query->where('is_commercial', true);
    }

    // Passenger crossing ports only
    public function scopePassenger($query)
    {
        return $query->where('is_passenger', true);
    }

    // Major crossing ports only
    public function scopeMajor($query)
    {
        return $query->where('is_major', true);
    }

    /**
     * Accessors & Mutators
     */

    // Get full location (city, state, country)
    public function getFullLocationAttribute()
    {
        $parts = array_filter([
            $this->city?->name,
            $this->state?->name,
            $this->country?->name
        ]);

        return implode(', ', $parts);
    }

    // Get coordinates as string
    public function getCoordinatesAttribute()
    {
        if ($this->latitude && $this->longitude) {
            return $this->latitude . ', ' . $this->longitude;
        }
        return null;
    }

    // Get type label
    public function getTypeLabel()
    {
        $types = [
            'land_crossing' => 'Land Crossing',
            'international_airport' => 'International Airport',
            'domestic_airport' => 'Domestic Airport',
            'seaport' => 'Seaport',
            'river_port' => 'River Port',
            'border_crossing' => 'Border Crossing',
        ];

        return $types[$this->type] ?? $this->type;
    }

    // Get active status label
    public function getStatusLabel()
    {
        return $this->is_active ? 'Active' : 'Inactive';
    }

    // Get operating hours formatted
    public function getFormattedOperatingHours()
    {
        if ($this->is_24_7) {
            return '24/7';
        }
        return $this->operating_hours ?? 'Not specified';
    }
}