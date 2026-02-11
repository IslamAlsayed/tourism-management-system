<?php

namespace Modules\Accommodations\Entities;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\ClearsEmptyRichText;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class Season extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, BroadcastsRecordEvents, ClearsEmptyRichText;
    protected $richTextAttributes = [
        'description',
        'notes'
    ];

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'name_ar',
        'season_from',
        'season_to',
        'model_type',
        'is_active',
        'description',
        'notes',
        'model_id',
    ];

    protected $casts = [
        'season_from' => 'date',
        'season_to' => 'date',
        'is_active' => 'boolean',
    ];

    public function getRelationshipNames()
    {
        return ['model'];
    }

    public function getExcludedColumns()
    {
        return ['model_id', 'description', 'notes'];
    }


    public function getFormattedSeasonFromAttribute()
    {
        return $this->season_from ? \Carbon\Carbon::parse($this->season_from)->format('Y-m-d') : null;
    }

    public function getFormattedSeasonToAttribute()
    {
        return $this->season_to ? \Carbon\Carbon::parse($this->season_to)->format('Y-m-d') : null;
    }

    public function model()
    {
        return $this->morphTo();
    }
}
