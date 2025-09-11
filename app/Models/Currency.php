<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'name_ar',
        'symbol',
        'country',
        'exchange_rate',
        'decimal_places',
        'is_active',
        'is_major_currency',
        'is_base_currency',
        'sort_order',
    ];

    public function countries()
    {
        return $this->hasMany(Country::class);
    }
}