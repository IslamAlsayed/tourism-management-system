<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_id',
        'trade_name',
        'name_ar',
        'name',
        'classification',
        'stars',
        'cat',
        'general_mobile',
        'general_email',
        'email',
        'website',
        'phone',
        'phone_ext',
        'fax',
        'contact_person',
        'contact_position',
        'contact_mobile',
        'contact_email',
        'description',
        'contract_file_path',
        'is_active',
        'country_id',
        'city_id',
        'region_id',
        'street',
        'box',
        'postal_code',
        'latitude',
        'longitude'
    ];

    public function hotel()
    {
        return $this->hasOne(Hotel::class);
    }

    /**
     * Rates associated with this accommodation.
     */
    public function rates()
    {
        return $this->hasMany(AccommodationRate::class);
    }
}