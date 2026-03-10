<?php

namespace Modules\TravelDocuments\Entities;

use Modules\TouristSites\Entities\TouristSite;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Entities\User;
use Modules\Geography\Entities\Country;
use Modules\Localization\Entities\Currency;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class TravelPasse extends Model
{
    use HasSearch, HasUuid, HasRichText, HasFactory;

    protected $richTextAttributes = [
        'description',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'name_ar',
        'pass_type',
        'price',
        'validity_days',
        'special_attraction_days',
        'waives_visa_fee',
        'min_stay_nights',
        'must_purchase_before_arrival',
        'official_purchase_url',
        'sort_order',
        'is_featured',
        'is_active',
        'description',
        'notes',

        'currency_id',
        'country_id',
    ];

    public function getRelationshipNames()
    {
        return ['country', 'currency', 'touristSites'];
    }

    public function getExcludedColumns()
    {
        return ['country_id', 'currency_id', 'description', 'notes'];
    }

    protected $casts = [
        'price' => 'decimal:2',
        'validity_days' => 'integer',
        'special_attraction_days' => 'integer',
        'waives_visa_fee' => 'boolean',
        'min_stay_nights' => 'integer',
        'must_purchase_before_arrival' => 'boolean',
        'sort_order' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function touristSites()
    {
        return $this->belongsToMany(TouristSite::class, 'travel_pass_sites', 'travel_pass_id', 'tourist_site_id');
    }

    public function includedSites()
    {
        return $this->touristSites()->wherePivot('is_included', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeForCountry($query, $countryId)
    {
        return $query->where('country_id', $countryId);
    }

    public function getDisplayNameAttribute()
    {
        if (app()->getLocale() === 'ar' && $this->name_ar) {
            return $this->name_ar;
        }
        return $this->name;
    }

    public static function getPassTypes()
    {
        return [
            'wanderer' => __('main.wanderer'),
            'explorer' => __('main.explorer'),
            'expert' => __('main.expert'),
            'basic' => __('main.basic'),
            'premium' => __('main.premium'),
            'custom' => __('main.custom'),
        ];
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
}
