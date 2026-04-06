@props([
    'name',
    'id' => null,
    'label',
    'type' => 'text',
    'value' => '',
    'defaultIcon' => 'fa-duotone fa-solid fa-pen-to-square',
    'required' => false,
    'placeholder' => '',
    'min' => null,
    'max' => null,
    'step' => null
])

@php
    $id = $id ?? $name;
    
    // Auto-register the key if it does not exist, and retrieve the record
    $uiIconRecord = \App\Models\UiIcon::firstOrCreate(
        ['field_key' => $name],
        ['icon_class' => $defaultIcon]
    );

    // Consider caching this globally later for optimal performance
    $icon = $uiIconRecord->icon_class;
@endphp

<div>
    <label for="{{ $id }}" class="kt-label mb-2 {{ $required ? 'required' : '' }}">{{ $label }}</label>
    <div class="kt-input-group">
        <span class="kt-input-addon kt-input-addon-icon">
            <i class="{{ $icon }}"></i>
        </span>
        <input 
            type="{{ $type }}" 
            name="{{ $name }}" 
            id="{{ $id }}" 
            class="kt-input" 
            value="{{ old($name, $value) }}" 
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ !is_null($min) ? 'min=' . $min : '' }}
            {{ !is_null($max) ? 'max=' . $max : '' }}
            {{ !is_null($step) ? 'step=' . $step : '' }}
        >
    </div>
    @error($name)
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>
