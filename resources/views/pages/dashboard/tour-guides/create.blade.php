@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.tour-guide')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.tour-guide')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.tour-guide')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('tour-guides.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tour-guides')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
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
                        @include('components.input-image', [
                            'column' => 'tour-guide',
                            'columnName' => 'photo',
                        ])

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            <!-- Name (Arabic) -->
                            <div class="">
                                <label for="name_ar"
                                    class="kt-label mb-2">{{ __('main.type_name_arabic', ['type' => __('main.tour-guide')]) }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
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
                                <label for="email" class="kt-label required mb-2">{{ __('main.email') }}</label>
                                <input type="email" name="email" id="email" class="kt-input h-[45px]" required
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

                            <!-- Mobile 02 -->
                            <div class="">
                                <label for="mobile_02" class="kt-label mb-2">{{ __('main.mobile_02') }}</label>
                                <input type="text" name="mobile_02" id="mobile_02" class="kt-input h-[45px]"
                                    max="2" value="{{ old('mobile_02') }}">
                                @error('mobile_02')
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
                                <label for="gender" class="kt-label required mb-2">{{ __('main.gender') }}</label>
                                <select name="gender" id="gender" class="kt-select h-[45px]" special-search required>
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

                            <!-- Currency -->
                            <div class="">
                                <label for="currency_id" class="kt-label mb-2 flex items-center justify-between">
                                    {{ __('main.currency') }}
                                    <a href="{{ route('currencies.create') }}" class="text-blue-600 text-2sm">
                                        {{ __('main.add') }}
                                    </a>
                                </label>
                                <select name="currency_id" id="currency_id" class="kt-select h-[45px]" special-search>
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

                            <!-- Guide languages -->
                            <div class="">
                                <label for="languages_ids" class="kt-label mb-2 flex items-center justify-between">
                                    {{ __('main.language') }}
                                </label>
                                <select name="languages_ids[]" id="languages_ids" class="kt-select h-[45px]"
                                    special-multiple>
                                    <option value="">--</option>
                                    @foreach ($languages_ids as $id => $language)
                                        <option value="{{ $id }}">
                                            {{ getCurrentLocale() == 'ar' ? $language['name_ar'] : $language['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('languages_ids')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Guide Type -->
                            <div class="">
                                <label for="guide_type_id"
                                    class="kt-label required mb-2">{{ __('main.guide_type') }}</label>
                                <select name="guide_type_id" id="guide_type_id" class="kt-input h-[45px]"
                                    special-multiple data-current-value="{{ $tourGuide->guide_type_id ?? 1 }}" required>
                                    <option value="">--</option>
                                    @foreach ($guideTypes as $type)
                                        <option value="{{ $type->id }}"
                                            {{ old('guide_type_id') == $type->id ? 'selected' : '' }}>
                                            {{ $type->type }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('guide_type_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Regions [region, subregion, country, state, city] --}}
                            @include('components.regions.create', [
                                'levels' => ['region', 'subregion', 'country', 'state', 'city'],
                                'multiple' => true,
                            ])

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
                                <input type="number" name="fd_day_fees" id="fd_day_fees" class="kt-input h-[45px]"
                                    value="{{ old('fd_day_fees') }}">
                                @error('fd_day_fees')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- hd Day Fees -->
                            <div class="">
                                <label for="hd_day_fees" class="kt-label mb-2">{{ __('main.hd_day_fees') }}</label>
                                <input type="number" name="hd_day_fees" id="hd_day_fees" class="kt-input h-[45px]"
                                    value="{{ old('hd_day_fees') }}">
                                @error('hd_day_fees')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Extra Fees 1 -->
                            <div class="">
                                <label for="extra_fees_1" class="kt-label mb-2">{{ __('main.extra_fees_1') }}</label>
                                <input type="number" name="extra_fees_1" id="extra_fees_1" class="kt-input h-[45px]"
                                    value="{{ old('extra_fees_1') }}">
                                @error('extra_fees_1')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Extra Fees 2 -->
                            <div class="">
                                <label for="extra_fees_2" class="kt-label mb-2">{{ __('main.extra_fees_2') }}</label>
                                <input type="number" name="extra_fees_2" id="extra_fees_2" class="kt-input h-[45px]"
                                    value="{{ old('extra_fees_2') }}">
                                @error('extra_fees_2')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Notes -->
                        @include('components.elements.input-text-editor', [
                            'column' => 'notes',
                            'value' => old('notes'),
                        ])

                        <!-- Tour guide Settings -->
                        <div class="space-y-4 mb-4">
                            <h4 class="font-semibold mb-2">
                                {{ __('main.type_settings', ['type' => __('main.tour-guide')]) }}
                            </h4>

                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="status" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'status',
                                        'id' => 'status',
                                        'value' => '1',
                                        'checked' => old('status'),
                                        'label' => __('main.status'),
                                    ])
                                </div>
                            </div>
                        </div>

                        <!-- Save Submit Buttons -->
                        @include('components.elements.save-submit', ['models' => 'tour-guides'])
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
                                <div class="mb-2 font-semibold">{{ __('main.geographic_coordinates') }}</div>
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

                        <div class="flex items-center gap-3">
                            <div class="bg-warning-light rounded-full p-2">
                                <i class="ki-filled ki-flag text-warning"></i>
                            </div>
                            <div>
                                <div class="font-semibold">
                                    {{ __('main.type_selection', ['type' => __('main.guide_type')]) }}</div>
                                <div class="text-sm text-secondary-foreground">
                                    {{ __('main.must_select_type1_before_creating_type2', ['type1' => __('main.guide_type'), 'type2' => __('main.tour-guide')]) }}
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
        document.addEventListener("DOMContentLoaded", () => {
            setTimeout(() => {
                filterByForeignId("region_id", "subregion", "subregion_id");
                filterByForeignId("subregion_id", "country", "country_id");
                filterByForeignId("country_id", "state", "state_id");
                filterByForeignId("state_id", "city", "city_id");
            }, 500);
        });
    </script>
@endpush

@include('components.regions.script-cascading')
