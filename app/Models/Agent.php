<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_name',
        'regions',
        'states',
        'country_code',
        'email_01',
        'address_01',
        'city',
        'office_category_en',
        'office_category_ar',
        'english_trade_name',
        'arabic_trade_name',
        'english_company_name',
        'arabic_company_name',
        'mobile_01',
        'id',
        'address_02',
        'phone_01',
        'phone_02',
        'fax',
        'email_02',
        'email_03',
        'email_04',
        'email_05',
        'website',
        'establishment_number',
        'office_name',
        'gm_name',
        'notes'
    ];
}