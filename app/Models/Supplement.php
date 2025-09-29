<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplement extends Model
{
    protected $fillable = [
        'name',
        'price',
        'accommodation_id',
    ];

    public function getRelationshipNames()
    {
        return ['accommodation'];
    }

    public function getExcludedColumns()
    {
        return ['accommodation_id'];
    }

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }
}