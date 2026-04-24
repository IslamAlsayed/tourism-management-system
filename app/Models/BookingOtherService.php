<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @status PLACEHOLDER — Pivot model for Booking ↔ OtherService.
 * @todo Create within Modules\Bookings when Booking module is built.
 */
class BookingOtherService extends Model
{
    protected $table = 'booking_other_service';
    protected $guarded = ['id'];
}
