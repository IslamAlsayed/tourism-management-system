<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\HasSearch;
use App\Traits\FiltersByUserRole;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransportationCompany extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, FiltersByUserRole;

    protected $richTextAttributes = [
        'description',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'name_ar',
        'code',
        'rating',
        'email',
        'phone',
        'mobile',
        'fax',
        'street',
        'box',
        'postal_code',
        'latitude',
        'longitude',
        'website',
        'is_active',
        'description',
        'notes',

        'timezone_id',
        'currency_id',
        'region_id',
        'subregion_id',
        'country_id',
        'state_id',
        'city_id',
    ];

    public function getRelationshipNames()
    {
        return ['timezone', 'currency', 'region', 'subregion', 'country', 'state', 'city', 'seasons', 'supplements'];
    }

    public function getExcludedColumns()
    {
        return ['timezone_id', 'currency_id', 'region_id', 'subregion_id', 'country_id', 'state_id', 'city_id'];
    }

    public function timezone()
    {
        return $this->belongsTo(Timezone::class);
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

    public function seasons()
    {
        return $this->morphMany(Season::class, 'model');
    }

    public function supplements()
    {
        return $this->morphMany(Supplement::class, 'model');
    }
}