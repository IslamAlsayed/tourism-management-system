<?php

namespace Modules\Geography\Entities;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\ClearsEmptyRichText;
use App\Traits\FiltersByUserRole;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class Subregion extends Model
{
    use HasSearch, HasRichText, HasUuid, FiltersByUserRole, BroadcastsRecordEvents, ClearsEmptyRichText;
    protected $richTextAttributes = [
        'description',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'name_ar',
        'wiki_data_id',
        'is_active',
        'description',
        'notes',
        'region_id',
    ];

    public function getRelationshipNames()
    {
        return ['region'];
    }

    public function getExcludedColumns()
    {
        return ['region_id', 'description', 'notes'];
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
