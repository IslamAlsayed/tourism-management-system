<?php

namespace Modules\TouristSites\Entities;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiteSeasonalHour extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'site_seasonal_hours';

    protected $fillable = [
        'tourist_site_id',
        'season_name',
        'season_name_ar',
        'start_date',
        'end_date',
        'opening_time',
        'closing_time',
        'is_closed',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_closed' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function touristSite()
    {
        return $this->belongsTo(TouristSite::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getDisplayNameAttribute()
    {
        if (app()->getLocale() === 'ar' && !empty($this->season_name_ar)) {
            return $this->season_name_ar;
        }
        return $this->season_name;
    }
}
