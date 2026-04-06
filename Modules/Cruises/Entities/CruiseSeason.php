<?php

namespace Modules\Cruises\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasUuid;
use App\Traits\FiltersByUserRole;
use App\Traits\HasSearch;

class CruiseSeason extends Model
{
    use HasFactory, HasUuid, FiltersByUserRole, HasSearch;

    protected $fillable = [
        'company_id',
        'name',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get the cruise that owns the season.
     */
    public function prices()
    {
        return $this->hasMany(CruisePrice::class, 'season_id');
    }

    protected static function newFactory()
    {
        return \Modules\Cruises\Database\factories\CruiseSeasonFactory::new();
    }
}
