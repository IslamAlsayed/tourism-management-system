<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportationBusType extends Model
{
    protected $fillable = [
        'id',
        'name',
        'name_ar',
        'category',
    ];

    public function getRelationshipNames()
    {
        return [];
    }

    public function getExcludedColumns()
    {
        return [];
    }
}