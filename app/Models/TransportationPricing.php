<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\HasSearch;
use App\Traits\FiltersByUserRole;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransportationPricing extends Model
{
    use HasFactory, HasSearch, HasUuid, HasRichText, FiltersByUserRole;

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
    ];

    public function getRelationshipNames()
    {
        return ['company', 'vehicle_type', 'season', 'pricing_unit'];
    }

    public function getExcludedColumns()
    {
        return ['company_id', 'vehicle_type_id', 'season_id', 'pricing_unit_id'];
    }

    public function company()
    {
        return $this->belongsTo(TransportationCompany::class);
    }

    public function vehicle_type()
    {
        return $this->belongsTo(TransportationVehicleType::class);
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function pricing_unit()
    {
        return $this->belongsTo(PricingDefinition::class);
    }
}