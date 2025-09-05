<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingOtherService extends Model
{
    protected $fillable = [
        'selected',
        'quantity',
        'price',
        'booking_id',
        'other_service_id',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function otherService()
    {
        return $this->belongsTo(OtherService::class);
    }
}