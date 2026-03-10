<?php

namespace Modules\Localization\Entities;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\FiltersByUserRole;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasSearch, HasUuid, FiltersByUserRole, BroadcastsRecordEvents;

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'name_ar',
        'name_en',
        'code',
        'symbol',
        'exchange_rate',
        'is_auto_update',
        'decimal_places',
        'is_active',
        'is_major_currency',
        'is_base_currency',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_auto_update' => 'boolean',
    ];
}
