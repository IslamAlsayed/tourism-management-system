<?php

namespace App\Models;

use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class TourGuideType extends Model
{
    use HasSearch, HasUuid;

    protected $fillable = [
        'id',
        'uuid',
        'type',
        'price',
        'all_states',
        'all_cities',
        'currency_id',
        'region_id',
        'subregion_id',
        'country_id',
    ];

    public function getRelationshipNames()
    {
        return ['currency', 'region', 'subregion', 'country', 'states', 'cities'];
    }

    public function getExcludedColumns()
    {
        return ['currency_id', 'region_id', 'subregion_id', 'country_id'];
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

    public function states()
    {
        return $this->belongsToMany(State::class, 'tour_guide_type_state');
    }

    public function cities()
    {
        return $this->belongsToMany(City::class, 'tour_guide_type_city');
    }
}