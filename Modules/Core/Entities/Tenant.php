<?php

namespace Modules\Core\Entities;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\FiltersByUserRole;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory, HasSearch, HasUuid, FiltersByUserRole, BroadcastsRecordEvents;

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'type',
        'status',
    ];
}
