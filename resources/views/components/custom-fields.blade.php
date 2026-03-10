@props(['moduleName', 'entityType', 'entity' => null])
{{-- 
    Dynamic Custom Fields Component
    Usage: <x-custom-fields module-name="tour_guides" entity-type="TourGuide" :entity="$tourGuide ?? null" />
--}}
@php
    $customFields = \Modules\Core\Entities\FieldDefinition::where('module_name', $moduleName)
        ->where('entity_type', $entityType)
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->orderBy('id')
        ->get();

    $customValues = [];
    if (isset($entity) && $entity && method_exists($entity, 'getCustomFieldsData')) {
        $customValues = $entity->getCustomFieldsData();
    }

    // Group fields by section_label
    $grouped = $customFields->groupBy(function ($field) {
        return $field->section_label ?: __('main.custom_fields');
    });
@endphp

@if ($customFields->count() > 0)
    @foreach ($grouped as $sectionLabel => $fields)
        <div class="kt-card">
            <div class="kt-card-header">
                <h3 class="kt-card-title">
                    <i class="fas fa-puzzle-piece text-primary me-2"></i>
                    {{ app()->getLocale() === 'ar' && $fields->first()->section_label_ar ? $fields->first()->section_label_ar : $sectionLabel }}
                </h3>
            </div>
            <div class="kt-card-body p-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach ($fields as $field)
                        @php
                            $fieldName = "custom_fields[{$field->id}]";
                            $fieldValue = old("custom_fields.{$field->id}", $customValues[$field->id] ?? '');
                            $displayName =
                                app()->getLocale() === 'ar' && $field->name_ar ? $field->name_ar : $field->name;
                            $placeholderText =
                                app()->getLocale() === 'ar' && $field->placeholder_ar
                                    ? $field->placeholder_ar
                                    : $field->placeholder;
                        @endphp

                        <div class="align-self-end">
                            <label for="custom_field_{{ $field->id }}"
                                class="kt-label {{ $field->is_required ? 'required' : '' }}">
                                {{ $displayName }}
                                @if ($field->is_required)
                                    <span class="text-red-600 text-2xl">*</span>
                                @endif
                            </label>

                            @switch($field->field_type)
                                @case('textarea')
                                    <textarea class="kt-input" id="custom_field_{{ $field->id }}" name="{{ $fieldName }}" rows="3"
                                        placeholder="{{ $placeholderText }}" {{ $field->is_required ? 'required' : '' }}>{{ $fieldValue }}</textarea>
                                @break

                                @case('select')
                                    <select class="kt-input basic-single h-[45px]" id="custom_field_{{ $field->id }}"
                                        name="{{ $fieldName }}" {{ $field->is_required ? 'required' : '' }}>
                                        <option value="">{{ __('main.select') }} {{ $displayName }}</option>
                                        @if (is_array($field->options))
                                            @foreach ($field->options as $option)
                                                <option value="{{ $option }}"
                                                    {{ $fieldValue == $option ? 'selected' : '' }}>
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                @break

                                @case('multiselect')
                                    @php
                                        $selectedValues = is_array($fieldValue)
                                            ? $fieldValue
                                            : (is_string($fieldValue) && !empty($fieldValue)
                                                ? json_decode($fieldValue, true) ?? []
                                                : []);
                                    @endphp
                                    <select class="kt-input basic-multiple" id="custom_field_{{ $field->id }}"
                                        name="{{ "custom_fields[{$field->id}][]" }}" multiple
                                        {{ $field->is_required ? 'required' : '' }}>
                                        @if (is_array($field->options))
                                            @foreach ($field->options as $option)
                                                <option value="{{ $option }}"
                                                    {{ in_array($option, $selectedValues) ? 'selected' : '' }}>
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                @break

                                @case('radio')
                                    <div class="flex flex-wrap gap-4 mt-2">
                                        @if (is_array($field->options))
                                            @foreach ($field->options as $option)
                                                <label class="flex items-center gap-2 cursor-pointer">
                                                    <input type="radio" name="{{ $fieldName }}"
                                                        value="{{ $option }}"
                                                        {{ $fieldValue == $option ? 'checked' : '' }}
                                                        {{ $field->is_required ? 'required' : '' }} class="kt-radio">
                                                    <span>{{ $option }}</span>
                                                </label>
                                            @endforeach
                                        @endif
                                    </div>
                                @break

                                @case('checkbox')
                                    <div class="flex items-center gap-3 mt-2">
                                        <input type="hidden" name="{{ $fieldName }}" value="0">
                                        @include('components.elements.checkbox-button', [
                                            'name' => $fieldName,
                                            'id' => "custom_field_{$field->id}",
                                            'value' => '1',
                                            'checked' => $fieldValue ? true : false,
                                            'label' => $displayName,
                                        ])
                                    </div>
                                @break

                                @case('color')
                                    <div class="flex items-center gap-3">
                                        <input type="color" class="h-[45px] w-[60px] rounded border cursor-pointer"
                                            id="custom_field_{{ $field->id }}" name="{{ $fieldName }}"
                                            value="{{ $fieldValue ?: '#000000' }}">
                                        <span class="text-sm text-secondary-foreground">{{ $fieldValue ?: '#000000' }}</span>
                                    </div>
                                @break

                                @case('range')
                                    <div class="flex items-center gap-3">
                                        <input type="range" class="w-full" id="custom_field_{{ $field->id }}"
                                            name="{{ $fieldName }}" value="{{ $fieldValue ?: 50 }}" min="0"
                                            max="100" step="1"
                                            oninput="document.getElementById('range_val_{{ $field->id }}').textContent = this.value">
                                        <span id="range_val_{{ $field->id }}"
                                            class="text-sm font-medium min-w-[30px] text-center">{{ $fieldValue ?: 50 }}</span>
                                    </div>
                                @break

                                @case('file')
                                    <input type="file" class="kt-input" id="custom_field_{{ $field->id }}"
                                        name="{{ $fieldName }}"
                                        {{ $field->is_required && !$fieldValue ? 'required' : '' }}>
                                    @if ($fieldValue)
                                        <p class="text-xs text-secondary-foreground mt-1">
                                            {{ __('main.current') }}: {{ basename($fieldValue) }}
                                        </p>
                                    @endif
                                @break

                                @case('hidden')
                                    <input type="hidden" id="custom_field_{{ $field->id }}" name="{{ $fieldName }}"
                                        value="{{ $fieldValue }}">
                                    <p class="text-xs text-secondary-foreground italic mt-1">{{ __('main.hidden_field') }}</p>
                                @break

                                @default
                                    {{-- text, number, email, tel, url, date, time, datetime-local --}}
                                    <input type="{{ $field->field_type }}" class="kt-input h-[45px]"
                                        id="custom_field_{{ $field->id }}" name="{{ $fieldName }}"
                                        value="{{ $fieldValue }}" placeholder="{{ $placeholderText }}"
                                        {{ $field->is_required ? 'required' : '' }}
                                        @if ($field->field_type === 'number') step="any" @endif>
                            @endswitch

                            @error("custom_fields.{$field->id}")
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
@endif
