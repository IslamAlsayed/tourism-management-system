<?php

namespace App\Models;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class AccommodationMealRate extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, BroadcastsRecordEvents;

    protected $richTextAttributes = [
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'accommodation_id',
        'season_id',
        'meal_id',
        'currency_id',
        'price',
        'is_supplement',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_supplement' => 'boolean',
    ];

    public function getRelationshipNames()
    {
        return ['accommodation', 'season', 'meal', 'currency'];
    }

    public function getExcludedColumns()
    {
        return ['accommodation_id', 'season_id', 'meal_id', 'currency_id'];
    }

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}