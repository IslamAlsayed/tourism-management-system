<?php

namespace App\Models;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class AccommodationSeason extends Model
{
    use HasFactory, HasSearch, HasRichText, BroadcastsRecordEvents;

    protected $richTextAttributes = [
        'notes',
    ];

    protected $fillable = [
        'id',
        'accommodation_id',
        'season_id',
        'notes'
    ];

    protected $casts = [
        'season_from' => 'date',
        'season_to' => 'date',
        'is_active' => 'boolean',
    ];

    public function getRelationshipNames()
    {
        return ['accommodation', 'season'];
    }

    public function getExcludedColumns()
    {
        return ['accommodation_id', 'season_id'];
    }

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }
}