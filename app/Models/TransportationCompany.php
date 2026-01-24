<?php

namespace App\Models;

use App\Traits\FiltersByUserRole;
use App\Traits\HandlesRichTextAttributes;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class TransportationCompany extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, FiltersByUserRole, HandlesRichTextAttributes;
    protected $table = 'transportations_companies';
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
        'code',
        'rating',
        'street',
        'box',
        'postal_code',
        'latitude',
        'longitude',
        'website',
        'is_active',
        'description',
        'notes',

        'currency_id',
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
            // Auto-fill code
            if (empty($item->code)) {
                $item->code = generateCode('TC-', 5);
            }
        });
    }

    public function getRelationshipNames()
    {
        return ['currency', 'region', 'subregion', 'country', 'state', 'city', 'vehicleTypes', 'seasons', 'supplements', 'contacts'];
    }

    public function getExcludedColumns()
    {
        return ['currency_id', 'region_id', 'subregion_id', 'country_id', 'state_id', 'city_id', 'description', 'notes'];
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

    public function vehicleTypes()
    {
        return $this->hasMany(TransportationVehicleType::class, 'company_id');
    }

    public function seasons()
    {
        return $this->morphMany(Season::class, 'model');
    }

    public function supplements()
    {
        return $this->morphMany(Supplement::class, 'model');
    }

    public function contacts()
    {
        return $this->hasMany(TransportationCompanyContact::class, 'company_id');
    }
}
