<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusType extends Model
{
    protected $fillable = [
        'name',
        'seats',
        'has_ac',
        'company_id',
    ];

    public function company()
    {
        return $this->belongsTo(TransportationCompany::class, 'company_id');
    }

    public function rates()
    {
        return $this->hasMany(TransportationRate::class, 'bus_type_id');
    }
}