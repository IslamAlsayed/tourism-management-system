<?php

namespace Modules\Cruises\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasUuid;
use App\Traits\FiltersByUserRole;
use App\Traits\HasSearch;

class CruiseCabin extends Model
{
    use HasFactory, SoftDeletes, HasUuid, FiltersByUserRole, HasSearch;

    protected $fillable = [
        'company_id',
        'cruise_id',
        'category_id',
        'name',
        'name_ar',
        'bed_type',
        'max_adults',
        'max_children',
        'base_count',
        'size_sqm',
        'deck_number',
    ];

    protected $casts = [
        'max_adults' => 'integer',
        'max_children' => 'integer',
        'base_count' => 'integer',
        'size_sqm' => 'float',
    ];

    /**
     * Get the cruise that owns the cabin.
     */
    public function cruise()
    {
        return $this->belongsTo(Cruise::class);
    }

    /**
     * Get the category that the cabin belongs to.
     */
    public function category()
    {
        return $this->belongsTo(CruiseCabinCategory::class, 'category_id');
    }

    protected static function newFactory()
    {
        return \Modules\Cruises\Database\factories\CruiseCabinFactory::new();
    }
}
