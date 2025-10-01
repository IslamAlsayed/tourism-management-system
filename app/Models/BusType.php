<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusType extends Model
{
    protected $fillable = [
        'id',
        'name',
        'seats',
        'type',
        'transportation_company_id',
    ];

    public function getRelationshipNames()
    {
        return ['transportation_company'];
    }

    public function getExcludedColumns()
    {
        return ['transportation_company_id'];
    }

    public function transportation_company()
    {
        return $this->belongsTo(TransportationCompany::class);
    }
}