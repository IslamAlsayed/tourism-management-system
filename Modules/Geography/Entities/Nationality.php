<?php

namespace Modules\Geography\Entities;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\FiltersByUserRole;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nationality extends Model
{
    use HasSearch, HasUuid, FiltersByUserRole, BroadcastsRecordEvents, SoftDeletes;

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
        return ['uuid', 'country_id', 'description', 'notes', 'created_at', 'updated_at', 'deleted_at'];
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
