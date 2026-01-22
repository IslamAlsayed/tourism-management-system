<?php

namespace App\Models;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\HandlesRichTextAttributes;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class Meal extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, BroadcastsRecordEvents, HandlesRichTextAttributes;
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
        'is_included',
        'is_supplement',
        'model_type',
        'is_active',
        'description',
        'notes',
        'model_id',
        'currency_id',
    ];

    protected $casts = [
        'is_included' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function getRelationshipNames()
    {
        return ['model', 'currency'];
    }

    public function getExcludedColumns()
    {
        return ['model_id', 'currency_id', 'description', 'notes'];
    }

    public function model()
    {
        return $this->morphTo();
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
