<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\HasSearch;
use App\Traits\FiltersByUserRole;
use App\Traits\ClearsEmptyRichText;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TouristService extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, FiltersByUserRole, ClearsEmptyRichText;
    protected $table = 'tourist_services';
    protected $richTextAttributes = [
        'description',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'photo',
        'gallery',
        'code',
        'name',
        'name_ar',
        'service_type',
        'category',
        'supplier_type',
        'supplier_name',
        'sort_order',
        'address',
        'latitude',
        'longitude',
        'pricing_model',
        'pricing_type',
        'pricing_unit',
        'pricing_unit_value',
        'cost_adult',
        'cost_child',
        'price_adult',
        'price_child',
        'service_seasons',
        'seasonal_prices',
        'child_min_age',
        'child_max_age',
        'price_foreigner_adult',
        'price_foreigner_child',
        'price_arab_adult',
        'price_arab_child',
        'price_local_adult',
        'price_local_child',
        'price_resident_adult',
        'price_resident_child',
        'target_modules',
        'is_tax_inclusive',
        'tax_configuration',
        'commission_configuration',
        'opening_time',
        'closing_time',
        'operating_days',
        'special_hours',
        'is_24_7',
        'min_participants',
        'max_participants',
        'email',
        'phone',
        'mobile',
        'contact_person',
        'booking_required',
        'cancellation_policy',
        'is_refundable',
        'is_mandatory',
        'is_free',
        'is_verified',
        'video_url',
        'rating',
        'total_reviews',
        'duration_minutes',
        'difficulty_level',
        'tags',
        'is_active',
        'is_featured',
        'description',
        'notes',
        'created_by',
        'updated_by',
        'currency_id',
        'country_id',
        'state_id',
        'city_id',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'cost_adult' => 'decimal:2',
        'cost_child' => 'decimal:2',
        'price_adult' => 'decimal:2',
        'price_child' => 'decimal:2',
        'price_foreigner_adult' => 'decimal:2',
        'price_foreigner_child' => 'decimal:2',
        'price_arab_adult' => 'decimal:2',
        'price_arab_child' => 'decimal:2',
        'price_local_adult' => 'decimal:2',
        'price_local_child' => 'decimal:2',
        'price_resident_adult' => 'decimal:2',
        'price_resident_child' => 'decimal:2',
        'rating' => 'decimal:2',
        'service_seasons' => 'array',
        'seasonal_prices' => 'array',
        'target_modules' => 'array',
        'tax_configuration' => 'array',
        'commission_configuration' => 'array',
        'operating_days' => 'array',
        'special_hours' => 'array',
        'gallery' => 'array',
        'tags' => 'array',
        'is_tax_inclusive' => 'boolean',
        'is_24_7' => 'boolean',
        'booking_required' => 'boolean',
        'is_refundable' => 'boolean',
        'is_mandatory' => 'boolean',
        'is_free' => 'boolean',
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function getRelationshipNames()
    {
        return ['currency', 'country', 'state', 'city', 'creator', 'updater', 'taxConfigurations', 'commissionConfigurations', 'modules', 'seasonalPrices', 'operatingSchedules', 'specialHours'];
    }

    public function getExcludedColumns()
    {
        return ['currency_id', 'country_id', 'state_id', 'city_id', 'description', 'notes'];
    }

    protected static function boot()
    {
        parent::boot();

        // Set created_by/updated_by
        static::saving(function ($item) {
            // Auto-fill code
            if (empty($item->code)) {
                $item->code = generateCode('TSERV-', 5);
            }
            if (Auth::check()) {
                $item->created_by = Auth::id();
            }
        });

        static::updating(function ($item) {
            if (empty($item->code)) {
                $item->code = generateCode('TSERV-', 5);
            }
            if (Auth::check()) {
                $item->updated_by = Auth::id();
            }
        });
    }

    public function getTagsAttribute($value)
    {
        return collect(json_decode($value ?? '[]'));
    }

    public function setTagsAttribute($value)
    {
        if (is_string($value)) {
            $value = json_decode($value, true);
        }

        $this->attributes['tags'] = json_encode(collect($value)->map(fn($item) => is_array($item) ? ($item['value'] ?? null) : $item)->filter()->values()->all());
    }

    public static function getDifficultyLevels()
    {
        return [
            'easy' => __('main.easy'),
            'medium' => __('main.medium'),
            'hard' => __('main.hard'),
        ];
    }

    /**
     * Relationships
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
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

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // === NEW RELATIONSHIPS FOR NORMALIZED TABLES ===

    /**
     * Get all seasonal prices for this service
     */
    public function seasonalPrices()
    {
        return $this->hasMany(SeasonalPrice::class);
    }

    /**
     * Get all tax configurations
     */
    public function taxConfigurations()
    {
        return $this->hasMany(TaxConfiguration::class);
    }

    /**
     * Get all commission configurations
     */
    public function commissionConfigurations()
    {
        return $this->hasMany(CommissionConfiguration::class);
    }

    /**
     * Get all target modules
     */
    public function modules()
    {
        return $this->hasMany(TouristServiceModule::class);
    }

    /**
     * Get all media files (photos, videos, gallery)
     */
    // public function media()
    // {
    //     return $this->hasMany(TouristServiceMedia::class);
    // }

    /**
     * Get primary photo
     */
    // public function primaryPhoto()
    // {
    //     return $this->hasOne(TouristServiceMedia::class)->where('is_primary', true)->where('file_type', 'image');
    // }

    /**
     * Get gallery images
     */
    // public function gallery()
    // {
    //     return $this->hasMany(TouristServiceMedia::class)->where('file_type', 'image')->where('is_primary', false)->orderBy('sort_order');
    // }

    /**
     * Get operating schedules
     */
    public function operatingSchedules()
    {
        return $this->hasMany(OperatingSchedule::class);
    }

    /**
     * Get special hours (holidays, temporary closures, etc.)
     */
    public function specialHours()
    {
        return $this->hasMany(SpecialHour::class);
    }
}
