<?php

namespace App\Models;

use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Model;

class TransportationCarRoute extends Model
{
    use HasSearch;

    protected $fillable = [
        'route',
        'route_ar',
        'duration',
        'distance',
    ];
}