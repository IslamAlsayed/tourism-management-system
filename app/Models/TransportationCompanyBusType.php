<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportationCompanyBusType extends Model
{
    protected $fillable = [
        'id',
        'min_seats',
        'max_seats',
        'seats',
        'company_id',
        'bus_type_id',
    ];

    public function getRelationshipNames()
    {
        return ['company', 'bus_type'];
    }

    public function getExcludedColumns()
    {
        return ['company_id', 'bus_type_id'];
    }

    public function company()
    {
        return $this->belongsTo(TransportationCompany::class, 'company_id');
    }

    public function bus_type()
    {
        return $this->belongsTo(TransportationBusType::class, 'bus_type_id');
    }
}