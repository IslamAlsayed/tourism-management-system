<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $fillable = [
        'name',
        'season_from',
        'season_to',
        'is_special',
        'special_type',
        'accommodation_id',
    ];
}