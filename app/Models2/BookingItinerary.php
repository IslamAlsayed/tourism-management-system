<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingItinerary extends Model
{
    protected $fillable = [
        'day_number',
        'description',
        'booking_id',
        'city_id',
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