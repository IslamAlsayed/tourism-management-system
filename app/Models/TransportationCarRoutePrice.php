<?php

namespace App\Models;

use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class TransportationCarRoutePrice extends Model
{
    use HasSearch, HasUuid;

    protected $fillable = [
        'uuid',
        'car_route_id',
        'seats',
        'currency_id',
        'price',
    ];

    /**
     * Get relationship names for eager loading
     */
    public function getRelationshipNames()
    {
        return ['car_route', 'currency'];
    }

    /**
     * Get columns to exclude from search/display
     */
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