<?php

namespace Modules\TourGuides\Entities;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\ClearsEmptyRichText;
use App\Traits\FiltersByUserRole;
use App\Traits\HasCustomFields;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Modules\Geography\Entities\City;
use Modules\Geography\Entities\Country;
use Modules\Geography\Entities\State;
use Modules\Localization\Entities\Currency;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class TourGuideType extends Model
{
    use BroadcastsRecordEvents, ClearsEmptyRichText, FiltersByUserRole, HasCustomFields, HasRichText, HasSearch, HasUuid;

    protected $richTextAttributes = [
        'description',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'type',
        'price',
        'all_states',
        'all_cities',
        'is_active',
        'description',
        'notes',
        'currency_id',
        'country_id',
    ];

    public function getSearchableRelations(): array
    {
        return [
            'currency' => ['uuid', 'name', 'name_ar', 'name_en', 'code', 'symbol', 'exchange_rate', 'is_auto_update', 'decimal_places', 'is_active', 'is_major_currency', 'is_base_currency', 'sort_order'],
            'country' => ['name', 'name_en', 'name_ar', 'iso2', 'iso3', 'phone_code', 'capital', 'currency', 'currency_name', 'currency_symbol', 'tld', 'native', 'region', 'subregion', 'nationality', 'latitude', 'longitude', 'is_active', 'language_id', 'currency_id', 'region_id', 'subregion_id', 'description', 'notes'],
            'states' => ['name', 'name_en', 'name_ar', 'state_code', 'latitude', 'longitude', 'is_active', 'description', 'notes'],
            'cities' => ['name', 'name_en', 'name_ar', 'latitude', 'longitude', 'is_active', 'description', 'notes', 'population'],
        ];
    }

    public function getRelationshipNames()
    {
        return ['currency', 'country', 'states', 'cities'];
    }

    public function getExcludedColumns()
    {
        return ['currency_id', 'country_id', 'description', 'notes'];
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function states()
    {
        return $this->belongsToMany(State::class, 'tour_guide_type_state');
    }

    public function cities()
    {
        return $this->belongsToMany(City::class, 'tour_guide_type_city');
    }
}
