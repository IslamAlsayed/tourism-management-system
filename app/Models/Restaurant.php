<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'country',
        'city',
        'type',
        'category',
        'restaurants_name_ar',
        'restaurants_name',
        'company_name_ar',
        'specialty',
        'phone_02',
        'fax',
        'phone_01',
        'contact_person',
        'email_01',
        'email_02',
        'box',
        'postal_code',
        'street',
        'mobile',
        'website',
        'note'
    ];
}