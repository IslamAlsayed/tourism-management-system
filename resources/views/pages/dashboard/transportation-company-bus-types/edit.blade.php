@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.transportations-company_bus_type')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.transportations-company_bus_type')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.transportations-company_bus_type')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.transportation.company-bus-types.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.transportations-company_bus_types')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- transportations-company_bus_type Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">
                        {{ __('main.type_information', ['type' => __('main.transportations-company_bus_type')]) }}</h3>
                </div>
                <div class="kt-card-body">
                    <form method="POST" action="{{ route('dashboard.transportation.company-bus-types.update', $transportationCompanyBusType->id) }}"
                        class="space-y-6 p-4">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 items-end mb-4">
                            <!-- Min seats -->
                            <div class="">
                                <label for="min_seats" class="kt-label mb-2">{{ __('main.min_seats') }}</label>
                                <input type="number" name="min_seats" id="min_seats" class="kt-input h-[45px]"
                                    value="{{ $transportationCompanyBusType->min_seats }}">
                                @error('min_seats')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Max seats -->
                            <div class="">
                                <label for="max_seats" class="kt-label mb-2">{{ __('main.max_seats') }}</label>
                                <input type="number" name="max_seats" id="max_seats" class="kt-input h-[45px]"
                                    value="{{ $transportationCompanyBusType->max_seats }}">
                                @error('max_seats')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- seats -->
                            <div class="">
                                <label for="seats" class="kt-label mb-2">{{ __('main.seats') }}</label>
                                <input type="number" name="seats" id="seats" class="kt-input h-[45px]" value="{{ $transportationCompanyBusType->seats }}">
                                @error('seats')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Transportation company -->
                            <div class="">
                                <label for="company_id" class="kt-label mb-2">Transportation Company</label>
                                <select name="company_id" id="company_id" class="kt-input h-[45px]">
                                    <option value="">--</option>
                                    @foreach ($transportationCompanies as $company)
                                        <option value="{{ $company->id }}" {{ $company->id == $transportationCompanyBusType->company_id ? 'selected' : '' }}>
                                            {{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Transportation bus type -->
                            <div class="">
                                <label for="bus_type_id" class="kt-label mb-2">Transportation Bus Type</label>
                                <select name="bus_type_id" id="bus_type_id" class="kt-input h-[45px]">
                                    <option value="">--</option>
                                    @foreach ($transportationBusTypes as $busType)
                                        <option value="{{ $busType->id }}" {{ $busType->id == $transportationCompanyBusType->bus_type_id ? 'selected' : '' }}>
                                            {{ $busType->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Update Submit Buttons -->
                        @include('components.elements.update-submit', [
                            'models' => 'transportation-company-bus-types',
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
