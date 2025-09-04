<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportationRate extends Model
{
    protected $fillable = [
        'price_per_day',
        'company_id',
        'bus_type_id',
        'route_id',
    ];

    // السعر ده بيتبع شركة
    public function company()
    {
        return $this->belongsTo(TransportationCompany::class, 'company_id');
    }

    // بيتبع نوع باص
    public function busType()
    {
        return $this->belongsTo(BusType::class, 'bus_type_id');
    }

    // بيتبع مسار
    public function route()
    {
        return $this->belongsTo(TransportationRoute::class, 'route_id');
    }
}