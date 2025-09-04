<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportationCompany extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'contact_person',
        'address'
    ];

    public function busTypes()
    {
        return $this->hasMany(BusType::class, 'company_id');
    }

    public function rates()
    {
        return $this->hasMany(TransportationRate::class, 'company_id');
    }
}