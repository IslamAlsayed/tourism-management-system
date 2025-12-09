@extends('layouts.master')

@section('title', 'Edit Accommodation')

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    Edit Accommodation
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    Update the accommodation details
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('accommodations.index') }}" class="kt-btn kt-btn-outline">
                    Back to Accommodations
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <form action="{{ route('accommodations.update', $accommodation->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid gap-4 lg:gap-6">

                <!-- Basic Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.basic_information') }}</h3>
                    </div>
                    <div class="kt-card-body p-4 pb-0">
                        <div class="grid lg:grid-cols-2 gap-6 mb-4">
                            <!-- Name -->
                            <div class="">
                                <label for="name" class="kt-label required mb-2">{{ __('main.name') }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]" required
                                    value="{{ $accommodation->name }}" placeholder="Enter accommodation name">
                                @error('name')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Name Arabic -->
                            <div class="">
                                <label for="name_ar" class="kt-label required mb-2">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]" required
                                    value="{{ $accommodation->name_ar }}" placeholder="أدخل اسم الإقامة">
                                @error('name_ar')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-3 gap-6 mb-4">
                            <!-- Accommodation Type -->
                            <div class="">
                                <label for="type_id" class="kt-label mb-2 flex items-center justify-between">
                                    <div>{{ __('main.type') }}</div>
                                    <a href="{{ route('types.create') }}"
                                        class="text-blue-600 text-2sm">{{ __('main.add') }}</a>
                                </label>

                                <select name="type_id" id="type_id" class="kt-select" required special-search>
                                    <option value="">--</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}"
                                            {{ $accommodation->type_id == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('type_id')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Classification -->
                            <div class="">
                                <label for="classification" class="kt-label mb-2">{{ __('main.classification') }}</label>
                                <input type="text" name="classification" id="classification" class="kt-input h-[45px]"
                                    value="{{ $accommodation->classification }}" placeholder="e.g., 5 Stars, Luxury">
                                @error('classification')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Stars Rating -->
                            <div class="">
                                <label for="stars" class="kt-label mb-2">{{ __('main.star_rating') }}</label>
                                <select name="stars" id="stars" class="kt-select" special-search>
                                    <option value="">--</option>
                                    <option value="1" {{ $accommodation->stars == 1 ? 'selected' : '' }}>1 Star</option>
                                    <option value="2" {{ $accommodation->stars == 2 ? 'selected' : '' }}>2 Stars</option>
                                    <option value="3" {{ $accommodation->stars == 3 ? 'selected' : '' }}>3 Stars</option>
                                    <option value="4" {{ $accommodation->stars == 4 ? 'selected' : '' }}>4 Stars</option>
                                    <option value="5" {{ $accommodation->stars == 5 ? 'selected' : '' }}>5 Stars</option>
                                </select>
                                @error('stars')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-3 gap-6 mb-4">
                            <!-- Season -->
                            <div class="">
                                <label for="season_id" class="kt-label mb-2">{{ __('main.season') }}</label>
                                <select name="season_id" id="season_id" class="kt-select" special-search>
                                    <option value="">--</option>
                                    @foreach ($seasons as $season)
                                        <option value="{{ $season->id }}"
                                            {{ $accommodation->season_id == $season->id ? 'selected' : '' }}>
                                            {{ $season->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('season_id')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Room -->
                            <div class="">
                                <label for="room_id" class="kt-label mb-2">{{ __('main.room') }}</label>
                                <select name="room_id" id="room_id" class="kt-select" special-search>
                                    <option value="">--</option>
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}"
                                            {{ $accommodation->room_id == $room->id ? 'selected' : '' }}>
                                            {{ $room->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('room_id')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Meal -->
                            <div class="">
                                <label for="meal_id" class="kt-label mb-2">{{ __('main.meal') }}</label>
                                <select name="meal_id" id="meal_id" class="kt-select" special-search>
                                    <option value="">--</option>
                                    @foreach ($meals as $meal)
                                        <option value="{{ $meal->id }}"
                                            {{ $accommodation->meal_id == $meal->id ? 'selected' : '' }}>
                                            {{ $meal->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('meal_id')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Description --}}
                        @include('components.elements.input-text-editor', [
                            'name' => 'description',
                            'value' => $accommodation->description,
                        ])
                    </div>
                </div>

                <!-- Location Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">Location Information</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
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
                                            {{ $accommodation->currency_id == $currency->id ? 'selected' : '' }}>
                                            {{ $currency->code }} - {{ $currency->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('currency_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Regions [region, subregion, country, state, city] --}}
                            @include('components.regions.edit', [
                                'levels' => ['region', 'subregion', 'country', 'state', 'city'],
                                'multiple' => false,
                                'record' => $accommodation,
                            ])
                        </div>

                        <div class="grid lg:grid-cols-3 gap-6">
                            <!-- Street Address -->
                            <div class="">
                                <label for="street" class="kt-label mb-2">Street Address</label>
                                <input type="text" name="street" id="street" class="kt-input"
                                    value="{{ $accommodation->street }}" placeholder="Enter street address">
                                @error('street')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Latitude -->
                            <div class="">
                                <label for="latitude" class="kt-label mb-2">Latitude</label>
                                <input type="number" name="latitude" id="latitude" step="0.0000001" class="kt-input"
                                    value="{{ $accommodation->latitude }}" placeholder="e.g., 31.2001">
                                @error('latitude')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Longitude -->
                            <div class="">
                                <label for="longitude" class="kt-label mb-2">Longitude</label>
                                <input type="number" name="longitude" id="longitude" step="0.0000001" class="kt-input"
                                    value="{{ $accommodation->longitude }}" placeholder="e.g., 29.9187">
                                @error('longitude')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Timezone -->
                            <div class="">
                                <label for="timezone_id" class="kt-label mb-2">{{ __('main.timezone') }}</label>
                                <select name="timezone_id" id="timezone_id" class="kt-select h-[45px]" special-search>
                                    <option value="">--</option>
                                    @foreach ($timezones as $zone)
                                        <option value="{{ $zone['id'] }}"
                                            {{ $accommodation->timezone_id == $zone['id'] ? 'selected' : '' }}>
                                            {{ app()->getLocale() == 'ar' ? ($zone['name_ar'] ? $zone['name_ar'] . ' ' : '') : ($zone['name'] ? $zone['name'] . ' ' : '') }}({{ $zone['abbreviation'] }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('timezone_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">Contact Information</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid lg:grid-cols-2 gap-6 mb-4">
                            <!-- General Mobile -->
                            <div class="">
                                <label for="general_mobile" class="kt-label mb-2">General Mobile</label>
                                <input type="tel" name="general_mobile" id="general_mobile" class="kt-input"
                                    value="{{ $accommodation->general_mobile }}" placeholder="+1234567890">
                                @error('general_mobile')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- General Email -->
                            <div class="">
                                <label for="general_email" class="kt-label mb-2">General Email</label>
                                <input type="email" name="general_email" id="general_email" class="kt-input"
                                    value="{{ $accommodation->general_email }}" placeholder="info@accommodation.com">
                                @error('general_email')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6 mb-4">
                            <!-- Phone -->
                            <div class="">
                                <label for="phone" class="kt-label mb-2">Phone</label>
                                <input type="tel" name="phone" id="phone" class="kt-input"
                                    value="{{ $accommodation->phone }}" placeholder="+1234567890">
                                @error('phone')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Website -->
                            <div class="">
                                <label for="website" class="kt-label mb-2">Website</label>
                                <input type="url" name="website" id="website" class="kt-input"
                                    value="{{ $accommodation->website }}" placeholder="https://www.accommodation.com">
                                @error('website')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Contact Person Details -->
                        <div class="border-t pt-4 mt-4">
                            <h4 class="text-lg font-medium mb-4">Contact Person</h4>
                            <div class="grid lg:grid-cols-2 gap-6 mb-4">
                                <div class="">
                                    <label for="contact_person" class="kt-label mb-2">Contact Person Name</label>
                                    <input type="text" name="contact_person" id="contact_person" class="kt-input"
                                        value="{{ $accommodation->contact_person }}" placeholder="John Doe">
                                    @error('contact_person')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="">
                                    <label for="contact_position" class="kt-label mb-2">Position</label>
                                    <input type="text" name="contact_position" id="contact_position" class="kt-input"
                                        value="{{ $accommodation->contact_position }}" placeholder="Manager">
                                    @error('contact_position')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid lg:grid-cols-2 gap-6">
                                <div class="">
                                    <label for="contact_mobile" class="kt-label mb-2">Contact Mobile</label>
                                    <input type="tel" name="contact_mobile" id="contact_mobile" class="kt-input"
                                        value="{{ $accommodation->contact_mobile }}" placeholder="+1234567890">
                                    @error('contact_mobile')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="">
                                    <label for="contact_email" class="kt-label mb-2">Contact Email</label>
                                    <input type="email" name="contact_email" id="contact_email" class="kt-input"
                                        value="{{ $accommodation->contact_email }}" placeholder="manager@accommodation.com">
                                    @error('contact_email')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Settings -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">Additional Settings</h3>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 p-4">
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="is_active" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'is_active',
                                'id' => 'is_active',
                                'value' => '1',
                                'checked' => $accommodation->is_active,
                                'label' => __('main.active'),
                            ])
                        </div>
                    </div>
                </div>

                {{-- Update Buttons --}}
                @include('components.elements.update-submit', ['models' => 'accommodations'])
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            setTimeout(() => {
                filterByForeignId("region_id", "subregion", "subregion_id","edit");
                filterByForeignId("subregion_id", "country", "country_id","edit");
                filterByForeignId("country_id", "state", "state_id","edit");
                filterByForeignId("state_id", "city", "city_id","edit");
            }, 500);
        });
    </script>
@endpush

@include('components.regions.script-cascading')
