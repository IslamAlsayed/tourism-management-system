<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportationRate extends Model
{
    protected $fillable = [
        'price_per_day',
        'price_per_km',
        'company_id',
        'bus_type_id',
        'route_id',
    ];

    public function company()
    {
        return $this->belongsTo(TransportationCompany::class, 'company_id');
    }

    public function busType()
    {
        return $this->belongsTo(BusType::class, 'bus_type_id');
    }

    public function route()
    {
        return $this->belongsTo(TransportationRoute::class, 'route_id');
    }
}