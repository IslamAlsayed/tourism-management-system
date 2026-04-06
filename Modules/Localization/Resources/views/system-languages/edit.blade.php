@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.language')]))

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.language')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.language')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.localization.languages.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.languages')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="container-fixed">
        <div class="grid gap-5 lg:gap-6">
            <!-- Language Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.basic_language_info') }}</h3>
                </div>
                <div class="kt-card-body">
                    <form method="POST" action="{{ route('dashboard.localization.system-languages.update', $language->id) }}"
                        enctype="multipart/form-data" class="space-y-6 p-4">
                        @csrf
                        @method('PUT')

                        <!-- Languages Photo -->
                        <div class="flex flex-col flex-wrap items-center gap-4 mb-4">
                            @include('components.input-image', [
                                'modelKey' => $language->code ?? 'C',
                                'column' => 'languages',
                                'columnName' => 'photo',
                                'record' => $language,
                            ])
                            <input type="hidden" name="selected_flag" id="selected_flag">
                            <button type="button" class="btn btn-sm btn-light-primary" data-kt-modal-toggle="#flags_modal">
                                <i class="fa-duotone fa-solid fa-image"></i> {{ __('main.choose_from_media') }}
                            </button>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            <!-- Language Code -->
                            <div class="">
                                <label for="code" class="kt-label mb-2">{{ __('main.code') }}</label>
                                <input type="text" name="code" id="code" class="kt-input h-[45px]" min="2"
                                    value="{{ $language->code }}">
                                @error('code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Language Name (Arabic) -->
                            <div class="">
                                <label for="name_ar" class="kt-label mb-2">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
                                    value="{{ $language->name_ar }}">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Language Name -->
                            <div class="">
                                <label for="name" class="kt-label mb-2">{{ __('main.name') }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]"
                                    value="{{ $language->name }}">
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Native Name -->
                            <div class="">
                                <label for="native" class="kt-label mb-2">{{ __('main.native_name') }}</label>
                                <input type="text" name="native" id="native" class="kt-input h-[45px]" placeholder="e.g. العربية"
                                    value="{{ $language->native }}">
                                @error('native')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Language Direction -->
                            <div class="">
                                <label for="dir" class="kt-label required mb-2">{{ __('main.direction') }}</label>
                                <select name="dir" id="dir" class="kt-select h-[45px]" required>
                                    <option value="ltr" {{ $language->dir == 'ltr' ? 'selected' : '' }}>Left to Right (LTR)</option>
                                    <option value="rtl" {{ $language->dir == 'rtl' ? 'selected' : '' }}>Right to Left (RTL)</option>
                                </select>
                                @error('dir')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Update Submit Buttons -->
                        @include('components.elements.update-submit', [
                            'models' => 'system-languages',
                            'cancel_route' => route('dashboard.localization.system-languages.index'),
                        ])
                    </form>
                </div>
            </div>

            <!-- Quick Info -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.important_information') }}</h3>
                </div>
                <div class="kt-card-body p-2">
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-primary-light rounded-full p-2">
                                <i class="fa-duotone fa-solid fa-circle-info text-primary"></i>
                            </div>
                            <div>
                                <div class="mb-2 font-semibold">{{ __('main.ensure_data_accuracy') }}</div>
                                <div class="text-sm text-secondary-foreground">
                                    {{ __('main.geographic_coordinates') }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-success-light rounded-full p-2">
                                <i class="fa-duotone fa-solid fa-location-dot text-success"></i>
                            </div>
                            <div>
                                <div class="mb-2 font-semibold">{{ __('main.geographic_coordinates') }}</div>
                                <div class="text-sm text-secondary-foreground">
                                    {{ __('main.use_map_services') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Flags Modal -->
    <div class="kt-modal" data-kt-modal="true" id="flags_modal">
        <div class="kt-modal-content max-w-[600px]">
            <div class="kt-modal-header py-4 px-5 border-b border-border">
                <h3 class="font-bold text-lg">{{ __('main.choose_from_media') }}</h3>
                <button class="kt-btn kt-btn-sm kt-btn-icon kt-btn-dim shrink-0" data-kt-modal-dismiss="true">
                    <i class="fa-duotone fa-solid fa-xmark"></i>
                </button>
            </div>
            
            <!-- Sticky Search Box -->
            <div class="px-5 py-3 border-b border-border bg-background/95 backdrop-blur-sm sticky-top z-10">
                <div class="relative">
                    <i class="fa-duotone fa-solid fa-magnifying-glass absolute rtl:right-3 ltr:left-3 top-1/2 -translate-y-1/2 text-muted-foreground"></i>
                    <input type="text" id="flagSearchInput" class="kt-input rtl:pr-10 ltr:pl-10 w-full" placeholder="{{ __('main.search') }}...">
                </div>
            </div>

            <div class="kt-modal-body p-5 max-h-[60vh] overflow-y-auto relative">
                <div class="grid grid-cols-4 sm:grid-cols-6 lg:grid-cols-8 gap-3" id="flagsContainer">
                    @foreach($flags as $flag)
                        <div class="flex flex-col items-center justify-center p-3 border border-gray-100 rounded-xl hover:bg-gray-50 hover:border-gray-200 hover:shadow-sm cursor-pointer flag-selector transition-all duration-200" data-flag="{{ $flag }}">
                            <img src="{{ asset('assets/media/flags/' . $flag) }}" alt="{{ Str::beforeLast($flag, '.') }}" title="{{ Str::beforeLast($flag, '.') }}" class="w-10 h-10 rounded-full mb-2 object-cover border border-gray-200 shadow-sm">
                            <span class="text-[11px] text-center text-gray-500 font-medium truncate w-full" title="{{ Str::beforeLast($flag, '.') }}">{{ Str::beforeLast($flag, '.') }}</span>
                        </div>
                    @endforeach
                </div>
                <!-- No Results Message -->
                <div id="noFlagsFound" class="hidden flex-col items-center justify-center py-12 text-gray-400">
                    <i class="fa-duotone fa-solid fa-magnifying-glass text-5xl mb-4 opacity-50"></i>
                    <p class="text-base font-medium">{{ __('main.no_results_found') }}</p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Flag search functionality
            const searchInput = document.getElementById('flagSearchInput');
            const flagItems = document.querySelectorAll('.flag-selector');
            const noResults = document.getElementById('noFlagsFound');

            if (searchInput) {
                searchInput.addEventListener('input', function(e) {
                    const term = e.target.value.toLowerCase();
                    let hasVisible = false;

                    flagItems.forEach(item => {
                        const flagName = item.getAttribute('data-flag').toLowerCase();
                        if (flagName.includes(term)) {
                            item.style.display = 'flex';
                            hasVisible = true;
                        } else {
                            item.style.display = 'none';
                        }
                    });

                    if (noResults) {
                        noResults.classList.toggle('hidden', hasVisible);
                        noResults.classList.toggle('flex', !hasVisible);
                    }
                });
                
                // Focus search input when modal opens
                const flagsModal = document.getElementById('flags_modal');
                if (flagsModal) {
                    flagsModal.addEventListener('shown.kt.modal', function () {
                        setTimeout(() => { searchInput.focus(); }, 100);
                    });
                }
            }

            document.querySelectorAll('.flag-selector').forEach(function(el) {
                el.addEventListener('click', function() {
                    var flag = this.getAttribute('data-flag');
                    var flagUrl = "{{ asset('assets/media/flags') }}/" + flag;
                    
                    // Set the hidden input value
                    var selectedFlagInput = document.getElementById('selected_flag');
                    if(selectedFlagInput) {
                        selectedFlagInput.value = flag;
                    }
                    
                    // Clear the file input
                    var photoInput = document.getElementById('photo');
                    if(photoInput) {
                        photoInput.value = '';
                    }
                    
                    // Update the preview
                    var photoPreview = document.querySelector('.photo-preview');
                    if(photoPreview) {
                        photoPreview.classList.remove('image-character');
                        photoPreview.innerHTML = '<img id="photo" src="' + flagUrl + '" class="w-full h-full object-cover">';
                    }
                    
                    // Close the modal
                    var modalEl = document.getElementById('flags_modal');
                    if (modalEl && typeof KTModal !== 'undefined') {
                        var modal = KTModal.getInstance(modalEl);
                        if (modal) {
                            modal.hide();
                        }
                    }
                });
            });
            
            // Also if user selects a file, clear the selected_flag
            var photoInput = document.getElementById('photo');
            if(photoInput) {
                photoInput.addEventListener('change', function() {
                    var selectedFlagInput = document.getElementById('selected_flag');
                    if(selectedFlagInput) {
                        selectedFlagInput.value = '';
                    }
                });
            }
        });
    </script>
    @endpush
@endsection
