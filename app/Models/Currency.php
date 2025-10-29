<?php

namespace App\Models;

use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasSearch;

    protected $fillable = [
        'id',
        'name',
        'code',
        'symbol',
        'is_active',
    ];
}