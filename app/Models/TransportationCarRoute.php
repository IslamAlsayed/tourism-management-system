<?php

namespace App\Models;

use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class TransportationCarRoute extends Model
{
    use HasSearch, HasUuid;

    protected $fillable = [
        'uuid',
        'route',
        'route_ar',
        'duration',
        'distance',
    ];
}