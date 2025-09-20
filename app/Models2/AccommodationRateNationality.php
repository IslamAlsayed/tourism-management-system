<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccommodationRateNationality extends Model
{
    protected $table = 'accommodation_rate_nationality';

    protected $fillable = [
        'accommodation_rate_id',
        'nationality_id',
        'is_all',
    ];
}