@extends('layouts.master')

@section('content')
    <div class="kt-container-fixed">
        {{-- Page Header --}}
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ __('main.upload_files') }}</h1>
                <p class="text-gray-600 mt-1">{{ __('main.upload_multiple_files') }}</p>
            </div>
            <div>
                <a href="{{ route('media-files.index') }}" class="kt-btn kt-btn-outline">
                    <i class="ki-filled ki-left"></i>
                    {{ __('main.back') }}
                </a>
            </div>
        </div>

        {{-- Upload Form --}}
        <div class="kt-card">
            <div class="kt-card-body p-4">
                <form action="{{ route('media-files.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid gap-4 lg:gap-6">

                        {{-- File Upload Area --}}
                        <div>
                            <label for="area_image" class="kt-label required">{{ __('main.files') }}</label>
                            <div class="dropzone mt-2 border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-primary transition-colors cursor-pointer"
                                data-input="area_image">
                                <i class="ki-filled ki-cloud-add text-5xl text-gray-400"></i>
                                <p class="mt-4">{{ __('main.click_or_drag_images_here') }}</p>
                            </div>
                            <input type="file" id="area_image" name="files[]" accept="image/*" multiple hidden>
                            <div id="preview-area_image" class="hidden flex flex-wrap gap-4 mt-6"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 items-end">
                            {{-- Title --}}
                            <div>
                                <label for="title" class="kt-label">{{ __('main.title') }}</label>
                                <input type="text" name="title" id="title" class="kt-input h-[45px] mt-2"
                                    value="{{ old('title') }}">
                                @error('title')
                                    <span class="kt-error">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Alt Text --}}
                            <div>
                                <label for="alt_text" class="kt-label">{{ __('main.alt_text') }}</label>
                                <input type="text" name="alt_text" id="alt_text" class="kt-input h-[45px]"
                                    value="{{ old('alt_text') }}">
                                @error('alt_text')
                                    <span class="kt-error">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Collection --}}
                            <div>
                                <label for="availableCollections"
                                    class="kt-label">{{ __('main.available_collections') }}</label>
                                <select name="collection_name" id="availableCollections"
                                    class="kt-select mt-2 basic-single">
                                    <option value="" selected>--</option>
                                    @foreach ($availableCollection as $collection)
                                        <option value="{{ $collection }}">
                                            {{ __('main.' . $collection) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('collection_name')
                                    <span class="kt-error">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Priority of Appearance --}}
                            <div>
                                <label for="priority_of_appearance"
                                    class="kt-label">{{ __('main.priority_of_appearance') }}</label>
                                <input type="number" name="order" id="priority_of_appearance" class="kt-input h-[45px]"
                                    value="{{ old('order') }}" min="0">
                                @error('order')
                                    <span class="kt-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-6">
                            {{-- Is Featured --}}
                            <div>
                                <label class="kt-label">{{ __('main.featured') }}</label>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="is_featured" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'is_featured',
                                        'id' => 'is_featured',
                                        'value' => '1',
                                        'label' => __('main.yes'),
                                    ])
                                </div>
                            </div>

                            {{-- Is Active --}}
                            <div style="margin-inline-start: 50px">
                                <label class="kt-label">{{ __('main.status') }}</label>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="is_active" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'is_active',
                                        'id' => 'is_active',
                                        'value' => '1',
                                        'checked' => 1,
                                        'label' => __('main.yes'),
                                    ])
                                </div>
                            </div>
                        </div>

                        {{-- Description --}}
                        @include('components.elements.input-text-editor', [
                            'column' => 'description',
                            'value' => old('description'),
                        ])

                        {{-- Submit Button --}}
                        @include('components.elements.save-submit', [
                            'models' => 'media-files',
                            'model' => 'media-file',
                        ])
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    @include('components.scripts.drag-drop-images')
@endpush
