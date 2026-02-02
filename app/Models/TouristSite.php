<?php

namespace App\Models;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\ClearsEmptyRichText;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class TouristSite extends Model
{
    use HasSearch, HasUuid, HasRichText, HasFactory, BroadcastsRecordEvents, ClearsEmptyRichText;
    protected $table = 'tourist_sites';
    protected $richTextAttributes = [
        'address',
        'nearby_attractions',
        'description',
        'notes',
    ];

    protected $fillable = [
        // Basic Information
        'id',
        'uuid',
        'code',
        'photo',
        'gallery',
        'name',
        'name_ar',
        'site_type',
        'category',
        'supplier_type',
        'sites_theme',
        'supplier_name',
        'sort_order',

        // Location Information
        'currency_id',
        'city_id',
        'address',
        'latitude',
        'longitude',
        'postal_code',

        // Entry Fees
        'entry_fee_adult',
        'entry_fee_child',
        'entry_fee_student',
        'entry_fee_senior',
        'entry_fee_group',
        'entry_fee_foreigner_adult',
        'entry_fee_foreigner_child',
        'entry_fee_arab_adult',
        'entry_fee_arab_child',
        'entry_fee_local_adult',
        'entry_fee_local_child',
        'entry_fee_resident_adult',
        'entry_fee_resident_child',

        // Operating Hours
        'opening_time',
        'closing_time',
        'operating_days',
        'special_hours',

        // Contact Information
        'phone',
        'mobile',
        'email',
        'website_url',
        'facebook_url',
        'instagram_url',
        'twitter_url',
        'fax',
        'contact_person',

        // Facilities & Services
        'wheelchair_accessible',
        'free_wifi',
        'parking',
        'restrooms',
        'restaurants',
        'gift_shop',
        'guided_tours',
        'audio_guide',
        'photography',
        'hiking',
        'swimming',
        'camping',
        'shopping',
        'dining',
        'entertainment',
        'educational_tours',
        'translation',
        'special_events',
        'group_bookings',
        'online_booking',
        'mobile_app',
        'virtual_tours',

        // Additional Pricing
        'local_guide_price',
        'club_car_price',

        // Media & Content
        'video_url',
        'virtual_tour_url',

        // Visitor Information
        'nearby_attractions',
        'average_rating',
        'total_reviews',
        'popularity_score',
        'estimated_visit_duration',
        'difficulty_level',
        'age_restrictions',
        'best_visit_time',
        'tags',

        // Status & Metadata
        'status',
        'unesco_site',
        'has_unified_ticket',
        'is_free_entry',
        'is_24_7',
        'is_featured',
        'is_verified',
        'is_active',

        // Description & Notes
        'description',
        'notes',

        // Audit Trail
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        // Booleans
        'unesco_site' => 'boolean',
        'is_free_entry' => 'boolean',
        'is_24_7' => 'boolean',
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
        'has_unified_ticket' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_verified' => 'boolean',

        // Decimals
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'entry_fee_adult' => 'decimal:2',
        'entry_fee_child' => 'decimal:2',
        'entry_fee_student' => 'decimal:2',
        'entry_fee_senior' => 'decimal:2',
        'entry_fee_group' => 'decimal:2',
        'entry_fee_foreigner_adult' => 'decimal:2',
        'entry_fee_foreigner_child' => 'decimal:2',
        'entry_fee_arab_adult' => 'decimal:2',
        'entry_fee_arab_child' => 'decimal:2',
        'entry_fee_local_adult' => 'decimal:2',
        'entry_fee_local_child' => 'decimal:2',
        'entry_fee_resident_adult' => 'decimal:2',
        'entry_fee_resident_child' => 'decimal:2',
        'local_guide_price' => 'decimal:2',
        'club_car_price' => 'decimal:2',
        'average_rating' => 'decimal:2',

        // Integers
        'sort_order' => 'integer',
        'total_reviews' => 'integer',
        'popularity_score' => 'integer',
        'estimated_visit_duration' => 'integer',

        // JSON
        'gallery' => 'json',
        'operating_days' => 'json',
        'special_hours' => 'json',
        'age_restrictions' => 'json',
        'best_visit_time' => 'json',
        'tags' => 'json',
    ];

    public function getRelationshipNames()
    {
        return ['currency', 'city', 'creator', 'updater'];
    }

    public function getExcludedColumns()
    {
        return [
            'currency_id',
            'city_id',
            'created_by',
            'updated_by',
            'description',
            'notes',
            'nearby_attractions',
            'address',
        ];
    }

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($item) {
            // Auto-fill code
            if (empty($item->code)) {
                $item->code = generateCode('TS-', 5);
            }
        });
    }

    public static function getDifficultyLevels()
    {
        return [
            'easy' => __('main.easy'),
            'moderate' => __('main.moderate'),
            'difficult' => __('main.difficult'),
            'very_difficult' => __('main.very_difficult'),
        ];
    }

    public static function getStatus()
    {
        return [
            'active' => __('main.active'),
            'maintenance' => __('main.maintenance'),
            'closed' => __('main.closed'),
        ];
    }

    /**
     * Relationships
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
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

    public function services()
    {
        return $this->hasMany(TouristService::class, 'site_id');
    }

    public function media()
    {
        return $this->morphMany(MediaFile::class, 'model');
    }

    public function photos()
    {
        return $this->hasManyThrough(
            MediaFile::class,
            null,
            'id',
            'id',
            'id',
            'photo_id_01'
        );
    }
}
