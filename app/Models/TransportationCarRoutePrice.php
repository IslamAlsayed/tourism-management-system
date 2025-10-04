<?php

namespace App\Models;

use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Model;

class TransportationCarRoutePrice extends Model
{
    use HasSearch;

    protected $fillable = [
        'car_route_id',
        'seats',
        'currency_id',
        'price',
    ];

    public function getRelationshipNames()
    {
        return ['car_route', 'currency'];
    }

    public function getExcludedColumns()
    {
        return ['car_route_id', 'currency_id'];
    }

    public function car_route()
    {
        return $this->belongsTo(TransportationCarRoute::class, 'car_route_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}