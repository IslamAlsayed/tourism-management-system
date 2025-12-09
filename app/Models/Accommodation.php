<?php

namespace App\Models;

use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class Accommodation extends Model
{
    use HasFactory, HasSearch, HasRichText;

    protected $richTextAttributes = [
        'description',
    ];

    protected $fillable = [
        'id',
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
        'season_id',
        'room_id',
        'meal_id',
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
        return ['currency', 'type', 'season', 'room', 'meal', 'region', 'subregion', 'country', 'state', 'city'];
    }

    public function getExcludedColumns()
    {
        return ['currency_id', 'season_id', 'room_id', 'meal_id', 'region_id', 'subregion_id', 'country_id', 'state_id', 'city_id'];
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function meal()
    {
        return $this->belongsTo(Meal::class, 'meal_id');
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

    public function seasons()
    {
        return $this->belongsToMany(Season::class, 'accommodation_seasons')->withTimestamps()->withPivot('notes');
    }

    public function types()
    {
        return $this->belongsToMany(Type::class, 'accommodation_types', 'accommodation_id', 'type_id', 'id', 'id')
            ->using(AccommodationType::class)
            ->withTimestamps()
            ->withPivot('notes');
    }

    public function roomRates()
    {
        return $this->hasMany(AccommodationRoomRate::class);
    }

    public function mealRates()
    {
        return $this->hasMany(AccommodationMealRate::class);
    }

    public function nationalityRates()
    {
        return $this->hasMany(AccommodationNationalityRate::class);
    }
}