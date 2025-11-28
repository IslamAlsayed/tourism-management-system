@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.restaurant')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.restaurant')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.restaurant')]) }}
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
        <div class="grid gap-4 lg:gap-6">
            {{-- Accommodation Form --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.basic_information') }}</h3>
                </div>
                <div class="kt-card-body">
                    <form class="space-y-6 p-4" method="POST" action="{{ route('restaurants.update', $restaurant->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Restaurant Photo --}}
                        @include('components.input-image', [
                            'modelKey' => $restaurant->name ?? 'R',
                            'column' => 'restaurant',
                            'columnName' => 'photo',
                            'record' => $restaurant,
                        ])

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            {{-- Name --}}
                            <div class="">
                                <label for="name" class="kt-label mb-2">{{ __('main.name') }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]"
                                    value="{{ $restaurant->name }}">
                            </div>

                            {{-- Name Arabic --}}
                            <div class="">
                                <label for="name_ar" class="kt-label mb-2">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
                                    value="{{ $restaurant->name_ar }}">
                            </div>

                            {{-- Type --}}
                            <div class="">
                                <label for="type" class="kt-label mb-2 flex items-center justify-between">
                                    {{ __('main.type') }}
                                    <a href="{{ route('types.create') }}" class="text-blue-600 text-2sm">
                                        {{ __('main.add') }}
                                    </a>
                                </label>
                                <select name="type_id" id="type_id" class="kt-select h-[45px]" special-search
                                    data-current-value={{ $restaurant->type_id }} value={{ $restaurant->type_id }}>
                                    <option value="">--</option>
                                    @foreach ($types as $id => $name)
                                        <option value="{{ $id }}"
                                            {{ $id == $restaurant->type_id ? 'selected' : '' }}>{{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Regions [region, subregion, country, state, city] --}}
                            @include('components.regions.edit', [
                                'levels' => ['region', 'subregion', 'country', 'state', 'city'],
                                'multiple' => false,
                                'record' => $restaurant,
                            ])

                            {{-- Rating --}}
                            <div class="">
                                <label for="rating" class="kt-label mb-2">{{ __('main.rating') }}</label>
                                <select name="rating" id="rating" class="kt-select h-[45px]" special-search
                                    value="{{ $restaurant->rating }}">
                                    <option value="">--</option>
                                    @foreach (range(1, 5) as $item)
                                        <option value="{{ $item }}"
                                            {{ $restaurant->rating == $item ? 'selected' : '' }}>
                                            {{ $item }} Star{{ $item > 1 ? 's' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Specialty --}}
                            <div class="">
                                <label for="specialty_id" class="kt-label mb-2 flex items-center justify-between">
                                    {{ __('main.specialty') }}
                                </label>
                                <select name="specialty_id" id="specialty_id" class="kt-select h-[45px]" special-search>
                                    <option value="">--</option>
                                    @foreach ($specialties ?? [] as $specialty)
                                        <option value="">--</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Company Name (Arabic) --}}
                            <div class="">
                                <label for="company_name_ar" class="kt-label mb-2">{{ __('main.company_name_ar') }}</label>
                                <input type="text" name="company_name_ar" id="company_name_ar" class="kt-input h-[45px]"
                                    value="{{ $restaurant->company_name_ar }}">
                            </div>

                            {{-- phone_01 --}}
                            <div class="">
                                <label for="phone_01" class="kt-label mb-2">{{ __('main.phone_01') }}</label>
                                <input type="text" name="phone_01" id="phone_01" class="kt-input h-[45px]"
                                    value="{{ $restaurant->phone_01 }}">
                            </div>

                            {{-- phone_02 --}}
                            <div class="">
                                <label for="phone_02" class="kt-label mb-2">{{ __('main.phone_02') }}</label>
                                <input type="text" name="phone_02" id="phone_02" class="kt-input h-[45px]"
                                    value="{{ $restaurant->phone_02 }}">
                            </div>

                            {{-- fax --}}
                            <div class="">
                                <label for="fax" class="kt-label mb-2">{{ __('main.fax') }}</label>
                                <input type="text" name="fax" id="fax" class="kt-input h-[45px]"
                                    value="{{ $restaurant->fax }}">
                            </div>

                            {{-- email_01 --}}
                            <div class="">
                                <label for="email_01" class="kt-label mb-2">{{ __('main.email_01') }}</label>
                                <input type="text" name="email_01" id="email_01" class="kt-input h-[45px]"
                                    value="{{ $restaurant->email_01 }}">
                            </div>

                            {{-- email_02 --}}
                            <div class="">
                                <label for="email_02" class="kt-label mb-2">{{ __('main.email_02') }}</label>
                                <input type="text" name="email_02" id="email_02" class="kt-input h-[45px]"
                                    value="{{ $restaurant->email_02 }}">
                            </div>

                            {{-- Contact Person --}}
                            <div class="">
                                <label for="contact_person" class="kt-label mb-2">{{ __('main.contact_person') }}</label>
                                <input type="text" name="contact_person" id="contact_person"
                                    class="kt-input h-[45px]" value="{{ $restaurant->contact_person }}">
                            </div>

                            {{-- Box --}}
                            <div class="">
                                <label for="box" class="kt-label mb-2">{{ __('main.box') }}</label>
                                <input type="text" name="box" id="box" class="kt-input h-[45px]"
                                    value="{{ $restaurant->box }}">
                            </div>

                            {{-- Postal Code --}}
                            <div class="">
                                <label for="postal_code" class="kt-label mb-2">{{ __('main.postal_code') }}</label>
                                <input type="text" name="postal_code" id="postal_code" class="kt-input h-[45px]"
                                    value="{{ $restaurant->postal_code }}">
                            </div>

                            {{-- Mobile --}}
                            <div class="">
                                <label for="mobile" class="kt-label mb-2">{{ __('main.mobile') }}</label>
                                <input type="text" name="mobile" id="mobile" class="kt-input h-[45px]"
                                    value="{{ $restaurant->mobile }}">
                            </div>

                            {{-- Website --}}
                            <div class="">
                                <label for="website" class="kt-label mb-2">{{ __('main.website') }}</label>
                                <input type="text" name="website" id="website" class="kt-input h-[45px]"
                                    value="{{ $restaurant->website }}">
                            </div>
                        </div>

                        {{-- Note --}}
                        @include('components.elements.input-text-editor', [
                            'column' => 'notes',
                            'value' => $restaurant->notes,
                        ])

                        <div class="flex items-center gap-3 mb-4">
                            {{-- Is Active --}}
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="is_active" value="0">
                                @include('components.elements.checkbox-button', [
                                    'name' => 'is_active',
                                    'id' => 'is_active',
                                    'value' => '1',
                                    'checked' => $restaurant->is_active,
                                    'label' => __('main.is_active'),
                                ])
                            </div>
                        </div>

                        {{-- Facilities --}}
                        <div class="mb-4">
                            <h4 class="mb-2 font-semibold">{{ __('main.facilities') }}</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="wheelchair_accessible" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'wheelchair_accessible',
                                        'id' => 'wheelchair_accessible',
                                        'value' => '1',
                                        'checked' => $restaurant->wheelchair_accessible,
                                        'label' => __('main.wheelchair_accessible'),
                                    ])
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="free_wifi" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'free_wifi',
                                        'id' => 'free_wifi',
                                        'value' => '1',
                                        'checked' => $restaurant->free_wifi,
                                        'label' => __('main.free_wifi'),
                                    ])
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="parking" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'parking',
                                        'id' => 'parking',
                                        'value' => '1',
                                        'checked' => $restaurant->parking,
                                        'label' => __('main.parking'),
                                    ])
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="swimming_pool" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'swimming_pool',
                                        'id' => 'swimming_pool',
                                        'value' => '1',
                                        'checked' => $restaurant->swimming_pool,
                                        'label' => __('main.swimming_pool'),
                                    ])
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="gym" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'gym',
                                        'id' => 'gym',
                                        'value' => '1',
                                        'checked' => $restaurant->gym,
                                        'label' => __('main.gym'),
                                    ])
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="indoor" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'indoor',
                                        'id' => 'indoor',
                                        'value' => '1',
                                        'checked' => $restaurant->indoor,
                                        'label' => __('main.indoor'),
                                    ])
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="outdoor" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'outdoor',
                                        'id' => 'outdoor',
                                        'value' => '1',
                                        'checked' => $restaurant->outdoor,
                                        'label' => __('main.outdoor'),
                                    ])
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="spa" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'spa',
                                        'id' => 'spa',
                                        'value' => '1',
                                        'checked' => $restaurant->spa,
                                        'label' => __('main.spa'),
                                    ])
                                </div>
                            </div>
                        </div>

                        <!-- Save Submit Buttons -->
                        @include('components.elements.update-submit', ['models' => 'restaurants'])
                    </form>
                </div>
            </div>

            {{-- Tips --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.restaurant_tips') }}</h3>
                </div>
                <div class="kt-card-body p-2">
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-success-light rounded-full p-2">
                                <i class="ki-filled ki-information text-success"></i>
                            </div>
                            <div>
                                <div class="font-semibold">{{ __('main.complete_information') }}</div>
                                <div class="text-sm text-secondary-foreground">
                                    {{ __('main.provide_detailed_information') }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-success-light rounded-full p-2">
                                <i class="ki-filled ki-information text-success"></i>
                            </div>
                            <div>
                                <div class="font-semibold">{{ __('main.upload_high_resolution_photos') }}</div>
                                <div class="text-sm text-secondary-foreground">
                                    {{ __('main.upload_high_resolution_photos') }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-primary-light rounded-full p-2">
                                <i class="ki-filled ki-star text-primary"></i>
                            </div>
                            <div>
                                <div class="font-semibold">{{ __('main.accurate_rating') }}</div>
                                <div class="text-sm text-secondary-foreground">
                                    {{ __('main.select_appropriate_star_rating') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
