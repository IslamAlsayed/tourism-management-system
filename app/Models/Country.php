<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name',
        'code',
        'flag_url',
        'flag_emoji',
        'currency_code',
        'capital',
        'phone_code',
        'continent',
        'population',
        'area',
        'is_active',
    ];

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
