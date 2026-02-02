<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\HasSearch;
use App\Traits\FiltersByUserRole;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class State extends Model
{
    use HasSearch, HasUuid, HasRichText, FiltersByUserRole;
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
        'all_cities',
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
        return ['timezone', 'country', 'city', 'cities'];
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
        return $this->belongsToMany(City::class, 'city_state');
    }
}
