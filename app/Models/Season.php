<?php

namespace App\Models;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class Season extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, BroadcastsRecordEvents;

    protected $richTextAttributes = [
        'description',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'name_ar',
        'season_from',
        'season_to',
        'description',
        'is_active',
    ];

    protected $casts = [
        'season_from' => 'date',
        'season_to' => 'date',
        'is_active' => 'boolean',
    ];

    public function getFormattedSeasonFromAttribute()
    {
        return $this->season_from ? \Carbon\Carbon::parse($this->season_from)->format('Y-m-d') : null;
    }

    public function getFormattedSeasonToAttribute()
    {
        return $this->season_to ? \Carbon\Carbon::parse($this->season_to)->format('Y-m-d') : null;
    }

    public function accommodations()
    {
        return $this->belongsToMany(Accommodation::class, 'accommodation_seasons')->withTimestamps()->withPivot('notes');
    }

    public function roomRates()
    {
        return $this->hasMany(AccommodationRoomRate::class);
    }

    public function mealRates()
    {
        return $this->hasMany(AccommodationMealRate::class);
    }

    public function nationalityRates()
    {
        return $this->hasMany(AccommodationNationalityRate::class);
    }
}