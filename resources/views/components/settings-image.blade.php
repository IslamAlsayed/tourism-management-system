<div class="text-center mb-4">
    <div class="flex items-center justify-center gap-7">
        @foreach ($photoUrl as $key => $photo)
            <div class="">
                <div class="relative inline-block">
                    <div
                        class="w-32 h-32 rounded-[9px] bg-secondary-light border-4 border-white shadow-lg mx-auto mb-4 overflow-hidden photo-preview{{ $key == 0 ? 'light' : ($key == 1 ? 'dark' : 'mini') }}">
                        <img id="{{ $column . $key ?? 'photo' }}"
                            src="{{ isset($photo) && $photo ? $photo : asset('metronic/media/avatars/blank.png') }}"
                            alt="" class="w-full h-full object-cover">
                    </div>
                    <label for="{{ $key == 0 ? 'light-photo' : ($key == 1 ? 'dark-photo' : 'mini-photo') }}"
                        style="padding-inline: 12px"
                        class="absolute bottom-0 right-0 bg-primary text-white rounded-full p-2 cursor-pointer hover:bg-primary-dark">
                        <i class="fas fa-camera text-sm"></i>
                    </label>
                    <input type="file"
                        id="{{ $key == 0 ? 'light-photo' : ($key == 1 ? 'dark-photo' : 'mini-photo') }}"
                        name="{{ $key == 0 ? 'app_light_photo' : ($key == 1 ? 'app_dark_photo' : 'app_mini_photo') }}"
                        data-mode="{{ $key == 0 ? 'light' : ($key == 1 ? 'dark' : 'mini') }}" class="hidden"
                        accept="image/*">
                </div>
                <div class="text-sm text-secondary-foreground">
                    {{ __('main.upload_type', ['type' => __('main.' . $column)]) . ' ' . __('main.' . ($key == 0 ? 'light' : ($key == 1 ? 'dark' : 'mini'))) }}
                </div>
            </div>
            @error('photo')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        @endforeach
    </div>
</div>

@push('scripts')
    <script>
        // Photo preview
        let photos = [
            document.getElementById('light-photo'),
            document.getElementById('dark-photo'),
            document.getElementById('mini-photo')
        ];

        photos.forEach(photo => {
            photo.addEventListener('change', function(e) {
                const mode = photo.dataset.mode;
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.querySelector(`.photo-preview${mode} img`).src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endpush
