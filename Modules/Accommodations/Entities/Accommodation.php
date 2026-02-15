<?php

namespace Modules\Accommodations\Entities;

use App\Traits\HasUuid;
use App\Traits\HasSearch;
use App\Traits\FiltersByUserRole;
use App\Traits\ClearsEmptyRichText;
use Modules\Geography\Entities\City;
use App\Traits\BroadcastsRecordEvents;
use Illuminate\Database\Eloquent\Model;
use Modules\Accommodations\Entities\Type;
use Modules\Localization\Entities\Currency;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Accommodation extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, FiltersByUserRole, BroadcastsRecordEvents, ClearsEmptyRichText;
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
        'classification',
        'stars',
        'general_mobile',
        'general_email',
        'email',
        'website',
        'phone',
        'phone_ext',
        'fax',
        'contact_person',
        'contact_position',
        'contact_mobile',
        'contact_email',
        'street',
        'box',
        'postal_code',
        'latitude',
        'longitude',
        'contract_file_path',
        'is_active',
        'description',
        'notes',

        'type_id',
        'currency_id',
        'city_id',
    ];

    protected $casts = [
        'stars' => 'integer',
        'is_active' => 'boolean',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    // protected static function boot()
    // {
    //     parent::boot();
    //     static::saving(function ($item) {
    //         if (!isset($item->country_id) || empty($item->country_id)) {
    //             if (!empty($item->city_id) && $item->city) {
    //                 $item->country_id = $item->city?->country_id;
    //             } elseif (!empty($item->state_id) && $item->state) {
    //                 $item->country_id = $item->state?->country_id;
    //             }
    //         }
    //         if (!isset($item->state_id) || empty($item->state_id)) {
    //             if (!empty($item->city_id) && $item->city) {
    //                 $item->state_id = $item->city?->state_id;
    //             }
    //         }
    //     });

    //     static::updating(function ($item) {
    //         if (!isset($item->country_id) || empty($item->country_id)) {
    //             if (!empty($item->city_id) && $item->city) {
    //                 $item->country_id = $item->city?->country_id;
    //             } elseif (!empty($item->state_id) && $item->state) {
    //                 $item->country_id = $item->state?->country_id;
    //             }
    //         }
    //         if (!isset($item->state_id) || empty($item->state_id)) {
    //             if (!empty($item->city_id) && $item->city) {
    //                 $item->state_id = $item->city?->state_id;
    //             }
    //         }
    //     });
    // }

    public function getRelationshipNames()
    {
        return ['type', 'currency', 'city', 'seasons', 'rooms', 'meals', 'supplements'];
    }

    public function getExcludedColumns()
    {
        return ['type_id', 'currency_id', 'city_id', 'description', 'notes'];
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
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

    // علاقة polymorphic modelship للغرف
    public function rooms()
    {
        return $this->morphMany(Room::class, 'model');
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
