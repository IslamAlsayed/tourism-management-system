<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelRate extends Model
{
    protected $fillable = [
        'meal_plan',
        'rate_per_person',
        'single_supplement',
        'hotel_id',
        'hotel_season_id',
        'room_type_id',
        'accommodation_id',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function hotelSeason()
    {
        return $this->belongsTo(HotelSeason::class);
    }

    public function roomType()
    {
        // return $this->belongsTo(HotelRoomType::class);
        return $this->belongsTo(HotelRoomType::class, 'room_type_id');
    }

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }
}