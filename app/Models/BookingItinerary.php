<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @status PLACEHOLDER — BookingItinerary (child of Booking).
 * @todo Create within Modules\Bookings when Booking module is built.
 */
class BookingItinerary extends Model
{
    protected $guarded = ['id'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
