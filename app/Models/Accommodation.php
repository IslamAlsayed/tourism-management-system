<?php

namespace App\Models;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\FiltersByUserRole;
use App\Traits\HandlesRichTextAttributes;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class Accommodation extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, FiltersByUserRole, BroadcastsRecordEvents, HandlesRichTextAttributes;
    protected $richTextAttributes = [
        'description',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
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
        'region_id',
        'subregion_id',
        'country_id',
        'state_id',
        'city_id',
    ];

    protected $casts = [
        'stars' => 'integer',
        'is_active' => 'boolean',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($item) {
            if (empty($item->region_id) && !empty($item->country_id)) {
                $item->region_id = $item->country?->region_id;
            }
            if (empty($item->subregion_id) && !empty($item->country_id)) {
                $item->subregion_id = $item->country?->subregion_id;
            }
            if (!isset($item->country_id) || empty($item->country_id)) {
                if (!empty($item->city_id) && $item->city) {
                    $item->country_id = $item->city?->country_id;
                } elseif (!empty($item->state_id) && $item->state) {
                    $item->country_id = $item->state?->country_id;
                }
            }
            if (!isset($item->state_id) || empty($item->state_id)) {
                if (!empty($item->city_id) && $item->city) {
                    $item->state_id = $item->city?->state_id;
                }
            }
        });

        static::updating(function ($item) {
            if (empty($item->region_id) && !empty($item->country_id)) {
                $item->region_id = $item->country?->region_id;
            }
            if (empty($item->subregion_id) && !empty($item->country_id)) {
                $item->subregion_id = $item->country?->subregion_id;
            }
            if (!isset($item->country_id) || empty($item->country_id)) {
                if (!empty($item->city_id) && $item->city) {
                    $item->country_id = $item->city?->country_id;
                } elseif (!empty($item->state_id) && $item->state) {
                    $item->country_id = $item->state?->country_id;
                }
            }
            if (!isset($item->state_id) || empty($item->state_id)) {
                if (!empty($item->city_id) && $item->city) {
                    $item->state_id = $item->city?->state_id;
                }
            }
        });
    }

    public function getRelationshipNames()
    {
        return ['type', 'currency', 'region', 'subregion', 'country', 'state', 'city', 'seasons', 'rooms', 'meals', 'supplements'];
    }

    public function getExcludedColumns()
    {
        return ['type_id', 'currency_id', 'region_id', 'subregion_id', 'country_id', 'state_id', 'city_id', 'description', 'notes'];
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
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
