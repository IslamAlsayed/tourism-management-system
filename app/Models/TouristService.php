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

    protected $table = 'tourist_services';

    protected $richTextAttributes = [
        'description',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'include_unified_ticket',
        'total_day_visit',

        // Pricing - Foreigners
        'per_adult_foreigners',
        'per_child_foreigners',

        // Pricing - Local
        'per_adult_local',
        'per_child_local',

        // Pricing - Arab
        'per_adult_arab',
        'per_child_arab',

        // Pricing - Residents
        'per_adult_residents',
        'per_child_residents',

        // Non-accommodated Visitors
        'non_accommodated_visitors_adult',
        'non_accommodated_visitors_child',

        // Operating Hours
        'summer_opening_time',
        'summer_closing_time',
        'winter_opening_time',
        'winter_closing_time',
        'operating_days',
        'annual_holidays',
        // 'special_schedules',

        // Day Off & Holidays
        'day_off',
        'yearly_holidays',

        // Contact Information
        'person_name_01',
        'person_name_02',
        'email_01',
        'email_02',
        'phone',
        'mobile_01',
        'mobile_02',
        'fax',
        'website',

        // Local Guide
        'local_guide_available',
        'local_guide_fees_01',
        'local_guide_fees_02',
        'local_guide_fees_03',
        'local_guide_fees_04',
        'local_guide_fees_05',

        // Payment Methods
        'credit_cards',

        // Club Cars
        'club_cars_available',
        'club_car_prices_01',
        'club_car_prices_02',
        'club_car_prices_03',
        'club_car_prices_04',
        'club_car_prices_05',
        'club_car_prices_06',
        'club_car_prices_07',
        'club_car_prices_08',

        // Additional Fields
        'ext1',
        'ext2',
        'ext3',

        // Description & Notes
        'description',
        'notes',

        // Status
        'sort_order',
        'is_active',

        'site_id',
        'currency_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'include_unified_ticket' => 'boolean',
        'local_guide_available' => 'boolean',
        'local_guide_not_available' => 'boolean',
        'credit_cards' => 'boolean',
        'club_cars_available' => 'boolean',
        'is_active' => 'boolean',

        'total_day_visit' => 'decimal:2',
        'per_adult_foreigners' => 'decimal:2',
        'per_child_foreigners' => 'decimal:2',
        'per_adult_local' => 'decimal:2',
        'per_child_local' => 'decimal:2',
        'per_adult_arab' => 'decimal:2',
        'per_child_arab' => 'decimal:2',
        'per_adult_residents' => 'decimal:2',
        'per_child_residents' => 'decimal:2',
        'non_accommodated_visitors_adult' => 'decimal:2',
        'non_accommodated_visitors_child' => 'decimal:2',
        'local_guide_fees_01' => 'decimal:2',
        'local_guide_fees_02' => 'decimal:2',
        'local_guide_fees_03' => 'decimal:2',
        'local_guide_fees_04' => 'decimal:2',
        'local_guide_fees_05' => 'decimal:2',
        'club_car_prices_01' => 'decimal:2',
        'club_car_prices_02' => 'decimal:2',
        'club_car_prices_03' => 'decimal:2',
        'club_car_prices_04' => 'decimal:2',
        'club_car_prices_05' => 'decimal:2',
        'club_car_prices_06' => 'decimal:2',
        'club_car_prices_07' => 'decimal:2',
        'club_car_prices_08' => 'decimal:2',

        'operating_days' => 'json',
        'annual_holidays' => 'json',
        // 'special_schedules' => 'json',
        'day_off' => 'json',
        'yearly_holidays' => 'json',

        'sort_order' => 'integer',
    ];

    public function getRelationshipNames()
    {
        return ['site', 'currency', 'creator', 'updater'];
    }

    public function getExcludedColumns()
    {
        return ['site_id', 'currency_id', 'created_by', 'updated_by', 'sort_order', 'description', 'note'];
    }

    /**
     * Boot method for model events
     */
    protected static function boot()
    {
        parent::boot();

        // Set created_by/updated_by
        static::saving(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });
    }

    /**
     * JSON Accessors - Convert JSON strings to arrays
     */
    public function getOperatingDaysAttribute($value)
    {
        return is_string($value) ? json_decode($value, true) ?? [] : ($value ?? []);
    }

    public function getAnnualHolidaysAttribute($value)
    {
        return is_string($value) ? json_decode($value, true) ?? [] : ($value ?? []);
    }

    // public function getSpecialSchedulesAttribute($value)
    // {
    //     return is_string($value) ? json_decode($value, true) ?? [] : ($value ?? []);
    // }

    public function getDayOffAttribute($value)
    {
        return is_string($value) ? json_decode($value, true) ?? [] : ($value ?? []);
    }

    public function getYearlyHolidaysAttribute($value)
    {
        return is_string($value) ? json_decode($value, true) ?? [] : ($value ?? []);
    }

    /**
     * Mutators - Clean and prepare array fields before storage
     */
    public function setOperatingDaysAttribute($value)
    {
        $cleaned = array_values(array_filter($value ?? []));
        $this->attributes['operating_days'] = json_encode($cleaned);
    }

    public function setAnnualHolidaysAttribute($value)
    {
        $cleaned = array_values(array_filter($value ?? []));
        $this->attributes['annual_holidays'] = json_encode($cleaned);
    }

    // public function setSpecialSchedulesAttribute($value)
    // {
    //     $cleaned = array_values(array_filter($value ?? []));
    //     $this->attributes['special_schedules'] = json_encode($cleaned);
    // }

    public function setDayOffAttribute($value)
    {
        $cleaned = array_values(array_filter($value ?? []));
        $this->attributes['day_off'] = json_encode($cleaned);
    }

    public function setYearlyHolidaysAttribute($value)
    {
        $cleaned = array_values(array_filter($value ?? []));
        $this->attributes['yearly_holidays'] = json_encode($cleaned);
    }

    /**
     * Relationships
     */
    public function site()
    {
        return $this->belongsTo(TouristSite::class, 'site_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
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