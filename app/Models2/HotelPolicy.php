<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelPolicy extends Model
{
    protected $fillable = [
        'hotel_id',
        'accommodation_id',
        'check_in_time',
        'check_out_time',
        'cancellation_policy',
        'child_policy',
        'pet_policy',
    ];
}