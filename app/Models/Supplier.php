<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'continent',
        'country',
        'country_code',
        'state',
        'city',
        'timezone',
        'nationality',
        'category',
        'sector',
        'business_type',
        'company_name',
        'contact_person_name',
        'job_title',
        'department',
        'mobile_phone',
        'work_phone',
        'work_phone_ext',
        'fax_number',
        'work_email',
        'personal_email',
        'secondary_email',
        'website',
        'primary_phone',
        'secondary_phone',
        'box',
        'postal_code',
        'street_address',
        'business_registration_number',
        'tax_id',
        'status',
        'notes'
    ];
}