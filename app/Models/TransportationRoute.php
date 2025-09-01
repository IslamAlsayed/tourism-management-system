<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportationRoute extends Model
{
    protected $fillable = [
        'transportation_company_id',
        'route_name',
        'start_location',
        'end_location',
        'distance_km',
    ];
}