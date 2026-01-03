<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\HasSearch;
use App\Traits\FiltersByUserRole;
use App\Traits\BroadcastsRecordEvents;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class TourGuideReview extends Model
{
    use HasSearch, HasUuid, HasRichText, FiltersByUserRole, BroadcastsRecordEvents;

    protected $richTextAttributes = [
        'description',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'tour_guide_id',
        'rating',
        'review',
        'is_active',
        'description',
        'notes',
    ];

    public function getRelationshipNames()
    {
        return ['tour_guide'];
    }

    public function getExcludedColumns()
    {
        return ['tour_guide_id', 'description', 'notes'];
    }

    public function tour_guide()
    {
        return $this->belongsTo(TourGuide::class, 'tour_guide_id');
    }
}