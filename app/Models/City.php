<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'name_ar',
        'latitude',
        'longitude',
        'timezone',
        'wiki_data_id',
        'population',
        'state_id',
        'country_id',
    ];

    public function getRelationshipNames()
    {
        return ['state', 'country'];
    }

    public function getExcludedColumns()
    {
        return [
            'state_id',
            'country_id',
        ];
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}