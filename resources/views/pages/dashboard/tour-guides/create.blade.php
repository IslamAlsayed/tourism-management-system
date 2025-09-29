@extends('layouts.master')

@section('title', __('main.add_type', ['type' => __('main.tour-guide')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.add_type', ['type' => __('main.tour-guide')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.add_type_description', ['type' => __('main.tour-guide')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('countries.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['type' => __('main.tour-guide')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-5 lg:gap-7.5">
            <!-- Tour Guide Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.tour-guide')]) }}</h3>
                </div>
                <div class="kt-card-body">
                    <form method="POST" action="{{ route('tour-guides.store') }}" enctype="multipart/form-data"
                        class="space-y-6 p-4">
                        @csrf

                        <!-- Tour guide Photo -->
                        @include('components.input-image', ['columnName' => 'tour-guide'])

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-4">
                            <!-- Name (Arabic) -->
                            <div class="">
                                <label for="name_ar"
                                    class="kt-label required mb-2">{{ __('main.type_name_arabic', ['type' => __('main.tour-guide')]) }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]" required
                                    value="{{ old('name_ar') }}">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Name (English) -->
                            <div class="">
                                <label for="name"
                                    class="kt-label required mb-2">{{ __('main.type_name_english', ['type' => __('main.tour-guide')]) }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]" required
                                    value="{{ old('name') }}">
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="">
                                <label for="email" class="kt-label mb-2">{{ __('main.email') }}</label>
                                <input type="email" name="email" id="email" class="kt-input h-[45px]"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Mobile 01 -->
                            <div class="">
                                <label for="mobile_01" class="kt-label required mb-2">{{ __('main.mobile_01') }}</label>
                                <input type="text" name="mobile_01" id="mobile_01" class="kt-input h-[45px]"
                                    max="2" required value="{{ old('mobile_01') }}">
                                @error('mobile_01')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Mobile 01 -->
                            <div class="">
                                <label for="mobile_01" class="kt-label required mb-2">{{ __('main.mobile_01') }}</label>
                                <input type="text" name="mobile_01" id="mobile_01" class="kt-input h-[45px]"
                                    max="2" required value="{{ old('mobile_01') }}">
                                @error('mobile_01')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Home City -->
                            <div class="">
                                <label for="home_city" class="kt-label mb-2">{{ __('main.home_city') }}</label>
                                <input type="text" name="home_city" id="home_city" class="kt-input h-[45px]"
                                    max="3" value="{{ old('home_city') }}">
                                @error('home_city')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Birth Year -->
                            <div class="">
                                <label for="birth_year" class="kt-label mb-2">{{ __('main.birth_year') }}</label>
                                <input type="birth_year" name="birth_year" id="birth_year" class="kt-input h-[45px]"
                                    value="{{ old('birth_year') }}">
                                @error('birth_year')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Gender -->
                            <div class="">
                                <label for="gender" class="kt-label mb-2">{{ __('main.gender') }}</label>
                                <select name="gender" id="gender" class="kt-select h-[45px]">
                                    <option value="">--</option>
                                    <option value="male">male</option>
                                    <option value="female">female</option>
                                </select>
                                @error('gender')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- National Guide ID -->
                            <div class="">
                                <label for="national_guide_id"
                                    class="kt-label mb-2">{{ __('main.national_guide_id') }}</label>
                                <input type="number" name="national_guide_id" id="national_guide_id"
                                    class="kt-input h-[45px]" value="{{ old('national_guide_id') }}">
                                @error('national_guide_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Country -->
                            <div class="">
                                <label for="country_id" class="kt-label mb-2">{{ __('main.country') }}</label>
                                <select name="country_id" id="country_id" class="kt-select h-[45px]">
                                    <option value="">--</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}"
                                            {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }} {{ $country->name_ar ? ' - ' . $country->name_ar : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Currency -->
                            <div class="">
                                <label for="currency_id" class="kt-label mb-2">{{ __('main.currency') }}</label>
                                <select name="currency_id" id="currency_id" class="kt-select h-[45px]">
                                    <option value="">--</option>
                                    @foreach ($currencies as $currency)
                                        <option value="{{ $currency->id }}"
                                            {{ old('currency_id') == $currency->id ? 'selected' : '' }}>
                                            {{ $currency->code }} - {{ $currency->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('currency_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Guide Type -->
                            <div class="">
                                <label for="guide_type" class="kt-label mb-2">{{ __('main.guide_type') }}</label>
                                <input type="number" name="guide_type" id="guide_type" class="kt-input h-[45px]"
                                    value="{{ old('guide_type') }}">
                                @error('guide_type')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tourism Ministry Code -->
                            <div class="">
                                <label for="tourism_ministry_code"
                                    class="kt-label mb-2">{{ __('main.tourism_ministry_code') }}</label>
                                <input type="number" name="tourism_ministry_code" id="tourism_ministry_code"
                                    class="kt-input h-[45px]" value="{{ old('tourism_ministry_code') }}">
                                @error('tourism_ministry_code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- hd Day Fees -->
                            <div class="">
                                <label for="fd_day_fees" class="kt-label mb-2">{{ __('main.fd_day_fees') }}</label>
                                <input type="text" name="fd_day_fees" id="fd_day_fees" class="kt-input h-[45px]"
                                    value="{{ old('fd_day_fees') }}">
                                @error('fd_day_fees')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- hd Day Fees -->
                            <div class="">
                                <label for="hd_day_fees" class="kt-label mb-2">{{ __('main.hd_day_fees') }}</label>
                                <input type="text" name="hd_day_fees" id="hd_day_fees" class="kt-input h-[45px]"
                                    value="{{ old('hd_day_fees') }}">
                                @error('hd_day_fees')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Extra Fees 1 -->
                            <div class="">
                                <label for="extra_fees_1" class="kt-label mb-2">{{ __('main.extra_fees_1') }}</label>
                                <input type="text" name="extra_fees_1" id="extra_fees_1" class="kt-input h-[45px]"
                                    value="{{ old('extra_fees_1') }}">
                                @error('extra_fees_1')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Extra Fees 2 -->
                            <div class="">
                                <label for="extra_fees_2" class="kt-label mb-2">{{ __('main.extra_fees_2') }}</label>
                                <input type="text" name="extra_fees_2" id="extra_fees_2" class="kt-input h-[45px]"
                                    value="{{ old('extra_fees_2') }}">
                                @error('extra_fees_2')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6 mb-4">
                            <!-- Notes -->
                            <div class="">
                                <label for="notes" class="kt-label mb-2">{{ __('main.notes') }}</label>
                                <textarea name="notes" id="notes" rows="4" class="kt-input h-[45px]">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tour guide Settings -->
                        <div class="space-y-4 mb-4">
                            <h4 class="font-semibold mb-2">
                                {{ __('main.type_settings', ['type' => __('main.tour-guide')]) }}</h4>

                            <div class="grid lg:grid-cols-2 gap-4">
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="status" value="0">
                                    <input type="checkbox" name="status" id="status" class="kt-checkbox"
                                        value="1" {{ old('status', '1') ? 'checked' : '' }}>
                                    <label for="status" class="kt-label mb-0">{{ __('main.status') }}</label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center gap-4">
                            <button type="submit" class="kt-btn kt-btn-primary">
                                <i class="ki-filled ki-check text-sm me-2"></i>
                                {{ __('main.save_type', ['type' => __('main.tour-guide')]) }}
                            </button>
                            <button type="submit" name="save_and_add" value="1"
                                class="kt-btn kt-btn-outline kt-btn-outline-primary">
                                <i class="ki-filled ki-plus text-sm me-2"></i>
                                {{ __('main.save_and_add_another') }}
                            </button>
                            <a href="{{ route('tour-guides.index') }}" class="kt-btn kt-btn-outline">
                                {{ __('main.cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Geographic Info -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.geographic_info') }}</h3>
                </div>
                <div class="kt-card-body p-2">
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-primary-light rounded-full p-2">
                                <i class="ki-filled ki-geolocation text-primary"></i>
                            </div>
                            <div>
                                <div class="font-semibold">{{ __('main.geographic_coordinates') }}</div>
                                <div class="text-sm text-secondary-foreground">{{ __('main.coordinates_hint') }}</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-warning-light rounded-full p-2">
                                <i class="ki-filled ki-flag text-warning"></i>
                            </div>
                            <div>
                                <div class="font-semibold">
                                    {{ __('main.type_selection', ['type' => __('main.gender')]) }}</div>
                                <div class="text-sm text-secondary-foreground">
                                    {{ __('main.must_select_type1_before_creating_type2', ['type1' => __('main.gender'), 'type2' => __('main.tour-guide')]) }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-warning-light rounded-full p-2">
                                <i class="ki-filled ki-flag text-warning"></i>
                            </div>
                            <div>
                                <div class="font-semibold">
                                    {{ __('main.type_selection', ['type' => __('main.country')]) }}</div>
                                <div class="text-sm text-secondary-foreground">
                                    {{ __('main.must_select_type1_before_creating_type2', ['type1' => __('main.country'), 'type2' => __('main.tour-guide')]) }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-warning-light rounded-full p-2">
                                <i class="ki-filled ki-flag text-warning"></i>
                            </div>
                            <div>
                                <div class="font-semibold">
                                    {{ __('main.type_selection', ['type' => __('main.currency')]) }}</div>
                                <div class="text-sm text-secondary-foreground">
                                    {{ __('main.must_select_type1_before_creating_type2', ['type1' => __('main.currency'), 'type2' => __('main.tour-guide')]) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Image preview
        document.getElementById('image')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('image-preview');
                    const placeholder = document.getElementById('image-placeholder');
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush
