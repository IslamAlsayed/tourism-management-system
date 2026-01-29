@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.jeep')]))

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/tagify/tagify.css') }}">
@endpush

@section('content')
<div class="kt-container-fixed">
    <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
        <div class="flex flex-col justify-center gap-2">
            <h1 class="text-xl font-medium leading-none text-mono">
                {{ __('main.edit_type', ['type' => __('main.jeep')]) }}
            </h1>
            <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                {{ __('main.edit_type_description', ['type' => __('main.jeep')]) }}
            </div>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('jeeps.index') }}" class="kt-btn kt-btn-outline">
                {{ __('main.back_to_types', ['types' => __('main.jeeps')]) }}
            </a>
        </div>
    </div>
</div>

<div class="kt-container-fixed">
    <form action="{{ route('jeeps.update', $jeep->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="grid gap-4 lg:gap-6">
            <!-- jeep Photo -->
            @include('components.input-image', [
            'column' => 'jeep',
            'columnName' => 'photo',
            ])

            <!-- Location Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">
                        {{ __('main.type_information', ['type' => __('main.location')]) }}
                    </h3>
                </div>
                <div class="kt-card-body p-4 pb-0">
                    {{-- Regions [region, subregion, country, state, city] --}}
                    <livewire:regions.location-select-base :record="$jeep" />
                </div>
            </div>

            <!-- Basic Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.basic_info') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                        <!-- Provider Company -->
                        <div>
                            <label for="company_id" class="kt-label">{{ __('main.transportation_company') }}</label>
                            <select name="company_id" id="company_id" class="kt-select basic-single" data-control="select2">
                                <option value="">{{ __('main.select_company') }}</option>
                                @foreach ($companies as $company)
                                <option value="{{ $company->id }}" {{ $jeep->company_id == $company->id ? 'selected' : '' }}>
                                    {{ $company->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-full">
                            {{-- Route --}}
                            @include('components.elements.input-text-editor', [
                            'name' => 'route',
                            'classes' => 'mb-4',
                            'value' => $jeep->route,
                            ])

                            {{-- Route Arabic --}}
                            @include('components.elements.input-text-editor', [
                            'name' => 'route_ar',
                            'value' => $jeep->route_ar,
                            ])
                        </div>

                        <!-- Route Itinerary (Tagify) -->
                        <div class="col-span-full">
                            <label for="route_itinerary" class="kt-label">{{ __('main.route_itinerary') }}</label>
                            <input type="text" name="route_itinerary" id="route_itinerary" class="kt-input h-fit" value="{{ $jeep->route_itinerary }}" placeholder="Stop 1, Stop 2, ...">
                            <span class="text-xs text-gray-500 mt-1">{{ __('main.tagify_desc') }}</span>
                        </div>

                        <div class="col-span-full">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Start City -->
                                <div>
                                    <label for="origin_city_id" class="kt-label">
                                        {{ __('main.origin_city') }}
                                        <span class="text-red-600 text-2xl">*</span>
                                    </label>
                                    <select name="origin_city_id" id="origin_city_id" class="kt-select basic-single cities-select">
                                        <option value="" selected>--</option>
                                    </select>
                                    @error('origin_city_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Destination City -->
                                <div>
                                    <label for="destination_city_id" class="kt-label">
                                        {{ __('main.destination_city') }}
                                        <span class="text-red-600 text-2xl">*</span>
                                    </label>
                                    <select name="destination_city_id" id="destination_city_id" class="kt-select basic-single cities-select">
                                        <option value="" selected>--</option>
                                    </select>
                                    @error('destination_city_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-span-full">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="flex gap-2">
                                    <div class="flex-grow">
                                        <label for="duration" class="kt-label">{{ __('main.duration') }}</label>
                                        <input type="number" step="0.1" name="duration" id="duration" class="kt-input h-[45px]" value="{{ $jeep->duration }}">
                                    </div>
                                    <div class="w-1/3">
                                        <label for="duration_unit" class="kt-label">{{ __('main.unit') }}</label>
                                        <select name="duration_unit" id="duration_unit" class="kt-select basic-single">
                                            @foreach ($durationUnits as $key => $label)
                                            <option value="{{ $key }}" {{ $jeep->duration_unit == $key ? 'selected' : '' }}>
                                                {{ __('main.' . $key) }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <div class="flex-grow">
                                        <label for="distance" class="kt-label">{{ __('main.distance') }}</label>
                                        <input type="number" step="0.1" name="distance" id="distance" class="kt-input h-[45px]" value="{{ $jeep->distance }}">
                                    </div>
                                    <div class="w-1/3">
                                        <label for="distance_unit" class="kt-label">{{ __('main.unit') }}</label>
                                        <select name="distance_unit" id="distance_unit" class="kt-select basic-single">
                                            @foreach ($distanceUnits as $key => $label)
                                            <option value="{{ $key }}" {{ $jeep->distance_unit == $key ? 'selected' : '' }}>
                                                {{ __('main.' . $key) }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vehicle Information -->
            <div class="kt-card mb-4 relative z-0">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.vehicle_info') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="kt-label">{{ __('main.vehicle_model') }}</label>
                            <input type="text" name="vehicle_model" class="kt-input h-[45px]" value="{{ $jeep->vehicle_model }}" placeholder="e.g. Toyota Land Cruiser">
                        </div>
                        <div>
                            <label class="kt-label">{{ __('main.model_year') }}</label>
                            <input type="text" name="model_year" class="kt-input h-[45px]" value="{{ $jeep->model_year }}" placeholder="e.g. 2025">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="kt-label">{{ __('main.license_plate') }}</label>
                            <input type="text" name="license_plate" class="kt-input h-[45px]" value="{{ $jeep->license_plate }}">
                        </div>
                        <div>
                            <label class="kt-label">{{ __('main.seating_capacity') }}</label>
                            <input type="number" name="car_seats" class="kt-input h-[45px]" value="{{ $jeep->car_seats }}" min="1">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pricing & Features -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.pricing_features') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <!-- Pricing Row -->
                    <h4 class="text-sm font-bold text-gray-700 mb-3 pb-2">
                        {{ __('main.default_pricing_config') }}
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
                        <!-- Left Side: Price Inputs -->
                        <div class="space-y-4">
                            <div>
                                <label class="kt-label mb-2 block">{{ __('main.price') }}</label>
                                <div class="flex">
                                    <div class="w-full">
                                        <input type="number" step="0.01" name="price" id="price" class="h-full rounded-none bg-gray-50 text-gray-600 flex-1 min-w-0 w-full text-sm p-2.5"
                                            style="border: 1px var(--tw-border-style) var(--input)" placeholder="0.00" value="{{ $jeep->price }}">
                                    </div>

                                    <div class="w-[220px]">
                                        <select name="price_type"
                                            class="basic-single bg-gray-50 border border-s-0 border-gray-200 text-gray-600 text-sm rounded-e-md focus:ring-blue-500 focus:border-blue-500 block p-2.5"
                                            style="border-top-left-radius: 0 !important; border-bottom-left-radius: 0 !important; margin-left: -1px;">
                                            @foreach ($priceTypes as $key => $label)
                                            <option value="{{ $key }}" {{ $jeep->price_type == $key ? 'selected' : '' }}>
                                                {{ __('main.' . $key) }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-500 mt-1 block">{{ __('main.fallback_price_if_no_season') }}</span>
                            </div>

                            <div class="grid grid-cols-2 items-end gap-4">
                                <!-- Currency -->
                                <div class="w-full">
                                    @include('components.selects.currency', ['record' => $jeep])
                                </div>

                                <!-- Status -->
                                <div class="w-full">
                                    <label for="status" class="kt-label mb-2 block">
                                        {{ __('main.status') }}
                                        <span class="text-red-600">*</span>
                                    </label>
                                    <select name="status" id="status" class="kt-select basic-single w-full">
                                        <option value="" selected>--</option>
                                        @foreach (['active', 'maintenance', 'retired'] as $status)
                                        <option value="{{ $status }}" {{ $jeep->status == $status ? 'selected' : '' }}>
                                            {{ __('main.' . $status) }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side: Properties Checkboxes -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <label class="kt-label mb-3 block text-center border-b border-gray-200 pb-2">{{ __('main.properties') }}</label>
                            <div class="grid grid-cols-2 gap-4">
                                @foreach (['has_ac', 'has_driver', 'is_4x4', 'has_camping_gear', 'is_featured'] as $item)
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="{{ $item }}" value="0">
                                    @include('components.elements.checkbox-button', [
                                    'name' => $item,
                                    'id' => $item,
                                    'value' => '1',
                                    'checked' => $jeep->$item,
                                    'label' => __('main.' . $item),
                                    ])
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Seasons & Pricing Repeater -->
            <div class="kt-card border border-primary/20 shadow-sm">
                <div class="kt-card-header bg-primary/5 min-h-[50px] px-4 py-2">
                    <div class="flex justify-between items-center w-full">
                        <div class="flex flex-col">
                            <h3 class="kt-card-title text-base font-bold text-primary">
                                {{ __('main.seasonal_pricing') }}
                            </h3>
                            <span class="text-xs text-gray-500">{{ __('main.seasonal_pricing_desc') }}</span>
                        </div>
                        <button type="button" class="kt-btn kt-btn-sm kt-btn-primary" id="add-season-btn">
                            <i class="ki-outline ki-plus fs-3"></i> {{ __('main.add_season') }}
                        </button>
                    </div>
                </div>
                <div class="kt-card-body p-4" id="seasons-container">
                    <!-- Seasons will be added here dynamically -->
                    <div class="text-center p-6 text-gray-400" id="no-seasons-msg">{{ __('main.no_seasons_added') }}</div>
                </div>
            </div>

            <!-- Template for New Season (Hidden) -->
            <template id="season-template">
                <div class="season-item border rounded-md bg-gray-50 overflow-hidden" data-index="INDEX">
                    <div class="bg-gray-50 px-4 py-2 flex justify-between items-center border-b border-gray-200 cursor-pointer season-header-toggle">
                        <div class="flex items-center gap-2 font-semibold">
                            <i class="ki-outline ki-calendar-tick fs-2 text-primary"></i>
                            <span class="season-title">New Season</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" class="text-gray-500 hover:text-primary transition-colors toggle-season">
                                <i class="ki-outline ki-arrow-down fs-2"></i>
                            </button>
                            <button type="button" class="text-red-500 hover:text-red-700 transition-colors remove-season" title="{{ __('main.remove_season') }}">
                                <i class="ki-outline ki-trash fs-2"></i>
                            </button>
                        </div>
                    </div>
                    <div class="p-4 season-body">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
                            <div class="w-full">
                                <label class="block text-sm font-medium mb-1">{{ __('main.season_name') }}</label>
                                <input type="text" name="seasons[INDEX][name]" class="kt-input h-[38px] season-name-input w-full" placeholder="Summer 2026">
                            </div>
                            <div class="w-full">
                                <label class="block text-sm font-medium mb-1">{{ __('main.start_date') }}</label>
                                <input type="date" name="seasons[INDEX][start_date]" class="kt-input h-[38px] w-full">
                            </div>
                            <div class="w-full">
                                <label class="block text-sm font-medium mb-1">{{ __('main.end_date') }}</label>
                                <input type="date" name="seasons[INDEX][end_date]" class="kt-input h-[38px] w-full">
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-3 mt-3">
                            <h4 class="text-sm font-bold mb-3 flex items-center gap-2">
                                <i class="ki-outline ki-dollar fs-3"></i> {{ __('main.base_prices') }}
                            </h4>
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                                <div class="background p-2 rounded border border-gray-200">
                                    <label class="block text-xs font-semibold mb-1 text-gray-600">{{ __('main.price_local') }}</label>
                                    <div class="flex">
                                        <span class="inline-flex items-center px-2 text-xs text-gray-600 bg-gray-50 border border-e-0 border-gray-200 rounded-s-md">
                                            $
                                        </span>
                                        <input type="number" step="0.01" name="seasons[INDEX][price_local]"
                                            class="rounded-none rounded-e-md bg-gray-50 border border-gray-200 text-gray-600 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-1.5"
                                            placeholder="0.00">
                                    </div>
                                </div>
                                <div class="background p-2 rounded border border-gray-200">
                                    <label class="block text-xs font-semibold mb-1 text-gray-600">{{ __('main.price_arab') }}</label>
                                    <div class="flex">
                                        <span class="inline-flex items-center px-2 text-xs text-gray-600 bg-gray-50 border border-e-0 border-gray-200 rounded-s-md">
                                            $
                                        </span>
                                        <input type="number" step="0.01" name="seasons[INDEX][price_arab]"
                                            class="rounded-none rounded-e-md bg-gray-50 border border-gray-200 text-gray-600 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-1.5"
                                            placeholder="0.00">
                                    </div>
                                </div>
                                <div class="background p-2 rounded border border-gray-200">
                                    <label class="block text-xs font-semibold mb-1 text-gray-600">{{ __('main.price_foreigner') }}</label>
                                    <div class="flex">
                                        <span class="inline-flex items-center px-2 text-xs text-gray-600 bg-gray-50 border border-e-0 border-gray-200 rounded-s-md">
                                            $
                                        </span>
                                        <input type="number" step="0.01" name="seasons[INDEX][price_foreigner]"
                                            class="rounded-none rounded-e-md bg-gray-50 border border-gray-200 text-gray-600 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-1.5"
                                            placeholder="0.00">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Nationality Exceptions -->
                        <div class="border-t border-gray-200 pt-3 mt-4 background rounded">
                            <div class="flex justify-between items-center mb-2">
                                <h4 class="text-xs font-bold uppercase text-gray-500 tracking-wider">
                                    {{ __('main.nationality_exceptions') }}
                                </h4>
                                <button type="button" class="text-xs text-primary font-medium hover:underline add-nationality-price" data-season-index="INDEX">
                                    + {{ __('main.add_exception') }}
                                </button>
                            </div>
                            <div class="nationality-prices-container space-y-2">
                                <!-- Exceptions go here -->
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Template for Nationality Exception -->
            <template id="nationality-price-template">
                <div class="flex gap-2 items-center nationality-price-row bg-gray-50 p-2 rounded border border-dashed border-gray-200">
                    <div class="w-full">
                        <select name="seasons[SEASON_INDEX][nationality_prices][NAT_INDEX][nationality_id]" class="kt-select nationality-select text-sm" id="nationality_id">
                            <option value="" selected>--</option>
                        </select>
                    </div>
                    <div class="w-full">
                        <select name="seasons[SEASON_INDEX][nationality_prices][NAT_INDEX][price_type]" class="kt-select price-type-select text-sm">
                            @foreach ($priceTypes as $key => $label)
                            <option value="{{ $key }}">{{ __('main.' . $key) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full">
                        <input type="number" step="0.01" name="seasons[SEASON_INDEX][nationality_prices][NAT_INDEX][price]" class="kt-input h-[45px] text-sm" placeholder="{{ __('main.price') }}">
                    </div>
                    <button type="button" class="text-red-500 hover:text-red-700 remove-nationality-price p-1">
                        <i class="ki-outline ki-cross fs-3"></i>
                    </button>
                </div>
            </template>

            <!-- Media Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">
                        {{ __('main.type_information', ['type' => __('main.media')]) }}
                    </h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Main Image -->
                        <div>
                            <label for="photo" class="kt-label">
                                {{ __('main.main_image') }}
                            </label>
                            <div class="dropzone mt-2 border-2 border-dashed border-gray-200 rounded-lg p-4 text-center hover:border-primary transition-colors cursor-pointer" data-input="photo"
                                data-preview="preview-photo">
                                <i class="far fa-cloud-arrow-up text-5xl text-gray-600"></i>
                                <p class="mt-4">{{ __('main.click_or_drag_image_here') }}</p>
                            </div>
                            <input type="file" name="photo" id="photo" accept="image/*" hidden>
                            <input type="hidden" name="remove_photo" id="remove_photo" value="0">

                            {{-- Existing photo (edit mode) --}}
                            @if (!empty($jeep->photo))
                            <div id="existing-photo" class="relative mt-3">
                                <img src="{{ asset('storage/' . $jeep->photo) }}" class="h-32 w-32 rounded">
                                <button type="button" class="remove-existing-photo absolute -top-2 -right-2 bg-danger text-white w-6 h-6 rounded-full">
                                    ×
                                </button>
                            </div>
                            @endif

                            <div id="preview-photo" class="hidden mt-3"></div>
                        </div>

                        <!-- Gallery Images -->
                        <div>
                            <label for="gallery" class="kt-label">
                                {{ __('main.gallery_images') }}
                            </label>
                            <div class="dropzone mt-2 border-2 border-dashed border-gray-200 rounded-lg p-4 text-center hover:border-primary transition-colors cursor-pointer" data-input="gallery"
                                data-preview="preview-gallery">
                                <i class="far fa-cloud-arrow-up text-5xl text-gray-600"></i>
                                <p class="mt-4">{{ __('main.click_or_drag_image_here_multiple') }}</p>
                            </div>
                            <input type="file" name="gallery[]" id="gallery" accept="image/*" hidden multiple>
                            <input type="hidden" name="removed_gallery" id="removed_gallery" value="[]">

                            <!-- Existing Gallery Images -->
                            <div class="mt-4 flex flex-wrap gap-4">
                                @if (is_array($jeep->gallery))
                                @foreach ($jeep->gallery as $index => $img)
                                <div id="existing_gallery_{{ $index }}" class="relative">
                                    <img src="{{ asset('storage/' . $img) }}" class="h-32 w-32 rounded">
                                    <button type="button" class="remove-existing-gallery absolute -top-2 -right-2 bg-danger text-white w-6 h-6 rounded-full" data-index="{{ $index }}"
                                        data-path="{{ $img }}">
                                        ×
                                    </button>
                                </div>
                                @endforeach
                                @endif
                            </div>

                            <div id="preview-gallery" class="hidden flex gap-3 mt-3"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Description --}}
            @include('components.elements.input-text-editor', ['name' => 'description', 'value' => $jeep->description])

            {{-- Notes --}}
            @include('components.elements.input-text-editor', ['name' => 'notes', 'value' => $jeep->notes])

            <div class="flex flex-wrap" style="gap: 10px 40px">
                <div class="flex items-center gap-3">
                    <input type="hidden" name="is_active" value="0">
                    @include('components.elements.checkbox-button', [
                    'name' => 'is_active',
                    'id' => 'is_active',
                    'value' => '1',
                    'checked' => $jeep->is_active,
                    'label' => __('main.active'),
                    ])
                </div>
            </div>

            {{-- Update Buttons --}}
            @include('components.elements.update-submit', ['models' => 'jeeps'])
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/plugins/tagify/tagify.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let seasonIndex = 0;
        const seasonsContainer = document.getElementById('seasons-container');
        const noSeasonsMsg = document.getElementById('no-seasons-msg');
        const seasonTemplate = document.getElementById('season-template').innerHTML;
        const natPriceTemplate = document.getElementById('nationality-price-template').innerHTML;
        seasonsContainer.classList.add('flex', 'flex-col', 'gap-4');

        // Add Season
        document.getElementById('add-season-btn').addEventListener('click', function() {
            noSeasonsMsg.style.display = 'none';
            let html = seasonTemplate.replace(/INDEX/g, seasonIndex);
            seasonsContainer.insertAdjacentHTML('beforeend', html);

            // Init inputs (if specific plugins needed)
            // Focus on name
            const newSeason = seasonsContainer.lastElementChild;
            newSeason.querySelector('.season-name-input').focus();

            seasonIndex++;
        });

        // Event Delegation for dynamic elements
        seasonsContainer.addEventListener('click', function(e) {
            const target = e.target.closest('button');
            if (!target) return;

            // Remove Season
            if (target.classList.contains('remove-season')) {
                if (confirm('{{ __('
                        messages.confirm_delete ') }}')) {
                    target.closest('.season-item').remove();
                    if (seasonsContainer.children.length <= 1) { // 1 accounts for message div (hidden or not)
                        if (seasonsContainer.querySelectorAll('.season-item').length === 0) {
                            noSeasonsMsg.style.display = 'block';
                        }
                    }
                }
            }

            // Toggle Season Body
            if (target.classList.contains('toggle-season')) {
                const body = target.closest('.season-item').querySelector('.season-body');
                body.classList.toggle('hidden');
                target.querySelector('i').classList.toggle('ki-arrow-up');
                target.querySelector('i').classList.toggle('ki-arrow-down');
            }

            // Add Nationality Exception
            if (target.classList.contains('add-nationality-price')) {
                const seasonIdx = target.getAttribute('data-season-index');
                const container = target.closest('.season-item').querySelector(
                    '.nationality-prices-container');

                // Calculate random/unique index for this row to avoid collision
                const natIdx = Date.now() + Math.floor(Math.random() * 1000);

                let html = natPriceTemplate
                    .replace(/SEASON_INDEX/g, seasonIdx)
                    .replace(/NAT_INDEX/g, natIdx);

                container.insertAdjacentHTML('beforeend', html);

                // Initialize Select2 on all new selects in the container
                const lastRow = container.lastElementChild;
                const newNationalitySelect = lastRow.querySelector('.nationality-select');
                const newPriceTypeSelect = lastRow.querySelector('.price-type-select');

                // Initialize nationality select with AJAX
                if (newNationalitySelect && !$(newNationalitySelect).hasClass('select2-hidden-accessible')) {
                    initNationalitySelect2($(newNationalitySelect));
                }

                // Initialize price type select as basic select2
                if (newPriceTypeSelect && !$(newPriceTypeSelect).hasClass('select2-hidden-accessible')) {
                    $(newPriceTypeSelect).select2({
                        minimumResultsForSearch: Infinity,
                        placeholder: '{{ __('
                        main.select ') }}',
                        allowClear: false
                    });
                }
            }

            // Remove Nationality Exception
            if (target.classList.contains('remove-nationality-price')) {
                target.closest('.nationality-price-row').remove();
            }
        });

        // Update Season Title on Type
        seasonsContainer.addEventListener('input', function(e) {
            if (e.target.classList.contains('season-name-input')) {
                const card = e.target.closest('.season-item');
                card.querySelector('.season-title').textContent = e.target.value || 'New Season';
            }
        });

        // Initialize Tagify on Route Itinerary
        var input = document.querySelector('#route_itinerary');
        if (input) {
            new Tagify(input, {
                maxTags: 20,
                dropdown: {
                    maxItems: 20, // <- mixumum allowed rendered suggestions
                    classname: "tags-look", // <- custom classname for this dropdown, so it could be targeted
                    enabled: 0, // <- show suggestions on focus
                    closeOnSelect: false // <- do not hide the suggestions dropdown once an item has been selected
                }
            });
        }
    });
</script>
@endpush

@push('scripts')
<script>
    // Initialize Select2 for cities with AJAX
    document.addEventListener('DOMContentLoaded', function() {

        // Function to initialize nationality Select2
        function initNationalitySelect2($select) {
            // Destroy any existing select2 instance
            if ($select.data('select2')) {
                $select.select2('destroy');
            }

            $select.select2({
                ajax: {
                    url: '{{ route('
                    routes.nationalities ') }}',
                    type: 'GET',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term,
                            page: params.page || 1
                        };
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.results,
                            pagination: {
                                more: data.pagination.more
                            }
                        };
                    },
                    cache: true
                },
                minimumInputLength: 0,
                placeholder: '{{ __('
                main.search ') }}...',
                allowClear: true,
                language: {
                    inputTooShort: function(args) {
                        return '--';
                    },
                    noResults: function() {
                        return '{{ __('
                        main.no_results_found ') }}';
                    }
                },
                dropdownParent: $select.parent()
            });

            // Load initial nationalities
            $.ajax({
                url: '{{ route('
                routes.nationalities ') }}',
                type: 'GET',
                data: {
                    q: '',
                    page: 1
                },
                dataType: 'json',
                success: function(data) {
                    data.results.forEach(function(nationality) {
                        const option = new Option(nationality.text.trim(), nationality.id);
                        $select.append(option);
                    });
                    $select.trigger('change');
                }
            });
        }

        // Make the function globally accessible
        window.initNationalitySelect2 = initNationalitySelect2;

        const citiesSelects = $('.cities-select');

        citiesSelects.select2({
            ajax: {
                url: '{{ route('
                routes.cities ') }}',
                type: 'GET',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                        page: params.page || 1
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.results,
                        pagination: {
                            more: data.pagination.more
                        }
                    };
                },
                cache: true
            },
            minimumInputLength: 0,
            placeholder: '{{ __('
            main.search ') }}...',
            allowClear: true,
            language: {
                inputTooShort: function(args) {
                    return '--';
                },
                noResults: function() {
                    return '{{ __('
                    main.no_results_found ') }}';
                }
            }
        });

        // Load initial 25 cities
        citiesSelects.each(function() {
            $.ajax({
                url: '{{ route('
                routes.cities ') }}',
                type: 'GET',
                data: {
                    q: '',
                    page: 1
                },
                dataType: 'json',
                success: function(data) {
                    const select = $(this);
                    data.results.forEach(function(city) {
                        const option = new Option(city.text.trim(), city.id);
                        select.append(option);
                    });
                }.bind(this)
            });
        });

        const nationalitySelects = $('.nationality-select');
        nationalitySelects.each(function() {
            initNationalitySelect2($(this));
        });
    });
</script>
@endpush

@push('scripts')
@include('components.scripts.drag-drop-images')
@endpush