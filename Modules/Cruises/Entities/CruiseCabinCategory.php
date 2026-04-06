<?php

namespace Modules\Cruises\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasUuid;
use App\Traits\FiltersByUserRole;
use App\Traits\HasSearch;
use App\Models\MediaFile;

class CruiseCabinCategory extends Model
{
    use HasFactory, SoftDeletes, HasUuid, FiltersByUserRole, HasSearch;

    protected $fillable = [
        'company_id',
        'name',
        'name_ar',
        'code',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the cabins for the category.
     */
    public function cabins()
    {
        return $this->hasMany(CruiseCabin::class, 'category_id');
    }

    /**
     * Get the prices for the category.
     */
    public function prices()
    {
        return $this->hasMany(CruisePrice::class, 'category_id');
    }

    /**
     * Get the images for the category.
     */
    public function images()
    {
        return $this->morphMany(MediaFile::class, 'model');
    }

    protected static function newFactory()
    {
        return \Modules\Cruises\Database\factories\CruiseCabinCategoryFactory::new();
    }
}
