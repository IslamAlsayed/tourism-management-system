<?php

namespace App\Models;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\FiltersByUserRole;
use App\Traits\HandlesRichTextAttributes;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class TourGuide extends Model
{
    use HasSearch, HasUuid, HasRichText, FiltersByUserRole, BroadcastsRecordEvents, HandlesRichTextAttributes;
    protected $richTextAttributes = [
        'description',
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
        'description',
        'notes',
        'currency_id',
        'guide_type_id',
        'region_id',
        'subregion_id',
        'country_id',
        'state_id',
        'city_id',
    ];

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($item) {
            if (empty($item->region_id) && !empty($item->city_id)) {
                $item->region_id = $item->city?->region_id;
            }
            if (empty($item->subregion_id) && !empty($item->city_id)) {
                $item->subregion_id = $item->city?->subregion_id;
            }
            if (empty($item->country_id) && !empty($item->city_id)) {
                $item->country_id = $item->city?->country_id;
            }
            if (empty($item->state_id) && !empty($item->city_id)) {
                $item->state_id = $item->city?->state_id;
            }
        });

        static::updating(function ($item) {
            if (empty($item->region_id) && !empty($item->city_id)) {
                $item->region_id = $item->city?->region_id;
            }
            if (empty($item->subregion_id) && !empty($item->city_id)) {
                $item->subregion_id = $item->city?->subregion_id;
            }
            if (empty($item->country_id) && !empty($item->city_id)) {
                $item->country_id = $item->city?->country_id;
            }
            if (empty($item->state_id) && !empty($item->city_id)) {
                $item->state_id = $item->city?->state_id;
            }
        });
    }


    public function getRelationshipNames()
    {
        return ['currency', 'guide_type', 'tourGuideLanguages', 'region', 'subregion', 'country', 'state', 'city'];
    }

    public function getExcludedColumns()
    {
        return ['currency_id', 'guide_type_id', 'region_id', 'subregion_id', 'country_id', 'state_id', 'city_id', 'description', 'notes'];
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
        return $this->hasMany(TourGuideLanguage::class, 'tour_guide_id')->with('language');
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
}
