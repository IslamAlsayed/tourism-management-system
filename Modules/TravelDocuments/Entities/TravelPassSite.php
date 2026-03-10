<?php

namespace Modules\TravelDocuments\Entities;

use Modules\TouristSites\Entities\TouristSite;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class TravelPassSite extends Model
{
    use HasSearch, HasUuid;

    protected $fillable = [
        'id',
        'uuid',
        'travel_pass_id',
        'tourist_site_id',
        'is_included',
        'visit_limit',
        'special_conditions',
    ];

    public function getRelationshipNames()
    {
        return ['travelPasse', 'touristSite'];
    }

    public function getExcludedColumns()
    {
        return ['travel_pass_id', 'tourist_site_id'];
    }

    protected $casts = [
        'is_included' => 'boolean',
        'visit_limit' => 'integer',
    ];

    public function travelPasse()
    {
        return $this->belongsTo(TravelPasse::class);
    }

    public function touristSite()
    {
        return $this->belongsTo(TouristSite::class);
    }
}
