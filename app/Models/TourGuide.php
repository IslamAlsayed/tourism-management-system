<?php

namespace App\Models;

use App\Traits\HasSearch;
use App\Traits\HasUuid;
use App\Traits\BroadcastsRecordEvents;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class TourGuide extends Model
{
    use HasSearch, HasUuid, HasRichText, BroadcastsRecordEvents;

    protected $richTextAttributes = [
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'name_ar',
        'email',
        'mobile_01',
        'mobile_02',
        'home_city',
        'birth_year',
        'photo',
        'gender',
        'national_guide_id',
        'tourism_ministry_code',
        'fd_day_fees',
        'hd_day_fees',
        'extra_fees_1',
        'extra_fees_2',
        'is_active',
        'notes',
        'currency_id',
        'guide_type_id',
        'region_id',
        'subregion_id',
        'country_id',
        'state_id',
        'city_id',
    ];

    /**
     * Get relationship names for eager loading
     */
    public function getRelationshipNames()
    {
        return ['currency', 'guide_type', 'region', 'subregion', 'country', 'state', 'city'];
    }

    /**
     * Get columns to exclude from search/display
     */
    public function getExcludedColumns()
    {
        return ['currency_id', 'guide_type_id', 'region_id', 'subregion_id', 'country_id', 'state_id', 'city_id'];
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function guide_type()
    {
        return $this->belongsTo(TourGuideType::class, 'guide_type_id');
    }

    public function tourGuideLanguages()
    {
        return $this->hasMany(TourGuideLanguage::class, 'tour_guide_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function subregion()
    {
        return $this->belongsTo(Subregion::class);
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

    // public function states()
    // {
    //     if (!$this->state_id)
    //         return [];
    //     return State::whereIn('id', explode(',', $this->state_id))->get()->toArray();
    // }

    // public function getStateListAttribute()
    // {
    //     if (!$this->state_id)
    //         return [];
    //     return State::whereIn('id', explode(',', $this->state_id))->get(['id', 'name'])->toArray();
    // }

    // public function getStateIdAttribute($value)
    // {
    //     return $value ?: "";
    // }

    // public function setStateIdAttribute($value)
    // {
    //     $this->attributes['state_id'] = is_array($value) ? implode(',', $value) : $value;
    // }

    // public function cities()
    // {
    //     if (!$this->city_id)
    //         return [];
    //     return City::whereIn('id', explode(',', $this->city_id))->get()->toArray();
    // }

    // public function getCityListAttribute()
    // {
    //     if (!$this->city_id)
    //         return [];
    //     return City::whereIn('id', explode(',', $this->city_id))->get(['id', 'name'])->toArray();
    // }

    // public function getCityIdAttribute($value)
    // {
    //     return $value ?: "";
    // }

    // public function setCityIdAttribute($value)
    // {
    //     $this->attributes['city_id'] = is_array($value) ? implode(',', $value) : $value;
    // }
}