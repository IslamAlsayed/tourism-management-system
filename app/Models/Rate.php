<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rate extends Model
{
    protected $fillable = [
        'id',
        'price',
        'currency_id',
        'accommodation_id',
        'season_id',
        'room_type_id',
    ];

    public function getRelationshipNames()
    {
        return ['country', 'currency', 'accommodation', 'season', 'room_type'];
    }

    public function getExcludedColumns()
    {
        return ['currency_id', 'accommodation_id', 'season_id', 'room_type_id'];
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function room_type()
    {
        return $this->belongsTo(RoomType::class);
    }
}