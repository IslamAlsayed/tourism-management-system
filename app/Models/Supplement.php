<?php

namespace App\Models;

use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Model;

class Supplement extends Model
{
    use HasSearch;

    protected $fillable = [
        'id',
        'name',
        'price',
        'accommodation_id',
    ];

    /**
     * Get relationship names for eager loading
     */
    public function getRelationshipNames()
    {
        return ['accommodation'];
    }

    /**
     * Get columns to exclude from search/display
     */
    public function getExcludedColumns()
    {
        return ['accommodation_id'];
    }

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }
}