<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @status PLACEHOLDER — Pivot model for Booking ↔ TransportationCompany.
 * @todo Create within Modules\Bookings when Booking module is built.
 */
class BookingTransportationCompany extends Model
{
    protected $table = 'booking_transportation_company';
    protected $guarded = ['id'];
}
