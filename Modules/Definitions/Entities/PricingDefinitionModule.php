<?php

namespace Modules\Definitions\Entities;

use Illuminate\Database\Eloquent\Model;

class PricingDefinitionModule extends Model
{
    protected $fillable = [
        'pricing_definition_id',
        'module_name',
        'field_name',
        'section_label',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function pricingDefinition()
    {
        return $this->belongsTo(PricingDefinition::class);
    }
}
