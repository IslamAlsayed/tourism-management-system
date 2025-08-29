<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_ar',
        'state_id',
        'country_id',
        'latitude',
        'longitude',
        'timezone',
        'wikiDataId',
        'population'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}