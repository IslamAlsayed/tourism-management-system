<?php

namespace Modules\Geography\Entities;

use App\Traits\HasUuid;
use Modules\Localization\Entities\Timezone;
use App\Traits\HasSearch;
use App\Traits\FiltersByUserRole;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class State extends Model
{
    use HasSearch, HasUuid, HasRichText, FiltersByUserRole, SoftDeletes;
    protected $richTextAttributes = [
        'description',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'name_ar',
        'iso2',
        'iso3',
        'fips_code',
        'type',
        'level',
        'latitude',
        'longitude',
        'photo',
        'is_active',
        'is_independent',
        'is_developed',
        'is_landlocked',
        'description',
        'notes',
        'timezone_id',
        'country_id',
    ];

    public function getRelationshipNames()
    {
        return ['timezone', 'country', 'city', 'cities', 'accommodations', 'restaurants', 'transportationCompanies'];
    }

    public function getExcludedColumns()
    {
        return ['timezone_id', 'country_id', 'description', 'notes'];
    }

    public function timezone()
    {
        return $this->belongsTo(Timezone::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function cities_pivot()
    {
        return $this->belongsToMany(City::class, 'city_state');
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
