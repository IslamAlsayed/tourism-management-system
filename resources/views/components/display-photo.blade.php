<!-- Media Files -->
<div class="kt-card">
    <div class="kt-card-header">
        <h3 class="kt-card-title">{{ __('main.media_resources') }}</h3>
    </div>
    <div class="kt-card-body p-4">
        <div class="flex flex-col gap-6">
            @if ($record->photo && checkExistFile($record->photo))
                <div class="flex flex-col w-fit">
                    <label class="kt-label mb-2">{{ __('main.photo') }}</label>
                    <div class="image-container">
                        @if ($record->photo)
                            <img src="{{ asset('storage/' . $record->photo) }}" alt="{{ $alt }}" class="w-auto h-[250px] object-cover shadow"
                                loading="lazy">
                        @else
                            <div class="h-40 bg-gray-200 flex items-center justify-center">
                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                            </div>
                        @endif
                        <div class="image-overlay">
                            <a href="{{ $record->photo ? asset('storage/' . $record->photo) : '#' }}" download="{{ $record->photo }}"
                                class="kt-btn kt-btn-sm kt-btn-primary">
                                <i class="fas fa-download text-sm me-1"></i>
                                <span>{{ __('main.download') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div>
                    <p class="text-sm text-secondary-foreground">{{ __('messages.no_photo_available') }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
