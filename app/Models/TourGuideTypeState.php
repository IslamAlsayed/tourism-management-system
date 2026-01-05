<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\HasSearch;
use App\Traits\BroadcastsRecordEvents;
use Illuminate\Database\Eloquent\Model;

class TourGuideTypeState extends Model
{
    use HasSearch, HasUuid, BroadcastsRecordEvents;

    protected $table = 'tour_guide_type_state';
    protected $fillable = [
        'id',
        'uuid',
        'tour_guide_type_id',
        'state_id',
    ];

    public function getRelationshipNames()
    {
        return ['tourGuideType', 'state'];
    }

    public function getExcludedColumns()
    {
        return ['tour_guide_type_id', 'state_id'];
    }

    public function tourGuideType()
    {
        return $this->belongsTo(TourGuideType::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}