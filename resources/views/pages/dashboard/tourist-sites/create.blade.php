@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.tourist-site')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.tourist-site')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.tourist-site')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('tourist-sites.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tourist-sites')]) }}
                </a>
            </div>
        </div>

        @include('components.must-add-first', [
            'requirements' => [
                [
                    'condition' => \App\Models\City::count() > 0,
                    'route' => route('cities.index'),
                    'label' => __('main.cities'),
                ],
            ],
        ])
    </div>

    <div class="kt-container-fixed">
        <form action="{{ route('tourist-sites.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-4 lg:gap-6">
                <!-- Basic Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.tourist-site')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            <!-- name (English) -->
                            <div class="align-self-end">
                                <label for="name" class="kt-label required">{{ __('main.name') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]" required
                                    value="{{ old('name') }}" placeholder="Enter site name">
                            </div>

                            <!-- name_ar (Arabic) -->
                            <div class="align-self-end">
                                <label for="name_ar" class="kt-label">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
                                    value="{{ old('name_ar') }}" placeholder="الاسم بالعربية">
                            </div>

                            <!-- City -->
                            <div>
                                <label for="city_id" class="kt-label required">
                                    {{ __('main.city') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <select name="city_id" id="city_id" class="kt-select cities-select" required>
                                    <option value="" selected>--</option>
                                </select>
                                @error('city_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- site_type -->
                            <div class="align-self-end">
                                <label for="site_type" class="kt-label">{{ __('main.site_type') }}</label>
                                <input type="text" name="site_type" id="site_type" class="kt-input h-[45px]"
                                    value="{{ old('site_type') }}" placeholder="e.g., Museum, Park, Historical Site">
                            </div>

                            <!-- unesco_site -->
                            <div class="align-self-end">
                                <label for="unesco_site" class="kt-label">{{ __('main.unesco_site') }}</label>
                                <select name="unesco_site" id="unesco_site" class="kt-select basic-single">
                                    <option value="">{{ __('main.select_option') }}</option>
                                    <option value="1" {{ old('unesco_site') == 1 ? 'selected' : '' }}>
                                        {{ __('main.yes') }}</option>
                                    <option value="0" {{ old('unesco_site') == 0 ? 'selected' : '' }}>
                                        {{ __('main.no') }}</option>
                                </select>
                            </div>

                            <!-- supplier_type -->
                            <div class="align-self-end">
                                <label for="supplier_type" class="kt-label">{{ __('main.supplier_type') }}</label>
                                <input type="text" name="supplier_type" id="supplier_type" class="kt-input h-[45px]"
                                    value="{{ old('supplier_type') }}" placeholder="e.g., Government, Private, NGO">
                            </div>

                            <!-- sites_theme -->
                            <div class="align-self-end">
                                <label for="sites_theme" class="kt-label">{{ __('main.sites_theme') }}</label>
                                <input type="text" name="sites_theme" id="sites_theme" class="kt-input h-[45px]"
                                    value="{{ old('sites_theme') }}" placeholder="Theme category">
                            </div>

                            <!-- supplier_name -->
                            <div class="align-self-end">
                                <label for="supplier_name" class="kt-label">{{ __('main.supplier_name') }}</label>
                                <input type="text" name="supplier_name" id="supplier_name" class="kt-input h-[45px]"
                                    value="{{ old('supplier_name') }}" placeholder="Supplier name">
                            </div>

                            {{-- sort_order --}}
                            <div class="align-self-end">
                                <label for="sort_order" class="kt-label">{{ __('main.sort_order') }}</label>
                                <input type="number" name="sort_order" id="sort_order" class="kt-input h-[45px]"
                                    value="{{ old('sort_order', 0) }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Location Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.location')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-6">
                            <!-- latitude -->
                            <div class="align-self-end">
                                <label for="latitude" class="kt-label">{{ __('main.latitude') }}</label>
                                <input type="number" step="0.00000001" min="-90" max="90" name="latitude"
                                    id="latitude" class="kt-input h-[45px]" value="{{ old('latitude') }}"
                                    placeholder="-90 to 90">
                            </div>

                            <!-- longitude -->
                            <div class="align-self-end">
                                <label for="longitude" class="kt-label">{{ __('main.longitude') }}</label>
                                <input type="number" step="0.00000001" min="-180" max="180" name="longitude"
                                    id="longitude" class="kt-input h-[45px]" value="{{ old('longitude') }}"
                                    placeholder="-180 to 180">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Media Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.media_resources')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Main Image -->
                            <div>
                                <label for="main_image" class="kt-label">
                                    {{ __('main.main_image') }}
                                </label>
                                <div class="dropzone mt-2 border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-primary transition-colors cursor-pointer"
                                    data-input="main_image">
                                    <i class="far fa-cloud-arrow-up text-5xl text-gray-600"></i>
                                    <p class="mt-4">{{ __('main.click_or_drag_image_here') }}</p>
                                </div>
                                <input type="file" id="main_image" name="main_image" accept="image/*" hidden
                                    required>
                                <div id="preview-main_image" class="hidden flex flex-wrap gap-4 mt-6"></div>
                            </div>

                            <!-- Gallery Images -->
                            <div>
                                <label for="gallery_images" class="kt-label">
                                    {{ __('main.gallery_images') }}
                                </label>
                                <div class="dropzone mt-2 border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-primary transition-colors cursor-pointer"
                                    data-input="gallery_images">
                                    <i class="far fa-cloud-arrow-up text-5xl text-gray-600"></i>
                                    <p class="mt-4">{{ __('main.click_or_drag_image_here_multiple') }}</p>
                                </div>
                                <input type="file" id="gallery_images" name="gallery_images[]" accept="image/*"
                                    hidden multiple required>
                                <div id="preview-gallery_images" class="hidden flex flex-wrap gap-4 mt-6"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description & Details -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.description_details')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 gap-6">
                            <!-- description -->
                            @include('components.elements.input-text-editor', [
                                'column' => 'description',
                                'value' => old('description'),
                            ])

                            <!-- description_01 -->
                            @include('components.elements.input-text-editor', [
                                'column' => 'description_01',
                                'value' => old('description_01'),
                            ])

                            <!-- description_02 -->
                            @include('components.elements.input-text-editor', [
                                'column' => 'description_02',
                                'value' => old('description_02'),
                            ])

                            <!-- description_03 -->
                            @include('components.elements.input-text-editor', [
                                'column' => 'description_03',
                                'value' => old('description_03'),
                            ])

                            <!-- nearby_attractions -->
                            @include('components.elements.input-text-editor', [
                                'column' => 'nearby_attractions',
                                'value' => old('nearby_attractions'),
                            ])
                        </div>
                    </div>
                </div>

                <!-- is_active -->
                <div class="flex items-center gap-3">
                    <input type="hidden" name="is_active" value="0">
                    @include('components.elements.checkbox-button', [
                        'name' => 'is_active',
                        'id' => 'is_active',
                        'value' => '1',
                        'checked' => old('is_active', true),
                        'label' => __('main.is_active'),
                    ])
                </div>

                <!-- Save Submit -->
                @include('components.elements.save-submit', [
                    'models' => 'tourist-sites',
                    'model' => 'tourist-site',
                ])
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    @include('components.scripts.drag-drop-images')

    <script>
        // Initialize Select2 for cities with AJAX
        document.addEventListener('DOMContentLoaded', function() {
            const citiesSelects = $('.cities-select');

            citiesSelects.select2({
                ajax: {
                    url: '{{ route('routes.cities') }}',
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
                placeholder: '{{ __('main.search') }}...',
                allowClear: true,
                language: {
                    inputTooShort: function(args) {
                        return '--';
                    },
                    noResults: function() {
                        return '{{ __('main.no_results_found') }}';
                    }
                }
            });

            // Load initial 25 cities
            citiesSelects.each(function() {
                $.ajax({
                    url: '{{ route('routes.cities') }}',
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
        });
    </script>
@endpush
