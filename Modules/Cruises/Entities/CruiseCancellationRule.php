<?php

namespace Modules\Cruises\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasUuid;
use App\Traits\FiltersByUserRole;
use App\Traits\HasSearch;

class CruiseCancellationRule extends Model
{
    use HasFactory, HasUuid, FiltersByUserRole, HasSearch;

    protected $fillable = [
        'company_id',
        'cruise_id',
        'days_before',
        'percentage',
        'type',
        'notes',
    ];

    protected $casts = [
        'days_before' => 'integer',
        'percentage' => 'float',
    ];

    /**
     * Get the cruise that owns the cancellation rule.
     */
    public function cruise()
    {
        return $this->belongsTo(Cruise::class);
    }

    protected static function newFactory()
    {
        return \Modules\Cruises\Database\factories\CruiseCancellationRuleFactory::new();
    }
}
