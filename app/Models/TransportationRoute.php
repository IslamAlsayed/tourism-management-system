<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportationRoute extends Model
{
    protected $fillable = [
        'start_location',
        'end_location'
    ];

    // الطريق ده ممكن يكون ليه أسعار مختلفة عند شركات مختلفة + باصات مختلفة
    public function rates()
    {
        return $this->hasMany(TransportationRate::class, 'route_id');
    }
}