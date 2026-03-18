<?php

namespace Modules\TourGuides\Entities;

use App\Traits\HasUuid;
use App\Traits\HasSearch;
use App\Traits\HasCustomFields;
use App\Traits\FiltersByUserRole;
use App\Traits\ClearsEmptyRichText;
use Modules\Geography\Entities\City;
use Modules\Geography\Entities\State;
use App\Traits\BroadcastsRecordEvents;
use Illuminate\Database\Eloquent\Model;
use Modules\Geography\Entities\Country;
use Modules\Localization\Entities\Currency;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class TourGuide extends Model
{
    use HasSearch, HasUuid, HasRichText, FiltersByUserRole, BroadcastsRecordEvents, ClearsEmptyRichText, HasCustomFields;
    protected $richTextAttributes = [
        'description',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'name_ar',
        'email',
        'mobile_01',
        'mobile_02',
        'home_city',
        'birth_date',
        'age',
        'photo',
        'gender',
        'national_guide_id',
        'tourism_ministry_code',
        'fd_day_fees',
        'hd_day_fees',
        'extra_fees_1',
        'extra_fees_2',
        'is_active',
        'description',
        'notes',
        'currency_id',
        'guide_type_id',
        'country_id',
        'state_id',
        'city_id',
    ];

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($item) {
            if ($item->birth_date) {
                $item->age = \Carbon\Carbon::parse($item->birth_date)->age;
            }
            if (empty($item->country_id) && !empty($item->city_id)) {
                $item->country_id = $item->city?->country_id;
            }
            if (empty($item->state_id) && !empty($item->city_id)) {
                $item->state_id = $item->city?->state_id;
            }
        });

        static::updating(function ($item) {
            if (empty($item->country_id) && !empty($item->city_id)) {
                $item->country_id = $item->city?->country_id;
            }
            if (empty($item->state_id) && !empty($item->city_id)) {
                $item->state_id = $item->city?->state_id;
            }
        });
    }

    public function getSearchableRelations(): array
    {
        return [
            'currency' => ['uuid', 'name', 'name_ar', 'name_en', 'code', 'symbol', 'exchange_rate', 'is_auto_update', 'decimal_places', 'is_active', 'is_major_currency', 'is_base_currency', 'sort_order'],
            'guide_type' => ['uuid', 'type', 'price', 'all_states', 'all_cities', 'is_active', 'description', 'notes'],
            'country' => ['name', 'name_en', 'name_ar', 'iso2', 'iso3', 'phone_code', 'capital', 'currency', 'currency_name', 'currency_symbol', 'tld', 'native', 'region', 'subregion', 'nationality', 'latitude', 'longitude', 'is_active', 'language_id', 'currency_id', 'region_id', 'subregion_id', 'description', 'notes'],
            'state' => ['name', 'name_en', 'name_ar', 'state_code', 'latitude', 'longitude', 'is_active', 'description', 'notes'],
            'city' => ['name', 'name_en', 'name_ar', 'latitude', 'longitude', 'is_active', 'description', 'notes', 'population'],
        ];
    }

    public function getRelationshipNames()
    {
        return ['currency', 'guide_type', 'tourGuideLanguages', 'country', 'state', 'city'];
    }

    public function getExcludedColumns()
    {
        return ['currency_id', 'guide_type_id', 'country_id', 'state_id', 'city_id', 'description', 'notes'];
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function guide_type()
    {
        return $this->belongsTo(TourGuideType::class, 'guide_type_id');
    }

    public function tourGuideLanguages()
    {
        return $this->hasMany(TourGuideLanguage::class, 'tour_guide_id')->with('language');
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
}
