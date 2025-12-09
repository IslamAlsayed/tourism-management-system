<?php

namespace App\Models;

use App\Traits\HasSearch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TouristSite extends Model
{
    use HasSearch, HasRichText, HasFactory;

    protected $richTextAttributes = [
        'description',
        'description_ar',
        'notes',
    ];

    protected $fillable = [
        'id',
        'photo',
        'site_code',

        // Basic Information
        'name',
        'name_ar',
        'description',
        'description_ar',
        'site_type',
        'category',

        // Location Information
        'region_id',
        'subregion_id',
        'country_id',
        'state_id',
        'city_id',

        // Geographical Details
        'address',
        'address_ar',
        'latitude',
        'longitude',
        'postal_code',

        // Entry Information
        'entry_fee_adult',
        'entry_fee_child',
        'entry_fee_student',
        'entry_fee_senior',
        'entry_fee_group',
        'currency',
        'is_free_entry',

        // Operating Hours
        'opening_time',
        'closing_time',
        'operating_days',
        'special_hours',
        'is_24_hours',

        // Contact Information
        'mobile',
        'email',
        'website_url',
        'facebook_url',
        'instagram_url',
        'twitter_url',

        // Facilities & Activities & Services
        'facilities',
        'activities',
        'services',
        'has_parking',
        'has_restaurant',
        'has_gift_shop',
        'has_restrooms',
        'wheelchair_accessible',

        // Media & Resources
        'phone',
        // 'main_image',
        // 'gallery_images',
        // 'video_url',
        // 'virtual_tour_url',

        // Ratings & Reviews
        'average_rating',
        'total_reviews',
        'popularity_score',

        // Visitor Information
        'estimated_visit_duration',
        'difficulty_level',
        'age_restrictions',
        'best_visit_time',

        // Administrative
        'status',
        'is_featured',
        'is_verified',
        'notes',
        'tags',

        // Tracking
        'created_by',
        'updated_by',
    ];

    public function getRelationshipNames()
    {
        return ['region', 'subregion', 'country', 'state', 'city'];
    }

    public function getExcludedColumns()
    {
        return ['region_id', 'subregion_id', 'country_id', 'state_id', 'city_id'];
    }

    protected $casts = [
        'operating_days' => 'array',
        'special_hours' => 'array',
        'facilities' => 'array',
        'activities' => 'array',
        'services' => 'array',
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
        'is_featured' => 'boolean',
        'is_verified' => 'boolean',
        'entry_fee_adult' => 'decimal:2',
        'entry_fee_child' => 'decimal:2',
        'entry_fee_student' => 'decimal:2',
        'entry_fee_senior' => 'decimal:2',
        'entry_fee_group' => 'decimal:2',
        'average_rating' => 'decimal:2',
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
        static::creating(function ($touristSite) {
            if (empty($touristSite->site_code)) {
                $touristSite->site_code = 'TS-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);

                // Ensure uniqueness
                while (static::where('site_code', $touristSite->site_code)->exists()) {
                    $touristSite->site_code = 'TS-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
                }
            }
        });

        // Set created_by/updated_by
        static::creating(function ($touristSite) {
            if (Auth::check()) {
                $touristSite->created_by = Auth::id();
            }
        });

        static::updating(function ($touristSite) {
            if (Auth::check()) {
                $touristSite->updated_by = Auth::id();
            }
        });
    }

    /**
     * Relationships
     */

    // Location relationships
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

    // Active sites only
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Featured sites only
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Verified sites only
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

    // Free entry sites only
    public function scopeFreeEntry($query)
    {
        return $query->where('is_free_entry', true);
    }

    // Sites with specific facilities
    public function scopeWithFacility($query, $facility)
    {
        return $query->whereJsonContains('facilities', $facility);
    }

    /**
     * Accessors & Mutators
     */

    public function getFacilitiesAttribute()
    {
        return $this->attributes['facilities'] ? json_decode($this->attributes['facilities'], true) : [];
    }

    public function getActivitiesAttribute()
    {
        return $this->attributes['activities'] ? json_decode($this->attributes['activities'], true) : [];
    }

    public function getServicesAttribute()
    {
        return $this->attributes['services'] ? json_decode($this->attributes['services'], true) : [];
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
    public function getOperatingHoursAttribute()
    {
        if ($this->is_24_hours) {
            return '24 Hours';
        }

        if ($this->opening_time && $this->closing_time) {
            return $this->opening_time->format('H:i') . ' - ' . $this->closing_time->format('H:i');
        }

        return 'Not specified';
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
    public static function getSiteTypes()
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