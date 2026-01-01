@props([
    'column' => 'image',
    'columnName' => null,
    'modelKey' => null,
    'record' => null,
])

@php
    $photoUrl = isset($record) && $record && checkExistFile($record->photo) ? asset('storage/' . $record->photo) : '';
@endphp

<div class="text-center mb-4">
    <div class="inline-block mb-4">
        <div class="relative flex justify-center">
            @php
                $classes =
                    isset($photoUrl) && $photoUrl
                        ? 'rounded-[9px] bg-secondary-light border-4 border-white shadow-lg mx-auto mb-4 overflow-hidden'
                        : 'image-character';
            @endphp

            <div class="w-[120px] h-[120px] {{ $classes }} photo-preview">

                @if ($photoUrl)
                    <img id="{{ $column ?? 'photo' }}" src="{{ $photoUrl }}" class="w-full h-full object-cover">
                @elseif(isset($modelKey) && $modelKey)
                    <span class="pb-2">
                        {{ env('CHARACTER_LENGTH', 1) == 2
                            ? ($modelKey[1]
                                ? strtoupper($modelKey[0]) . lcfirst($modelKey[1])
                                : strtoupper($modelKey[0]))
                            : strtoupper($modelKey[0]) }}
                    </span>
                @else
                    <img id="{{ $column ?? 'photo' }}" src="{{ asset('metronic/media/avatars/blank.png') }}"
                        class="w-full h-full object-cover">
                @endif
            </div>

            {{-- 
            @if (isset($photoUrl) && $photoUrl)
                <div
                    class="w-[120px] h-[120px] rounded-[9px] bg-secondary-light border-4 border-white shadow-lg mx-auto mb-4 overflow-hidden photo-preview">

                    <img id="{{ $column ?? 'photo' }}" src="{{ $photoUrl }}" class="w-full h-full object-cover">

                </div>
            @elseif(isset($modelKey) && $modelKey)
                <div class="w-[120px] h-[120px] image-character">
                    <span class="pb-2">
                        {{ env('CHARACTER_LENGTH', 1) == 2
                            ? ($modelKey[1]
                                ? lcfirst($modelKey[0]) . lcfirst($modelKey[1])
                                : lcfirst($modelKey[0]))
                            : lcfirst($modelKey[0]) }}
                    </span>
                </div>
            @else
                <div
                    class="w-[120px] h-[120px] rounded-[9px] bg-secondary-light border-4 border-white shadow-lg mx-auto mb-4 overflow-hidden photo-preview">
                    <img id="{{ $column ?? 'photo' }}" src="{{ asset('metronic/media/avatars/blank.png') }}"
                        class="w-full h-full object-cover">
                </div>
            @endif --}}

            <label for="photo"
                class="absolute bg-primary text-white rounded-full p-2 cursor-pointer hover:bg-primary-dark"
                style="right: 25%; bottom: -10px; padding-inline: 12px">
                <i class="fas fa-camera text-sm"></i>
            </label>
        </div>

        <input type="file" id="photo" name="photo" class="hidden" accept="image/*">

        <div class="text-sm text-secondary-foreground mt-4">
            {{ __('main.upload_type', ['type' => __('main.' . $column)]) . ' ' . __('main.' . $columnName ?? 'photo') }}
        </div>
        @error('photo')
            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>
</div>

@push('scripts')
    <script>
        // Photo preview
        document.getElementById('photo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    let photoPreview = document.querySelector('.photo-preview');
                    photoPreview.classList.remove('image-character');
                    let img = document.createElement('img');
                    img.src = e.target.result;
                    photoPreview.innerHTML = '';
                    photoPreview.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush
