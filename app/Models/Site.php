<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = [
        'name_ar',
        'name_en',
        'entry_fee',
        'currency_id',
        'city',
    ];
}
