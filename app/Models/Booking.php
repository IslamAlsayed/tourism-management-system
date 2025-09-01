<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'currency_id',
        'hotel_id',
        'room_type_id',
        'hotel_season_id',
    ];

    public function transportationCompanies()
    {
        return $this->belongsToMany(TransportationCompany::class, 'booking_transportation_company');
    }

    public function otherServices()
    {
        return $this->belongsToMany(OtherService::class, 'booking_other_service');
    }

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'booking_supplier');
    }
}