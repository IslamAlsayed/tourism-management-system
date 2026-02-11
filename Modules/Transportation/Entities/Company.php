<?php

namespace Modules\Transportation\Entities;

use App\Traits\ClearsEmptyRichText;
use App\Traits\FiltersByUserRole;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Accommodations\Entities\Season;
use Modules\Accommodations\Entities\Supplement;
use Modules\Geography\Entities\City;
use Modules\Geography\Entities\Country;
use Modules\Geography\Entities\State;
use Modules\Localization\Entities\Currency;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class Company extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, FiltersByUserRole, ClearsEmptyRichText;
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
        return ['currency', 'country', 'state', 'city', 'vehicleTypes', 'seasons', 'supplements', 'contacts'];
    }

    public function getExcludedColumns()
    {
        return ['currency_id', 'country_id', 'state_id', 'city_id', 'description', 'notes'];
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
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
        return $this->hasMany(VehicleType::class, 'company_id');
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
        return $this->hasMany(CompanyContact::class, 'company_id');
    }
}
