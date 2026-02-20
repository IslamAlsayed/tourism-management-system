<?php

namespace Modules\Geography\Entities;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\ClearsEmptyRichText;
use App\Traits\FiltersByUserRole;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasSearch, HasUuid, FiltersByUserRole, BroadcastsRecordEvents, ClearsEmptyRichText;

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
