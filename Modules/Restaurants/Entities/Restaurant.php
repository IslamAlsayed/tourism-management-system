<?php

namespace Modules\Restaurants\Entities;

use App\Traits\HasSearch;
use App\Traits\HasUuid;
use App\Traits\HasCustomFields;
use App\Traits\FiltersByUserRole;
use App\Traits\ClearsEmptyRichText;
use Modules\Geography\Entities\City;
use Modules\Geography\Entities\State;
use Modules\Geography\Entities\Region;
use Modules\Geography\Entities\Subregion;
use Illuminate\Database\Eloquent\Model;
use Modules\Geography\Entities\Country;
use Modules\Accommodations\Entities\Season;
use Modules\Localization\Entities\Currency;
use Modules\Localization\Entities\Timezone;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Restaurant extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, FiltersByUserRole, ClearsEmptyRichText, HasCustomFields;
    protected $richTextAttributes = [
        'description',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'photo',
        'name',
        'name_ar',
        'rating',
        'company_name',
        'specialty',
        'fit_price_adult',
        'fit_price_child_6_11',
        'fit_price_child_under_6',
        'group_price_adult',
        'group_price_child_6_11',
        'group_price_child_under_6',
        'min_group_size',
        'phone_01',
        'phone_02',
        'fax',
        'contact_person',
        'email_01',
        'email_02',
        'box',
        'postal_code',
        'street',
        'mobile',
        'website',
        'latitude',
        'longitude',
        'cat',

        'wheelchair_accessible',
        'free_wifi',
        'parking',
        'swimming_pool',
        'gym',
        'indoor',
        'outdoor',
        'spa',
        'is_active',
        'description',
        'notes',

        'type_id',
        'timezone_id',
        'currency_id',
        'country_id',
        'state_id',
        'city_id',
        'region_id',
        'subregion_id',
    ];

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($item) {
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

    public function getRelationshipNames()
    {
        return ['type', 'timezone', 'currency', 'country', 'state', 'city', 'region', 'subregion', 'seasons', 'meals', 'supplements'];
    }

    public function getExcludedColumns()
    {
        return ['type_id', 'timezone_id', 'currency_id', 'country_id', 'state_id', 'city_id', 'region_id', 'subregion_id', 'description', 'notes'];
    }

    public function type()
    {
        return $this->belongsTo(RestaurantType::class, 'type_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function subregion()
    {
        return $this->belongsTo(Subregion::class);
    }

    public function timezone()
    {
        return $this->belongsTo(Timezone::class);
    }

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

    // علاقة polymorphic modelship للمواسم
    public function seasons()
    {
        return $this->morphMany(Season::class, 'model');
    }

    // علاقة وجبات المطعم - مستقلة
    public function meals()
    {
        return $this->hasMany(RestaurantMeal::class);
    }

    // علاقة إضافات المطعم - مستقلة
    public function supplements()
    {
        return $this->hasMany(RestaurantSupplement::class);
    }
}
