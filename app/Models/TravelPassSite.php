<?php

namespace App\Models;

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
        return ['travelPass', 'touristSite'];
    }

    public function getExcludedColumns()
    {
        return ['travel_pass_id', 'tourist_site_id'];
    }

    protected $casts = [
        'is_included' => 'boolean',
        'visit_limit' => 'integer',
    ];

    public function travelPass()
    {
        return $this->belongsTo(TravelPass::class);
    }

    public function touristSite()
    {
        return $this->belongsTo(TouristSite::class);
    }
}
