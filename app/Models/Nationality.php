<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'nationality_ar',
        'nationality_en',
        'is_active',
        'nationality_id',
    ];
}