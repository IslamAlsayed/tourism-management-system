<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportationRoute extends Model
{
    protected $fillable = [
        'start_location',
        'end_location',
        'distance_km'
    ];

    public function rates()
    {
        return $this->hasMany(TransportationRate::class, 'route_id');
    }
}