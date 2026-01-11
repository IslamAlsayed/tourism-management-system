@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.tourist-service')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.tourist-service')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.tourist-service')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('tourist-services.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tourist-services')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <form action="{{ route('tourist-services.update', $touristService->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid gap-4 lg:gap-6">
                <!-- Tourist Site Photo -->
                @include('components.input-image', [
                    'modelKey' => $touristService->name ?? 'TS',
                    'column' => 'tourist-service',
                    'columnName' => 'photo',
                    'record' => $touristService,
                ])

                <!-- Location Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.location')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <!-- region_id, subregion_id, country_id, state_id, city_id -->
                        <livewire:regions.location-select-base :record="$touristService" />

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            @include('components.selects.currency', [
                                'record' => $touristService,
                            ])

                            <!-- latitude -->
                            <div class="align-self-end">
                                <label for="latitude" class="kt-label">{{ __('main.latitude') }}</label>
                                <input type="number" step="0.00000001" min="-90" max="90" name="latitude"
                                    id="latitude" class="kt-input h-[45px]" value="{{ $touristService->latitude }}">
                            </div>

                            <!-- longitude -->
                            <div class="align-self-end">
                                <label for="longitude" class="kt-label">{{ __('main.longitude') }}</label>
                                <input type="number" step="0.00000001" min="-180" max="180" name="longitude"
                                    id="longitude" class="kt-input h-[45px]" value="{{ $touristService->longitude }}">
                            </div>

                            <div class="align-self-end">
                                <label for="area" class="kt-label">{{ __('main.area') }}</label>
                                <input type="text" name="area" id="area" class="kt-input h-[45px]"
                                    value="{{ $touristService->area }}">
                            </div>

                            <div class="align-self-end">
                                <label for="zone" class="kt-label">{{ __('main.zone') }}</label>
                                <input type="text" name="zone" id="zone" class="kt-input h-[45px]"
                                    value="{{ $touristService->zone }}">
                            </div>

                            <div class="align-self-end">
                                <label for="district" class="kt-label">{{ __('main.district') }}</label>
                                <input type="text" name="district" id="district" class="kt-input h-[45px]"
                                    value="{{ $touristService->district }}">
                            </div>

                            <div class="align-self-end">
                                <label for="neighborhood" class="kt-label">{{ __('main.neighborhood') }}</label>
                                <input type="text" name="neighborhood" id="neighborhood" class="kt-input h-[45px]"
                                    value="{{ $touristService->neighborhood }}">
                            </div>

                            <div class="align-self-end">
                                <label for="block" class="kt-label">{{ __('main.block') }}</label>
                                <input type="text" name="block" id="block" class="kt-input h-[45px]"
                                    value="{{ $touristService->block }}">
                            </div>

                            <div class="align-self-end">
                                <label for="building" class="kt-label">{{ __('main.building') }}</label>
                                <input type="text" name="building" id="building" class="kt-input h-[45px]"
                                    value="{{ $touristService->building }}">
                            </div>

                            <div class="align-self-end">
                                <label for="floor" class="kt-label">{{ __('main.floor') }}</label>
                                <input type="text" name="floor" id="floor" class="kt-input h-[45px]"
                                    value="{{ $touristService->floor }}">
                            </div>

                            <div class="align-self-end">
                                <label for="apartment" class="kt-label">{{ __('main.apartment') }}</label>
                                <input type="text" name="apartment" id="apartment" class="kt-input h-[45px]"
                                    value="{{ $touristService->apartment }}">
                            </div>

                            <div class="align-self-end">
                                <label for="landmark" class="kt-label">{{ __('main.landmark') }}</label>
                                <input type="text" name="landmark" id="landmark" class="kt-input h-[45px]"
                                    value="{{ $touristService->landmark }}">
                            </div>

                            <div class="align-self-end">
                                <label for="directions" class="kt-label">{{ __('main.directions') }}</label>
                                <input type="text" name="directions" id="directions" class="kt-input h-[45px]"
                                    value="{{ $touristService->directions }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.tourist-service')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            <!-- name -->
                            <div class="align-self-end">
                                <label for="name" class="kt-label">{{ __('main.name') }}<span
                                        class="text-red-600 text-2xl">*</span></label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]"
                                    value="{{ $touristService->name }}">
                            </div>

                            <!-- name_ar -->
                            <div class="align-self-end">
                                <label for="name_ar" class="kt-label">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
                                    value="{{ $touristService->name_ar }}">
                            </div>

                            <!-- code -->
                            <div class="align-self-end">
                                <label for="code" class="kt-label">{{ __('main.code') }}</label>
                                <input type="text" name="code" id="code" class="kt-input h-[45px]"
                                    value="{{ $touristService->code }}">
                            </div>

                            <!-- site_type -->
                            <div class="align-self-end">
                                <label for="site_type" class="kt-label">{{ __('main.site_type') }}</label>
                                <input type="text" name="site_type" id="site_type" class="kt-input h-[45px]"
                                    value="{{ $touristService->site_type }}">
                            </div>

                            <!-- category -->
                            <div class="align-self-end">
                                <label for="category" class="kt-label">{{ __('main.category') }}</label>
                                <input type="text" name="category" id="category" class="kt-input h-[45px]"
                                    value="{{ $touristService->category }}">
                            </div>

                            <!-- Main Image -->
                            <div class="">
                                <label for="main_image" class="kt-label mb-2">{{ __('main.main_image') }}</label>
                                <input type="file" name="main_image" id="main_image" class="kt-input h-[45px]"
                                    accept="image/*">
                                @error('main_image')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                                <!-- Preview Main Image -->
                                <div id="main_image_preview" class="mt-3">
                                    @if ($touristService->main_image)
                                        <div class="relative inline-block" id="existing_main_image">
                                            <img src="{{ asset('storage/' . $touristService->main_image) }}"
                                                alt="Main Image" class="h-32 w-32 object-cover rounded-lg shadow-md">
                                            <button type="button" onclick="removeExistingMainImage()"
                                                class="absolute -top-2 -right-2 z-20 bg-danger text-white cursor-pointer rounded-full w-6 h-6 text-center">×</button>
                                        </div>
                                        <input type="hidden" name="remove_main_image" id="remove_main_image"
                                            value="0">
                                    @endif
                                </div>
                            </div>

                            <!-- Gallery Images -->
                            <div class="">
                                <label for="gallery_images" class="kt-label mb-2">{{ __('main.gallery_images') }}</label>
                                <input type="file" name="gallery_images[]" id="gallery_images"
                                    class="kt-input h-[45px]" accept="image/*" multiple>
                                @error('gallery_images')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                                <!-- Preview Gallery Images -->
                                <div id="gallery_preview" class="mt-3 grid grid-cols-4 gap-2">
                                    @if ($touristService->gallery_images && is_array($touristService->gallery_images))
                                        @foreach ($touristService->gallery_images as $index => $image)
                                            @if (!empty($image) && is_string($image))
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
                                </div>
                                <input type="hidden" name="remove_gallery_images" id="remove_gallery_images"
                                    value="">
                            </div>

                            <!-- video_url -->
                            <div class="align-self-end">
                                <label for="video_url" class="kt-label">{{ __('main.video_url') }}</label>
                                <input type="url" name="video_url" id="video_url" class="kt-input h-[45px]"
                                    value="{{ $touristService->video_url }}">
                            </div>

                            <!-- virtual_tour_url -->
                            <div class="align-self-end">
                                <label for="virtual_tour_url" class="kt-label">{{ __('main.virtual_tour_url') }}</label>
                                <input type="url" name="virtual_tour_url" id="virtual_tour_url"
                                    class="kt-input h-[45px]" value="{{ $touristService->virtual_tour_url }}">
                            </div>

                            <!-- rating -->
                            <div class="align-self-end">
                                <label for="rating" class="kt-label">{{ __('main.rating') }}</label>
                                <select name="rating" id="rating" class="kt-select basic-single">
                                    <option value="" selected>--</option>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}"
                                            {{ $touristService->rating == $i ? 'selected' : '' }}>
                                            {{ $i . ' ' . __('main.stars') }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <!-- total_reviews -->
                            <div class="align-self-end">
                                <label for="total_reviews" class="kt-label">{{ __('main.total_reviews') }}</label>
                                <input type="number" name="total_reviews" id="total_reviews" class="kt-input h-[45px]"
                                    value="{{ $touristService->total_reviews }}">
                            </div>

                            <!-- popularity_score -->
                            <div class="align-self-end">
                                <label for="popularity_score" class="kt-label">{{ __('main.popularity_score') }}</label>
                                <input type="number" name="popularity_score" id="popularity_score"
                                    class="kt-input h-[45px]" value="{{ $touristService->popularity_score }}">
                            </div>

                            <!-- estimated_visit_duration -->
                            <div class="align-self-end">
                                <label for="estimated_visit_duration"
                                    class="kt-label">{{ __('main.estimated_visit_duration') }}</label>
                                <input type="number" name="estimated_visit_duration" id="estimated_visit_duration"
                                    class="kt-input h-[45px]" value="{{ $touristService->estimated_visit_duration }}">
                            </div>

                            <!-- difficulty_level -->
                            <div class="align-self-end">
                                <label for="difficulty_level" class="kt-label">{{ __('main.difficulty_level') }}</label>
                                <input type="text" name="difficulty_level" id="difficulty_level"
                                    class="kt-input h-[45px]" value="{{ $touristService->difficulty_level }}">
                            </div>

                            <!-- status -->
                            <div class="align-self-end">
                                <label for="status" class="kt-label">{{ __('main.status') }}</label>
                                <input type="text" name="status" id="status" class="kt-input h-[45px]"
                                    value="{{ $touristService->status }}">
                            </div>

                            <!-- tags -->
                            <div class="align-self-end">
                                <label for="tags" class="kt-label">{{ __('main.tags') }}</label>
                                <select name="tags[]" id="tags" class="kt-input basic-multiple" multiple>
                                    @foreach (['family_friendly', 'adventure', 'cultural', 'historical', 'nature', 'romantic', 'luxury', 'budget', 'eco_friendly', 'accessible'] as $tag)
                                        <option value="{{ $tag }}"
                                            {{ $touristService->tags == $tag ? 'selected' : '' }}>
                                            {{ __('main.' . $tag) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
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
                            <div class="align-self-end">
                                <label for="contact_person" class="kt-label">{{ __('main.contact_person') }}</label>
                                <input type="text" name="contact_person" id="contact_person"
                                    class="kt-input h-[45px]" value="{{ $touristService->contact_person }}">
                            </div>

                            <div class="align-self-end">
                                <label for="whatsapp" class="kt-label">{{ __('main.whatsapp') }}</label>
                                <input type="text" name="whatsapp" id="whatsapp" class="kt-input h-[45px]"
                                    value="{{ $touristService->whatsapp }}">
                            </div>

                            <div class="align-self-end">
                                <label for="telegram" class="kt-label">{{ __('main.telegram') }}</label>
                                <input type="text" name="telegram" id="telegram" class="kt-input h-[45px]"
                                    value="{{ $touristService->telegram }}">
                            </div>

                            <div class="align-self-end">
                                <label for="snapchat" class="kt-label">{{ __('main.snapchat') }}</label>
                                <input type="text" name="snapchat" id="snapchat" class="kt-input h-[45px]"
                                    value="{{ $touristService->snapchat }}">
                            </div>

                            <div class="align-self-end">
                                <label for="tiktok" class="kt-label">{{ __('main.tiktok') }}</label>
                                <input type="text" name="tiktok" id="tiktok" class="kt-input h-[45px]"
                                    value="{{ $touristService->tiktok }}">
                            </div>

                            <div class="align-self-end">
                                <label for="youtube" class="kt-label">{{ __('main.youtube') }}</label>
                                <input type="text" name="youtube" id="youtube" class="kt-input h-[45px]"
                                    value="{{ $touristService->youtube }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- address -->
                @include('components.elements.input-text-editor', [
                    'column' => 'address',
                    'value' => $touristService->address,
                ])

                <!-- description -->
                @include('components.elements.input-text-editor', [
                    'column' => 'description',
                    'value' => $touristService->description,
                ])

                <!-- notes -->
                @include('components.elements.input-text-editor', [
                    'column' => 'notes',
                    'value' => $touristService->notes,
                ])

                <div class="flex flex-wrap" style="gap: 10px 40px;">
                    @foreach (['is_active', 'translation', 'special_events', 'group_bookings', 'online_booking', 'mobile_app', 'virtual_tours', 'has_parking', 'has_restaurant', 'has_gift_shop', 'has_restrooms', 'is_featured', 'is_verified'] as $input)
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="{{ $input }}" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => '{{ $input }}',
                                'id' => '{{ $input }}',
                                'value' => '1',
                                'checked' => $touristService->$input ? true : false,
                                'label' => __('main.' . $input),
                            ])
                        </div>
                    @endforeach
                </div>

                <!-- Update Submit -->
                @include('components.elements.update-submit', [
                    'models' => 'tourist-services',
                    'model' => 'tourist-service',
                ])
            </div>
        </form>
    </div>
@endsection

@push('scripts')
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
