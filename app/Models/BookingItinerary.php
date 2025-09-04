<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingItinerary extends Model
{
    protected $fillable = [
        'booking_id',
        'day_number',
        'city_id',
        'description'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}