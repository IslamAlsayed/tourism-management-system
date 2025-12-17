@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.room')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $room->name }}
                </h1>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('rooms.edit', $room->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('rooms.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.rooms')]) }}
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
                        <div>
                            <label class="kt-label mb-1">{{ __('main.name') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $room->name ?: __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $room->name_ar ?: __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $room->id,
                                    'modelType' => '\\App\\Models\\Room',
                                    'field' => 'is_active',
                                    'value' => (bool) $room->is_active,
                                    'table' => 'rooms',
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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

            <!-- Room rates -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.room_rates') }}</h3>
                    <div class="kt-card-toolbar">
                        <a href="{{ route('accommodations-rates.create-room') }}" class="kt-btn kt-btn-sm kt-btn-primary">
                            <i class="ki-filled ki-plus text-sm me-1"></i>
                            {{ __('main.add_type', ['type' => __('main.room_rates')]) }}
                        </a>
                    </div>
                </div>
                <div class="kt-card-body p-4" wire:ignore>
                    <div class="grid lg:grid-cols-2 gap-4">
                        @forelse($room->roomRates as $roomRate)
                            <div wire:key="roomRate-{{ $roomRate->id }}"
                                class="kt-card bg-gray-50 rounded-lg p-4 pt-2 record-{{ $roomRate->id }}">
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4">
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.price_per_person_double') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ number_format($roomRate->price_per_person_double, 2) }}</p>
                                    </div>
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.single_room_supplement') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ number_format($roomRate->single_room_supplement, 2) }}</p>
                                    </div>
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.triple_room_discount') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ number_format($roomRate->triple_room_discount, 2) }}</p>
                                    </div>
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.third_person_price') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ number_format($roomRate->third_person_price, 2) }}</p>
                                    </div>
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.extra_bed_price') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ number_format($roomRate->extra_bed_price, 2) }}</p>
                                    </div>
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.sea_view_supplement') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ number_format($roomRate->sea_view_supplement, 2) }}</p>
                                    </div>
                                    <div class="col-span-2 flex items-center gap-10 mb-2">
                                        <div wire:key="toggle-{{ $roomRate->id }}-is_active">
                                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                                            <div class="flex items-center gap-2">
                                                @livewire('toggle-switch', [
                                                    'modelId' => $roomRate->id,
                                                    'modelType' => '\\App\\Models\\AccommodationRoomRate',
                                                    'field' => 'is_active',
                                                    'value' => (bool) $roomRate->is_active,
                                                    'table' => 'accommodation_room_rates',
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if ($roomRate->notes)
                                    <div class="lg:col-span-2 mb-2">
                                        <label class="kt-label mb-1">{{ __('main.notes') }}</label>
                                        <p class="text-sm text-secondary-foreground">{!! $roomRate->notes !!}</p>
                                    </div>
                                @endif
                                @livewire('delete-bottom', [
                                    'type' => 'roomRate',
                                    'modelId' => $roomRate->id,
                                    'modelType' => '\\App\\Models\\AccommodationRoomRate',
                                    'table' => 'accommodation_room_rates',
                                ])
                            </div>
                        @empty
                            <div class="text-center py-8 text-secondary-foreground">
                                <i class="ki-filled ki-information text-4xl mb-2"></i>
                                <p>{{ __('main.no_data_available') }}</p>
                                <a href="{{ route('accommodations-rates.create-room') }}"
                                    class="kt-btn kt-btn-sm kt-btn-primary mt-4">
                                    <i class="ki-filled ki-plus text-sm me-1"></i>
                                    {{ __('main.create_type', ['type' => __('main.room_rate')]) }}
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'rooms',
                    'id' => $room->id,
                ])
                @livewire('delete-bottom', [
                    'type' => 'room',
                    'modelId' => $room->id,
                    'modelType' => '\\App\\Models\\Room',
                    'table' => 'rooms',
                ])
                <a href="{{ route('rooms.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.rooms')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
