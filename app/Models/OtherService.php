<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtherService extends Model
{
    protected $fillable = [
        'name',
        'name_ar',
        'price_type',
        'price',
        'currency_id',
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_other_services')
            ->withPivot(['selected', 'quantity', 'price'])
            ->withTimestamps();
    }
}