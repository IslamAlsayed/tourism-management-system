<?php

namespace Modules\Geography\Entities;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\FiltersByUserRole;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    use HasSearch, HasUuid, FiltersByUserRole, BroadcastsRecordEvents;

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'name_ar',
        'is_active',
        'description',
        'notes',
        'country_id',
    ];

    public function getRelationshipNames()
    {
        return ['country'];
    }

    public function getExcludedColumns()
    {
        return ['country_id', 'description', 'notes'];
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
