<?php

namespace App\Models;

use App\Traits\FiltersByUserRole;
use App\Traits\ClearsEmptyRichText;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class SeasonalPrice extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, FiltersByUserRole, ClearsEmptyRichText;
    protected $richTextAttributes = [
        'notes',
    ];

    protected $table = 'seasonal_prices';
    protected $fillable = [
        'tourist_service_id',
        'season_name',
        'season_start_date',
        'season_end_date',
        'pricing_matrix',
        'notes',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'pricing_matrix' => 'json',
        'season_start_date' => 'date',
        'season_end_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Relationship: Belongs to TouristService
     */
    public function touristService()
    {
        return $this->belongsTo(TouristService::class);
    }

    /**
     * Relationship: Has many subregion pricing
     */
    public function subregionPricing()
    {
        return $this->hasMany(SubregionPricing::class);
    }

    /**
     * Relationship: Has many custom nationalities
     */
    public function customNationalities()
    {
        return $this->hasMany(CustomNationality::class);
    }
}
