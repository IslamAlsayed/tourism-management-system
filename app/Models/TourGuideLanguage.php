<?php

namespace App\Models;

use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class TourGuideLanguage extends Model
{
    use HasSearch, HasUuid;

    protected $fillable = [
        'id',
        'uuid',
        'tour_guide_id',
        'language_id',
    ];

    public function getRelationshipNames()
    {
        return ['tour_guide', 'language'];
    }

    public function getExcludedColumns()
    {
        return ['tour_guide_id', 'language_id'];
    }

    public function tour_guide()
    {
        return $this->belongsTo(TourGuide::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}