<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_ar',
        'country_id',
        'city_id',
        'region_id',
        'subregion_id',
        'type',
        'rating',
        'company_name_ar',
        'specialty',
        'phone_01',
        'phone_02',
        'fax',
        'contact_person',
        'email_01',
        'email_02',
        'box',
        'postal_code',
        'street',
        'mobile',
        'website',
        'notes',
        'is_active',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}