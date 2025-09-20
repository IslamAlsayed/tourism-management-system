<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccommodationSupplement extends Model
{
    protected $fillable = [
        'name',
        'price',
        'is_per_person',
        'is_mandatory',
        'applicable_date',
        'accommodation_id',
    ];
}