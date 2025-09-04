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
    ];

    // شركة واحدة ليها أنواع أتوبيسات كتير
    public function busTypes()
    {
        return $this->hasMany(BusType::class, 'company_id');
    }

    // شركة واحدة ليها أسعار كتير (حسب نوع الباص + الطريق)
    public function rates()
    {
        return $this->hasMany(TransportationRate::class, 'company_id');
    }
}