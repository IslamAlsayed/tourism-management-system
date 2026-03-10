@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.city')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.city')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.city')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.geography.cities.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.cities')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <form action="{{ route('dashboard.geography.cities.update', $city->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid gap-4 lg:gap-6">
                <!-- Location Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.location')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        {{-- State --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            {{-- State --}}
                            @include('components.selects.state', ['record' => $city])

                            <!-- Latitude -->
                            @include('components.inputs.latitude', ['record' => $city])

                            <!-- Longitude -->
                            @include('components.inputs.longitude', ['record' => $city])
                        </div>
                    </div>
                </div>

                <!-- City Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.city')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            <!-- City Name (English) -->
                            <div class="">
                                <label for="name" class="kt-label required mb-2">{{ __('main.name') }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]" required value="{{ $city->name }}">
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- City Name (Arabic) -->
                            <div class="">
                                <label for="name_ar" class="kt-label mb-2">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]" value="{{ $city->name_ar }}">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Population -->
                            <div class="">
                                <label for="population" class="kt-label mb-2">{{ __('main.population') }}</label>
                                <input type="number" name="population" id="population" class="kt-input h-[45px]" value="{{ $city->population }}">
                                @error('population')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Wiki data id -->
                            <div class="">
                                <label for="wiki_data_id" class="kt-label mb-2">{{ __('main.wiki_data_id') }}</label>
                                <input type="text" name="wiki_data_id" id="wiki_data_id" class="kt-input h-[45px]" value="{{ $city->wiki_data_id }}">
                                @error('wiki_data_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Media Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.media')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Photo -->
                            <div>
                                <label for="photo" class="kt-label">{{ __('main.photo') }}</label>
                                <div class="dropzone mt-2 border-2 border-dashed border-gray-200 rounded-lg p-4 text-center hover:border-primary transition-colors cursor-pointer"
                                    data-input="photo" data-preview="preview-photo">
                                    <i class="far fa-cloud-arrow-up text-5xl text-gray-600"></i>
                                    <p class="mt-4">{{ __('main.click_or_drag_image_here') }}</p>
                                </div>
                                <input type="file" name="photo" id="photo" accept="image/*" hidden>
                                <input type="hidden" name="remove_photo" id="remove_photo" value="0">

                                {{-- Existing photo (edit mode) --}}
                                @if (!empty($city->photo))
                                    <div id="existing-photo" class="relative w-fit mt-8">
                                        <img src="{{ asset('storage/' . $city->photo) }}" class="h-32 w-32 rounded">
                                        <button type="button"
                                            class="remove-existing-photo absolute -top-2 -right-2 bg-danger cursor-pointer text-white w-6 h-6 rounded-full">
                                            ×
                                        </button>
                                    </div>
                                @endif

                                <div id="preview-photo" class="hidden mt-8"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                @include('components.elements.input-text-editor', [
                    'name' => 'description',
                    'value' => $city->description,
                ])

                {{-- Notes --}}
                @include('components.elements.input-text-editor', [
                    'name' => 'notes',
                    'value' => $city->notes,
                ])

                <!-- Is active -->
                <div class="flex flex-wrap gap-10">
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_active',
                            'id' => 'is_active',
                            'value' => '1',
                            'checked' => $city->is_active,
                            'label' => __('main.is_active'),
                        ])
                    </div>
                </div>

                <!-- Update Submit -->
                @include('components.elements.update-submit', ['models' => 'dashboard.geography.cities', 'model' => 'city'])
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    @include('components.scripts.drag-drop-images')
@endpush
