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

                    {{-- File Upload Area --}}
                    <div class="mb-4">
                        <label class="kt-label required">{{ __('main.files') }}</label>
                        <div class="mt-2 border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-primary transition-colors cursor-pointer"
                            onclick="document.getElementById('file-input').click()">
                            <i class="ki-filled ki-cloud-add text-5xl text-gray-400"></i>
                            <p class="text-gray-600 mt-4">{{ __('main.click_to_upload_or_drag_and_drop') }}</p>
                            <p class="text-sm text-gray-500 mt-2">{{ __('main.supported_formats_all') }}</p>
                            <input type="file" id="file-input" name="files[]" multiple class="hidden"
                                onchange="displaySelectedFiles(this)">
                        </div>
                        @error('files')
                            <span class="kt-error">{{ $message }}</span>
                        @enderror
                        @error('files.*')
                            <span class="kt-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Selected Files Preview --}}
                    <div id="files-preview" class="mb-4 hidden">
                        <label class="kt-label">{{ __('main.selected_files') }}</label>
                        <div id="files-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 mt-2"></div>
                        <button type="button" class="kt-btn bg-danger mt-2" toggle-button onclick="clearSelectedFiles()">
                            {{ __('main.cancel') }}
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-4">
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
                            <input type="text" name="alt_text" id="alt_text" class="kt-input h-[45px] mt-2"
                                value="{{ old('alt_text') }}">
                            @error('alt_text')
                                <span class="kt-error">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Collection --}}
                        <div>
                            <label for="availableCollections"
                                class="kt-label">{{ __('main.available_collections') }}</label>
                            <select name="collection_name" id="availableCollections" class="kt-input mt-2" special-search>
                                <option value="">--</option>
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

                    <div class="flex flex-wrap gap-6 mb-4">
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
                            @error('is_featured')
                                <span class="kt-error">{{ $message }}</span>
                            @enderror
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
                                    'label' => __('main.yes'),
                                ])
                            </div>
                            @error('is_active')
                                <span class="kt-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Description --}}
                    @include('components.elements.input-text-editor', [
                        'column' => 'description',
                        'value' => old('description'),
                    ])

                    {{-- Submit Button --}}
                    @include('components.elements.save-submit', ['models' => 'media-files'])
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function displaySelectedFiles(input) {
            const filesPreview = document.getElementById('files-preview');
            const filesList = document.getElementById('files-list');

            if (input.files && input.files.length > 0) {
                filesPreview.classList.remove('hidden');
                filesList.innerHTML = '';

                Array.from(input.files).forEach((file, index) => {
                    const fileDiv = document.createElement('div');
                    fileDiv.className = 'border rounded-lg p-3 text-center';

                    if (file.type.startsWith('image/')) {
                        const img = document.createElement('img');
                        img.src = URL.createObjectURL(file);
                        img.className = 'mx-auto object-cover rounded mb-2';
                        fileDiv.appendChild(img);
                    } else {
                        const icon = document.createElement('i');
                        icon.className = 'ki-filled ki-file text-3xl text-gray-400';
                        fileDiv.appendChild(icon);
                    }

                    const fileName = document.createElement('div');
                    fileName.className = 'text-xs text-gray-700 truncate mt-2';
                    fileName.textContent = file.name;
                    fileName.title = file.name;
                    fileDiv.appendChild(fileName);

                    const fileSize = document.createElement('div');
                    fileSize.className = 'text-xs text-gray-500 mt-1';
                    fileSize.textContent = formatFileSize(file.size);
                    fileDiv.appendChild(fileSize);

                    filesList.appendChild(fileDiv);
                });
            } else {
                filesPreview.classList.add('hidden');
            }
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
        }

        // Drag and drop functionality
        const dropZone = document.querySelector('.border-dashed');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            dropZone.classList.add('border-primary', 'bg-primary-light');
        }

        function unhighlight(e) {
            dropZone.classList.remove('border-primary', 'bg-primary-light');
        }

        dropZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            const fileInput = document.getElementById('file-input');
            fileInput.files = files;
            displaySelectedFiles(fileInput);
        }

        function clearSelectedFiles() {
            setTimeout(() => {
                const fileInput = document.getElementById('file-input');
                fileInput.value = '';
                const filesPreview = document.getElementById('files-preview');
                const filesList = document.getElementById('files-list');
                filesList.innerHTML = '';
                filesPreview.classList.add('hidden')
            }, 250);
        }
    </script>
@endpush
