<?php

namespace Modules\Cruises\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasUuid;
use App\Traits\FiltersByUserRole;
use App\Traits\HasSearch;

class CruisePrice extends Model
{
    use HasFactory, HasUuid, FiltersByUserRole, HasSearch;

    protected $fillable = [
        'company_id',
        'cruise_id',
        'category_id',
        'season_id',
        'buy_price',
        'buy_currency',
        'sell_price',
        'sell_currency',
        'charter_price',
        'charter_currency',
        'is_tax_included',
        'extra_fees',
    ];

    protected $casts = [
        'buy_price' => 'float',
        'sell_price' => 'float',
        'charter_price' => 'float',
        'is_tax_included' => 'boolean',
        'extra_fees' => 'json',
    ];

    /**
     * Get the cruise that owns the price.
     */
    public function cruise()
    {
        return $this->belongsTo(Cruise::class);
    }

    /**
     * Get the category that the price applies to.
     */
    public function category()
    {
        return $this->belongsTo(CruiseCabinCategory::class, 'category_id');
    }

    /**
     * Get the season that the price applies to.
     */
    public function season()
    {
        return $this->belongsTo(CruiseSeason::class, 'season_id');
    }

    protected static function newFactory()
    {
        return \Modules\Cruises\Database\factories\CruisePriceFactory::new();
    }
}
