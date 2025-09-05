<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingTransportationCompany extends Model
{
    protected $fillable = [
        'day',
        'price_per_day',
        'booking_id',
        'company_id',
        'bus_type_id',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function company()
    {
        return $this->belongsTo(TransportationCompany::class, 'company_id');
    }

    public function busType()
    {
        return $this->belongsTo(BusType::class);
    }
}