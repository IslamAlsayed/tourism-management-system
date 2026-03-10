<?php

namespace Modules\TouristSites\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Facility extends Model
{
    use \App\Traits\HasUuid;
    use \App\Traits\HasSearch;

    protected $fillable = [
        'uuid',
        'name',
        'name_ar',
        'icon',
        'description',
        'is_active',
        'sort_order',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function touristSites()
    {
        return $this->belongsToMany(TouristSite::class, 'tourist_site_facilities');
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
        
        // Try fallback to translation key based on slugified name
        // e.g. "Wheelchair accessible" -> "wheelchair_accessible" -> "main.wheelchair_accessible"
        $slug = \Illuminate\Support\Str::slug($this->name, '_');
        $transKey = 'main.' . $slug;
        
        // We use Lang::has to check if key exists, but standard __() returns key if not found so we can't just check result.
        // However, standard __() behavior is fine if we want to default to key, but here we have $this->name.
        // We prefer translation if available.
        if (\Illuminate\Support\Facades\Lang::has($transKey)) {
            return __($transKey);
        }

        return $this->name_ar ?: $this->name;
    }

}
