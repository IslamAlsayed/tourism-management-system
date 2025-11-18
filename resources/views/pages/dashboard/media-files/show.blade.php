@extends('layouts.master')

@section('content')
    <div class="kt-container-fixed">
        {{-- Page Header --}}
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ __('main.media_file_details') }}</h1>
                <p class="text-gray-600 mt-1">{{ $mediaFile->file_name }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('media-files.edit', $mediaFile->id) }}" class="kt-btn kt-btn-primary">
                    <i class="ki-filled ki-pencil"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('media-files.index') }}" class="kt-btn kt-btn-outline">
                    <i class="ki-filled ki-left"></i>
                    {{ __('main.back') }}
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- File Preview --}}
            <div class="lg:col-span-2">
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.preview') }}</h3>
                    </div>
                    <div class="kt-card-body p-6">
                        @if ($mediaFile->is_image)
                            <div class="text-center">
                                <img class="max-w-full mx-auto rounded-lg shadow-lg" src="{{ $mediaFile->url }}"
                                    alt="{{ $mediaFile->alt_text }}">
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center py-12">
                                <i class="ki-filled ki-file text-8xl text-gray-400"></i>
                                <p class="text-xl font-medium text-gray-700 mt-4">{{ strtoupper($mediaFile->extension) }}
                                    {{ __('main.file') }}</p>
                                <p class="text-gray-600 mt-2">{{ $mediaFile->human_file_size }}</p>
                                <a href="{{ $mediaFile->url }}" download="{{ $mediaFile->file_name }}"
                                    class="kt-btn kt-btn-primary mt-6">
                                    <i class="ki-filled ki-download"></i>
                                    {{ __('main.download') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- File Information --}}
            <div class="space-y-6">
                {{-- Basic Info --}}
                <div class="kt-card mb-6">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.file_information') }}</h3>
                    </div>
                    <div class="kt-card-body p-6">
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">{{ __('main.file_name') }}</dt>
                                <dd class="text-sm text-gray-900 mt-1 break-all">{{ $mediaFile->file_name }}</dd>
                            </div>

                            @if ($mediaFile->title)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('main.title') }}</dt>
                                    <dd class="text-sm text-gray-900 mt-1">{{ $mediaFile->title }}</dd>
                                </div>
                            @endif

                            @if ($mediaFile->alt_text)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('main.alt_text') }}</dt>
                                    <dd class="text-sm text-gray-900 mt-1">{{ $mediaFile->alt_text }}</dd>
                                </div>
                            @endif

                            @if ($mediaFile->description)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('main.description') }}</dt>
                                    <dd class="text-sm text-gray-900 mt-1">{{ $mediaFile->description }}</dd>
                                </div>
                            @endif

                            <div>
                                <dt class="text-sm font-medium text-gray-500">{{ __('main.file_type') }}</dt>
                                <dd class="text-sm text-gray-900 mt-1">
                                    <span class="px-2 py-1 rounded-full bg-primary text-white">
                                        {{ strtoupper($mediaFile->extension) }}
                                    </span>
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">{{ __('main.mime_type') }}</dt>
                                <dd class="text-sm text-gray-900 mt-1">{{ $mediaFile->mime_type }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">{{ __('main.file_size') }}</dt>
                                <dd class="text-sm text-gray-900 mt-1">{{ $mediaFile->human_file_size }}</dd>
                            </div>

                            @if ($mediaFile->width && $mediaFile->height)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('main.dimensions') }}</dt>
                                    <dd class="text-sm text-gray-900 mt-1">{{ $mediaFile->width }} ×
                                        {{ $mediaFile->height }}
                                        px</dd>
                                </div>
                            @endif

                            @if ($mediaFile->collection_name)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('main.collection_name') }}</dt>
                                    <dd class="text-sm text-gray-900 mt-1">
                                        <span class="px-2 py-1 rounded-full bg-primary/30 text-primary">
                                            {{ ucfirst($mediaFile->collection_name) }}
                                        </span>
                                    </dd>
                                </div>
                            @endif

                            <div>
                                <dt class="text-sm font-medium text-gray-500">{{ __('main.status') }}</dt>
                                <dd class="text-sm text-gray-900 mt-1">
                                    @if ($mediaFile->is_active)
                                        <span class="px-2 py-1 rounded-full bg-success/30 text-green-600">
                                            {{ __('main.active') }}
                                        </span>
                                    @else
                                        <span class="px-2 py-1 rounded-full bg-danger text-danger">
                                            {{ __('main.inactive') }}
                                        </span>
                                    @endif
                                </dd>
                            </div>

                            @if ($mediaFile->is_featured)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('main.featured') }}</dt>
                                    <dd class="text-sm text-gray-900 mt-1">
                                        <span class="px-2 py-1 rounded-full bg-warning-light text-warning">
                                            <i class="ki-filled ki-star"></i>
                                            {{ __('main.yes') }}
                                        </span>
                                    </dd>
                                </div>
                            @endif

                            <div>
                                <dt class="text-sm font-medium text-gray-500">{{ __('main.display_order') }}</dt>
                                <dd class="text-sm text-gray-900 mt-1">{{ $mediaFile->display_order }}</dd>
                            </div>

                            @if ($mediaFile->uploader)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('main.uploaded_by') }}</dt>
                                    <dd class="text-sm text-gray-900 mt-1">{{ $mediaFile->uploader->name }}</dd>
                                </div>
                            @endif

                            <div>
                                <dt class="text-sm font-medium text-gray-500">{{ __('main.uploaded_at') }}</dt>
                                <dd class="text-sm text-gray-900 mt-1">{{ $mediaFile->created_at->format('Y-m-d H:i') }}
                                </dd>
                            </div>

                            @if ($mediaFile->updated_at != $mediaFile->created_at)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('main.last_updated') }}</dt>
                                    <dd class="text-sm text-gray-900 mt-1">
                                        {{ $mediaFile->updated_at->format('Y-m-d H:i') }}
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.actions') }}</h3>
                    </div>
                    <div class="kt-card-body p-6 space-y-3">
                        <a href="{{ $mediaFile->url }}" target="_blank" class="kt-btn kt-btn-light w-full">
                            <i class="ki-filled ki-eye"></i>
                            {{ __('main.view_original') }}
                        </a>

                        <a href="{{ $mediaFile->url }}" download="{{ $mediaFile->file_name }}"
                            class="kt-btn kt-btn-light w-full">
                            <i class="ki-filled ki-download"></i>
                            {{ __('main.download') }}
                        </a>

                        <button type="button" data-url="{{ $mediaFile->url }}" class="kt-btn kt-btn-light w-full"
                            id="copyToClipboard">
                            <i class="ki-filled ki-copy"></i>
                            {{ __('main.copy_url') }}
                        </button>

                        <form action="{{ route('media-files.destroy', $mediaFile->id) }}" method="POST"
                            onsubmit="return confirm('{{ __('main.are_you_sure') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="kt-btn bg-danger w-full">
                                <i class="ki-filled ki-trash"></i>
                                {{ __('main.delete') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('vendor/toasts/js/toasts.js') }}" type="module"></script>

    <script>
        document.getElementById('copyToClipboard').addEventListener('click', function(e) {
            let text = e.target.getAttribute('data-url');
            let successMessage = @json(__('main.url_copied_to_clipboard'));
            let errorMessage = @json(__('main.failed_to_copy_url'));

            navigator.clipboard.writeText(text).then(() => {
                window.showToast({
                    type: 'success',
                    message: successMessage
                });

                this.disabled = true;
                this.innerHTML = '<i class="ki-filled ki-copied"></i> {{ __('main.copied') }}';

                setTimeout(() => {
                    this.disabled = false;
                    this.innerHTML = `<i class="ki-filled ki-copy"></i>{{ __('main.copy_url') }}`;
                }, 4000);
            }).catch(() => {
                window.showToast({
                    type: 'error',
                    message: errorMessage
                });
            });
        });
    </script>
@endpush
