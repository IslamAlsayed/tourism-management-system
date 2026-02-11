<?php

namespace Modules\Accommodations\Entities;

use App\Traits\HasUuid;
use App\Traits\HasSearch;
use Modules\Core\Entities\User;
use App\Traits\FiltersByUserRole;
use App\Traits\BroadcastsRecordEvents;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplement extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, FiltersByUserRole, BroadcastsRecordEvents;
    protected $richTextAttributes = [
        'description',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'name_ar',
        'price',
        'price_type',
        'applicable_date',
        'model_type',
        'is_mandatory',
        'is_active',
        'description',
        'notes',
        'model_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_mandatory' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function getRelationshipNames()
    {
        return ['model', 'creator', 'updater'];
    }

    public function getExcludedColumns()
    {
        return ['model_id', 'description', 'notes'];
    }

    public function model()
    {
        return $this->morphTo();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
