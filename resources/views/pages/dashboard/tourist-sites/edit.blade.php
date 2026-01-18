@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.tourist-site')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.tourist-site')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.tourist-site')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('tourist-sites.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tourist-sites')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <form action="{{ route('tourist-sites.update', $touristSite->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
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
                                <label for="name" class="kt-label">{{ __('main.name') }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]"
                                    value="{{ $touristSite->name }}">
                            </div>

                            <!-- name_ar (Arabic) -->
                            <div class="align-self-end">
                                <label for="name_ar" class="kt-label">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
                                    value="{{ $touristSite->name_ar }}">
                            </div>

                            <!-- City -->
                            <div>
                                <label for="city_id" class="kt-label">{{ __('main.city') }}</label>
                                <select name="city_id" id="city_id" class="kt-select cities-select"
                                    data-value="{{ $touristSite->city_id }}">
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
                                    value="{{ $touristSite->site_type }}">
                            </div>

                            <!-- unesco_site -->
                            <div class="align-self-end">
                                <label for="unesco_site" class="kt-label">{{ __('main.unesco_site') }}</label>
                                <select name="unesco_site" id="unesco_site" class="kt-select basic-single">
                                    <option value="">{{ __('main.select_option') }}</option>
                                    <option value="1" {{ $touristSite->unesco_site == 1 ? 'selected' : '' }}>
                                        {{ __('main.yes') }}</option>
                                    <option value="0" {{ $touristSite->unesco_site == 0 ? 'selected' : '' }}>
                                        {{ __('main.no') }}</option>
                                </select>
                            </div>

                            <!-- supplier_type -->
                            <div class="align-self-end">
                                <label for="supplier_type" class="kt-label">{{ __('main.supplier_type') }}</label>
                                <input type="text" name="supplier_type" id="supplier_type" class="kt-input h-[45px]"
                                    value="{{ $touristSite->supplier_type }}">
                            </div>

                            <!-- sites_theme -->
                            <div class="align-self-end">
                                <label for="sites_theme" class="kt-label">{{ __('main.sites_theme') }}</label>
                                <input type="text" name="sites_theme" id="sites_theme" class="kt-input h-[45px]"
                                    value="{{ $touristSite->sites_theme }}">
                            </div>

                            <!-- supplier_name -->
                            <div class="align-self-end">
                                <label for="supplier_name" class="kt-label">{{ __('main.supplier_name') }}</label>
                                <input type="text" name="supplier_name" id="supplier_name" class="kt-input h-[45px]"
                                    value="{{ $touristSite->supplier_name }}">
                            </div>

                            {{-- sort_order --}}
                            <div class="align-self-end">
                                <label for="sort_order" class="kt-label">{{ __('main.sort_order') }}</label>
                                <input type="number" name="sort_order" id="sort_order" class="kt-input h-[45px]"
                                    value="{{ $touristSite->sort_order }}">
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
                                    id="latitude" class="kt-input h-[45px]" value="{{ $touristSite->latitude }}">
                            </div>

                            <!-- longitude -->
                            <div class="align-self-end">
                                <label for="longitude" class="kt-label">{{ __('main.longitude') }}</label>
                                <input type="number" step="0.00000001" min="-180" max="180" name="longitude"
                                    id="longitude" class="kt-input h-[45px]" value="{{ $touristSite->longitude }}">
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
                            {{-- <div>
                                <label for="main_image" class="kt-label">
                                    {{ __('main.main_image') }}
                                </label>
                                <div class="dropzone mt-2 border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-primary transition-colors cursor-pointer"
                                    data-input="main_image">
                                    <i class="far fa-cloud-arrow-up text-5xl text-gray-600"></i>
                                    <p class="mt-2">{{ __('main.click_or_drag_image_here') }}</p>
                                </div>
                                <input type="file" id="main_image" name="main_image" accept="image/*" hidden>
                                <!-- Preview Main Image -->
                                <div id="preview-main_image" class="flex flex-wrap gap-4 mt-6">
                                    @if (Str::isUrl($touristSite->main_image))
                                        <div class="relative inline-block" id="existing_main_image">
                                            <img src="{{ $touristSite->main_image }}" alt="Main Image"
                                                class="h-32 w-32 object-cover rounded-lg shadow-md">
                                            <button type="button" onclick="removeExistingMainImage()"
                                                class="absolute -top-2 -right-2 z-20 bg-danger text-white cursor-pointer rounded-full w-6 h-6 text-center">×</button>
                                        </div>
                                        <input type="hidden" name="remove_main_image" id="remove_main_image"
                                            value="0">
                                    @elseif (Storage::exists($touristSite->main_image))
                                        <div class="relative inline-block" id="existing_main_image">
                                            <img src="{{ asset('storage/' . $touristSite->main_image) }}"
                                                alt="Main Image" class="h-32 w-32 object-cover rounded-lg shadow-md">
                                            <button type="button" onclick="removeExistingMainImage()"
                                                class="absolute -top-2 -right-2 z-20 bg-danger text-white cursor-pointer rounded-full w-6 h-6 text-center">×</button>
                                        </div>
                                        <input type="hidden" name="remove_main_image" id="remove_main_image"
                                            value="0">
                                    @else
                                        <p class="text-sm text-gray-500">{{ __('main.no_image_uploaded') }}</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Gallery Images -->
                            <div>
                                <label for="gallery_images" class="kt-label">
                                    {{ __('main.gallery_images') }}
                                </label>
                                <div class="dropzone mt-2 border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-primary transition-colors cursor-pointer"
                                    data-input="gallery_images">
                                    <i class="far fa-cloud-arrow-up text-5xl text-gray-600"></i>
                                    <p class="mt-2">{{ __('main.click_or_drag_image_here_multiple') }}</p>
                                </div>
                                <input type="file" id="gallery_images" name="gallery_images[]" accept="image/*"
                                    hidden multiple>

                                <div id="preview-gallery_images" class="flex flex-wrap gap-4 mt-6">
                                    @if ($touristSite->gallery_images && is_array($touristSite->gallery_images))
                                        @foreach ($touristSite->gallery_images as $index => $image)
                                            @if (Str::isUrl($touristSite->main_image))
                                                <div class="relative" id="existing_gallery_{{ $index }}">
                                                    <img src="{{ $image }}" alt="Gallery Image"
                                                        class="rounded-lg shadow-md w-full h-24 object-cover">
                                                    <button type="button"
                                                        onclick="removeExistingGalleryImage({{ $index }}, '{{ $image }}')"
                                                        class="absolute -top-2 -right-2 z-20 bg-danger text-white cursor-pointer rounded-full w-6 h-6 text-center">×</button>
                                                </div>
                                            @elseif (Storage::exists($image))
                                                <div class="relative" id="existing_gallery_{{ $index }}">
                                                    <img src="{{ asset('storage/' . $image) }}" alt="Gallery Image"
                                                        class="rounded-lg shadow-md w-full h-24 object-cover">
                                                    <button type="button"
                                                        onclick="removeExistingGalleryImage({{ $index }}, '{{ $image }}')"
                                                        class="absolute -top-2 -right-2 z-20 bg-danger text-white cursor-pointer rounded-full w-6 h-6 text-center">×</button>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                    <input type="hidden" name="removed_gallery[]" id="removed_gallery">
                                </div>
                            </div> --}}

                            <!-- Main Image -->
                            <div>
                                <label for="main_image" class="kt-label">
                                    {{ __('main.main_image') }}
                                </label>
                                <div class="dropzone mt-2 border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-primary transition-colors cursor-pointer"
                                    data-input="main_image">
                                    <i class="far fa-cloud-arrow-up text-5xl text-gray-600"></i>
                                    <p class="mt-2">{{ __('main.click_or_drag_image_here') }}</p>
                                </div>
                                <input type="file" id="main_image" name="main_image" accept="image/*" hidden>
                                <!-- Preview Main Image -->
                                <div id="main_image_preview" class="mt-3">
                                    @if (Str::isUrl($touristSite->main_image))
                                        <div class="relative inline-block" id="existing_main_image">
                                            <img src="{{ $touristSite->main_image }}" alt="Main Image"
                                                class="h-32 w-32 object-cover rounded-lg shadow-md">
                                            <button type="button" onclick="removeExistingMainImage()"
                                                class="absolute -top-2 -right-2 z-20 bg-danger text-white cursor-pointer rounded-full w-6 h-6 text-center">×</button>
                                        </div>
                                        <input type="hidden" name="remove_main_image" id="remove_main_image"
                                            value="0">
                                    @elseif (Storage::exists($touristSite->main_image))
                                        <div class="relative inline-block" id="existing_main_image">
                                            <img src="{{ asset($touristSite->main_image) }}" alt="Main Image"
                                                class="h-32 w-32 object-cover rounded-lg shadow-md">
                                            <button type="button" onclick="removeExistingMainImage()"
                                                class="absolute -top-2 -right-2 z-20 bg-danger text-white cursor-pointer rounded-full w-6 h-6 text-center">×</button>
                                        </div>
                                        <input type="hidden" name="remove_main_image" id="remove_main_image"
                                            value="0">
                                    @endif
                                </div>
                            </div>

                            <!-- Gallery Images -->
                            <div>
                                <label for="gallery_images" class="kt-label">
                                    {{ __('main.gallery_images') }}
                                </label>
                                <div class="dropzone mt-2 border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-primary transition-colors cursor-pointer"
                                    data-input="gallery_images">
                                    <i class="far fa-cloud-arrow-up text-5xl text-gray-600"></i>
                                    <p class="mt-2">{{ __('main.click_or_drag_image_here_multiple') }}</p>
                                </div>
                                <input type="file" id="gallery_images" name="gallery_images[]" accept="image/*"
                                    hidden multiple>

                                <!-- Preview Gallery Images -->
                                <div id="gallery_preview" class="flex flex-wrap gap-4 mt-6">
                                    @if ($touristSite->gallery_images && is_array($touristSite->gallery_images))
                                        @foreach ($touristSite->gallery_images as $index => $image)
                                            @if (Str::isUrl($image))
                                                <div class="relative" id="existing_gallery_{{ $index }}">
                                                    <img src="{{ $image }}" alt="Gallery Image"
                                                        class="rounded-lg shadow-md w-full h-24 object-cover">
                                                    <button type="button"
                                                        onclick="removeExistingGalleryImage({{ $index }}, '{{ $image }}')"
                                                        class="absolute -top-2 -right-2 z-20 bg-danger text-white cursor-pointer rounded-full w-6 h-6 text-center">×</button>
                                                </div>
                                            @elseif (Storage::exists($image))
                                                <div class="relative" id="existing_gallery_{{ $index }}">
                                                    <img src="{{ $image }}" alt="Gallery Image"
                                                        class="rounded-lg shadow-md w-full h-24 object-cover">
                                                    <button type="button"
                                                        onclick="removeExistingGalleryImage({{ $index }}, '{{ $image }}')"
                                                        class="absolute -top-2 -right-2 z-20 bg-danger text-white cursor-pointer rounded-full w-6 h-6 text-center">×</button>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                                <input type="hidden" name="remove_gallery_images" id="remove_gallery_images"
                                    value="">
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
                                'value' => $touristSite->description,
                            ])

                            <!-- description_01 -->
                            @include('components.elements.input-text-editor', [
                                'column' => 'description_01',
                                'value' => $touristSite->description_01,
                            ])

                            <!-- description_02 -->
                            @include('components.elements.input-text-editor', [
                                'column' => 'description_02',
                                'value' => $touristSite->description_02,
                            ])

                            <!-- description_03 -->
                            @include('components.elements.input-text-editor', [
                                'column' => 'description_03',
                                'value' => $touristSite->description_03,
                            ])

                            <!-- nearby_attractions -->
                            @include('components.elements.input-text-editor', [
                                'column' => 'nearby_attractions',
                                'value' => $touristSite->nearby_attractions,
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
                        'checked' => $touristSite->is_active,
                        'label' => __('main.is_active'),
                    ])
                </div>

                <!-- Update Submit -->
                @include('components.elements.update-submit', [
                    'models' => 'tourist-sites',
                    'model' => 'tourist-site',
                ])
            </div>
        </form>
    </div>
@endsection

@push('scripts')
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

            // ✅ Handle EDIT MODE for each select
            const select = $('.cities-select');
            const selectedCityId = select.data('value') || null;
            if (!selectedCityId) return;

            $.ajax({
                url: '{{ url('api/routes/cities') }}/' + selectedCityId,
                type: 'GET',
                dataType: 'json'
            }).done(function(data) {
                if (select.find("option[value='" + data.id + "']").length) {
                    return;
                }
                const option = new Option(data.text, data.id, true, true);
                select.append(option).trigger('change');
            });
        });
    </script>

    <script>
        // Track removed gallery images
        let removedGalleryImages = [];

        // Remove existing main image
        function removeExistingMainImage() {
            document.getElementById('existing_main_image').style.display = 'none';
            document.getElementById('remove_main_image').value = '1';
        }

        // Remove existing gallery image
        function removeExistingGalleryImage(index, imagePath) {
            document.getElementById('existing_gallery_' + index).style.display = 'none';
            removedGalleryImages.push(imagePath);
            document.getElementById('remove_gallery_images').value = JSON.stringify(removedGalleryImages);
        }

        // Image Preview for Main Image
        document.getElementById('main_image').addEventListener('change', function(e) {
            const preview = document.getElementById('main_image_preview');
            const existingImg = document.getElementById('existing_main_image');

            if (this.files && this.files[0]) {
                // Hide existing image when new image is selected
                if (existingImg) {
                    existingImg.style.display = 'none';
                    document.getElementById('remove_main_image').value = '1';
                }

                // Remove old new preview if exists
                const oldNewPreview = document.getElementById('new_main_image_preview');
                if (oldNewPreview) {
                    oldNewPreview.remove();
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const container = document.createElement('div');
                    container.className = 'relative inline-block';
                    container.id = 'new_main_image_preview';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'h-32 w-32 rounded-lg shadow-md object-cover';

                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.innerHTML = '×';
                    removeBtn.className =
                        'absolute -top-2 -right-2 z-20 bg-danger text-white cursor-pointer rounded-full w-6 h-6 text-center';
                    removeBtn.onclick = function() {
                        document.getElementById('main_image').value = '';
                        container.remove();
                        // Show existing image again if it was hidden
                        if (existingImg) {
                            existingImg.style.display = 'inline-block';
                            document.getElementById('remove_main_image').value = '0';
                        }
                    };

                    container.appendChild(img);
                    container.appendChild(removeBtn);
                    preview.appendChild(container);
                };
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Image Preview for Gallery Images
        const galleryInput = document.getElementById('gallery_images');
        const galleryPreview = document.getElementById('gallery_preview');
        let newGalleryFiles = new DataTransfer();
        let existingGalleryHidden = false;

        galleryInput.addEventListener('change', function(e) {
            if (this.files && this.files.length > 0) {
                // Hide all existing gallery images when new images are selected
                if (!existingGalleryHidden) {
                    document.querySelectorAll('[id^="existing_gallery_"]').forEach(function(element) {
                        if (element.style.display !== 'none') {
                            element.style.display = 'none';
                            const imagePath = element.querySelector('img').src.replace(window.location
                                .origin + '/storage/', '');
                            if (!removedGalleryImages.includes(imagePath)) {
                                removedGalleryImages.push(imagePath);
                            }
                        }
                    });
                    document.getElementById('remove_gallery_images').value = JSON.stringify(removedGalleryImages);
                    existingGalleryHidden = true;
                }

                Array.from(this.files).forEach((file, index) => {
                    newGalleryFiles.items.add(file);

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'relative new-gallery-item';
                        div.dataset.fileIndex = newGalleryFiles.files.length - Array.from(
                            galleryInput.files).length + index;

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'rounded-lg shadow-md w-full h-24 object-cover';

                        const removeBtn = document.createElement('button');
                        removeBtn.type = 'button';
                        removeBtn.innerHTML = '×';
                        removeBtn.className =
                            'absolute -top-2 -right-2 z-20 bg-danger text-white cursor-pointer rounded-full w-6 h-6 text-center';
                        removeBtn.onclick = function() {
                            div.remove();
                            // Rebuild DataTransfer without this file
                            const tempTransfer = new DataTransfer();
                            Array.from(newGalleryFiles.files).forEach((f, i) => {
                                if (i !== parseInt(div.dataset.fileIndex)) {
                                    tempTransfer.items.add(f);
                                }
                            });
                            newGalleryFiles = tempTransfer;
                            galleryInput.files = newGalleryFiles.files;

                            // If no new images, show existing images again
                            if (newGalleryFiles.files.length === 0) {
                                document.querySelectorAll('[id^="existing_gallery_"]').forEach(
                                    function(element) {
                                        element.style.display = 'block';
                                    });
                                removedGalleryImages = [];
                                document.getElementById('remove_gallery_images').value = '';
                                existingGalleryHidden = false;
                            }
                        };

                        div.appendChild(img);
                        div.appendChild(removeBtn);
                        galleryPreview.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                });

                galleryInput.files = newGalleryFiles.files;
            }
        });
    </script>
@endpush
