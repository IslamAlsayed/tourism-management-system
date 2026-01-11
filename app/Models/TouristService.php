<?php

namespace App\Models;

use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TouristService extends Model
{
    use HasSearch, HasUuid, HasRichText, HasFactory;

    protected $richTextAttributes = [
        'address',
        'description',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'photo',
        'code',
        'name',
        'name_ar',
        'site_type',
        'category',
        'translation',
        'special_events',
        'group_bookings',
        'online_booking',
        'mobile_app',
        'virtual_tours',
        'has_parking',
        'has_restaurant',
        'has_gift_shop',
        'has_restrooms',
        'photo',
        'main_image',
        'gallery_images',
        'video_url',
        'virtual_tour_url',
        'rating',
        'total_reviews',
        'popularity_score',
        'estimated_visit_duration',
        'difficulty_level',
        'age_restrictions',
        'best_visit_time',
        'is_active',
        'is_featured',
        'is_verified',
        'tags',
        'address',
        'description',
        'notes',
        'area',
        'zone',
        'district',
        'neighborhood',
        'block',
        'building',
        'floor',
        'apartment',
        'landmark',
        'directions',
        'contact_person',
        'whatsapp',
        'telegram',
        'snapchat',
        'tiktok',
        'youtube',
        'ticket_type',
        'ticket_price',
        'ticket_price_children',
        'ticket_price_students',
        'ticket_price_seniors',
        'ticket_price_groups',
        'ticket_options',
        'discounts',
        'special_offers',
        'opening_hours',
        'holiday_hours',
        'closed_dates',
        'event_schedules',
        'facilities',
        'accessibility_features',
        'safety_features',
        'health_measures',
        'covid_measures',
        'services',
        'activities',
        'events',
        'workshops',
        'tours',
        'programs',
        'packages',
        'media_files',
        'documents',
        'links',
        'brochures',
        'menus',
        'maps',
        'translations',
        'custom_fields',
        'extra',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'last_imported_at',
        'last_exported_at',
        'import_metadata',
        'export_metadata',
        'created_by',
        'updated_by',
        'latitude',
        'longitude',

        // 'currency_id',
        'region_id',
        'subregion_id',
        'country_id',
        'state_id',
        'city_id',
    ];

    public function getRelationshipNames()
    {
        return ['region', 'subregion', 'country', 'state', 'city'];
    }

    public function getExcludedColumns()
    {
        return ['region_id', 'subregion_id', 'country_id', 'state_id', 'city_id', 'description', 'notes'];
    }

    protected $casts = [
        'operating_days' => 'array',
        'special_hours' => 'array',
        'gallery_images' => 'array',
        'age_restrictions' => 'array',
        'best_visit_time' => 'array',
        'tags' => 'array',
        'is_free_entry' => 'boolean',
        'is_24_hours' => 'boolean',
        'has_parking' => 'boolean',
        'has_restaurant' => 'boolean',
        'has_gift_shop' => 'boolean',
        'has_restrooms' => 'boolean',
        'wheelchair_accessible' => 'boolean',
        'free_wifi' => 'boolean',
        'parking' => 'boolean',
        'restrooms' => 'boolean',
        'restaurants' => 'boolean',
        'gift_shop' => 'boolean',
        'guided_tours' => 'boolean',
        'audio_guide' => 'boolean',
        'photography' => 'boolean',
        'hiking' => 'boolean',
        'swimming' => 'boolean',
        'camping' => 'boolean',
        'shopping' => 'boolean',
        'dining' => 'boolean',
        'entertainment' => 'boolean',
        'educational_tours' => 'boolean',
        'translation' => 'boolean',
        'special_events' => 'boolean',
        'group_bookings' => 'boolean',
        'online_booking' => 'boolean',
        'mobile_app' => 'boolean',
        'virtual_tours' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_verified' => 'boolean',
        'entry_fee_adult' => 'decimal:2',
        'entry_fee_child' => 'decimal:2',
        'entry_fee_student' => 'decimal:2',
        'entry_fee_senior' => 'decimal:2',
        'entry_fee_group' => 'decimal:2',
        'rating' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'opening_time' => 'datetime:H:i',
        'closing_time' => 'datetime:H:i',
    ];

    /**
     * Boot method for model events
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generate site code on creating
        static::saving(function ($touristService) {
            if (empty($touristService->code)) {
                $touristService->code = 'TS-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);

                // Ensure uniqueness
                while (static::where('code', $touristService->code)->exists()) {
                    $touristService->code = 'TS-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
                }
            }
        });

        // Set created_by/updated_by
        static::saving(function ($touristService) {
            if (Auth::check()) {
                $touristService->created_by = Auth::id();
            }
        });

        static::updating(function ($touristService) {
            if (Auth::check()) {
                $touristService->updated_by = Auth::id();
            }
        });
    }

    /**
     * Relationships
     */

    // Location relationships
    // public function currency()
    // {
    //     return $this->belongsTo(Currency::class);
    // }

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

    // Creator and updater relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scopes
     */

    // Active services only
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Featured services only
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Verified services only
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    // Filter by site type
    public function scopeOfSiteType($query, $siteType)
    {
        return $query->where('site_type', $siteType);
    }

    // Filter by category
    public function scopeOfCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Free entry services only
    public function scopeFreeEntry($query)
    {
        return $query->where('is_free_entry', true);
    }

    // services with specific facilities
    public function scopeWithFacility($query, $facility)
    {
        return $query->whereJsonContains('facilities', $facility);
    }

    // Get display name (with Arabic if available)
    public function getDisplayNameAttribute()
    {
        if (app()->getLocale() === 'ar' && $this->name_ar) {
            return $this->name_ar;
        }
        return $this->name;
    }

    // Get display description (with Arabic if available)
    public function getDisplayDescriptionAttribute()
    {
        if (app()->getLocale() === 'ar' && $this->description_ar) {
            return $this->description_ar;
        }
        return $this->description;
    }

    // Get full address
    public function getFullAddressAttribute()
    {
        $parts = array_filter([
            $this->address,
            $this->city?->name,
            $this->state?->name,
            $this->country?->name
        ]);

        return implode(', ', $parts);
    }

    // Get formatted operating hours
    // public function getOpeningTimeAttribute()
    // {
    //     if ($this->is_24_hours) {
    //         return '24 Hours';
    //     }

    //     if ($this->opening_time && $this->closing_time) {
    //         return $this->opening_time->format('H:i') . ' - ' . $this->closing_time->format('H:i');
    //     }

    //     return 'Not specified';
    // }

    public function getFormattedOpeningTimeAttribute()
    {
        return $this->opening_time ? $this->opening_time->format('H:i') : null;
    }

    public function getFormattedClosingTimeAttribute()
    {
        return $this->closing_time ? $this->closing_time->format('H:i') : null;
    }

    // Check if site is open now
    public function getIsOpenNowAttribute()
    {
        if ($this->is_24_hours) {
            return true;
        }

        if (!$this->opening_time || !$this->closing_time) {
            return false;
        }

        $now = now();
        $today = $now->dayOfWeek + 1; // Laravel uses 0-6, we use 1-7

        if (!in_array($today, $this->operating_days ?? [])) {
            return false;
        }

        $currentTime = $now->format('H:i');
        return $currentTime >= $this->opening_time->format('H:i') &&
            $currentTime <= $this->closing_time->format('H:i');
    }

    /**
     * Static methods
     */

    // Get available types
    public static function getServiceTypes()
    {
        return [
            'historical' => __('main.historical'),
            'natural' => __('main.natural'),
            'cultural' => __('main.cultural'),
            'religious' => __('main.religious'),
            'recreational' => __('main.recreational'),
            'archaeological' => __('main.archaeological'),
            'museum' => __('main.museum'),
            'park' => __('main.park'),
            'other' => __('main.other'),
        ];
    }

    // Get available categories
    public static function getCategories()
    {
        return [
            'monument' => __('main.monument'),
            'landmark' => __('main.landmark'),
            'attraction' => __('main.attraction'),
            'site' => __('main.site'),
            'facility' => __('main.facility'),
        ];
    }

    // Get available difficulty levels
    public static function getDifficultyLevels()
    {
        return [
            'easy' => __('main.easy'),
            'moderate' => __('main.moderate'),
            'challenging' => __('main.challenging'),
            'extreme' => __('main.extreme'),
        ];
    }

    // Get available statuses
    public static function getStatuses()
    {
        return [
            'active' => __('main.active'),
            'inactive' => __('main.inactive'),
            'maintenance' => __('main.maintenance'),
            'permanently_closed' => __('main.permanently_closed'),
        ];
    }
}