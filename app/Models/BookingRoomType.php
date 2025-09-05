<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingRoomType extends Model
{
    protected $fillable = [
        'booking_id',
        'hotel_room_type_id',
        'quantity',
    ];

    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_room_type')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function roomType()
    {
        return $this->belongsTo(HotelRoomType::class, 'hotel_room_type_id');
    }
}