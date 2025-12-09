<?php

namespace App\Models;

use App\Traits\HasSearch;
use App\Traits\BroadcastsRecordEvents;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccommodationRoomRate extends Model
{
    use HasFactory, HasSearch, HasRichText, BroadcastsRecordEvents;

    protected $richTextAttributes = [
        'notes',
    ];

    protected $fillable = [
        'id',
        'accommodation_id',
        'season_id',
        'room_id',
        'currency_id',
        'price_per_person_double',
        'single_room_supplement',
        'triple_room_discount',
        'third_person_price',
        'extra_bed_price',
        'sea_view_supplement',
        'notes',
    ];

    protected $casts = [
        'price_per_person_double' => 'decimal:2',
        'single_room_supplement' => 'decimal:2',
        'triple_room_discount' => 'decimal:2',
        'third_person_price' => 'decimal:2',
        'extra_bed_price' => 'decimal:2',
        'sea_view_supplement' => 'decimal:2',
    ];

    public function getRelationshipNames()
    {
        return ['accommodation', 'season', 'room', 'currency'];
    }

    public function getExcludedColumns()
    {
        return ['accommodation_id', 'season_id', 'room_id', 'currency_id'];
    }

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}