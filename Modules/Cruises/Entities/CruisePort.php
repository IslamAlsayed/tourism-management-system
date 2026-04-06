<?php

namespace Modules\Cruises\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasUuid;
use App\Traits\FiltersByUserRole;
use App\Traits\HasSearch;
use Modules\Geography\Entities\City;
use Modules\Geography\Entities\Country;

class CruisePort extends Model
{
    use HasFactory, SoftDeletes, HasUuid, FiltersByUserRole, HasSearch;

    protected $fillable = [
        'company_id',
        'name',
        'name_ar',
        'city_id',
        'country_id',
        'latitude',
        'longitude',
        'type',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    /**
     * Get the city where the port is located.
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the country where the port is located.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    protected static function newFactory()
    {
        return \Modules\Cruises\Database\factories\CruisePortFactory::new();
    }
}
