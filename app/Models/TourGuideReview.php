<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourGuideReview extends Model
{
    protected $fillable = [
        'id',
        'tour_guide_id',
        'rating',
        'review',
    ];

    public function getRelationshipNames()
    {
        return ['tour_guide'];
    }

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