@extends('layouts.master')

@section('title', __('main.show_type', ['type' => __('main.field-definition')]))

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $fieldDefinition->name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $fieldDefinition->code }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.core.field-definitions.edit', $fieldDefinition->id) }}"
                    class="kt-btn kt-btn-primary">
                    <i class="fa-duotone fa-solid fa-pen"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('dashboard.core.field-definitions.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.field-definitions')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.basic_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.code') }}</label>
                            <p class="text-sm text-secondary-foreground font-mono">{{ $fieldDefinition->code }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.name') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $fieldDefinition->name }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                            <p class="text-sm text-secondary-foreground" dir="rtl">
                                {{ $fieldDefinition->name_ar ?: '-' }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.module') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $modules[$fieldDefinition->module_name]['label'] ?? $fieldDefinition->module_name }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.section') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $modules[$fieldDefinition->module_name]['entities'][$fieldDefinition->entity_type] ?? $fieldDefinition->entity_type }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.field_type') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                <span class="kt-badge kt-badge-info px-2 py-1 rounded text-xs">
                                    {{ $fieldTypes[$fieldDefinition->field_type] ?? $fieldDefinition->field_type }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.sort_order') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $fieldDefinition->sort_order }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.required') }}</label>
                            <p class="text-sm">
                                @if ($fieldDefinition->is_required)
                                    <span class="kt-badge kt-badge-warning px-2 py-1 rounded text-xs">{{ __('main.yes') }}</span>
                                @else
                                    <span class="kt-badge kt-badge-light px-2 py-1 rounded text-xs">{{ __('main.no') }}</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.status') }}</label>
                            <p class="text-sm">
                                @if ($fieldDefinition->is_active)
                                    <span
                                        class="kt-badge kt-badge-success px-2 py-1 rounded text-xs">{{ __('main.active') }}</span>
                                @else
                                    <span
                                        class="kt-badge kt-badge-destructive px-2 py-1 rounded text-xs">{{ __('main.inactive') }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            @if ($fieldDefinition->field_type === 'select' && !empty($fieldDefinition->options))
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.dropdown_options') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="flex flex-wrap gap-2">
                            @foreach ($fieldDefinition->options as $option)
                                <span class="kt-badge kt-badge-outline px-3 py-1 rounded-full text-sm">{{ $option }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            @if ($fieldDefinition->placeholder || $fieldDefinition->section_label)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.additional_settings') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            @if ($fieldDefinition->placeholder)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.placeholder') }}</label>
                                    <p class="text-sm text-secondary-foreground">{{ $fieldDefinition->placeholder }}</p>
                                </div>
                            @endif
                            @if ($fieldDefinition->section_label)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.section_label') }}</label>
                                    <p class="text-sm text-secondary-foreground">{{ $fieldDefinition->section_label }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
