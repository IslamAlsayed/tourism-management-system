<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelSeason extends Model
{
    protected $fillable = [
        'season_name',
        'start_date',
        'end_date',
        'hotel_id',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}