<?php

namespace Modules\Geography\Entities;

use App\Traits\HasUuid;
use App\Traits\HasSearch;
use App\Traits\BroadcastsRecordEvents;
use Illuminate\Database\Eloquent\Model;

class CityState extends Model
{
    use HasSearch, HasUuid, BroadcastsRecordEvents;

    protected $table = 'city_state';

    protected $fillable = [
        'id',
        'uuid',
        'state_id',
        'city_id',
    ];

    public function getRelationshipNames()
    {
        return ['state', 'city'];
    }

    public function getExcludedColumns()
    {
        return ['state_id', 'city_id'];
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
