<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportationCompany extends Model
{
    protected $fillable = [
        'id',
        'name',
        'name_ar',
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