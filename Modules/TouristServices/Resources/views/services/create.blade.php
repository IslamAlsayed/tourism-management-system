@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.tourist-service')]))

@push('styles')
    {{-- Force Flatpickr Assets (Fallback) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ asset('assets/plugins/tagify/tagify.css') }}">
@endpush

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.tourist-service')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.tourist-service')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.touristservices.services.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tourist-services')]) }}
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

    <div class="kt-container-fixed">
        <form action="{{ route('dashboard.touristservices.services.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-6 lg:gap-4">
                <!-- 1. Location Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title flex items-center gap-2 text-lg font-bold text-gray-600 dark:text-white">
                            <span
                                class="flex items-center justify-center w-6 h-6 rounded-full bg-primary/10 text-primary text-xs font-bold">1</span>
                            {{ __('main.location') }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4 pb-0">
                        {{-- Regions [country, state, city] --}}
                        @livewire('geography::livewire.regions.location-select-base')
                    </div>
                </div>

                <!-- 2. BASIC INFORMATION & SETTINGS -->
                <div class="kt-card background dark:bg-gray-800 border-custom dark:border-gray-700 shadow-sm rounded-xl">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title flex items-center gap-2 text-lg font-bold text-gray-600 dark:text-white">
                            <span
                                class="flex items-center justify-center w-6 h-6 rounded-full bg-primary/10 text-primary text-xs font-bold">2</span>
                            {{ __('main.basic_info_settings') }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <!-- Identity Row - Names on same line (50% each) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 border-custom-b pb-6">
                            <div>
                                <label class="kt-label font-bold text-sm mb-1 required">
                                    {{ __('main.service_name') }}
                                </label>
                                <input type="text" name="name" class="kt-input h-[42px] font-medium" required
                                    value="{{ old('name') }}" placeholder="e.g. Meet and Assist Airport">
                            </div>
                            <div>
                                <label class="kt-label font-bold text-sm mb-1">
                                    {{ __('main.service_name_ar') }}
                                </label>
                                <input type="text" name="name_ar" class="kt-input h-[42px] font-medium"
                                    value="{{ old('name_ar') }}" placeholder="مثال: خدمة استقبال بالمطار">
                            </div>
                        </div>

                        <!-- Service Type (Hidden) -->
                        <input type="hidden" name="service_type" value="other">

                        <!-- Pricing Configuration - Full Width Row -->
                        <!-- Pricing Configuration - Full Width Row -->
                        <div class="mb-6">
                            <div
                                class="bg-gradient-to-br from-slate-50 to-gray-50 p-4 rounded-xl border-custom shadow-sm transition-all duration-300 hover:shadow-md">
                                <h4
                                    class="flex items-center gap-2 font-bold text-sm uppercase mb-6 text-slate-700 tracking-wide border-custom-b pb-3">
                                    <span class="p-1.5 bg-blue-100 text-blue-600 rounded-md">
                                        <i class="ki-filled ki-setting-2 fs-5"></i>
                                    </span>
                                    {{ __('main.pricing_configuration') }}
                                </h4>

                                <!-- 4 Items in One Row -->
                                <div
                                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 items-end gap-4 mb-4 border-custom-b pb-6">
                                    <!-- Currency -->
                                    @include('components.selects.currency')

                                    <!-- Pricing Unit -->
                                    <div class="relative group">
                                        <label
                                            class="text-xs font-bold text-gray-600 uppercase mb-2 block flex items-center gap-1">
                                            <i class="ki-outline ki-category text-gray-400"></i>
                                            {{ __('main.pricing_unit') }}
                                        </label>
                                        <div class="relative">
                                            <select name="pricing_unit" id="pricing_unit"
                                                class="kt-select w-full h-[45px] background border-custom rounded-lg transition-all font-semibold text-gray-700 shadow-sm pl-3 pr-8">
                                                @foreach ($pricing_units as $unit)
                                                    <option value="{{ $unit->key }}"
                                                        {{ old('pricing_unit') == $unit->key ? 'selected' : '' }}>
                                                        {{ $unit->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Quantity -->
                                    <div class="relative group">
                                        <label
                                            class="text-xs font-bold text-gray-600 uppercase mb-2 block flex items-center gap-1">
                                            <i class="ki-outline ki-calculator text-gray-400"></i>
                                            {{ __('main.qty') }}
                                        </label>
                                        <input type="number" name="pricing_unit_value"
                                            class="kt-input w-full h-[45px] background border-custom rounded-lg transition-all font-bold text-gray-600 shadow-sm"
                                            value="1" min="1">
                                    </div>
                                </div>

                                <!-- Tags (Tagify) -->
                                <div class="col-span-full mb-4">
                                    <label for="tags" class="kt-label">{{ __('main.tags') }}</label>
                                    <input type="text" name="tags" id="tags"
                                        class="kt-input h-fit tagify-container" value="{{ old('tags') }}"
                                        placeholder="Stop 1, Stop 2, ...">
                                    <span class="text-xs text-gray-500 mt-1">{{ __('main.tagify_desc') }}</span>
                                </div>

                                <!-- Align nicely with bottom of inputs -->
                                <div class="flex items-center gap-4">
                                    <input type="hidden" name="is_mandatory" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'is_mandatory',
                                        'id' => 'is_mandatory',
                                        'value' => '1',
                                        'checked' => old('is_mandatory', 1) == 1,
                                        'label' => __('main.is_mandatory'),
                                    ])
                                </div>
                            </div>
                        </div>

                        <!-- Target Modules - Separate Row -->
                        <div class="mb-6">
                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-4 rounded-lg border-custom-1">
                                <div class="flex items-center justify-between mb-3">
                                    <label
                                        class="kt-label font-bold text-sm uppercase text-blue-900 flex items-center gap-2">
                                        <i class="ki-filled ki-element-11 text-blue-600"></i>
                                        {{ __('main.target_modules_context') }}
                                        <span
                                            class="text-xs font-normal normal-case text-blue-600">({{ __('main.select_one_or_more') }})</span>
                                    </label>
                                    <button type="button" id="toggleAllBtn" onclick="toggleAllModules()"
                                        class="kt-btn kt-btn-sm">
                                        <i class="ki-filled ki-check-circle me-1"></i>
                                        <span id="toggleAllText">{{ __('main.select_all') }}</span>
                                    </button>
                                </div>
                                @php
                                    // Define modules just like in Edit page for consistency
                                    $modules = [
                                        'accommodations' => [
                                            'icon' => 'ki-home-2',
                                            'label' => 'Accommodations',
                                            'color' => 'blue',
                                        ],
                                        'transportation' => [
                                            'icon' => 'ki-delivery-2',
                                            'label' => 'Transportation',
                                            'color' => 'green',
                                        ],
                                        'food' => [
                                            'icon' => 'ki-coffee',
                                            'label' => 'Restaurants',
                                            'color' => 'orange',
                                        ],
                                        'tour_guides' => [
                                            'icon' => 'ki-user',
                                            'label' => 'Tour Guides',
                                            'color' => 'purple',
                                        ],
                                        'activities' => [
                                            'icon' => 'ki-rocket',
                                            'label' => 'Activities',
                                            'color' => 'red',
                                        ],
                                        'visa_requirements' => [
                                            'icon' => 'ki-security-user',
                                            'label' => 'Visa Requirements',
                                            'color' => 'indigo',
                                        ],
                                        'travel_passes' => [
                                            'icon' => 'ki-document',
                                            'label' => 'Travel Passes',
                                            'color' => 'teal',
                                        ],
                                        'crossings_ports' => [
                                            'icon' => 'ki-entrance-left',
                                            'label' => 'Crossings & Ports',
                                            'color' => 'gray',
                                        ],
                                        'tours' => ['icon' => 'ki-map', 'label' => 'Tours', 'color' => 'cyan'],
                                        'jeep_safari' => [
                                            'icon' => 'ki-car',
                                            'label' => 'Jeep Safari',
                                            'color' => 'yellow',
                                        ],
                                        'tourist_sites' => [
                                            'icon' => 'ki-flag',
                                            'label' => 'Tourist Sites',
                                            'color' => 'pink',
                                        ],
                                        'airlines' => [
                                            'icon' => 'ki-airplane',
                                            'label' => 'Airlines',
                                            'color' => 'sky',
                                        ],
                                        'quotation' => [
                                            'icon' => 'ki-bill',
                                            'label' => 'Quotation',
                                            'color' => 'emerald',
                                        ],
                                    ];
                                @endphp
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2" id="modules_container">
                                    @foreach ($modules ?? [] as $key => $module)
                                        <label class="module-toggle cursor-pointer">
                                            <input type="checkbox" name="target_modules[]" value="{{ $key }}"
                                                class="module-checkbox sr-only" onchange="toggleModuleVisual(this)">
                                            <div
                                                class="module-btn flex items-center gap-2 p-2 rounded-lg border-custom-1 transition-all duration-200 background text-gray-700 hover:shadow-md peer-checked:bg-blue-600 peer-checked:text-white peer-checked:shadow-lg peer-checked:scale-105 shadow-sm">
                                                <i
                                                    class="ki-filled {{ $module['icon'] }} text-lg text-gray-600 peer-checked:text-white"></i>
                                                <span class="text-xs font-bold">{{ $module['label'] }}</span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>

                            </div>
                        </div>

                        <!-- Pricing Mode Selection - Distinct Cards -->
                        <div class="mb-6">
                            <label
                                class="kt-label font-bold text-sm mb-3 block text-gray-700 uppercase tracking-wide">{{ __('main.pricing_model') }}
                                <span class="text-red-600">*</span></label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Option 1: Flat Rate -->
                                <label id="label_flat" class="relative cursor-pointer group">
                                    <input type="radio" name="pricing_type" value="flat" class="peer sr-only"
                                        checked onchange="togglePricingMode('flat')">
                                    <div
                                        class="p-5 rounded-xl border-custom-1 background transition-all h-full flex flex-col items-center text-center">
                                        <div
                                            class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mb-3 transition-colors">
                                            <i class="ki-filled ki-dollar fs-2"></i>
                                        </div>
                                        <h4
                                            class="font-bold text-lg text-gray-600 mb-1 group-hover:text-blue-600 transition-colors">
                                            {{ __('main.flat_rate') }}</h4>
                                        <p class="text-xs text-gray-600 leading-relaxed">
                                            {{ __('main.flat_rate_desc') }}
                                        </p>
                                        <div class="mt-4 opacity-0 transition-opacity">
                                            <span
                                                class="inline-flex items-center gap-1 text-xs font-bold text-blue-700 bg-blue-100 px-2 py-1 rounded">
                                                <i class="ki-filled ki-check fs-4"></i>
                                                {{ __('main.selected') }}
                                            </span>
                                        </div>
                                    </div>
                                </label>

                                <!-- Option 2: Seasonal Pricing -->
                                <label id="label_seasonal" class="relative cursor-pointer group">
                                    <input type="radio" name="pricing_type" value="seasonal" class="peer sr-only"
                                        onchange="togglePricingMode('seasonal')">
                                    <div
                                        class="p-5 rounded-xl border-custom-1 background transition-all h-full flex flex-col items-center text-center">
                                        <div
                                            class="w-12 h-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center mb-3 transition-colors">
                                            <i class="ki-filled ki-calendar fs-2"></i>
                                        </div>
                                        <h4
                                            class="font-bold text-lg text-gray-600 mb-1 group-hover:text-green-600 transition-colors">
                                            {{ __('main.seasonal_pricing') }}</h4>
                                        <p class="text-xs text-gray-600 leading-relaxed">
                                            {{ __('main.seasonal_pricing_desc') }}
                                        </p>
                                        <div class="mt-4 opacity-0 transition-opacity">
                                            <span
                                                class="inline-flex items-center gap-1 text-xs font-bold text-green-700 bg-green-100 px-2 py-1 rounded">
                                                <i class="ki-filled ki-check fs-4"></i>
                                                {{ __('main.selected') }}
                                            </span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Flat Date Range (Only visible if Flat) -->
                        <div id="flat_pricing_container" class="p-4 bg-gray-50 rounded-lg border-custom border-dashed">
                            <h4 class="font-bold text-gray-700 text-sm mb-3">{{ __('main.validity_period_optional') }}
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="text-xs font-bold text-gray-600 mb-1 block">{{ __('main.effective_from') }}</label>
                                    <input type="date" name="flat_start_date" class="kt-input h-[40px]"
                                        placeholder="YYYY/MM/DD">
                                </div>
                                <div>
                                    <label
                                        class="text-xs font-bold text-gray-600 mb-1 block">{{ __('main.effective_until') }}</label>
                                    <input type="date" name="flat_end_date" class="kt-input h-[40px]"
                                        placeholder="YYYY/MM/DD">
                                </div>
                            </div>
                        </div>

                        <!-- Seasons Container (Only visible if Seasonal) -->
                        <div id="seasonal_pricing_container" class="hidden border-custom rounded-lg p-4 bg-gray-50/50">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h4 class="font-bold text-gray-700 text-sm uppercase tracking-wide">
                                        {{ __('main.service_seasons') }}</h4>
                                    <p class="text-xs text-gray-600 mt-1">Define your seasons here (e.g., Winter 2024,
                                        Summer 2025). Prices will be grouped by season name.</p>
                                </div>
                                <button type="button" onclick="addSeasonRow()" class="kt-btn kt-btn-sm kt-btn-primary">
                                    + {{ __('main.add_season') }}
                                </button>
                            </div>

                            <div id="seasons_container" class="space-y-6">
                                <div class="text-gray-400 italic text-sm text-center" id="no_seasons_msg">
                                    {{ __('main.no_seasons_added') }}
                                </div>
                                <!-- Groups will be injected here -->
                            </div>
                            <div class="mt-4">
                                <button type="button" onclick="addSeasonGroup()"
                                    class="kt-btn kt-btn-sm kt-btn-primary">
                                    <i class="ki-outline ki-plus fs-3"></i> {{ __('main.add_season_group') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. PRICING ENGINE -->
                <div class="kt-card background border-custom shadow-sm rounded-xl" id="pricing_engine_container">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title flex items-center gap-2 text-lg font-bold text-gray-600 dark:text-white">
                            <span
                                class="flex items-center justify-center w-6 h-6 rounded-full bg-green-100 text-green-600 text-xs font-bold">3</span>
                            {{ __('main.pricing_engine') }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <!-- Helper Text -->
                        <div class="mb-4 text-sm text-gray-600">
                            {{ __('main.pricing_engine_desc') }}
                        </div>

                        <!-- PRICING TABLES CONTAINER -->
                        <div id="generated_pricing_tables" class="space-y-6">

                            {{-- Standard/Flat Rate Table (Always visible for flat_rate mode) --}}
                            <div id="flat_rate_table_container">
                                @include('touristservices::services.services.pricing-table', [
                                    'prefix' => 'seasonal_prices[Standard]',
                                    'seasonName' => 'Standard',
                                    'isStandard' => true,
                                    'nationalities' => $nationalities ?? collect(),
                                    'subregions' => $subregions ?? collect(),
                                ])
                            </div>

                            {{-- Seasonal Tables Container (Hidden by default, shown when seasonal mode) --}}
                            <div id="seasonal_tables_container" class="hidden space-y-6">
                                {{-- JavaScript will clone and add tables here based on season names --}}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. TAXES & FEES -->
                <div class="kt-card background border-custom shadow-sm rounded-xl">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title flex items-center gap-2 text-lg font-bold text-gray-600 dark:text-white">
                            <span
                                class="flex items-center justify-center w-6 h-6 rounded-full bg-primary/10 text-primary text-xs font-bold">4</span>
                            {{ __('main.taxes_fees') }}
                            <span class="text-xs text-gray-400 font-normal">({{ __('main.optional') }})</span>
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <!-- Tax Explanation -->
                        <div class="mb-4 p-3 bg-amber-50 rounded-lg border border-amber-200">
                            <p class="text-sm text-amber-800"><i class="ki-filled ki-information-2 me-1"></i>
                                {{ __('main.taxes_explanation') }}</p>
                        </div>

                        <div class="flex items-center gap-4 mb-6">
                            <label class="font-medium text-gray-700">{{ __('main.price_includes_tax') }}?</label>
                            <div class="flex items-center gap-4">

                                <div class="flex items-center gap-4">
                                    <input type="hidden" name="is_tax_inclusive" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'type' => 'radio',
                                        'name' => 'is_tax_inclusive',
                                        'id' => 'yes_inclusive',
                                        'value' => '1',
                                        'checked' => old('is_tax_inclusive', 1) == 1,
                                        'label' => __('main.yes_inclusive'),
                                        'customize' => 'onclick="toggleTaxRows(false)"',
                                    ])
                                </div>

                                <div class="flex items-center gap-4">
                                    <input type="hidden" name="is_tax_inclusive" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'type' => 'radio',
                                        'name' => 'is_tax_inclusive',
                                        'id' => 'no_exclusive',
                                        'value' => '0',
                                        'checked' => old('is_tax_inclusive', 0) == 1,
                                        'label' => __('main.no_exclusive'),
                                        'customize' => 'onclick="toggleTaxRows(true)"',
                                    ])
                                </div>
                            </div>
                        </div>

                        <div id="taxes_wrapper" class="hidden border rounded-lg p-4 bg-red-50/10">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="font-bold text-gray-700 text-sm uppercase">
                                    {{ __('main.applicable_taxes') }}</h4>
                                <button type="button" onclick="addTaxRow()" class="kt-btn kt-btn-sm text-white">
                                    + {{ __('main.add_tax') }}
                                </button>
                            </div>

                            <div id="taxes_container" class="space-y-3">
                                <!-- Dynamic Tax Rows -->
                            </div>
                            <small class="text-gray-400 block mt-2">{{ __('main.taxes_desc') }}</small>
                        </div>
                    </div>
                </div>

                <!-- 6. MEDIA & DESCRIPTION -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.media')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="photo" class="kt-label">
                                    {{ __('main.photo') }}
                                </label>
                                <div class="dropzone mt-2 border-2 border-dashed border-gray-200 rounded-lg p-4 text-center hover:border-primary transition-colors cursor-pointer"
                                    data-input="photo">
                                    <i class="far fa-cloud-arrow-up text-5xl text-gray-600"></i>
                                    <p class="mt-4">{{ __('main.click_or_drag_image_here') }}</p>
                                </div>
                                <input type="file" id="photo" name="photo" accept="image/*" hidden>
                                <div id="preview-photo" class="hidden flex flex-wrap gap-4 mt-6"></div>
                            </div>
                            <div>
                                <label for="gallery" class="kt-label">
                                    {{ __('main.gallery') }}
                                </label>
                                <div class="dropzone mt-2 border-2 border-dashed border-gray-200 rounded-lg p-4 text-center hover:border-primary transition-colors cursor-pointer"
                                    data-input="gallery">
                                    <i class="far fa-cloud-arrow-up text-5xl text-gray-600"></i>
                                    <p class="mt-4">{{ __('main.click_or_drag_image_here_multiple') }}</p>
                                </div>
                                <input type="file" id="gallery" name="gallery[]" accept="image/*" hidden multiple>
                                <div id="preview-gallery" class="hidden flex flex-wrap gap-4 mt-6"></div>
                            </div>
                            <div>
                                <label for="video_url" class="kt-label">{{ __('main.video_url') }}</label>
                                <input type="url" name="video_url" id="video_url" class="kt-input h-[45px]"
                                    value="{{ old('video_url') }}" placeholder="https://youtube.com/...">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                @include('components.elements.input-text-editor', [
                    'column' => 'description',
                    'value' => old('description'),
                ])

                <!-- Notes -->
                @include('components.elements.input-text-editor', [
                    'column' => 'notes',
                    'value' => old('notes'),
                ])

                <x-custom-fields module-name="tourists" entity-type="TouristService" />

                <!-- is_active -->
                <div class="flex items-center gap-4">
                    <input type="hidden" name="is_active" value="0">
                    @include('components.elements.checkbox-button', [
                        'name' => 'is_active',
                        'id' => 'is_active',
                        'value' => '1',
                        'checked' => old('is_active', 1),
                        'label' => __('main.is_active'),
                    ])
                </div>

                <!-- Save Submit -->
                @include('components.elements.save-submit', [
                    'models' => 'dashboard.touristservices.services',
                    'model' => 'service',
                ])
            </div>
        </form>
    </div>

    @include('touristservices::services.services.pricing-logic')
    @include('touristservices::services.services.pricing-scripts')
@endsection

@push('scripts')
    @include('components.scripts.drag-drop-images')

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ asset('assets/plugins/tagify/tagify.js') }}"></script>

    <script>
        // Initialize Tagify on Route Itinerary
        var inputs = document.querySelectorAll('.tagify-container');
        if (inputs) {
            inputs.forEach(input => {
                new Tagify(input, {
                    maxTags: 20,
                    dropdown: {
                        maxItems: 20, // <- mixumum allowed rendered suggestions
                        classname: "tags-look", // <- custom classname for this dropdown, so it could be targeted
                        enabled: 0, // <- show suggestions on focus
                        closeOnSelect: false // <- do not hide the suggestions dropdown once an item has been selected
                    }
                });
            });
        }

        // Use a simple global counter for dynamic IDs
        let seasonCount = 1;
        let taxCount = 0;

        // Map currency IDs to Codes/Symbols (generated from server-side data)
        const currencyMap = {
            @foreach ($currencies as $currency)
                    '{{ $currency->id }}': '{{ $currency->code }}', @endforeach
        };

        // Expose helper to get current currency code/symbol safely
        // Expose helper to get current currency code/symbol safely
        window.getCurrentCurrencySymbol = function() {
            const select = document.getElementById('currency_id');
            if (!select) return '$';
            // Prefer the map if available, fallback to first word of text (e.g. "USD" from "USD - US Dollar")
            return currencyMap[select.value] || select.options[select.selectedIndex]?.text.split(' ')[0] || '$';
        };

        let groupIndex = 0;

        function addSeasonGroup() {
            const container = document.getElementById('seasons_container');
            const noMsg = document.getElementById('no_seasons_msg');
            if (noMsg) noMsg.style.display = 'none';

            const groupId = groupIndex++;
            const html = `
                    <div class="season-group border-custom rounded-lg p-4 bg-gray-50 relative mb-6" data-group-id="${groupId}">
                        <div class="flex justify-end mb-2">
                            <button type="button" onclick="window.manualRemoveSeason(this)" class="kt-btn kt-btn-sm kt-btn-light kt-btn-destructive flex items-center gap-2 remove-season-btn">
                                <i class="ki-outline ki-trash fs-5"></i>
                                {{ __('main.remove_season') }}
                            </button>
                        </div>
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                            <!-- Left Column: Season Name (1/3) -->
                            <div class="relative lg:col-span-1">
                                <label class="text-sm font-bold text-gray-700 mb-2 block">{{ __('main.season_name') }}</label>
                                <input type="text" name="season_groups[${groupId}][name]" 
                                       class="kt-input h-[45px] font-medium season-name-input w-full" 
                                       placeholder="e.g. High Season" 
                                       oninput="updateSeasonalPricingTables()">
                                <small class="text-gray-400 mt-1 block">{{ __('main.season_name_desc') }}</small>
                            </div>
                            
                            <!-- Right Column: Date Ranges (2/3) -->
                            <div class="ranges-container background rounded-lg border-custom p-4 lg:col-span-2">
                                 <div class="flex items-center justify-between mb-3">
                                    <label class="text-xs font-bold text-gray-600 uppercase flex items-center gap-1">
                                        <i class="ki-outline ki-calendar fs-4"></i>
                                        {{ __('main.date_ranges') }}
                                    </label>
                                     <button type="button" onclick="addRangeToGroup(this, ${groupId})" class="text-xs text-blue-600 hover:text-blue-800 font-bold background hover:bg-blue-100 py-1 px-2 rounded transition">
                                        <i class="ki-outline ki-plus fs-5"></i> {{ __('main.add') }}
                                    </button>
                                 </div>
                                 <div class="ranges-list flex flex-col gap-2">
                                    <!-- Ranges go here -->
                                 </div>
                            </div>
                        </div>
                    </div>
                `;
            container.insertAdjacentHTML('beforeend', html);

            // Add initial range
            const newGroup = container.lastElementChild;
            addRangeToGroup(newGroup.querySelector('button[onclick^="addRangeToGroup"]'), groupId);
        }



        function addRangeToGroup(btn, groupId) {
            const container = btn.closest('.ranges-container');
            const list = container.querySelector('.ranges-list');
            const rangeId = Date.now() + Math.floor(Math.random() * 1000); // Unique ID for keying

            const html = `
                    <div class="flex flex-col md:flex-row items-center gap-2 range-row bg-gray-50 p-2 rounded border-custom group transition">
                        <div class="flex-1 w-full md:w-auto flex items-center gap-2">
                                <div class="flex items-center w-full gap-2">
                                    <div class="h-[35px] px-3 bg-gray-50 border border-r-0 border-gray-300 rounded-l flex items-center justify-center">
                                        <i class="ki-outline ki-calendar text-blue-500 text-lg"></i>
                                    </div>
                                    <input type="text" name="season_groups[${groupId}][ranges][${rangeId}][start]" 
                                           class="kt-input h-[35px] text-sm season-start-date w-full pluck-calendar background rounded-l-none" 
                                           required
                                           placeholder="YYYY-MM-DD"
                                           onchange="validateSeasonDates(this)">
                                </div>
                            </div>
                            <span class="text-gray-400 font-bold hidden md:inline">→</span>
                            <span class="text-gray-400 font-bold md:hidden">↓</span>
                            <div class="relative flex-1 w-full md:w-auto">
                                <div class="flex items-center w-full gap-2">
                                    <div class="h-[35px] px-3 bg-gray-50 border border-r-0 border-gray-300 rounded-l flex items-center justify-center">
                                        <i class="ki-outline ki-calendar text-blue-500 text-lg"></i>
                                    </div>
                                    <input type="text" name="season_groups[${groupId}][ranges][${rangeId}][end]" 
                                           class="kt-input h-[35px] text-sm season-end-date w-full pluck-calendar background rounded-l-none" 
                                           required
                                           placeholder="YYYY-MM-DD"
                                       onchange="validateSeasonDates(this)">
                            </div>
                        </div>
                        <button type="button" onclick="removeRangeRow(this)" class="text-gray-400 hover:text-red-600 p-1 rounded-full hover:bg-red-50 transition self-end md:self-center" title="{{ __('main.delete') }}">
                            <i class="ki-outline ki-trash fs-3"></i>
                        </button>
                    </div>
                `;
            list.insertAdjacentHTML('beforeend', html);

            // Re-initialize Flatpickr for the new range inputs
            if (typeof window.initializeFlatpickrForSeasons === 'function') {
                window.initializeFlatpickrForSeasons();
            } else if (typeof initializeFlatpickrForSeasons === 'function') {
                initializeFlatpickrForSeasons();
            }
        }



        function removeRangeRow(btn) {
            const list = btn.closest('.ranges-list');
            btn.closest('.range-row').remove();
            if (list.children.length === 0) {
                // Optionally remove group or warn? Let's leave empty group for now or auto-remove
            }
        }

        function manualRemoveSeason(btn) {
            const seasonGroup = btn.closest('.season-group');
            if (seasonGroup) {
                seasonGroup.remove();
                updateSeasonalPricingTables();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const currencySelect = document.getElementById('currency_id');
            if (currencySelect) {
                currencySelect.addEventListener('change', function() {
                    const symbol = window.getCurrentCurrencySymbol();
                    updateCurrencySymbols(symbol);

                    // Also trigger update in pricing logic (for tables)
                    if (typeof window.updateCurrencySymbolsInTables === 'function') {
                        window.updateCurrencySymbolsInTables(symbol);
                    }
                });

                // Trigger initial update to set correct symbols on load
                const initialSymbol = window.getCurrentCurrencySymbol();
                updateCurrencySymbols(initialSymbol);

                // Initial update for tables too
                if (typeof window.updateCurrencySymbolsInTables === 'function') {
                    window.updateCurrencySymbolsInTables(initialSymbol);
                }
            }
        });

        function updateCurrencySymbols(symbol) {
            // Update all elements with .currency-symbol class
            document.querySelectorAll('.currency-symbol').forEach(el => {
                el.textContent = symbol;
            });

            // Also update any inputs/elements that might use data-currency-symbol attribute
            // or specific IDs if needed.
        }

        function addSeasonRow() {
            const container = document.getElementById('seasons_container');
            const index = seasonCount++;
            const html = `
                <div class="flex flex-row gap-4 items-end season-row background mb-4 p-4 rounded border-custom shadow-sm relative">
                    <div class="flex-1 min-w-0">
                        <label class="text-sm font-bold text-gray-700 mb-2 block">{{ __('main.season_name') }}</label>
                        <input type="text" name="service_seasons[${index}][name]" class="kt-input h-[45px] font-medium season-name-input w-full" placeholder="e.g. Winter" oninput="updateSeasonalPricingTables()">
                    </div>
                    <div class="w-1/4 min-w-[150px]">
                        <label class="text-sm font-bold text-gray-700 mb-2 block">{{ __('main.start_date') }}</label>
                        <input type="date" name="service_seasons[${index}][start]" class="kt-input h-[45px] season-start-date w-full" onchange="validateSeasonDates(this)" placeholder="YYYY/MM/DD">
                    </div>
                    <div class="w-1/4 min-w-[150px]">
                        <label class="text-sm font-bold text-gray-700 mb-2 block">{{ __('main.end_date') }}</label>
                        <input type="date" name="service_seasons[${index}][end]" class="kt-input h-[45px] season-end-date w-full" onchange="validateSeasonDates(this)" placeholder="YYYY/MM/DD">
                    </div>
                    <div class="w-[50px] pb-1">
                        <button type="button" onclick="removeSeasonRow(this)" class="w-full h-[45px] flex items-center justify-center cursor-pointer text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 rounded-md transition" title="{{ __('main.remove') }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);

            /// Re-initialize Flatpickr for all rows (including the new one)
            if (typeof initializeFlatpickrForSeasons === 'function') {
                initializeFlatpickrForSeasons();
            } else {
                updateAllSeasonDateRestrictions();
            }
        }

        function removeSeasonRow(btn) {
            btn.closest('.season-row').remove();
        }

        function toggleTaxRows(show) {
            const wrapper = document.getElementById('taxes_wrapper');
            if (show) {
                wrapper.classList.remove('hidden');
                if (document.getElementById('taxes_container').children.length === 0) {
                    addTaxRow(); // Add first row if empty
                }
            } else {
                wrapper.classList.add('hidden');
            }
        }

        function updateTaxSymbol(select) {
            const row = select.closest('.tax-row');
            const symbolSpan = row.querySelector('.tax-symbol');
            const currentCurrency = window.getCurrentCurrencySymbol();

            if (select.value === 'percentage') {
                symbolSpan.textContent = '%';
                symbolSpan.classList.add('right-8'); // Move to right
                symbolSpan.classList.remove('left-2', 'currency-symbol'); // Remove currency class to avoid auto-update
            } else {
                symbolSpan.textContent = currentCurrency;
                symbolSpan.classList.remove('right-8');
                symbolSpan.classList.add('left-2', 'currency-symbol'); // Add currency class for auto-updates
            }
        }

        function addTaxRow() {
            const container = document.getElementById('taxes_container');
            const index = taxCount++;
            // Get current currency
            const currentCurrency = window.getCurrentCurrencySymbol();

            const html = `
                <div class="flex flex-row gap-2 items-end tax-row relative background p-3 rounded border border-dashed border-red-200">
                    <!-- Name -->
                    <div class="flex-1 min-w-0">
                        <label class="text-xs font-bold text-gray-600 mb-1 block">{{ __('main.name') }}</label>
                        <input type="text" name="tax_configuration[${index}][name]" class="kt-input h-9 w-full" placeholder="e.g. VAT">
                    </div>
                    <!-- Type -->
                    <div class="w-1/4 min-w-[120px]">
                        <label class="text-xs font-bold text-gray-600 mb-1 block">{{ __('main.type') }}</label>
                        <select name="tax_configuration[${index}][type]" class="kt-select h-9 py-1 text-sm bg-gray-50 w-full" onchange="updateTaxSymbol(this)">
                            <option value="percentage">Percentage (%)</option>
                            <option value="fixed">Fixed Amount</option>
                        </select>
                    </div>
                    <!-- Value + Delete -->
                    <div class="w-1/3 min-w-[150px] flex items-center gap-2">
                         <div class="relative w-full">
                            <label class="text-xs font-bold text-gray-600 mb-1 block">{{ __('main.value') }}</label>
                            <div class="relative w-full">
                                <input type="number" step="0.01" name="tax_configuration[${index}][value]" class="kt-input h-9 w-full pe-8 font-bold text-gray-700" placeholder="0">
                                <span class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 font-bold text-xs tax-symbol">%</span>
                            </div>
                        </div>
                        <button type="button" onclick="removeTaxRow(this)" class="mt-5 text-red-600 cursor-pointer hover:text-red-700 p-1.5 hover:bg-red-50 rounded transition" title="{{ __('main.delete') }}" toggle-button>
                             <i class="ki-outline ki-trash fs-2"></i>
                        </button>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        }

        function removeTaxRow(btn) {
            btn.closest('.tax-row').remove();
        }

        // === COMMISSION FUNCTIONS ===
        let commissionCount = 0;

        function toggleCommissionRows(show) {
            const wrapper = document.getElementById('commission_wrapper');
            if (show) {
                wrapper.classList.remove('hidden');
                if (document.getElementById('commission_container').children.length === 0) {
                    addCommissionRow(); // Add first row if empty
                }
            } else {
                wrapper.classList.add('hidden');
            }
        }

        function updateCommissionSymbol(select) {
            const row = select.closest('.commission-row');
            const symbolSpan = row.querySelector('.commission-symbol');
            const currentCurrency = window.getCurrentCurrencySymbol();

            if (select.value === 'percentage') {
                symbolSpan.textContent = '%';
                symbolSpan.classList.remove('currency-symbol');
            } else {
                symbolSpan.textContent = currentCurrency;
                symbolSpan.classList.add('currency-symbol');
            }
        }

        function addCommissionRow() {
            const container = document.getElementById('commission_container');
            const index = commissionCount++;
            // Get current currency
            const currentCurrency = window.getCurrentCurrencySymbol();

            const html = `
                <div class="flex flex-row gap-2 items-end commission-row relative background p-3 rounded border border-dashed border-green-200">
                    <!-- Name (Flex 1) -->
                    <div class="flex-1 min-w-0">
                        <label class="text-xs font-bold text-gray-600 mb-1 block">{{ __('main.name') }}</label>
                        <input type="text" name="commission_configuration[${index}][name]" class="kt-input h-9 w-full" placeholder="e.g. Agent Commission">
                    </div>
                    <!-- Applies To (W-1/4) -->
                    <div class="w-1/4 min-w-[140px]">
                        <label class="text-xs font-bold text-gray-600 mb-1 block">{{ __('main.applies_to') }}</label>
                        <select name="commission_configuration[${index}][applies_to]" class="kt-select h-9 py-1 text-sm bg-gray-50 w-full">
                            <option value="all">{{ __('main.all_nationalities') }}</option>
                            <option value="foreigner">{{ __('main.foreigner') }}</option>
                            <option value="arab">{{ __('main.arab') }}</option>
                            <option value="resident">{{ __('main.resident') }}</option>
                        </select>
                    </div>
                    <!-- Type (W-1/6) -->
                    <div class="w-1/6 min-w-[120px]">
                        <label class="text-xs font-bold text-gray-600 mb-1 block">{{ __('main.type') }}</label>
                        <select name="commission_configuration[${index}][type]" class="kt-select h-9 py-1 text-sm bg-gray-50 w-full" onchange="updateCommissionSymbol(this)">
                            <option value="percentage">{{ __('main.percentage') }} (%)</option>
                            <option value="fixed">{{ __('main.fixed_amount') }}</option>
                        </select>
                    </div>
                    <!-- Value + Delete (W-1/6) -->
                    <div class="w-1/6 min-w-[120px] flex items-center gap-2">
                        <div class="relative w-full">
                            <label class="text-xs font-bold text-gray-600 mb-1 block">{{ __('main.value') }}</label>
                            <div class="relative w-full">
                                <input type="number" step="0.01" name="commission_configuration[${index}][value]" class="kt-input h-9 w-full pe-8 text-center font-bold text-gray-700" placeholder="0">
                                <span class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 font-bold text-xs commission-symbol pointer-events-none">%</span>
                            </div>
                        </div>
                        <button type="button" onclick="removeCommissionRow(this)" class="mt-5 text-red-600 hover:text-red-700 p-1.5 hover:bg-red-50 rounded transition" title="{{ __('main.delete') }}">
                            <i class="ki-outline ki-trash fs-2"></i>
                        </button>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        }

        function removeCommissionRow(btn) {
            btn.closest('.commission-row').remove();
        }



        // Module Toggle Functions
        // Module Toggle Functions
        function toggleModuleVisual(input) {
            const visualDiv = input.nextElementSibling;
            if (!visualDiv || !visualDiv.classList.contains('module-btn')) return;

            const icon = visualDiv.querySelector('i');

            if (input.checked) {
                visualDiv.classList.remove('border-gray-300', 'background', 'text-gray-700');
                visualDiv.classList.add('border-blue-600', 'bg-blue-600', 'text-white', 'shadow-lg', 'scale-105');
                if (icon) {
                    icon.classList.remove('text-gray-600');
                    icon.classList.add('text-white');
                }
            } else {
                visualDiv.classList.add('border-gray-300', 'background', 'text-gray-700');
                visualDiv.classList.remove('border-blue-600', 'bg-blue-600', 'text-white', 'shadow-lg', 'scale-105');
                if (icon) {
                    icon.classList.add('text-gray-600');
                    icon.classList.remove('text-white');
                }
            }
            updateToggleAllButton();
        }

        function toggleAllModules() {
            const checkboxes = document.querySelectorAll('#modules_container .module-checkbox');
            const allChecked = Array.from(checkboxes).every(c => c.checked);
            const newState = !allChecked;

            checkboxes.forEach(cb => {
                cb.checked = newState;
                toggleModuleVisual(cb);
            });
        }

        function updateToggleAllButton() {
            const checkboxes = document.querySelectorAll('#modules_container .module-checkbox');
            const allChecked = Array.from(checkboxes).length > 0 && Array.from(checkboxes).every(c => c.checked);

            const toggleText = document.getElementById('toggleAllText') || document.getElementById('toggle_all_text');
            if (toggleText) {
                toggleText.textContent = allChecked ? 'Deselect All' : 'Select All';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('#modules_container .module-checkbox').forEach(cb => toggleModuleVisual(
                cb));

            // Initialize Pricing Logic
            const currentType = document.querySelector('input[name="pricing_type"]:checked')?.value || 'flat';
            togglePricingMode(currentType);

            // Initialize Flatpickr Logic (Defined in pricing-logic.blade.php)
            if (typeof window.initializeFlatpickrForFlatRate === 'function') {
                window.initializeFlatpickrForFlatRate();
            }
            if (typeof window.initializeFlatpickrForSeasons === 'function') {
                window.initializeFlatpickrForSeasons();
            }
        });

        // === PRICING TOGGLE FUNCTIONS ===
        function togglePricingMode(mode) {
            // Update Visuals
            updatePricingModelVisuals(mode);

            // Trigger Logic
            if (typeof handlePricingTypeChange === 'function') {
                handlePricingTypeChange(mode);
            }
        }

        function updatePricingModelVisuals(selectedMode) {
            const labelFlat = document.getElementById('label_flat');
            const labelSeasonal = document.getElementById('label_seasonal');
            if (!labelFlat || !labelSeasonal) return;

            // Classes for Active State (Enhanced Colors)
            const blueActive = ['border-blue-600', 'bg-blue-100', 'shadow-md'];
            const blueInactive = ['border-gray-200', 'background'];
            const greenActive = ['border-green-600', 'bg-green-100', 'shadow-md'];
            const greenInactive = ['border-gray-200', 'background'];

            // Reset Flat
            const flatDiv = labelFlat.querySelector('div');
            const seasonalDiv = labelSeasonal.querySelector('div');

            if (selectedMode === 'flat') {
                // Activate Flat
                flatDiv.classList.remove(...blueInactive);
                flatDiv.classList.add(...blueActive);
                // Deactivate Seasonal
                seasonalDiv.classList.remove(...greenActive);
                seasonalDiv.classList.add(...greenInactive);

                // Toggle Check Icons
                flatDiv.querySelector('.opacity-0')?.classList.remove('opacity-0');
                seasonalDiv.querySelector('.opacity-100')?.classList.remove('opacity-100');
                seasonalDiv.querySelector('.mt-4').classList.add('opacity-0');

                // Show Flat Table, Hide Seasonal Tables
                document.getElementById('flat_rate_table_container').classList.remove('hidden');
                document.getElementById('seasonal_tables_container').classList.add('hidden');

            } else {
                // Activate Seasonal
                seasonalDiv.classList.remove(...greenInactive);
                seasonalDiv.classList.add(...greenActive);
                // Deactivate Flat
                flatDiv.classList.remove(...blueActive);
                flatDiv.classList.add(...blueInactive);

                // Toggle Check Icons
                seasonalDiv.querySelector('.opacity-0')?.classList.remove('opacity-0');
                flatDiv.querySelector('.opacity-100')?.classList.remove('opacity-100');
                flatDiv.querySelector('.mt-4').classList.add('opacity-0');

                // Show Seasonal Tables, Hide Flat Table
                document.getElementById('flat_rate_table_container').classList.add('hidden');
                document.getElementById('seasonal_tables_container').classList.remove('hidden');
            }
        }
    </script>
@endpush
