<?php

namespace App\Models;

use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Model;

class TransportationBusType extends Model
{
    use HasSearch;

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