<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;

class CustomFieldValue extends Model
{
    protected $fillable = [
        'field_definition_id',
        'entity_type',
        'entity_id',
        'value',
    ];

    /**
     * The field definition this value belongs to.
     */
    public function fieldDefinition()
    {
        return $this->belongsTo(FieldDefinition::class);
    }

    /**
     * The entity this value belongs to (polymorphic).
     */
    public function entity()
    {
        return $this->morphTo();
    }
}
