<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'created_by',
        'sales_man',
        'sales_phone',
        'sales_mail',
        'reservation_man',
        'reservation_phone',
        'reservation_mail',
        'accounting_person',
        'accounting_mail',
        'accounting_phone',
        'description',
        'country_id',
        'city_id',
        'region_id',
        'subregion_id',
        'accommodation_id',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function subregion()
    {
        return $this->belongsTo(Subregion::class);
    }

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }
}