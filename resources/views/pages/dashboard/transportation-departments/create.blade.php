@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.transportations-company')]))

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.transportations-company')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.transportations-company')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.transportation.companies.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.transportations_companies')]) }}
                </a>
            </div>
        </div>

        @include('components.must-add-first', [
            'requirements' => [
                [
                    'condition' => \Modules\Geography\Entities\Country::count() > 0,
                    'route' => route('dashboard.geography.countries.index'),
                    'label' => __('main.countries'),
                ],
                [
                    'condition' => \Modules\Geography\Entities\State::count() > 0,
                    'route' => route('dashboard.geography.states.index'),
                    'label' => __('main.states'),
                ],
                [
                    'condition' => \Modules\Geography\Entities\City::count() > 0,
                    'route' => route('dashboard.geography.cities.index'),
                    'label' => __('main.cities'),
                ],
            ],
        ])
    </div>

    <div class="container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- transportations-company Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">
                        {{ __('main.type_information', ['type' => __('main.transportations-company')]) }}</h3>
                </div>
                <div class="kt-card-body">
                    <form method="POST" action="{{ route('dashboard.transportation.companies.store') }}" class="space-y-6 p-4">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 items-end mb-4">
                            <!-- Transportation department (Arabic) -->
                            <div class="">
                                <label for="department" class="kt-label required mb-2">{{ __('main.transportations-department') }}</label>
                                <input type="text" name="department" id="department" class="kt-input h-[45px]" required>
                                @error('department')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Contact Person -->
                            <div class="">
                                <label for="contact_person" class="kt-label required mb-2">Contact Person</label>
                                <input type="text" name="contact_person" id="contact_person" class="kt-input h-[45px]" name" required>
                            </div>

                            <!-- Mobile -->
                            <div class="">
                                <label for="mobile" class="kt-label required mb-2">Mobile</label>
                                <input type="text" name="mobile" id="mobile" class="kt-input h-[45px]" required>
                            </div>

                            <!-- phone_01 -->
                            <div class="">
                                <label for="phone_01" class="kt-label required mb-2">Phone 01</label>
                                <input type="text" name="phone_01" id="phone_01" class="kt-input h-[45px]" required>
                            </div>

                            <!-- phone_02 -->
                            <div class="">
                                <label for="phone_02" class="kt-label required mb-2">Phone 02</label>
                                <input type="text" name="phone_02" id="phone_02" class="kt-input h-[45px]" required>
                            </div>

                            <!-- email_01 -->
                            <div class="">
                                <label for="email_01" class="kt-label required mb-2">Email 1</label>
                                <input type="text" name="email_01" id="email_01" class="kt-input h-[45px]" required>
                            </div>

                            <!-- email_02 -->
                            <div class="">
                                <label for="email_02" class="kt-label required mb-2">Email 2</label>
                                <input type="text" name="email_02" id="email_02" class="kt-input h-[45px]" required>
                            </div>

                            <!-- fax -->
                            <div class="">
                                <label for="fax" class="kt-label required mb-2">Fax</label>
                                <input type="text" name="fax" id="fax" class="kt-input h-[45px]" required>
                            </div>

                            <!-- address -->
                            <div class="">
                                <label for="address" class="kt-label required mb-2">Address</label>
                                <input type="text" name="address" id="address" class="kt-input h-[45px]" required>
                            </div>

                            <!-- Website -->
                            <div class="">
                                <label for="website" class="kt-label required mb-2">Website</label>
                                <input type="text" name="website" id="website" class="kt-input h-[45px]" required>
                            </div>

                            <!-- Transportation company -->
                            <div class="">
                                <label for="company_id" class="kt-label required mb-2 flex items-center justify-between">
                                    Transportation Company
                                    <a href="{{ route('dashboard.transportation.companies.create') }}" class="text-blue-600 text-2sm">
                                        {{ __('main.add') }}
                                    </a>
                                </label>
                                <select name="company_id" id="company_id" class="kt-input h-[45px]" required>
                                    <option value="">--</option>
                                    @foreach ($transportationCompanies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Countries -->
                            <div class="">
                                <label for="country_id" class="kt-label required mb-2 flex items-center justify-between">
                                    Countries
                                    <a href="{{ route('dashboard.geography.countries.create') }}" class="text-blue-600 text-2sm">
                                        {{ __('main.add') }}
                                    </a>
                                </label>
                                <select name="country_id" id="country_id" class="kt-input h-[45px]" required>
                                    <option value="">--</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- States -->
                            <div class="">
                                <label for="state_id" class="kt-label required mb-2 flex items-center justify-between">
                                    States
                                    <a href="{{ route('dashboard.geography.states.create') }}" class="text-blue-600 text-2sm">
                                        {{ __('main.add') }}
                                    </a>
                                </label>
                                <select name="state_id" id="state_id" class="kt-input h-[45px]" required>
                                    <option value="">--</option>
                                    @foreach ($states as $state)
                                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Cities -->
                            <div class="">
                                <label for="city_id" class="kt-label required mb-2 flex items-center justify-between">
                                    Cities
                                    <a href="{{ route('dashboard.geography.cities.create') }}" class="text-blue-600 text-2sm">
                                        {{ __('main.add') }}
                                    </a>
                                </label>
                                <select name="city_id" id="city_id" class="kt-input h-[45px]" required>
                                    <option value="">--</option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Regions -->
                            <div class="">
                                <label for="region_id" class="kt-label required mb-2 flex items-center justify-between">
                                    Regions
                                    <a href="{{ route('dashboard.geography.regions.create') }}" class="text-blue-600 text-2sm">
                                        {{ __('main.add') }}
                                    </a>
                                </label>
                                <select name="region_id" id="region_id" class="kt-input h-[45px]" required>
                                    <option value="">--</option>
                                    @foreach ($regions as $region)
                                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Subregions -->
                            <div class="">
                                <label for="subregion_id" class="kt-label required mb-2 flex items-center justify-between">
                                    Subregions
                                    <a href="{{ route('dashboard.geography.subregions.create') }}" class="text-blue-600 text-2sm">
                                        {{ __('main.add') }}
                                    </a>
                                </label>
                                <select name="subregion_id" id="subregion_id" class="kt-input h-[45px]" required>
                                    <option value="">--</option>
                                    @foreach ($subregions as $subregion)
                                        <option value="{{ $subregion->id }}">{{ $subregion->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Save Submit Buttons -->
                        @include('components.elements.save-submit', [
                            'models' => 'transportation-departments',
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
                                <i class="fa-duotone fa-solid fa-circle-info text-primary"></i>
                            </div>
                            <div>
                                <div class="mb-2 font-semibold">{{ __('main.ensure_data_accuracy') }}</div>
                                <div class="text-sm text-secondary-foreground">{{ __('main.geographic_coordinates') }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-success-light rounded-full p-2">
                                <i class="fa-duotone fa-solid fa-location-dot text-success"></i>
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
