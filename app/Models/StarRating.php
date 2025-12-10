<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class StarRating extends Model
{
    use HasUuid;

    protected $table = 'star_rating';

    protected $fillable = [
        'uuid',
        'star_rating',
        'foreign_id',
    ];

    protected $casts = [
        'star_rating' => 'string',
        'foreign_id' => 'integer',
    ];
}