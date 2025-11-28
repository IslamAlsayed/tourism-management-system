<?php

namespace App\Models;

use App\Traits\FiltersByUserRole;
use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class Restaurant extends Model
{
    use HasSearch, HasRichText, FiltersByUserRole;

    protected $richTextAttributes = [
        'notes',
    ];

    protected $fillable = [
        'id',
        'photo',
        'name',
        'name_ar',
        'company_name_ar',
        'specialty',
        'phone_01',
        'phone_02',
        'fax',
        'contact_person',
        'email_01',
        'email_02',
        'box',
        'postal_code',
        'street',
        'mobile',
        'website',
        'notes',
        'is_active',
        'wheelchair_accessible',
        'free_wifi',
        'parking',
        'swimming_pool',
        'gym',
        'indoor',
        'outdoor',
        'spa',
        'rating',
        'type_id',
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
        return ['type', 'region', 'subregion', 'country'];
    }

    /**
     * Get columns to exclude from search/display
     */
    public function getExcludedColumns()
    {
        return ['type_id', 'region_id', 'subregion_id', 'country_id'];
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
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

    public function states()
    {
        if (!$this->state_id)
            return [];
        return State::whereIn('id', explode(',', $this->state_id))->get()->toArray();
    }

    public function getStateListAttribute()
    {
        if (!$this->state_id)
            return [];
        return State::whereIn('id', explode(',', $this->state_id))->get(['id', 'name'])->toArray();
    }

    public function getStateIdAttribute($value)
    {
        return $value ?: "";
    }

    public function setStateIdAttribute($value)
    {
        $this->attributes['state_id'] = is_array($value) ? implode(',', $value) : $value;
    }

    public function cities()
    {
        if (!$this->city_id)
            return [];
        return City::whereIn('id', explode(',', $this->city_id))->get()->toArray();
    }

    public function getCityListAttribute()
    {
        if (!$this->city_id)
            return [];
        return City::whereIn('id', explode(',', $this->city_id))->get(['id', 'name'])->toArray();
    }

    public function getCityIdAttribute($value)
    {
        return $value ?: "";
    }

    public function setCityIdAttribute($value)
    {
        $this->attributes['city_id'] = is_array($value) ? implode(',', $value) : $value;
    }
}