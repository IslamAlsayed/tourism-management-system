<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @status PLACEHOLDER — HotelRate not yet migrated to Accommodations module.
 * @todo Create rate system in Modules\Accommodations and migrate.
 */
class HotelRate extends Model
{
    protected $guarded = ['id'];

    public function hotel()
    {
        return $this->belongsTo(\Modules\Accommodations\Entities\Accommodation::class, 'hotel_id');
    }

    public function roomType()
    {
        return $this->belongsTo(\Modules\Accommodations\Entities\Room::class, 'room_type_id');
    }

    public function season()
    {
        return $this->belongsTo(\Modules\Accommodations\Entities\Season::class, 'hotel_season_id');
    }
}
