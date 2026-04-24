<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @status PLACEHOLDER — HotelPolicy not yet migrated to Accommodations module.
 * @todo Create policy system in Modules\Accommodations and migrate.
 */
class HotelPolicy extends Model
{
    protected $guarded = ['id'];

    public function hotel()
    {
        return $this->belongsTo(\Modules\Accommodations\Entities\Accommodation::class, 'hotel_id');
    }
}
