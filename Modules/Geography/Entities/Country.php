<?php

namespace Modules\Geography\Entities;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\ClearsEmptyRichText;
use App\Traits\FiltersByUserRole;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Geography\Entities\City;
use Modules\Geography\Entities\Region;
use Modules\Geography\Entities\State;
use Modules\Geography\Entities\Subregion;
use Modules\Localization\Entities\Currency;
use Modules\Localization\Entities\Language;
use Modules\Localization\Entities\Timezone;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class Country extends Model
{
    use HasSearch, HasRichText, HasUuid, FiltersByUserRole, BroadcastsRecordEvents, ClearsEmptyRichText, SoftDeletes;
    protected $richTextAttributes = [
        'description',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'photo',
        'emoji',
        'emojiU',
        'name',
        'name_ar',
        'iso2',
        'iso3',
        'numeric_code',
        'phone_code',
        'capital',
        'tld',
        'native',
        'latitude',
        'longitude',
        'population',
        'area',
        'is_active',
        'is_independent',
        'is_developed',
        'is_landlocked',
        'description',
        'notes',
        'timezone_id',
        'language_id',
        'currency_id',
        'region_id',
        'subregion_id',
    ];

    public function getRelationshipNames()
    {
        return ['timezone', 'language', 'currency', 'region', 'subregion', 'states', 'cities', 'accommodations', 'restaurants', 'transportationCompanies'];
    }

    public function getExcludedColumns()
    {
        return ['timezone_id', 'language_id', 'currency_id', 'region_id', 'subregion_id', 'description', 'notes'];
    }

    public function timezone()
    {
        return $this->belongsTo(Timezone::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function subregion()
    {
        return $this->belongsTo(Subregion::class);
    }

    public function states()
    {
        return $this->hasMany(State::class);
    }

    public function states_pivot()
    {
        return $this->belongsToMany(State::class, 'country_state', 'country_id', 'state_id');
    }

    public function cities()
    {
        return $this->hasManyThrough(City::class, State::class);
    }

    public function cities_pivot()
    {
        return $this->belongsToMany(City::class, 'country_city', 'country_id', 'city_id');
    }

    public function accommodations()
    {
        return $this->hasMany(\Modules\Accommodations\Entities\Accommodation::class);
    }

    public function restaurants()
    {
        return $this->hasMany(\Modules\Restaurants\Entities\Restaurant::class);
    }

    public function transportationCompanies()
    {
        return $this->hasMany(\Modules\Transportation\Entities\Company::class);
    }
}
