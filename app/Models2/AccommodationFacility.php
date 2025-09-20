<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccommodationFacility extends Model
{
    protected $fillable = [
        'accommodation_id',
        'facility_id',
    ];
}