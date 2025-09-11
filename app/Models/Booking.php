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
        'adults',
        'children',
        'infants',
        'arrival_date',
        'departure_date',
        'nights',
        'nationality_id',
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
    public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function roomTypes()
    {
        return $this->belongsToMany(HotelRoomType::class, 'booking_room_types', 'booking_id', 'hotel_room_type_id')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function season()
    {
        return $this->belongsTo(HotelSeason::class, 'hotel_season_id');
    }

    public function transportationCompanies()
    {
        return $this->belongsToMany(TransportationCompany::class, 'booking_transportation_companies', 'booking_id', 'company_id')
            ->withPivot(['bus_type_id', 'day', 'price_per_day'])
            ->withTimestamps();
    }

    public function bookingOtherService()
    {
        return $this->hasMany(BookingOtherService::class, 'booking_other_service_id');
    }

    public function otherServices()
    {
        return $this->belongsToMany(OtherService::class, 'booking_other_services')
            ->withPivot(['selected', 'quantity', 'price'])
            ->withTimestamps();
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
        return $this->hasMany(BookingTransportationCompany::class);
        // return $this->belongsToMany(TransportationCompany::class, 'booking_transportation')
        //     ->withPivot(['bus_type_id', 'route_id', 'day', 'price_per_day'])
        //     ->withTimestamps();
    }
}