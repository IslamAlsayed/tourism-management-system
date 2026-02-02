@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.tours.guide')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.tours.guide')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.tours.guide')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('tours.guides.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tours.guides')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <form action="{{ route('tours.guides.update', $tourGuide->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid gap-4 lg:gap-6">

                {{-- Tour Guide Photo --}}
                @include('components.input-image', [
                    'modelKey' => $tourGuide->name ?? 'TG',
                    'column' => 'tour-guide',
                    'columnName' => 'photo',
                    'record' => $tourGuide,
                ])

                <!-- Location Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.location')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        {{-- Regions [country, state, city] --}}
                        <livewire:regions.location-select-base :record="$tourGuide" />

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            {{-- Currency --}}
                            @include('components.selects.currency', ['record' => $tourGuide])
                        </div>
                    </div>
                </div>

                <!-- Tour Guide Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.tours.guide')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            <!-- Name (English) -->
                            <div class="">
                                <label for="name" class="kt-label mb-2">{{ __('main.name') }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]" value="{{ $tourGuide->name }}">
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Name (Arabic) -->
                            <div class="">
                                <label for="name_ar" class="kt-label mb-2">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]" value="{{ $tourGuide->name_ar }}">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="">
                                <label for="email" class="kt-label mb-2">{{ __('main.email') }}</label>
                                <input type="email" name="email" id="email" class="kt-input h-[45px]" value="{{ $tourGuide->email }}">
                                @error('email')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Mobile 01 -->
                            <div class="">
                                <label for="mobile_01" class="kt-label mb-2">{{ __('main.mobile_01') }}</label>
                                <input type="text" name="mobile_01" id="mobile_01" class="kt-input h-[45px]" max="2" value="{{ $tourGuide->mobile_01 }}">
                                @error('mobile_01')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Mobile 02 -->
                            <div class="">
                                <label for="mobile_02" class="kt-label mb-2">{{ __('main.mobile_02') }}</label>
                                <input type="text" name="mobile_02" id="mobile_02" class="kt-input h-[45px]" max="2" value="{{ $tourGuide->mobile_02 }}">
                                @error('mobile_02')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Home City -->
                            <div class="">
                                <label for="home_city" class="kt-label mb-2">{{ __('main.home_city') }}</label>
                                <input type="text" name="home_city" id="home_city" class="kt-input h-[45px]" max="3" value="{{ $tourGuide->home_city }}">
                                @error('home_city')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Birth Year -->
                            <div class="">
                                <label for="birth_year" class="kt-label mb-2">{{ __('main.birth_year') }}</label>
                                <input type="birth_year" name="birth_year" id="birth_year" class="kt-input h-[45px]" value="{{ $tourGuide->birth_year }}">
                                @error('birth_year')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Gender -->
                            <div class="align-self-end">
                                <label for="gender" class="kt-label mb-2">{{ __('main.gender') }}</label>
                                <select name="gender" id="gender" class="kt-select basic-single">
                                    <option value="" disabled></option>
                                    <option value="male" {{ $tourGuide->gender == 'male' ? 'selected' : '' }}>male
                                    </option>
                                    <option value="female" {{ $tourGuide->gender == 'female' ? 'selected' : '' }}>female
                                    </option>
                                </select>
                                @error('gender')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- National Guide ID -->
                            <div class="">
                                <label for="national_guide_id" class="kt-label mb-2">{{ __('main.national_guide_id') }}</label>
                                <input type="number" name="national_guide_id" id="national_guide_id" class="kt-input h-[45px]" value="{{ $tourGuide->national_guide_id }}">
                                @error('national_guide_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Guide languages -->
                            <div class="align-self-end">
                                <label for="language_id" class="kt-label mb-2 flex items-center justify-between">
                                    {{ __('main.language') }}
                                </label>
                                <select name="language_id[]" id="language_id" class="kt-select basic-multiple" multiple>
                                    @foreach ($languages as $language)
                                        <option value="{{ $language->id }}" {{ in_array($language->id, $tourGuide->language_ids) ? 'selected' : '' }}>
                                            {{ getCurrentLocale() == 'ar' ? $language['name_ar'] : $language['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('language_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Guide Type -->
                            <div class="align-self-end">
                                <label for="guide_type_id" class="kt-label mb-2">{{ __('main.guide_type') }}</label>
                                <select name="guide_type_id" id="guide_type_id" class="kt-input basic-single">
                                    <option value="" disabled></option>
                                    @foreach ($guideTypes as $type)
                                        <option value="{{ $type->id }}" {{ $tourGuide->guide_type_id == $type->id ? 'selected' : '' }}>
                                            {{ $type->type }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('guide_type_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tourism Ministry Code -->
                            <div class="">
                                <label for="tourism_ministry_code" class="kt-label mb-2">{{ __('main.tourism_ministry_code') }}</label>
                                <input type="number" name="tourism_ministry_code" id="tourism_ministry_code" class="kt-input h-[45px]" value="{{ $tourGuide->tourism_ministry_code }}">
                                @error('tourism_ministry_code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- hd Day Fees -->
                            <div class="">
                                <label for="fd_day_fees" class="kt-label mb-2">{{ __('main.fd_day_fees') }}</label>
                                <input type="number" name="fd_day_fees" id="fd_day_fees" class="kt-input h-[45px]" value="{{ $tourGuide->fd_day_fees }}">
                                @error('fd_day_fees')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- hd Day Fees -->
                            <div class="">
                                <label for="hd_day_fees" class="kt-label mb-2">{{ __('main.hd_day_fees') }}</label>
                                <input type="number" name="hd_day_fees" id="hd_day_fees" class="kt-input h-[45px]" value="{{ $tourGuide->hd_day_fees }}">
                                @error('hd_day_fees')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Extra Fees 1 -->
                            <div class="">
                                <label for="extra_fees_1" class="kt-label mb-2">{{ __('main.extra_fees_1') }}</label>
                                <input type="number" name="extra_fees_1" id="extra_fees_1" class="kt-input h-[45px]" value="{{ $tourGuide->extra_fees_1 }}">
                                @error('extra_fees_1')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Extra Fees 2 -->
                            <div class="">
                                <label for="extra_fees_2" class="kt-label mb-2">{{ __('main.extra_fees_2') }}</label>
                                <input type="number" name="extra_fees_2" id="extra_fees_2" class="kt-input h-[45px]" value="{{ $tourGuide->extra_fees_2 }}">
                                @error('extra_fees_2')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                @include('components.elements.input-text-editor', [
                    'column' => 'description',
                    'value' => $tourGuide->description,
                ])

                <!-- Notes -->
                @include('components.elements.input-text-editor', [
                    'column' => 'notes',
                    'value' => $tourGuide->notes,
                ])

                <div class="flex flex-wrap" style="gap: 10px 40px;">
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_active',
                            'id' => 'is_active',
                            'value' => '1',
                            'checked' => $tourGuide->is_active,
                            'label' => __('main.active'),
                        ])
                    </div>
                </div>

                {{-- Update Buttons --}}
                @include('components.elements.update-submit', [
                    'models' => 'tours.guides',
                    'model' => 'tour-guide',
                ])
            </div>
        </form>
    </div>
@endsection
