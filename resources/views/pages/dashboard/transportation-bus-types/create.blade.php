@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.transportations-bus_type')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.transportations-bus_type')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.transportations-bus_type')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('transportation-bus-types.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.transportations-bus_types')]) }}
                </a>
            </div>
        </div>

        @include('components.must-add-first', [
            'requirements' => [
                [
                    'condition' => \App\Models\State::count() > 0,
                    'route' => route('states.create'),
                    'label' => __('main.states_'),
                ],
            ],
        ])
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- transportations-bus_type Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">
                        {{ __('main.type_information', ['type' => __('main.transportations-bus_type')]) }}</h3>
                </div>
                <div class="kt-card-body">
                    <form method="POST" action="{{ route('transportation-bus-types.store') }}" class="space-y-6 p-4">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 items-end mb-4">
                            <!-- Transportation bus type -->
                            <div class="">
                                <label for="name"
                                    class="kt-label required mb-2">{{ __('main.transportations-bus_type') }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]" required>
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Seats -->
                            <div class="">
                                <label for="seats" class="kt-label required mb-2">Seats</label>
                                <input type="number" name="seats" id="seats" class="kt-input h-[45px]" required>
                            </div>

                            <!-- Type -->
                            <div class="">
                                <label for="type" class="kt-label required mb-2">Type</label>
                                <input type="text" name="type" id="type" class="kt-input h-[45px]" required>
                            </div>

                            <!-- Transportation company -->
                            <div class="">
                                <label for="company_id" class="kt-label required mb-2 flex items-center justify-between">
                                    Transportation Company
                                    <a href="{{ route('transportation-companies.create') }}" class="text-blue-600 text-2sm">
                                        {{ __('main.add') }}
                                    </a>
                                </label>
                                <select name="company_id" id="company_id" class="kt-input h-[45px]" required special-search>
                                    <option value="">--</option>
                                    @foreach ($transportationCompanies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Save Submit Buttons -->
                        @include('components.elements.save-submit', [
                            'models' => 'transportations-bus-types',
                        ])
                    </form>
                </div>
            </div>

            <!-- Quick Info -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.important_information') }}</h3>
                </div>
                <div class="kt-card-body p-2">
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-primary-light rounded-full p-2">
                                <i class="ki-filled ki-information text-primary"></i>
                            </div>
                            <div>
                                <div class="mb-2 font-semibold">{{ __('main.ensure_data_accuracy') }}</div>
                                <div class="text-sm text-secondary-foreground">{{ __('main.geographic_coordinates') }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-success-light rounded-full p-2">
                                <i class="ki-filled ki-geolocation text-success"></i>
                            </div>
                            <div>
                                <div class="mb-2 font-semibold">{{ __('main.geographic_coordinates') }}</div>
                                <div class="text-sm text-secondary-foreground">{{ __('main.use_map_services') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
