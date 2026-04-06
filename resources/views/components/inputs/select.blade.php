@props([
    'name',
    'id' => null,
    'label',
    'defaultIcon' => 'fa-duotone fa-solid fa-pen-to-square',
    'required' => false,
    'disabled' => false,
    'placeholder' => null
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
    $placeholder = $placeholder ?? __('main.select_option');
@endphp

<div>
    <label for="{{ $id }}" class="kt-label mb-2 {{ $required ? 'required' : '' }}">{{ $label }}</label>
    <div class="kt-input-group">
        <span class="kt-input-addon kt-input-addon-icon">
            <i class="{{ $icon }}"></i>
        </span>
        <select 
            name="{{ $name }}" 
            id="{{ $id }}" 
            class="kt-input" 
            {{ $disabled ? 'disabled' : '' }}
            {{ $required ? 'required' : '' }}
            {{ $attributes }}
        >
            <option value="" selected disabled>{{ $placeholder }}</option>
            {{ $slot }}
        </select>
    </div>
    @error($name)
        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>
