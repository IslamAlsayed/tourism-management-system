<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RateDetail extends Model
{
    protected $fillable = [
        'rate_id',
        'room_type_id',
        'price',
        'price_type',
    ];

    public function getRelationshipNames()
    {
        return ['rate', 'room_type'];
    }

    public function getExcludedColumns()
    {
        return ['rate_id', 'room_type_id', 'season_id', 'room_type_id'];
    }

    public function rate()
    {
        return $this->belongsTo(Rate::class);
    }

    public function room_type()
    {
        return $this->belongsTo(RoomType::class);
    }
}