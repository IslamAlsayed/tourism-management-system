<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TouristSite extends Model
{
    protected $fillable = [
        'site_name',
        'location',
        'description',
        'entry_fee',
        'opening_hours',
    ];
}
