<?php

namespace Modules\Restaurants\Entities;

use App\Traits\HasUuid;
use App\Traits\HasSearch;
use App\Traits\FiltersByUserRole;
use App\Traits\ClearsEmptyRichText;
use Modules\Geography\Entities\City;
use Illuminate\Database\Eloquent\Model;
use Modules\Accommodations\Entities\Meal;
use Modules\Accommodations\Entities\Type;
use Modules\Accommodations\Entities\Season;
use Modules\Localization\Entities\Currency;
use Modules\Localization\Entities\Timezone;
use Modules\Accommodations\Entities\Supplement;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Restaurant extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, FiltersByUserRole, ClearsEmptyRichText;
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
        'city_id',
    ];

    // protected static function boot()
    // {
    //     parent::boot();
    //     static::saving(function ($item) {
    //         if (empty($item->country_id) && !empty($item->city_id)) {
    //             $item->country_id = $item->city?->country_id;
    //         }
    //         if (empty($item->state_id) && !empty($item->city_id)) {
    //             $item->state_id = $item->city?->state_id;
    //         }
    //     });

    //     static::updating(function ($item) {
    //         if (empty($item->country_id) && !empty($item->city_id)) {
    //             $item->country_id = $item->city?->country_id;
    //         }
    //         if (empty($item->state_id) && !empty($item->city_id)) {
    //             $item->state_id = $item->city?->state_id;
    //         }
    //     });
    // }

    public function getRelationshipNames()
    {
        return ['type', 'timezone', 'currency', 'city', 'seasons', 'meals', 'supplements'];
    }

    public function getExcludedColumns()
    {
        return ['type_id', 'timezone_id', 'currency_id', 'city_id', 'description', 'notes'];
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function timezone()
    {
        return $this->belongsTo(Timezone::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
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

    // علاقة polymorphic modelship للوجبات
    public function meals()
    {
        return $this->morphMany(Meal::class, 'model');
    }

    // علاقة polymorphic modelship للإضافات
    public function supplements()
    {
        return $this->morphMany(Supplement::class, 'model');
    }
}
