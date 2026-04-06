@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.route-assignment')]))

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.route-assignment')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.route-assignment')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.transportation.route-assignments.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.route-assignments')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="container-fixed">
        <form action="{{ route('dashboard.transportation.route-assignments.update', $assignment->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid gap-4 lg:gap-6">

                <!-- Basic Assignment Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.assignment_information') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <livewire:transportations.route-assignment :record="$assignment" :routes="$routes" />
                    </div>
                </div>

                <!-- Pricing Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.pricing_information') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Base Price -->
                            <div>
                                <label for="base_price" class="kt-label">{{ __('main.base_price') }}</label>
                                <input type="number" name="base_price" id="base_price" step="0.01" class="kt-input h-[45px]"
                                    value="{{ $assignment->base_price }}" placeholder="0.00">
                                @error('base_price')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Price Per KM -->
                            <div>
                                <label for="price_per_km" class="kt-label">{{ __('main.price_per_km') }}</label>
                                <input type="number" name="price_per_km" id="price_per_km" step="0.01" class="kt-input h-[45px]"
                                    value="{{ $assignment->price_per_km }}" placeholder="0.00">
                                @error('price_per_km')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Price Per Person -->
                            <div>
                                <label for="price_per_person" class="kt-label">{{ __('main.price_per_person') }}</label>
                                <input type="number" name="price_per_person" id="price_per_person" step="0.01" class="kt-input h-[45px]"
                                    value="{{ $assignment->price_per_person }}" placeholder="0.00">
                                @error('price_per_person')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Schedule Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.schedule_information') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                            <!-- Departure Time -->
                            <div>
                                <label for="departure_time" class="kt-label">{{ __('main.departure_time') }}</label>
                                <input type="time" name="departure_time" id="departure_time" class="kt-input h-[45px]"
                                    value="{{ $assignment->departure_time }}">
                                @error('departure_time')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Arrival Time -->
                            <div>
                                <label for="arrival_time" class="kt-label">{{ __('main.arrival_time') }}</label>
                                <input type="time" name="arrival_time" id="arrival_time" class="kt-input h-[45px]" value="{{ $assignment->arrival_time }}">
                                @error('arrival_time')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Frequency Per Day -->
                            <div>
                                <label for="frequency_per_day" class="kt-label">{{ __('main.frequency_per_day') }}</label>
                                <input type="number" name="frequency_per_day" id="frequency_per_day" class="kt-input h-[45px]"
                                    value="{{ $assignment->frequency_per_day }}" min="1">
                                @error('frequency_per_day')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Available Days -->
                        <div class="mt-4">
                            <label class="kt-label mb-2">{{ __('main.available_days') }}</label>
                            <div class="flex flex-wrap" style="gap: 10px 40px;">
                                @foreach ([0, 1, 2, 3, 4, 5, 6] as $day)
                                    <div class="flex items-center gap-3">
                                        <input type="hidden" name="" value="0">
                                        @include('components.elements.checkbox-button', [
                                            'name' => 'available_days[' . $day . ']',
                                            'id' => 'day_' . $day,
                                            'value' => $day,
                                            'checked' => in_array($day, $assignment->available_days ?? []),
                                            'label' => __('main.' . config('helpers.daysMap')[$day]),
                                        ])
                                    </div>
                                @endforeach
                            </div>
                            @error('available_days')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Validity Period -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.validity_period') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Valid From -->
                            <div>
                                <label for="valid_from" class="kt-label">{{ __('main.valid_from') }}</label>
                                <input type="date" name="valid_from" id="valid_from" class="kt-input h-[45px]"
                                    value="{{ $assignment->formatted_valid_from }}">
                                @error('valid_from')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Valid To -->
                            <div>
                                <label for="valid_to" class="kt-label">{{ __('main.valid_to') }}</label>
                                <input type="date" name="valid_to" id="valid_to" class="kt-input h-[45px]" value="{{ $assignment->formatted_valid_to }}">
                                @error('valid_to')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                @include('components.elements.input-text-editor', [
                    'name' => 'description',
                    'value' => $assignment->description,
                ])

                <!-- Notes -->
                @include('components.elements.input-text-editor', [
                    'name' => 'notes',
                    'value' => $assignment->notes,
                ])

                <div class="flex flex-wrap" style="gap: 10px 40px;">
                    <!-- Is Active -->
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_active',
                            'id' => 'is_active',
                            'value' => '1',
                            'checked' => $assignment->is_active,
                            'label' => __('main.active'),
                        ])
                    </div>
                </div>

                {{-- Update Buttons --}}
                @include('components.elements.update-submit', [
                    'models' => 'dashboard.transportation.route-assignments',
                    'model' => 'route-assignment',
                ])
            </div>
        </form>
    </div>
@endsection
