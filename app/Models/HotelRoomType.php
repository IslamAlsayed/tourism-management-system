<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelRoomType extends Model
{
    protected $fillable = [
        'accommodation_id',
        'name_ar',
        'name_en',
        'max_occupancy',
    ];
}