<?php

namespace Modules\Accommodations\Entities;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\ClearsEmptyRichText;
use App\Traits\HasUuid;
use App\Traits\HasSearch;
use App\Traits\HasCustomFields;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class Type extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, BroadcastsRecordEvents, ClearsEmptyRichText, HasCustomFields;
    protected $richTextAttributes = [
        'description',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'name_ar',
        'is_active',
        'description',
        'notes',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getExcludedColumns()
    {
        return ['description', 'notes'];
    }

    public function accommodations()
    {
        return $this->hasMany(Accommodation::class);
    }
}
