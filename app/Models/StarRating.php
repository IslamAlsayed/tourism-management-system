<?php

namespace App\Models;

use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Model;

class StarRating extends Model
{
    use HasSearch;

    protected $fillable = [
        'id',
        'star_rating',
        'foreign_id'
    ];
}