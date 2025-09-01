<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccommodationSupplement extends Model
{
    protected $fillable = [
        'accommodation_id',
        'supplement_name',
        'price',
        'currency_id',
        'applicable_to',
    ];
}
