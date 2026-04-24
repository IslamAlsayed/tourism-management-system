<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @status PLACEHOLDER — Booking module not yet created.
 * @see Quote v1/v2 controllers depend on this model.
 * @todo Create Modules\Bookings\Entities\Booking and migrate this.
 */
class Booking extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'subtotal_hotels' => 'float',
        'subtotal_transport' => 'float',
        'subtotal_services' => 'float',
        'grand_total' => 'float',
        'discount' => 'float',
        'tax' => 'float',
    ];

    public function currency()
    {
        return $this->belongsTo(\Modules\Localization\Entities\Currency::class);
    }

    public function hotel()
    {
        return $this->belongsTo(\Modules\Accommodations\Entities\Accommodation::class, 'hotel_id');
    }

    public function roomTypes()
    {
        return $this->belongsToMany(\Modules\Accommodations\Entities\Room::class, 'booking_room_type');
    }

    public function season()
    {
        return $this->belongsTo(\Modules\Accommodations\Entities\Season::class, 'hotel_season_id');
    }

    public function transportation()
    {
        return $this->belongsToMany(\Modules\Transportation\Entities\Company::class, 'booking_transportation_company');
    }

    public function transportationCompanies()
    {
        return $this->belongsToMany(\Modules\Transportation\Entities\Company::class, 'booking_transportation_company')
            ->withPivot(['days', 'price_per_day']);
    }

    public function otherServices()
    {
        return $this->belongsToMany(OtherService::class, 'booking_other_service')
            ->withPivot(['qty', 'unit_price']);
    }

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'booking_supplier');
    }

    public function itineraries()
    {
        return $this->hasMany(BookingItinerary::class);
    }

    public function getNightsAttribute(): int
    {
        if (!$this->arrival_date || !$this->departure_date) {
            return 0;
        }
        return \Carbon\Carbon::parse($this->arrival_date)->diffInDays(\Carbon\Carbon::parse($this->departure_date));
    }
}
