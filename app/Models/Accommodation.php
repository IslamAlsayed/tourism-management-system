<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'trade_name',
        'name_ar',
        'name_en',
        'country',
        'city',
        'city_name',
        'region',
        'street',
        'box',
        'postal_code',
        'classification',
        'star_rating',
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
    ];
}