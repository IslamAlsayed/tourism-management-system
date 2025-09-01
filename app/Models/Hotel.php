<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'country',
        'city',
        'street',
        'cat',
        'type',
        'trade_name',
        'arabic_name',
        'general_mobile',
        'general_email',
        'website',
        'phone',
        'phone_ext',
        'fax',
        'box',
        'postal_code',
        'sales_man',
        'sales_phone',
        'sales_mail',
        'resv_man',
        'resv_phone',
        'resvr_mail',
        'accounting_person',
        'acc_mail',
        'acc_phone',
        'accommodation_id',
        'name',
        'hotel_chain',
        'sales_man',
        'sales_phone',
        'sales_mail',
        'resv_man',
        'resv_phone',
        'resvr_mail',
        'accounting_person',
        'acc_mail',
        'acc_phone',
    ];

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }
}