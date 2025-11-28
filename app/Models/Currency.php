<?php

namespace App\Models;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\FiltersByUserRole;
use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasSearch, FiltersByUserRole, BroadcastsRecordEvents;

    protected $fillable = [
        'id',
        'name',
        'code',
        'symbol',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}