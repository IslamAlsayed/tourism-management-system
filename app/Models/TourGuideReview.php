<?php

namespace App\Models;

use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Model;

class TourGuideReview extends Model
{
    use HasSearch;

    protected $fillable = [
        'id',
        'tour_guide_id',
        'rating',
        'review',
    ];

    /**
     * Get relationship names for eager loading
     */
    public function getRelationshipNames()
    {
        return ['tour_guide'];
    }

    /**
     * Get columns to exclude from search/display
     */
    public function getExcludedColumns()
    {
        return [
            'tour_guide_id',
        ];
    }

    public function tour_guide()
    {
        return $this->belongsTo(TourGuide::class, 'tour_guide_id');
    }
}