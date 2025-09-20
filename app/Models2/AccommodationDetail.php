<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccommodationDetail extends Model
{
    protected $fillable = [
        'accommodation_id',
        'key',
        'value',
    ];
}