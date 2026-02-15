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
                    data-input="photo" {{ isset($record) && $record ? 'data-preview="preview-photo"' : '' }}>
                    <i class="far fa-cloud-arrow-up text-5xl text-gray-600"></i>
                    <p class="mt-4">{{ __('main.click_or_drag_image_here') }}</p>
                </div>
                <input type="file" id="photo" name="photo" accept="image/*" hidden>

                {{-- Existing photo (edit mode) --}}
                @if (isset($record) && $record && !empty($record->photo) && checkExistFile($record->photo))
                    <input type="hidden" name="remove_photo" id="remove_photo" value="0">

                    <div id="existing-photo" class="relative w-fit mt-8">
                        <img src="{{ asset('storage/' . $record->photo) }}" class="h-32 w-32 rounded">
                        <button type="button" class="remove-existing-photo absolute -top-2 -right-2 bg-danger cursor-pointer text-white w-6 h-6 rounded-full">
                            ×
                        </button>
                    </div>
                    <div id="preview-photo" class="hidden mt-8"></div>
                @else
                    <div id="preview-photo" class="hidden flex flex-wrap gap-4 mt-6"></div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
    @include('components.scripts.drag-drop-images')
@endpush
