<div class="text-center mb-4">
    <div class="relative inline-block">
        <div
            class="w-32 h-32 rounded-full bg-secondary-light border-4 border-white shadow-lg mx-auto mb-4 overflow-hidden photo-preview">
            <img id="{{ $columnName ?? 'photo' }}"
                src="{{ isset($photoUrl) ? asset('storage/' . $photoUrl) : asset('metronic/media/avatars/blank.png') }}"
                alt="" class="w-full h-full object-cover">
        </div>
        <label for="photo"
            class="absolute bottom-0 right-0 bg-primary text-white rounded-full p-2 cursor-pointer hover:bg-primary-dark"
            style="padding-inline: 12px">
            <i class="fas fa-camera text-sm"></i>
        </label>
        <input type="file" id="photo" name="photo" class="hidden" accept="image/*">
    </div>
    <div class="text-sm text-secondary-foreground">
        {{ __('main.upload_type', ['type' => __('main.' . $columnName)]) . ' ' . __('main.photo') }}
    </div>
    @error('photo')
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>

@push('scripts')
    <script>
        // Photo preview
        document.getElementById('photo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('.photo-preview img').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush
