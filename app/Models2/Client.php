<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'continent',
        'country',
        'timezone',
        'country_code',
        'state',
        'city',
        'first_name',
        'middle_name',
        'gf_name',
        'last_name',
        'gender',
        'nationality',
        'birth_date',
        'passport_number',
        'passport_issue_date',
        'passport_expiry_date',
        'personal_email',
        'primary_phone',
        'secondary_phone',
        'mobile_phone',
        'fax_number',
        'work_phone',
        'work_phone_ext',
        'email_primary',
        'home_phone',
        'work_email',
        'secondary_email',
        'website_url',
        'company_name',
        'job_title',
        'sector',
        'department',
        'business_type',
        'box',
        'postal_code',
        'street_address',
        'address_line_2',
        'business_registration_number',
        'tax_id',
        'linkedin_url',
        'status',
        'notes'
    ];
}