<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $fillable = [
        'id',
        'name',
        'season_from',
        'season_to',
        'is_special',
        'special_type',
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