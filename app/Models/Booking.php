<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'first_name',
        'last_name',
        'email',
        'phone',
        'nationality',
        'adults',
        'children',
        'infants',
        'arrival_date',
        'departure_date',
        'currency_id',
        'hotel_id',
        'hotel_room_type_id',
        'hotel_season_id',
        'subtotal_hotels',
        'subtotal_transport',
        'subtotal_services',
        'discount',
        'tax',
        'grand_total',
    ];

    // core refs
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function roomType()
    {
        return $this->belongsTo(HotelRoomType::class, 'hotel_room_type_id');
    }

    public function season()
    {
        return $this->belongsTo(HotelSeason::class, 'hotel_season_id');
    }

    // pivots
    public function transportationCompanies()
    {
        return $this->belongsToMany(TransportationCompany::class, 'booking_transportation_company')
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

    public function transportation()
    {
        return $this->belongsToMany(TransportationCompany::class, 'booking_transportation')
            ->withPivot(['bus_type_id', 'route_id', 'days', 'price_per_day'])
            ->withTimestamps();
    }
}