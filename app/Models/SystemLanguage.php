<?php

namespace App\Models;

use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Model;

class SystemLanguage extends Model
{
    use HasSearch;

    protected $fillable = [
        'id',
        'code',
        'name',
        'photo'
    ];
}