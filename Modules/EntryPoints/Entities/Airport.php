<?php

namespace Modules\EntryPoints\Entities;

use App\Traits\HasUuid;
use App\Traits\HasSearch;
use App\Traits\FiltersByUserRole;
use App\Traits\ClearsEmptyRichText;
use Modules\Geography\Entities\City;
use Modules\Geography\Entities\State;
use App\Traits\BroadcastsRecordEvents;
use Illuminate\Database\Eloquent\Model;
use Modules\Geography\Entities\Country;
use Modules\Localization\Entities\Currency;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Airport extends Model
{
    use HasSearch, HasUuid, HasRichText, HasFactory, FiltersByUserRole, BroadcastsRecordEvents, ClearsEmptyRichText;
    protected $table = 'airports';
    protected $richTextAttributes = [
        'address',
        'description',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'code',

        // Basic Information
        'name',
        'name_ar',
        'type',

        // Location Information
        'country_id',
        'state_id',
        'city_id',
        'address',

        // Geographic coordinates
        'latitude',
        'longitude',

        // Operating Information
        'operating_days',
        'opening_time',
        'closing_time',
        'is_24_7',
        'is_commercial',
        'is_passenger',
        'is_international',

        // Visa and Immigration Policies
        'allows_visa_on_arrival',
        'nationality_policy',
        'departure_tax',
        'departure_tax_currency_id',

        // Contact Information
        'email',
        'phone',
        'website',

        // Display and Classification
        'sort_order',
        'is_major',

        // Visa Requirements
        'visa_required',
        'visa_fee',
        'visa_fee_currency_id',
        'visa_duration',
        'visa_conditions',
        'visa_application_url',
        'visa_policy_source',
        'visa_last_update',

        // Administrative
        'is_active',
        'address',
        'description',
        'notes',
    ];

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($item) {
            // Auto-fill code
            if (empty($item->code)) {
                $item->code = generateCode('CPORT-', 5);
            }
        });
    }

    public function getRelationshipNames()
    {
        return ['departure_tax_currency', 'visa_fee_currency', 'country', 'state', 'city'];
    }

    public function getExcludedColumns()
    {
        return [
            'departure_tax_currency_id',
            'visa_fee_currency_id',
            'country_id',
            'state_id',
            'city_id',
            'created_by',
            'updated_by',
            'address',
            'description',
            'notes'
        ];
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
        'operating_days' => 'json',
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
    public function departure_tax_currency()
    {
        return $this->belongsTo(Currency::class, 'departure_tax_currency_id');
    }

    public function visa_fee_currency()
    {
        return $this->belongsTo(Currency::class, 'visa_fee_currency_id');
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

    public function getTypeAttribute()
    {
        return __('main.' . $this->attributes['type']) ?? $this->attributes['type'];
    }

    public function getNationalityPolicyAttribute($value)
    {
        return collect(json_decode($value ?? '[]'));
    }

    public function setNationalityPolicyAttribute($value)
    {
        if (is_string($value)) {
            $value = json_decode($value, true);
        }

        $this->attributes['nationality_policy'] = json_encode(collect($value)->map(fn($item) => is_array($item) ? ($item['value'] ?? null) : $item)->filter()->values()->all());
    }

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
            'land_crossing' => __('main.land_crossing'),
            'international_airport' => __('main.international_airport'),
            'domestic_airport' => __('main.domestic_airport'),
            'seaport' => __('main.seaport'),
            'river_port' => __('main.river_port'),
            'border_crossing' => __('main.border_crossing'),
        ];

        return $types[$this->type] ?? $this->type;
    }

    // Get active status label
    public function getStatusLabel()
    {
        return $this->is_active ? __('main.active') : __('main.inactive');
    }

    // Get operating days formatted
    public function getOperatingDaysAttribute()
    {
        return json_decode($this->attributes['operating_days'] ?? '[]', true);
    }

    // Get operating hours formatted
    public function getFormattedOperatingHours()
    {
        if ($this->is_24_7) {
            return '24/7';
        }
        return $this->operating_hours ?? __('main.not_specified');
    }

    public function getFormattedVisaLastUpdateAttribute()
    {
        return $this->visa_last_update ? \Carbon\Carbon::parse($this->visa_last_update)->format('Y-m-d') : null;
    }
}
