<?php

namespace Modules\TourGuides\Entities;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\FiltersByUserRole;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Modules\Geography\Entities\City;

class TourGuideTypeCity extends Model
{
    use HasSearch, HasUuid, FiltersByUserRole, BroadcastsRecordEvents;

    protected $table = 'tour_guide_type_city';
    protected $fillable = [
        'id',
        'uuid',
        'tour_guide_type_id',
        'city_id',
    ];

    public function getRelationshipNames()
    {
        return ['tourGuideType', 'city'];
    }

    public function getExcludedColumns()
    {
        return ['tour_guide_type_id', 'city_id'];
    }

    public function tourGuideType()
    {
        return $this->belongsTo(TourGuideType::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
