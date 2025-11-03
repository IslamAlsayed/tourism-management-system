<?php

namespace App\Models;

use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Model;

class RateDetail extends Model
{
    use HasSearch;

    protected $fillable = [
        'id',
        'rate_id',
        'room_type_id',
        'price',
        'price_type',
    ];

    /**
     * Get relationship names for eager loading
     */
    public function getRelationshipNames()
    {
        return ['rate', 'room_type'];
    }

    /**
     * Get columns to exclude from search/display
     */
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