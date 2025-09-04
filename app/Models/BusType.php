<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusType extends Model
{
    protected $fillable = [
        'name',
        'seats',
        'company_id',
    ];

    // كل نوع باص بيتبع لشركة
    public function company()
    {
        return $this->belongsTo(TransportationCompany::class, 'company_id');
    }

    // نوع الباص ده ليه أسعار مختلفة حسب المسارات
    public function rates()
    {
        return $this->hasMany(TransportationRate::class, 'bus_type_id');
    }
}