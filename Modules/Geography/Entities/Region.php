<?php

namespace Modules\Geography\Entities;

use App\Traits\HasUuid;
use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Region extends Model
{
    use HasFactory, HasSearch, HasUuid;

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'name_ar',
        'wiki_data_id',
        'is_active',
        'description',
        'notes',
    ];

    public function getExcludedColumns()
    {
        return ['description', 'notes'];
    }

    public function subregions()
    {
        return $this->hasMany(Subregion::class);
    }
}
