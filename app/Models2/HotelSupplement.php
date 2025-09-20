<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelSupplement extends Model
{
    protected $fillable = [
        'hotel_id',
        'accommodation_id',
        'supplement_name',
        'price',
        'currency_id',
        'applicable_to',
    ];
}