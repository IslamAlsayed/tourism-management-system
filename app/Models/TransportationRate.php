<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportationRate extends Model
{
    protected $fillable = [
        'transportation_company_id',
        'vehicle_type',
        'rate_per_km',
        'currency_id',
    ];
}
