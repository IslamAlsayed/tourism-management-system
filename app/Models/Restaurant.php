<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\HasSearch;
use App\Traits\FiltersByUserRole;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Restaurant extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, FiltersByUserRole;

    protected $richTextAttributes = [
        'description',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'photo',
        'name',
        'name_ar',
        'rating',
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

        'wheelchair_accessible',
        'free_wifi',
        'parking',
        'swimming_pool',
        'gym',
        'indoor',
        'outdoor',
        'spa',
        'is_active',
        'description',
        'notes',

        'type_id',
        'currency_id',
        'region_id',
        'subregion_id',
        'country_id',
        'state_id',
        'city_id',
    ];

    public function getRelationshipNames()
    {
        return ['type', 'currency', 'region', 'subregion', 'country', 'state', 'city', 'seasons', 'meals', 'supplements'];
    }

    public function getExcludedColumns()
    {
        return ['type_id', 'currency_id', 'region_id', 'subregion_id', 'country_id', 'state_id', 'city_id'];
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
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

    // علاقة polymorphic modelship للمواسم
    public function seasons()
    {
        return $this->morphMany(Season::class, 'model');
    }

    // علاقة polymorphic modelship للوجبات
    public function meals()
    {
        return $this->morphMany(Meal::class, 'model');
    }

    // علاقة polymorphic modelship للإضافات
    public function supplements()
    {
        return $this->morphMany(Supplement::class, 'model');
    }
}