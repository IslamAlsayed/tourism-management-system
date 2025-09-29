<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_ar',
        'iso2',
        'iso3',
        'fips_code',
        'type',
        'level',
        'latitude',
        'longitude',
        'timezone',
        'parent_id',
        'country_id',
    ];

    public function getRelationshipNames()
    {
        return ['country'];
    }

    public function getExcludedColumns()
    {
        return ['country_id'];
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}