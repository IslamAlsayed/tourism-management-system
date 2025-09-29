<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StarRating extends Model
{
    protected $fillable = [
        'star_rating',
        'foreign_id'
    ];
}