<?php

namespace App\Models;

use App\Traits\HasSearch;
use App\Traits\HasUuid;
use App\Traits\BroadcastsRecordEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class Room extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, BroadcastsRecordEvents;

    protected $richTextAttributes = [
        'description',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'name_ar',
        'max_occupancy',
        'occupancy_details',
        'model_type',
        'price_per_person_double',
        'single_room_supplement',
        'triple_room_discount',
        'third_person_price',
        'extra_bed_price',
        'sea_view_supplement',
        'is_active',
        'model_id',
        'description',
        'notes',
        'currency_id',
    ];

    protected $casts = [
        'max_occupancy' => 'integer',
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