<?php

namespace Modules\Cruises\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasUuid;
use App\Traits\FiltersByUserRole;
use App\Traits\HasSearch;
use App\Models\MediaFile;

class Cruise extends Model
{
    use HasFactory, SoftDeletes, HasUuid, FiltersByUserRole, HasSearch;

    /**
     * Use UUID as the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    protected $fillable = [
        'company_id',
        'name',
        'name_ar',
        'slug',
        'vessel_class',
        'type',
        'total_cabins',
        'deck_count',
        'built_year',
        'renovated_year',
        'length_meters',
        'draft_meters',
        'policies',
        'is_active',
        'is_chartered',
        'photo',
        'region_id',
        'subregion_id',
        'country_id',
        'state_id',
        'city_id',
        'main_start_point_id',
        'main_end_point_id',
        'vessel_nationality_id',
    ];

    protected $casts = [
        'policies' => 'json',
        'is_active' => 'boolean',
        'is_chartered' => 'boolean',
        'total_cabins' => 'integer',
        'deck_count' => 'integer',
        'built_year' => 'integer',
        'renovated_year' => 'integer',
        'length_meters' => 'float',
        'draft_meters' => 'float',
    ];

    /**
     * Get the cabins for the cruise.
     */
    public function cabins()
    {
        return $this->hasMany(CruiseCabin::class);
    }

    /**
     * Get the seasons for the cruise.
     */
    public function seasons()
    {
        return $this->hasMany(CruiseSeason::class);
    }

    /**
     * Get the cancellation rules for the cruise.
     */
    public function cancellationRules()
    {
        return $this->hasMany(CruiseCancellationRule::class);
    }

    /**
     * Get the prices for the cruise.
     */
    public function prices()
    {
        return $this->hasMany(CruisePrice::class);
    }

    /**
     * Get the images for the cruise.
     */
    public function images()
    {
        return $this->morphMany(MediaFile::class, 'model');
    }

    /**
     * Get the featured image.
     */
    public function featuredImage()
    {
        return $this->morphOne(MediaFile::class, 'model')->where('is_featured', true);
    }

    protected static function newFactory()
    {
        return \Modules\Cruises\Database\factories\CruiseFactory::new();
    }
}
