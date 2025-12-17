@extends('layouts.master')

@section('content')
    <div class="kt-container-fixed">

        {{-- Page Header --}}
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ __('main.edit_media_file') }}</h1>
                <p class="text-gray-600 mt-1">{{ $mediaFile->file_name }}</p>
            </div>
            <div>
                <a href="{{ route('media-files.index') }}" class="kt-btn kt-btn-outline">
                    <i class="ki-filled ki-left"></i>
                    {{ __('main.back') }}
                </a>
            </div>
        </div>

        {{-- Edit Form --}}
        <div class="kt-card">
            <div class="kt-card-body p-6">
                <form action="{{ route('media-files.update', $mediaFile->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- File Preview --}}
                    <div class="mb-6 text-center w-[200px] mx-auto">
                        @if ($mediaFile->is_image)
                            <img src="{{ $mediaFile->url }}" alt="{{ $mediaFile->alt_text }}"
                                class="max-w-md mx-auto rounded-lg shadow-lg">
                        @else
                            <div class="inline-flex items-center justify-center w-32 h-32 bg-gray-100 rounded-lg">
                                <i class="ki-filled ki-file text-5xl text-gray-400"></i>
                            </div>
                        @endif
                        <div class="mt-4 text-sm text-gray-600">
                            <div>{{ __('main.file_type') }}: <strong>{{ strtoupper($mediaFile->extension) }}</strong></div>
                            <div>{{ __('main.file_size') }}: <strong>{{ $mediaFile->human_file_size }}</strong></div>
                            @if ($mediaFile->width && $mediaFile->height)
                                <div>
                                    {{ __('main.dimensions') }}:
                                    <strong> {{ $mediaFile->width }} × {{ $mediaFile->height }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-4">
                        {{-- File Name --}}
                        <div>
                            <label for="file_name" class="kt-label">{{ __('main.file_name') }}</label>
                            <input type="text" name="file_name" id="file_name" class="kt-input mt-2"
                                value="{{ old('file_name', $mediaFile->file_name) }}">
                            @error('file_name')
                                <span class="kt-error">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Title --}}
                        <div>
                            <label for="title" class="kt-label">{{ __('main.title') }}</label>
                            <input type="text" name="title" id="title" class="kt-input mt-2"
                                value="{{ old('title', $mediaFile->title) }}">
                            @error('title')
                                <span class="kt-error">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Alt Text --}}
                        <div>
                            <label for="alt_text" class="kt-label">{{ __('main.alt_text') }}</label>
                            <input type="text" name="alt_text" id="alt_text" class="kt-input mt-2"
                                value="{{ old('alt_text', $mediaFile->alt_text) }}">
                            @error('alt_text')
                                <span class="kt-error">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Collection --}}
                        <div>
                            <label for="collection_name" class="kt-label">{{ __('main.available_collections') }}</label>
                            <select name="collection_name" id="collection_name" class="kt-input mt-2" special-search
                                data-current-value="{{ $mediaFile->collection_name }}"
                                value="{{ $mediaFile->collection_name }}">
                                <option value="">--</option>
                                @foreach ($availableCollection as $collection)
                                    <option value="{{ $collection }}"
                                        {{ $mediaFile->collection_name == $collection ? 'selected' : '' }}>
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
                                value="{{ $mediaFile->order }}" min="0">
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
                                    'value' => $mediaFile->is_featured,
                                    'checked' => $mediaFile->is_featured,
                                    'label' => __('main.yes'),
                                ])
                            </div>
                            @error('is_featured')
                                <span class="kt-error">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Is Active --}}
                        <div>
                            <label class="kt-label">{{ __('main.status') }}</label>
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="is_active" value="0">
                                @include('components.elements.checkbox-button', [
                                    'name' => 'is_active',
                                    'id' => 'is_active',
                                    'value' => $mediaFile->is_active,
                                    'checked' => $mediaFile->is_active,
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
                        'value' => $mediaFile->description,
                    ])

                    {{-- Replace File (Optional) --}}
                    <div class="mb-4">
                        <label for="replace_file" class="kt-label">
                            {{ __('main.replace_file') }} ({{ __('main.optional') }})
                        </label>
                        <div class="mt-2 border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-primary transition-colors cursor-pointer"
                            id="drop-zone" onclick="document.getElementById('replace_file').click()">
                            <i class="ki-filled ki-cloud-change text-4xl text-gray-400"></i>
                            <p class="text-gray-600 mt-2">{{ __('main.click_to_upload_or_drag_and_drop') }}</p>
                            <p class="text-sm text-gray-500 mt-1">{{ __('main.leave_empty_to_keep_current_file') }}</p>
                            <input type="file" name="replace_file" id="replace_file" class="hidden"
                                onchange="displaySelectedFile(this)">
                        </div>
                        @error('replace_file')
                            <span class="kt-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Selected File Preview --}}
                    <div id="file-preview" class="w-fit mb-4 hidden">
                        <label class="kt-label">{{ __('main.replaced_file') }}</label>
                        <div id="file-info" class="kt-card bg-gray-50 rounded-lg p-4"></div>
                        <button type="button" class="kt-btn bg-danger mt-2" onclick="clearSelectedFile()">
                            {{ __('main.cancel') }}
                        </button>
                    </div>

                    {{-- Form Actions --}}
                    @include('components.elements.update-submit', ['models' => 'media-files'])
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function displaySelectedFile(input) {
            const filePreview = document.getElementById('file-preview');
            const fileInfo = document.getElementById('file-info');

            if (input.files && input.files.length > 0) {
                const file = input.files[0];
                filePreview.classList.remove('hidden');
                fileInfo.innerHTML = '';

                const fileDiv = document.createElement('div');
                fileDiv.className = 'flex items-center gap-4';

                // Preview for image or icon for other files
                if (file.type.startsWith('image/')) {
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.className = 'w-24 h-24 object-cover rounded';
                    fileDiv.appendChild(img);

                    // Update main preview if exists
                    const mainPreview = document.querySelector('#media-file-preview');
                    if (mainPreview) {
                        mainPreview.src = URL.createObjectURL(file);
                    }
                } else {
                    const iconDiv = document.createElement('div');
                    iconDiv.className = 'w-24 h-24 flex items-center justify-center bg-gray-100 rounded';
                    const icon = document.createElement('i');
                    icon.className = 'ki-filled ki-file text-4xl text-gray-400';
                    iconDiv.appendChild(icon);
                    fileDiv.appendChild(iconDiv);
                }

                // File details
                const detailsDiv = document.createElement('div');
                detailsDiv.className = 'flex-1';

                const fileName = document.createElement('div');
                fileName.className = 'font-medium text-gray-900';
                fileName.textContent = file.name;
                detailsDiv.appendChild(fileName);

                const fileSize = document.createElement('div');
                fileSize.className = 'text-sm text-gray-600 mt-1';
                fileSize.textContent = '{{ __('main.file_size') }}: ' + formatFileSize(file.size);
                detailsDiv.appendChild(fileSize);

                const fileType = document.createElement('div');
                fileType.className = 'text-sm text-gray-600 mt-1';
                const extension = file.name.split('.').pop().toUpperCase();
                fileType.textContent = '{{ __('main.file_type') }}: ' + extension;
                detailsDiv.appendChild(fileType);

                fileDiv.appendChild(detailsDiv);
                fileInfo.appendChild(fileDiv);
            } else {
                filePreview.classList.add('hidden');
            }
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
        }

        function clearSelectedFile() {
            setTimeout(() => {
                const fileInput = document.getElementById('replace_file');
                fileInput.value = '';
                const filePreview = document.getElementById('file-preview');
                const fileInfo = document.getElementById('file-info');
                fileInfo.innerHTML = '';
                filePreview.classList.add('hidden');

                // Restore original preview if exists
                const mainPreview = document.querySelector('#media-file-preview');
                if (mainPreview) {
                    mainPreview.src = '{{ $mediaFile->url }}';
                }
            }, 250);
        }

        // Drag and drop functionality
        const dropZone = document.getElementById('drop-zone');

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
            const fileInput = document.getElementById('replace_file');
            fileInput.files = files;
            displaySelectedFile(fileInput);
        }
    </script>
@endpush
