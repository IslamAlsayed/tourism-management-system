<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    protected $fillable = [
        'type_id',
        'name',
        'name_ar',
        'classification',
        'stars',
        'cat',
        'description',
        'is_active',
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
        'country_id',
        'city_id',
        'region_id',
        'street',
        'box',
        'postal_code',
        'latitude',
        'longitude',
        'contract_file_path',
    ];

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }
}