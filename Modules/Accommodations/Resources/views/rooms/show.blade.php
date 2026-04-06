@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.room')]))

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $room->name }}
                </h1>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.accommodations.rooms.edit', $room->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="fa-duotone fa-solid fa-pen text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('dashboard.accommodations.rooms.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.rooms')]) }}
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
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.name') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $room->name ?: __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $room->name_ar ?: __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.max_occupancy') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $room->max_occupancy ?: __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.occupancy_details') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $room->occupancy_details ?: __('main.na') }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.price_per_person_double') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ number_format($room->price_per_person_double, 2) }}
                                {{ $room->currency->code }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.single_room_supplement') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ number_format($room->single_room_supplement, 2) }}
                                {{ $room->currency->code }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.triple_room_discount') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ number_format($room->triple_room_discount, 2) }}
                                {{ $room->currency->code }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.third_person_price') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ number_format($room->third_person_price, 2) }}
                                {{ $room->currency->code }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.extra_bed_price') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ number_format($room->extra_bed_price, 2) }}
                                {{ $room->currency->code }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.sea_view_supplement') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ number_format($room->sea_view_supplement, 2) }}
                                {{ $room->currency->code }}
                            </p>
                        </div>
                        <div wire:key="toggle-{{ $room->id }}-is_active">
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $room->id,
                                    'modelType' => '\\Modules\\Accommodations\\Entities\\Room',
                                    'field' => 'is_active',
                                    'value' => (bool) $room->is_active,
                                    'table' => 'rooms',
                                ])
                            </div>
                        </div>
                        @include('components.elements.displayable-rich-text', [
                            'record' => $room,
                            'column' => 'description',
                        ])
                        @include('components.elements.displayable-rich-text', [
                            'record' => $room,
                            'column' => 'notes',
                        ])
                    </div>
                </div>
            </div>

            {{-- Metadata --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.metadata') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.created_at') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $room->created_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.updated_at') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $room->updated_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Room Related Components -->
            @if ($room->model && Str::contains($room->model_type, 'Accommodation'))
                @include('pages.dashboard.related-components.accommodation', [
                    'record' => $room->model,
                ])
            @elseif($room->model && Str::contains($room->model_type, 'Restaurant'))
                @include('pages.dashboard.related-components.restaurant', [
                    'record' => $room->model,
                ])
            @elseif($room->model && Str::contains($room->model_type, 'Transportation'))
                @include('pages.dashboard.related-components.transportation', [
                    'record' => $room->model,
                ])
            @else
                <!-- No Associated Type Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.no_associated_type')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <p class="text-sm text-secondary-foreground mb-4">
                            {{ __('main.no_associated_type_details', ['type' => __('main.season')]) }}
                        </p>

                        <div class="flex flex-wrap items-center gap-4">
                            @include('components.elements.create-button', [
                                'models' => 'dashboard.accommodations',
                                'model' => 'accommodation',
                            ])
                            @include('components.elements.create-button', [
                                'models' => 'restaurants',
                                'model' => 'restaurant',
                            ])
                            @include('components.elements.create-button', [
                                'models' => 'transportation.companies',
                                'model' => 'transportation-company',
                            ])
                        </div>
                    </div>
                </div>
            @endif

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'dashboard.accommodations.rooms',
                    'id' => $room->id,
                ])
                @include('components.elements.delete-form', [
                    'model' => 'dashboard.accommodations.rooms',
                    'id' => $room->id,
                ])
                <a href="{{ route('dashboard.accommodations.rooms.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.rooms')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
