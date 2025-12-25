@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.restaurant')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.restaurant')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.restaurant')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('restaurants.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.restaurants')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <form action="{{ route('restaurants.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-4 lg:gap-6">
                <!-- Restaurant Photo -->
                @include('components.input-image', ['column' => 'restaurant', 'columnName' => 'photo'])

                <!-- Location Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.location')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            {{-- Regions [region, subregion, country, state, city] --}}
                            @include('components.regions.create', [
                                'levels' => ['region', 'subregion', 'country', 'state', 'city'],
                                'multiple' => false,
                            ])

                            <!-- Latitude -->
                            <div class="">
                                <label for="latitude" class="kt-label mb-2">{{ __('main.latitude') }}</label>
                                <input type="number" step="0.00000001" name="latitude" id="latitude"
                                    class="kt-input h-[45px]" value="{{ old('latitude') }}">
                                @error('latitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Longitude -->
                            <div class="">
                                <label for="longitude" class="kt-label mb-2">{{ __('main.longitude') }}</label>
                                <input type="number" step="0.00000001" name="longitude" id="longitude"
                                    class="kt-input h-[45px]" value="{{ old('longitude') }}">
                                @error('longitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Currency -->
                            <div class="">
                                <label for="currency_id" class="kt-label mb-2 flex items-center justify-between">
                                    {{ __('main.currency') }}
                                    <a href="{{ route('currencies.create') }}" class="text-blue-600 text-2sm">
                                        {{ __('main.add') }}
                                    </a>
                                </label>
                                <select name="currency_id" id="currency_id" class="kt-select basic-single">
                                    @foreach ($currencies as $currency)
                                        <option value="{{ $currency->id }}"
                                            {{ old('currency_id') == $currency->id ? 'selected' : '' }}>
                                            {{ $currency->code }} - {{ $currency->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('currency_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Timezone -->
                            <div class="">
                                <label for="timezone_id" class="kt-label mb-2">{{ __('main.timezone') }}</label>
                                <select name="timezone_id" id="timezone_id" class="kt-select basic-single">
                                    <option value="" selected disabled></option>
                                    @foreach ($timezones as $zone)
                                        <option value="{{ $zone['id'] }}"
                                            {{ old('timezone_id') == $zone['id'] ? 'selected' : '' }}>
                                            {{ app()->getLocale() == 'ar' ? ($zone['name_ar'] ? $zone['name_ar'] . ' ' : '') : ($zone['name'] ? $zone['name'] . ' ' : '') }}({{ $zone['abbreviation'] }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('timezone_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Street Address -->
                            <div class="align-self-end">
                                <label for="street" class="kt-label">{{ __('main.street') }}</label>
                                <input type="text" name="street" id="street" class="kt-input h-[45px]"
                                    value="{{ old('street') }}">
                                @error('street')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Postal Code -->
                            <div class="align-self-end">
                                <label for="postal_code" class="kt-label">{{ __('main.postal_code') }}</label>
                                <input type="text" name="postal_code" id="postal_code" class="kt-input h-[45px]"
                                    value="{{ old('postal_code') }}">
                                @error('postal_code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Box -->
                            <div class="align-self-end">
                                <label for="box" class="kt-label">{{ __('main.box') }}</label>
                                <input type="text" name="box" id="box" class="kt-input h-[45px]"
                                    value="{{ old('box') }}">
                                @error('box')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Restaurant Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.restaurant')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            <!-- Name -->
                            <div class="align-self-end">
                                <label for="name" class="kt-label">
                                    {{ __('main.name') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Name Arabic -->
                            <div class="align-self-end">
                                <label for="name_ar" class="kt-label">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
                                    value="{{ old('name_ar') }}">
                                @error('name_ar')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Company Name Arabic -->
                            <div class="align-self-end">
                                <label for="company_name_ar" class="kt-label">{{ __('main.company_name_ar') }}</label>
                                <input type="text" name="company_name_ar" id="company_name_ar"
                                    class="kt-input h-[45px]" value="{{ old('company_name_ar') }}">
                                @error('company_name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Type -->
                            <div class="align-self-end">
                                <label for="type_id" class="kt-label flex items-center justify-between mb-2">
                                    <div>{{ __('main.type') }}</div>
                                    <a href="{{ route('types.create') }}"
                                        class="text-blue-600 text-2sm">{{ __('main.add') }}</a>
                                </label>
                                <select name="type_id" id="type_id" class="kt-select basic-single">
                                    <option value="" disabled selected></option>
                                    @foreach ($types as $key => $type)
                                        <option value="{{ $key }}"
                                            {{ old('type_id') == $key ? 'selected' : '' }}>
                                            {{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('type_id')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Rating -->
                            <div class="align-self-end">
                                <label for="rating" class="kt-label mb-2">{{ __('main.rating') }}</label>
                                <select name="rating" id="rating" class="kt-select basic-single">
                                    <option value="" disabled selected></option>
                                    @foreach (range(1, 5) as $item)
                                        <option value="{{ $item }}"
                                            {{ old('rating') == $item ? 'selected' : '' }}>
                                            {{ $item }} {{ __('main.stars') }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('rating')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Specialty -->
                            <div class="align-self-end">
                                <label for="specialty" class="kt-label">{{ __('main.specialty') }}</label>
                                <input type="text" name="specialty" id="specialty" class="kt-input h-[45px]"
                                    value="{{ old('specialty') }}">
                                @error('specialty')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- description --}}
                        @include('components.elements.input-text-editor', [
                            'column' => 'description',
                            'value' => old('description'),
                        ])

                        {{-- notes --}}
                        @include('components.elements.input-text-editor', [
                            'column' => 'notes',
                            'value' => old('notes'),
                        ])
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.contact')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            <!-- Email 01 -->
                            <div class="align-self-end">
                                <label for="email_01" class="kt-label">{{ __('main.email_01') }}</label>
                                <input type="email" name="email_01" id="email_01" class="kt-input h-[45px]"
                                    value="{{ old('email_01') }}">
                                @error('email_01')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email 02 -->
                            <div class="align-self-end">
                                <label for="email_02" class="kt-label">{{ __('main.email_02') }}</label>
                                <input type="email" name="email_02" id="email_02" class="kt-input h-[45px]"
                                    value="{{ old('email_02') }}">
                                @error('email_02')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone 01 -->
                            <div class="align-self-end">
                                <label for="phone_01" class="kt-label">{{ __('main.phone_01') }}</label>
                                <input type="tel" name="phone_01" id="phone_01" class="kt-input h-[45px]"
                                    value="{{ old('phone_01') }}">
                                @error('phone_01')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone 02 -->
                            <div class="align-self-end">
                                <label for="phone_02" class="kt-label">{{ __('main.phone_02') }}</label>
                                <input type="tel" name="phone_02" id="phone_02" class="kt-input h-[45px]"
                                    value="{{ old('phone_02') }}">
                                @error('phone_02')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Mobile -->
                            <div class="align-self-end">
                                <label for="mobile" class="kt-label">{{ __('main.mobile') }}</label>
                                <input type="tel" name="mobile" id="mobile" class="kt-input h-[45px]"
                                    value="{{ old('mobile') }}">
                                @error('mobile')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Fax -->
                            <div class="align-self-end">
                                <label for="fax" class="kt-label">{{ __('main.fax') }}</label>
                                <input type="text" name="fax" id="fax" class="kt-input h-[45px]"
                                    value="{{ old('fax') }}">
                                @error('fax')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Contact Person --}}
                            <div class="align-self-end">
                                <label for="contact_person" class="kt-label">{{ __('main.contact_person') }}</label>
                                <input type="text" name="contact_person" id="contact_person"
                                    class="kt-input h-[45px]" value="{{ old('contact_person') }}">
                                @error('contact_person')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Website --}}
                            <div class="align-self-end">
                                <label for="website" class="kt-label">{{ __('main.website') }}</label>
                                <input type="url" name="website" id="website" class="kt-input h-[45px]"
                                    value="{{ old('website') }}">
                                @error('website')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap" style="gap: 10px 40px;">
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="wheelchair_accessible" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'wheelchair_accessible',
                            'id' => 'wheelchair_accessible',
                            'value' => '1',
                            'checked' => old('wheelchair_accessible'),
                            'label' => __('main.wheelchair_accessible'),
                        ])
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="free_wifi" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'free_wifi',
                            'id' => 'free_wifi',
                            'value' => '1',
                            'checked' => old('free_wifi'),
                            'label' => __('main.free_wifi'),
                        ])
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="parking" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'parking',
                            'id' => 'parking',
                            'value' => '1',
                            'checked' => old('parking'),
                            'label' => __('main.parking'),
                        ])
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="swimming_pool" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'swimming_pool',
                            'id' => 'swimming_pool',
                            'value' => '1',
                            'checked' => old('swimming_pool'),
                            'label' => __('main.swimming_pool'),
                        ])
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="gym" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'gym',
                            'id' => 'gym',
                            'value' => '1',
                            'checked' => old('gym'),
                            'label' => __('main.gym'),
                        ])
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="indoor" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'indoor',
                            'id' => 'indoor',
                            'value' => '1',
                            'checked' => old('indoor'),
                            'label' => __('main.indoor'),
                        ])
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="outdoor" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'outdoor',
                            'id' => 'outdoor',
                            'value' => '1',
                            'checked' => old('outdoor'),
                            'label' => __('main.outdoor'),
                        ])
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="spa" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'spa',
                            'id' => 'spa',
                            'value' => '1',
                            'checked' => old('spa'),
                            'label' => __('main.spa'),
                        ])
                    </div>
                </div>

                {{-- Seasons Information --}}
                <livewire:morphic-forms.season-form />

                {{-- Meals Information --}}
                <livewire:morphic-forms.meal-form />

                {{-- Supplements Information --}}
                <livewire:morphic-forms.supplement-form />

                <div class="flex items-center gap-3">
                    <input type="hidden" name="is_active" value="0">
                    @include('components.elements.checkbox-button', [
                        'name' => 'is_active',
                        'id' => 'is_active',
                        'value' => '1',
                        'checked' => 1,
                        'label' => __('main.is_active'),
                    ])
                </div>

                <!-- Save Submit -->
                @include('components.elements.save-submit', ['models' => 'restaurants'])
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            setTimeout(() => {
                filterByForeignId("region_id", "subregion", "subregion_id");
                filterByForeignId("subregion_id", "country", "country_id");
                filterByForeignId("country_id", "state", "state_id");
                filterByForeignId("state_id", "city", "city_id");
            }, 500);
        });
    </script>
@endpush

@include('components.regions.script-cascading')
