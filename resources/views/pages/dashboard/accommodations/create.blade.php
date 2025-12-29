@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.accommodation')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.accommodation')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.accommodation')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('accommodations.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.accommodations')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <form action="{{ route('accommodations.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Accommodation Photo --}}
            @include('components.input-image', [
                'column' => 'accommodation',
                'columnName' => 'photo',
            ])

            <div class="grid gap-4 lg:gap-6">
                <!-- Location Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.location')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            {{-- Regions [region, subregion, country, state, city] --}}
                            @include('components.regions.create', [
                                'levels' => ['region', 'subregion', 'country', 'state', 'city'],
                                'multiple' => false,
                            ])

                            {{-- Currency --}}
                            @include('components.selects.currency', [
                                'name' => 'currency_id',
                                'currencies' => $currencies,
                            ])

                            <!-- Street Address -->
                            <div class="align-self-end">
                                <label for="street" class="kt-label">Street Address</label>
                                <input type="text" name="street" id="street" class="kt-input h-[45px]"
                                    value="{{ old('street') }}" placeholder="Enter street address">
                                @error('street')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Latitude -->
                            <div class="align-self-end">
                                <label for="latitude" class="kt-label">Latitude</label>
                                <input type="number" name="latitude" id="latitude" step="0.0000001"
                                    class="kt-input h-[45px]" value="{{ old('latitude') }}" placeholder="e.g., 31.2001">
                                @error('latitude')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Longitude -->
                            <div class="align-self-end">
                                <label for="longitude" class="kt-label">Longitude</label>
                                <input type="number" name="longitude" id="longitude" step="0.0000001"
                                    class="kt-input h-[45px]" value="{{ old('longitude') }}" placeholder="e.g., 29.9187">
                                @error('longitude')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Accommodation Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.accommodation')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid lg:grid-cols-2 gap-6 items-end mb-4">
                            <!-- Name -->
                            <div class="align-self-end">
                                <label for="name" class="kt-label required">
                                    {{ __('main.name') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]" required
                                    value="{{ old('name') }}" placeholder="Enter accommodation name">
                                @error('name')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Name Arabic -->
                            <div class="align-self-end">
                                <label for="name_ar" class="kt-label">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
                                    value="{{ old('name_ar') }}" placeholder="أدخل اسم الإقامة">
                                @error('name_ar')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-3 gap-6 mb-4">
                            <!-- Accommodation Type -->
                            <div class="align-self-end">
                                <label for="type_id" class="kt-label flex items-center justify-between mb-2">
                                    <div>{{ __('main.type') }}</div>
                                    <a href="{{ route('types.create') }}"
                                        class="text-blue-600 text-2sm">{{ __('main.add') }}</a>
                                </label>

                                <select name="type_id" id="type_id" class="kt-select basic-single">
                                    <option value="" disabled selected></option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}"
                                            {{ old('type_id') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('type_id')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Classification -->
                            <div class="align-self-end">
                                <label for="classification" class="kt-label">{{ __('main.classification') }}</label>
                                <input type="text" name="classification" id="classification" class="kt-input h-[45px]"
                                    value="{{ old('classification') }}" placeholder="e.g., 5 Stars, Luxury">
                                @error('classification')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Stars Rating -->
                            <div class="align-self-end">
                                <label for="stars" class="kt-label mb-2">{{ __('main.star_rating') }}</label>
                                <select name="stars" id="stars" class="kt-select basic-single">
                                    <option value="" disabled selected></option>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ old('stars') == $i ? 'selected' : '' }}>
                                            {{ $i . ' ' . ($i > 1 ? __('main.stars') : __('main.star')) }}</option>
                                    @endfor
                                </select>
                                @error('stars')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Description --}}
                        @include('components.elements.input-text-editor', [
                            'name' => 'description',
                            'value' => old('description'),
                            'classes' => 'mb-4',
                        ])

                        {{-- Notes --}}
                        @include('components.elements.input-text-editor', [
                            'name' => 'notes',
                            'value' => old('notes'),
                        ])
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.contact')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid lg:grid-cols-2 gap-6 items-end mb-4">
                            <!-- General Mobile -->
                            <div class="align-self-end">
                                <label for="general_mobile" class="kt-label">General Mobile</label>
                                <input type="tel" name="general_mobile" id="general_mobile"
                                    class="kt-input h-[45px]" value="{{ old('general_mobile') }}"
                                    placeholder="+1234567890">
                                @error('general_mobile')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- General Email -->
                            <div class="align-self-end">
                                <label for="general_email" class="kt-label">General Email</label>
                                <input type="email" name="general_email" id="general_email" class="kt-input h-[45px]"
                                    value="{{ old('general_email') }}" placeholder="info@accommodation.com">
                                @error('general_email')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6 items-end mb-4">
                            <!-- Phone -->
                            <div class="align-self-end">
                                <label for="phone" class="kt-label">Phone</label>
                                <input type="tel" name="phone" id="phone" class="kt-input h-[45px]"
                                    value="{{ old('phone') }}" placeholder="+1234567890">
                                @error('phone')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Website -->
                            <div class="align-self-end">
                                <label for="website" class="kt-label">Website</label>
                                <input type="url" name="website" id="website" class="kt-input h-[45px]"
                                    value="{{ old('website') }}" placeholder="https://www.accommodation.com">
                                @error('website')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Contact Person Details -->
                        <div class="border-t pt-4 mt-4">
                            <h4 class="text-lg font-medium mb-4">Contact Person</h4>
                            <div class="grid lg:grid-cols-2 gap-6 items-end mb-4">
                                <div class="align-self-end">
                                    <label for="contact_person" class="kt-label">Contact Person Name</label>
                                    <input type="text" name="contact_person" id="contact_person"
                                        class="kt-input h-[45px]" value="{{ old('contact_person') }}"
                                        placeholder="John Doe">
                                    @error('contact_person')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="align-self-end">
                                    <label for="contact_position" class="kt-label">Position</label>
                                    <input type="text" name="contact_position" id="contact_position"
                                        class="kt-input h-[45px]" value="{{ old('contact_position') }}"
                                        placeholder="Manager">
                                    @error('contact_position')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid lg:grid-cols-2 gap-6">
                                <div class="align-self-end">
                                    <label for="contact_mobile" class="kt-label">Contact Mobile</label>
                                    <input type="tel" name="contact_mobile" id="contact_mobile"
                                        class="kt-input h-[45px]" value="{{ old('contact_mobile') }}"
                                        placeholder="+1234567890">
                                    @error('contact_mobile')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="align-self-end">
                                    <label for="contact_email" class="kt-label">Contact Email</label>
                                    <input type="email" name="contact_email" id="contact_email"
                                        class="kt-input h-[45px]" value="{{ old('contact_email') }}"
                                        placeholder="manager@accommodation.com">
                                    @error('contact_email')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap" style="gap: 10px 40px;">
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_active',
                            'id' => 'is_active',
                            'value' => '1',
                            'checked' => 1,
                            'label' => __('main.active'),
                        ])
                    </div>
                </div>

                {{-- Seasons Information --}}
                <livewire:morphic-forms.season-form />

                {{-- Rooms Information --}}
                <livewire:morphic-forms.room-form />

                {{-- Meals Information --}}
                <livewire:morphic-forms.meal-form />

                {{-- Supplements Information --}}
                <livewire:morphic-forms.supplement-form />

                {{-- Save Buttons --}}
                @include('components.elements.save-submit', ['models' => 'accommodations'])
            </div>
        </form>
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
