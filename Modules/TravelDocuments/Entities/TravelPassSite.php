<?php

namespace Modules\TravelDocuments\Entities;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\ClearsEmptyRichText;
use App\Traits\FiltersByUserRole;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Modules\Tourists\Entities\TouristSite;

class TravelPassSite extends Model
{
    use HasSearch, HasUuid, FiltersByUserRole, BroadcastsRecordEvents, ClearsEmptyRichText;

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
