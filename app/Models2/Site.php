<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = [
        'name',
        'name_ar',
        'entry_fee',
        'city_id',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}