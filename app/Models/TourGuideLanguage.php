<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourGuideLanguage extends Model
{
    protected $fillable = [
        'tour_guide_id',
        'guide_language_id',
    ];

    public function getRelationshipNames()
    {
        return ['tour_guide', 'guide_language'];
    }

    public function getExcludedColumns()
    {
        return ['tour_guide_id', 'guide_language_id'];
    }

    public function tourGuide()
    {
        return $this->belongsTo(TourGuide::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'guide_language_id');
    }
}