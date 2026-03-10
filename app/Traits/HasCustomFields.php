<?php

namespace App\Traits;

use Modules\Core\Entities\CustomFieldValue;
use Modules\Core\Entities\FieldDefinition;

trait HasCustomFields
{
    /**
     * Get all custom field values for this entity.
     */
    public function customFieldValues()
    {
        return $this->morphMany(CustomFieldValue::class, 'entity');
    }

    /**
     * Get active field definitions for this entity type.
     */
    public function getCustomFields()
    {
        $entityType = class_basename($this);
        return FieldDefinition::where('entity_type', $entityType)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }

    /**
     * Get the value of a specific custom field.
     */
    public function getCustomFieldValue($fieldDefinitionId)
    {
        $value = $this->customFieldValues()
            ->where('field_definition_id', $fieldDefinitionId)
            ->first();

        return $value ? $value->value : null;
    }

    /**
     * Save custom field values from form data.
     * Expects: ['custom_fields' => [field_id => value, ...]]
     */
    public function saveCustomFields(array $customFields)
    {
        foreach ($customFields as $fieldId => $value) {
            // Skip empty file fields
            if ($value === null && FieldDefinition::find($fieldId)?->field_type === 'file') {
                continue;
            }

            CustomFieldValue::updateOrCreate(
                [
                    'field_definition_id' => $fieldId,
                    'entity_type' => get_class($this),
                    'entity_id' => $this->id,
                ],
                [
                    'value' => is_array($value) ? json_encode($value) : $value,
                ]
            );
        }
    }

    /**
     * Get all custom field values as key-value pairs.
     * Returns: [field_id => value, ...]
     */
    public function getCustomFieldsData(): array
    {
        return $this->customFieldValues()
            ->pluck('value', 'field_definition_id')
            ->toArray();
    }
}
