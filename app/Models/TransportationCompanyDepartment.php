<?php

namespace App\Models;

use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Model;

class TransportationCompanyDepartment extends Model
{
    use HasSearch;

    protected $fillable = [
        'id',
        'department',
        'contact_person',
        'mobile',
        'phone_01',
        'phone_02',
        'email_01',
        'email_02',
        'fax',
        'address',
        'website',
        'company_id',
        'country_id',
        'state_id',
        'city_id',
        'region_id',
        'subregion_id',
    ];

    public function getRelationshipNames()
    {
        return [
            'company',
            'country',
            'state',
            'city',
            'region',
            'subregion',
        ];
    }

    public function getExcludedColumns()
    {
        return [
            'company_id',
            'country_id',
            'state_id',
            'city_id',
            'region_id',
            'subregion_id',
        ];
    }

    public function company()
    {
        return $this->belongsTo(TransportationCompany::class, 'company_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
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
}