<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TouristGuide extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_name',
        'home_city',
        'national_guide_id',
        'tourism_ministry_id',
        'guide_name_ar',
        'guide_name',
        'FD_Day_fees',
        'HD_Day_fees',
        'extra_fees_1',
        'extra_fees_2',
        'overnight_fees_2',
        'cat',
        'type',
        'age',
        'guide_sts',
        'guide_languages',
        'email',
        'mobile_01',
        'mobile_02',
        'note'
    ];
}