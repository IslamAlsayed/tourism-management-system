<?php

namespace App\Models;

use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CrossingPort extends Model
{
    use HasSearch, HasFactory;

    protected $fillable = [
        'id',
        'code',
        'name',
        'name_ar',
        'status',
        'description',
        'region_id',
        'subregion_id',
        'country_id',
        'state_id',
        'city_id',
        'type',
        'latitude',
        'longitude',
        'elevation',
        'is_operational',
        'is_24_hours',
        'opening_time',
        'closing_time',
        'operating_days',
        'facilities',
        'services',
        'phone',
        'fax',
        'email',
        'website',
        'address',
        'postal_code',
        'capacity',
        'runway_info',
        'customs_office',
        'immigration_office',
        'notes',
        'images',
        'documents',
        'created_by',
        'updated_by',
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
        'is_operational' => 'boolean',
        'is_24_hours' => 'boolean',
        'operating_days' => 'array',
        'facilities' => 'array',
        'services' => 'array',
        'runway_info' => 'array',
        'images' => 'array',
        'documents' => 'array',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'opening_time' => 'datetime:H:i',
        'closing_time' => 'datetime:H:i',
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

    // Creator relationship
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Updater relationship
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scopes
     */

    // Active crossing ports only
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Operational crossing ports only
    public function scopeOperational($query)
    {
        return $query->where('is_operational', true);
    }

    // Filter by crossing port type
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Filter by crossing port status
    public function scopeOfStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // 24 hours crossing ports
    public function scope24Hours($query)
    {
        return $query->where('is_24_hours', true);
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

    // Get status label
    public function getStatusLabel()
    {
        $statuses = [
            'active' => 'Active',
            'inactive' => 'Inactive',
            'under_construction' => 'Under Construction',
            'maintenance' => 'Under Maintenance',
        ];

        return $statuses[$this->status] ?? $this->status;
    }
}