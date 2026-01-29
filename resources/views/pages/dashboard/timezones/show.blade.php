@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.timezone')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $timezone->name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $timezone->abbreviation }} • {{ $timezone->gmt_offset_name }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('timezones.edit', $timezone->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('timezones.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.timezones')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.basic_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @if ($timezone->name)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $timezone->name ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($timezone->name_ar)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $timezone->name_ar ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($timezone->abbreviation)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.abbreviation') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $timezone->abbreviation ?: __('main.na') }}
                                </p>
                            </div>
                        @endif
                        @if ($timezone->abbreviation_dst)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.abbreviation_dst') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $timezone->abbreviation_dst ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($timezone->country_code)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.country_code') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $timezone->country_code ?: __('main.na') }}
                                </p>
                            </div>
                        @endif
                        @if ($timezone->gmt_offset_name)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.gmt_offset_name') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $timezone->gmt_offset_name ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($timezone->offset !== null)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.offset') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $timezone->offset }}
                                    {{ __('main.seconds') }}</p>
                            </div>
                        @endif
                        @if ($timezone->offset_dst !== null)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.offset_dst') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $timezone->offset_dst }}
                                    {{ __('main.seconds') }}</p>
                            </div>
                        @endif
                        @if ($timezone->sort_order !== null)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.sort_order') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $timezone->sort_order }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.supports_dst') }}</label>
                            <div class="flex items-center gap-2">
                                <span class="text-sm {{ $timezone->supports_dst ? 'text-success' : 'text-danger' }}">
                                    {{ $timezone->supports_dst ? __('main.yes') : __('main.no') }}
                                </span>
                            </div>
                        </div>
                        <div class="col-span-full flex flex-wrap" style="gap: 10px 40px;">
                            <div>
                                <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $timezone->id,
                                        'modelType' => '\\App\\Models\\Timezone',
                                        'field' => 'is_active',
                                        'value' => (bool) $timezone->is_active,
                                        'table' => 'timezones',
                                    ])
                                </div>
                            </div>
                            <div>
                                <label class="kt-label mb-1">{{ __('main.supports_dst') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $timezone->id,
                                        'modelType' => '\\App\\Models\\Timezone',
                                        'field' => 'supports_dst',
                                        'value' => (bool) $timezone->supports_dst,
                                        'table' => 'timezones',
                                    ])
                                </div>
                            </div>
                        </div>
                        @include('components.elements.display-desc-or-notes', [
                            'record' => $timezone,
                            'column' => 'description',
                        ])
                        @include('components.elements.display-desc-or-notes', [
                            'record' => $timezone,
                            'column' => 'notes',
                        ])
                    </div>
                </div>
            </div>

            <!-- Metadata -->
            @include('components.metadata', ['record' => $timezone])

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'timezones',
                    'id' => $timezone->id,
                ])
                @include('components.elements.delete-form', [
                    'model' => 'timezones',
                    'id' => $timezone->id,
                ])
                <a href="{{ route('timezones.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.timezones')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
