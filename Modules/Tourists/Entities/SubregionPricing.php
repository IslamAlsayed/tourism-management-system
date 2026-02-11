<?php

namespace Modules\Tourists\Entities;

use App\Traits\FiltersByUserRole;
use App\Traits\ClearsEmptyRichText;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubregionPricing extends Model
{
    use HasFactory, HasSearch, HasUuid, FiltersByUserRole, ClearsEmptyRichText;

    protected $table = 'subregion_pricing';
    protected $fillable = [
        'seasonal_price_id',
        'city_id',
        'subregion_name',
        'adult_cost',
        'adult_price',
        'child_cost',
        'child_price',
        'pricing_override',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'adult_cost' => 'decimal:2',
        'adult_price' => 'decimal:2',
        'child_cost' => 'decimal:2',
        'child_price' => 'decimal:2',
        'pricing_override' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Relationship: Belongs to SeasonalPrice
     */
    public function seasonalPrice()
    {
        return $this->belongsTo(SeasonalPrice::class);
    }

    /**
     * Relationship: Belongs to City
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
