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
    ];

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'name_ar',
        'description',
        'max_occupancy',
        'occupancy_details',
        'is_active',
    ];

    protected $casts = [
        'max_occupancy' => 'integer',
        'is_active' => 'boolean',
    ];

    public function roomRates()
    {
        return $this->hasMany(AccommodationRoomRate::class);
    }
}