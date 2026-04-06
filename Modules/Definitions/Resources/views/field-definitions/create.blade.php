@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.field-definition')]))

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.field-definition')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_new_custom_field') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.definitions.field-definitions.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.field-definitions')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="container-fixed">
        <form action="{{ route('dashboard.definitions.field-definitions.store') }}" method="POST">
            @csrf
            <div class="grid gap-4 lg:gap-6">
                <!-- Basic Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.basic_information') }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                            {{-- Name (English) --}}
                            <div class="align-self-end">
                                <label for="name" class="kt-label required">
                                    {{ __('main.name') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <input type="text" class="kt-input h-[45px]" id="name" name="name"
                                    value="{{ old('name') }}" placeholder="e.g. Phone Number" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Name (Arabic) --}}
                            <div class="align-self-end">
                                <label for="name_ar" class="kt-label">{{ __('main.name_ar') }}</label>
                                <input type="text" class="kt-input h-[45px]" id="name_ar" name="name_ar"
                                    value="{{ old('name_ar') }}" placeholder="مثال: رقم الهاتف" dir="rtl">
                                @error('name_ar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Module --}}
                            <div class="align-self-end">
                                <label for="module_name" class="kt-label required">
                                    {{ __('main.module') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <select name="module_name" id="module_name" class="kt-input basic-single h-[45px]" required
                                    onchange="updateEntityOptions()">
                                    <option value="">{{ __('main.select_module') }}</option>
                                    @foreach ($modules as $modKey => $modData)
                                        <option value="{{ $modKey }}"
                                            {{ old('module_name') == $modKey ? 'selected' : '' }}>
                                            {{ $modData['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('module_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Entity Type --}}
                            <div class="align-self-end">
                                <label for="entity_type" class="kt-label required">
                                    {{ __('main.section') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <select name="entity_type" id="entity_type" class="kt-input basic-single h-[45px]" required>
                                    <option value="">{{ __('main.select_section') }}</option>
                                </select>
                                @error('entity_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Field Type --}}
                            <div class="align-self-end">
                                <label for="field_type" class="kt-label required">
                                    {{ __('main.field_type') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <select name="field_type" id="field_type" class="kt-input basic-single h-[45px]" required
                                    onchange="toggleOptions()">
                                    <option value="">{{ __('main.select_field_type') }}</option>
                                    @foreach ($fieldTypes as $ftKey => $ftLabel)
                                        <option value="{{ $ftKey }}"
                                            {{ old('field_type') == $ftKey ? 'selected' : '' }}>
                                            {{ $ftLabel }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('field_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Sort Order --}}
                            <div class="align-self-end">
                                <label for="sort_order" class="kt-label">{{ __('main.sort_order') }}</label>
                                <input type="number" class="kt-input h-[45px]" id="sort_order" name="sort_order"
                                    value="{{ old('sort_order', 0) }}" min="0">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Options (for select/dropdown fields) -->
                <div class="kt-card" id="options_section" style="display: none;">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.dropdown_options') }} (Select / Multi-Select / Radio)</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <label for="options" class="kt-label mb-2">{{ __('main.options_comma_separated') }}</label>
                        <textarea class="kt-input" id="options" name="options" rows="3" placeholder="Option 1, Option 2, Option 3">{{ old('options') }}</textarea>
                        <p class="text-xs text-secondary-foreground mt-1">
                            {{ __('main.separate_options_with_comma') }}
                        </p>
                    </div>
                </div>

                <!-- Placeholders -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.additional_settings') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-6">
                            {{-- Placeholder (English) --}}
                            <div>
                                <label for="placeholder" class="kt-label">{{ __('main.placeholder') }}</label>
                                <input type="text" class="kt-input h-[45px]" id="placeholder" name="placeholder"
                                    value="{{ old('placeholder') }}" placeholder="e.g. Enter phone number">
                            </div>

                            {{-- Placeholder (Arabic) --}}
                            <div>
                                <label for="placeholder_ar" class="kt-label">{{ __('main.placeholder_ar') }}</label>
                                <input type="text" class="kt-input h-[45px]" id="placeholder_ar"
                                    name="placeholder_ar" value="{{ old('placeholder_ar') }}"
                                    placeholder="مثال: أدخل رقم الهاتف" dir="rtl">
                            </div>

                            {{-- Section Label (English) --}}
                            <div>
                                <label for="section_label" class="kt-label">{{ __('main.section_label') }}</label>
                                <input type="text" class="kt-input h-[45px]" id="section_label" name="section_label"
                                    value="{{ old('section_label') }}" placeholder="e.g. Contact Information">
                            </div>

                            {{-- Section Label (Arabic) --}}
                            <div>
                                <label for="section_label_ar" class="kt-label">{{ __('main.section_label_ar') }}</label>
                                <input type="text" class="kt-input h-[45px]" id="section_label_ar"
                                    name="section_label_ar" value="{{ old('section_label_ar') }}"
                                    placeholder="مثال: معلومات الاتصال" dir="rtl">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Checkboxes --}}
                <div class="flex flex-wrap" style="gap: 10px 40px;">
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_required" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_required',
                            'id' => 'is_required',
                            'value' => '1',
                            'checked' => old('is_required', 0),
                            'label' => __('main.required'),
                        ])
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_active',
                            'id' => 'is_active',
                            'value' => '1',
                            'checked' => old('is_active', 1),
                            'label' => __('main.active'),
                        ])
                    </div>
                </div>

                {{-- Save Buttons --}}
                @include('components.elements.save-submit', [
                    'models' => 'dashboard.definitions.field-definitions',
                    'model' => 'field-definition',
                ])
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        // Module registry data from PHP
        const moduleRegistry = @json($modules);

        function updateEntityOptions() {
            const moduleSelect = document.getElementById('module_name');
            const entitySelect = document.getElementById('entity_type');
            const selectedModule = moduleSelect.value;

            // Clear existing options
            entitySelect.innerHTML = '<option value="">{{ __('main.select_section') }}</option>';

            if (selectedModule && moduleRegistry[selectedModule]) {
                const entities = moduleRegistry[selectedModule].entities;
                for (const [key, label] of Object.entries(entities)) {
                    const option = document.createElement('option');
                    option.value = key;
                    option.textContent = label;
                    entitySelect.appendChild(option);
                }
            }

            // Refresh Select2 so it sees the new options
            if (typeof $ !== 'undefined' && $(entitySelect).data('select2')) {
                $(entitySelect).trigger('change.select2');
            }
        }

        function toggleOptions() {
            const fieldType = document.getElementById('field_type').value;
            const optionsSection = document.getElementById('options_section');
            const needsOptions = ['select', 'multiselect', 'radio'].includes(fieldType);
            optionsSection.style.display = needsOptions ? 'block' : 'none';
        }

        // Initialize on page load (for old() values)
        document.addEventListener('DOMContentLoaded', function() {
            const oldModule = '{{ old('module_name') }}';
            const oldEntity = '{{ old('entity_type') }}';

            // Listen for Select2 module change too
            if (typeof $ !== 'undefined') {
                $('#module_name').on('change', function() {
                    updateEntityOptions();
                });
                $('#field_type').on('change', function() {
                    toggleOptions();
                });
            }

            if (oldModule) {
                updateEntityOptions();
                if (oldEntity) {
                    document.getElementById('entity_type').value = oldEntity;
                    if (typeof $ !== 'undefined' && $('#entity_type').data('select2')) {
                        $('#entity_type').trigger('change.select2');
                    }
                }
            }
            toggleOptions();
        });
    </script>
@endpush
