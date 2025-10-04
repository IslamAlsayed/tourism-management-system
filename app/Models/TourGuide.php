<?php

namespace App\Models;

use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Model;

class TourGuide extends Model
{
    use HasSearch;

    protected $fillable = [
        'id',
        'name',
        'name_ar',
        'email',
        'mobile_01',
        'mobile_02',
        'home_city',
        'birth_year',
        'gender',
        'national_guide_id',
        'tourism_ministry_code',
        'fd_day_fees',
        'hd_day_fees',
        'extra_fees_1',
        'extra_fees_2',
        'status',
        'notes',
        'country_id',
        'currency_id',
        'guide_type_id',
    ];

    public function getRelationshipNames()
    {
        return ['country', 'currency', 'guide_type'];
    }

    public function getExcludedColumns()
    {
        return ['country_id', 'currency_id', 'guide_type_id'];
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function guide_type()
    {
        return $this->belongsTo(TourGuideType::class, 'guide_type_id');
    }
}