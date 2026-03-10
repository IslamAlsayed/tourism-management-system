<?php

namespace Modules\TouristSites\Entities;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiteHoliday extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'site_holidays';

    protected $fillable = [
        'tourist_site_id',
        'type',          // weekly, annual, one_time
        'day_of_week',   // for weekly: saturday, sunday, etc.
        'holiday_date',  // for annual/one_time
        'name',
        'name_ar',
        'is_active',
    ];

    protected $casts = [
        'holiday_date' => 'date',
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
        if (app()->getLocale() === 'ar' && !empty($this->name_ar)) {
            return $this->name_ar;
        }
        return $this->name;
    }
}
