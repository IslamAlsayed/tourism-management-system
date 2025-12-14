<?php

namespace App\Models;

use App\Traits\HasSearch;
use App\Traits\HasUuid;
use App\Traits\FiltersByUserRole;
use App\Traits\BroadcastsRecordEvents;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Accommodation extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, FiltersByUserRole, BroadcastsRecordEvents;

    protected $richTextAttributes = [
        'description',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'name_ar',
        'classification',
        'stars',
        'description',
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
        'currency_id',
        'type_id',
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

    public function getRelationshipNames()
    {
        return ['currency', 'type', 'seasons', 'rooms', 'meals', 'region', 'subregion', 'country', 'state', 'city'];
    }

    public function getExcludedColumns()
    {
        return ['currency_id', 'type_id', 'region_id', 'subregion_id', 'country_id', 'state_id', 'city_id'];
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    // Many-to-Many: accommodation يمكن أن يكون له عدة seasons عبر جدول accommodation_seasons
    public function seasons()
    {
        // return $this->belongsToMany(Season::class, 'accommodation_seasons')->withTimestamps()->withPivot('notes');
        return $this->hasMany(AccommodationSeason::class);
    }

    // One-to-Many: جدول accommodation_room_rates يحتوي على أسعار الغرف لكل موسم
    public function rooms()
    {
        // return $this->belongsToMany(Room::class, 'accommodation_room_rates')->withTimestamps()->withPivot('notes');
        return $this->hasMany(AccommodationRoomRate::class);
    }

    // One-to-Many: جدول accommodation_meal_rates يحتوي على أسعار الوجبات لكل موسم
    public function meals()
    {
        // return $this->belongsToMany(Meal::class, 'accommodation_meal_rates')->withTimestamps()->withPivot('notes');
        return $this->hasMany(AccommodationMealRate::class);
    }

    // One-to-Many: Accommodation has many supplements
    public function supplements()
    {
        return $this->hasMany(AccommodationSupplement::class);
    }

    // public function nationalityRates()
    // {
    //     return $this->hasMany(AccommodationNationalityRate::class);
    // }

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
}