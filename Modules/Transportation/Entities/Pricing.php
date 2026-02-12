<?php

namespace Modules\Transportation\Entities;

use App\Traits\HasUuid;
use App\Traits\HasSearch;
use App\Traits\FiltersByUserRole;
use App\Traits\ClearsEmptyRichText;
use Illuminate\Database\Eloquent\Model;
use Modules\Accommodations\Entities\Season;
use Modules\Localization\Entities\Currency;
use Modules\Core\Entities\PricingDefinition;
use Modules\Transportation\Entities\Company;
use Modules\Transportation\Entities\VehicleType;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pricing extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, FiltersByUserRole, ClearsEmptyRichText;

    protected $richTextAttributes = [
        'description',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'price',
        'is_active',
        'description',
        'notes',

        'company_id',
        'vehicle_type_id',
        'season_id',
        'pricing_unit_id',
        'currency_id',
    ];

    public function getRelationshipNames()
    {
        return ['company', 'vehicleType', 'season', 'pricingUnit', 'currency'];
    }

    public function getExcludedColumns()
    {
        return ['company_id', 'vehicle_type_id', 'season_id', 'pricing_unit_id', 'currency_id', 'description', 'notes'];
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class);
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function pricingUnit()
    {
        return $this->belongsTo(PricingDefinition::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
