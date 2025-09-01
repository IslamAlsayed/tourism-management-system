<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportationCompany extends Model
{
    protected $fillable = [
        'company_name',
        'contact_person',
        'phone_number',
        'email',
        'address',
    ];
}
