<?php

namespace App\Models;

use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasSearch;

    protected $fillable = [
        'id',
        'name',
        'name_ar'
    ];
}