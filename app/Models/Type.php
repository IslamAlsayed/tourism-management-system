<?php

namespace App\Models;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class Type extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, BroadcastsRecordEvents;

    protected $richTextAttributes = [
        'description',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'name_ar',
        'description',
        'is_active',
        // 'accommodation_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // public function getRelationshipNames()
    // {
    //     return ['accommodation'];
    // }

    // public function getExcludedColumns()
    // {
    //     return ['accommodation_id'];
    // }

    public function accommodations()
    {
        return $this->hasMany(Accommodation::class);
    }
}