<?php

namespace Modules\TravelDocuments\Entities;

use Modules\EntryPoints\Entities\Landcrossing;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Entities\User;
use Modules\Geography\Entities\Country;
use Modules\Geography\Entities\Nationality;
use Modules\Localization\Entities\Currency;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class VisaRequirement extends Model
{
    use HasSearch, HasUuid, HasRichText, HasFactory;

    protected $richTextAttributes = [
        'description',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'nationality_id',
        'destination_country_id',
        'landcrossing_id',
        'visa_type',
        'visa_category',
        'can_issue_at_port',
        'max_stay_days',
        'visa_validity_days',
        'visa_fee',
        'visa_fee_currency_id',
        'departure_tax',
        'departure_tax_currency_id',
        'processing_time_days',
        'group_min_size',
        'group_min_nights',
        'group_processing_days',
        'application_url',
        'official_source_url',
        'effective_from',
        'effective_until',
        'last_verified_at',
        'is_restricted',
        'is_active',
        'description',
        'notes',
    ];

    public function getRelationshipNames()
    {
        return ['nationality', 'destinationCountry', 'landcrossing', 'visaFeeCurrency', 'departureTaxCurrency'];
    }

    public function getExcludedColumns()
    {
        return ['nationality_id', 'destination_country_id', 'crossing_port_id', 'visa_fee_currency_id', 'departure_tax_currency_id', 'description', 'notes'];
    }

    protected $casts = [
        'is_restricted' => 'boolean',
        'can_issue_at_port' => 'boolean',
        'is_active' => 'boolean',
        'visa_fee' => 'decimal:2',
        'departure_tax' => 'decimal:2',
        'max_stay_days' => 'integer',
        'visa_validity_days' => 'integer',
        'processing_time_days' => 'integer',
        'group_min_size' => 'integer',
        'group_min_nights' => 'integer',
        'group_processing_days' => 'integer',
        'effective_from' => 'date',
        'effective_until' => 'date',
        'last_verified_at' => 'datetime',
    ];

    public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }

    public function destinationCountry()
    {
        return $this->belongsTo(Country::class, 'destination_country_id');
    }

    public function landcrossing()
    {
        return $this->belongsTo(Landcrossing::class);
    }

    public function visaFeeCurrency()
    {
        return $this->belongsTo(Currency::class, 'visa_fee_currency_id');
    }

    public function departureTaxCurrency()
    {
        return $this->belongsTo(Currency::class, 'departure_tax_currency_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForNationality($query, $nationalityId)
    {
        return $query->where('nationality_id', $nationalityId);
    }

    public function scopeForCountry($query, $countryId)
    {
        return $query->where('destination_country_id', $countryId);
    }

    public static function getVisaTypes()
    {
        return [
            'none_required' => __('main.none_required'),
            'on_arrival' => __('main.on_arrival'),
            'e_visa' => __('main.e_visa'),
            'embassy_required' => __('main.embassy_required'),
            'transit' => __('main.transit'),
            'restricted' => __('main.restricted'),
        ];
    }

    public static function getVisaCategories()
    {
        return [
            'tourist' => __('main.tourist'),
            'business' => __('main.business'),
            'medical' => __('main.medical'),
            'student' => __('main.student'),
            'work' => __('main.work'),
            'transit' => __('main.transit'),
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
