@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.accommodation')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.accommodation')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.accommodation')]) }}
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
                            <div class="align-self-end">
                                <label for="name" class="kt-label">{{ __('main.name') }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]"
                                    value="{{ $accommodation->name }}" placeholder="Enter accommodation name">
                                @error('name')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Name Arabic -->
                            <div class="align-self-end">
                                <label for="name_ar" class="kt-label">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
                                    value="{{ $accommodation->name_ar }}" placeholder="أدخل اسم الإقامة">
                                @error('name_ar')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-3 gap-6 mb-4">
                            <!-- Type -->
                            <div class="align-self-end">
                                <label for="type_id" class="kt-label flex items-center justify-between mb-2">
                                    <div>{{ __('main.type') }}</div>
                                    <a href="{{ route('types.create') }}"
                                        class="text-blue-600 text-2sm">{{ __('main.add') }}</a>
                                </label>

                                <select name="type_id" id="type_id" class="kt-select basic-single">
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
                            <div class="align-self-end">
                                <label for="classification" class="kt-label">{{ __('main.classification') }}</label>
                                <input type="text" name="classification" id="classification" class="kt-input h-[45px]"
                                    value="{{ $accommodation->classification }}" placeholder="e.g., 5 Stars, Luxury">
                                @error('classification')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Stars Rating -->
                            <div class="align-self-end">
                                <label for="stars" class="kt-label mb-2">{{ __('main.star_rating') }}</label>
                                <select name="stars" id="stars" class="kt-select basic-single">
                                    <option value="1" {{ $accommodation->stars == 1 ? 'selected' : '' }}>1 Star
                                    </option>
                                    <option value="2" {{ $accommodation->stars == 2 ? 'selected' : '' }}>2 Stars
                                    </option>
                                    <option value="3" {{ $accommodation->stars == 3 ? 'selected' : '' }}>3 Stars
                                    </option>
                                    <option value="4" {{ $accommodation->stars == 4 ? 'selected' : '' }}>4 Stars
                                    </option>
                                    <option value="5" {{ $accommodation->stars == 5 ? 'selected' : '' }}>5 Stars
                                    </option>
                                </select>
                                @error('stars')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-3 gap-6 mb-4">
                            <!-- Seasons (Multiple Selection) -->
                            <div class="align-self-end">
                                <label for="season_ids" class="kt-label flex items-center justify-between mb-2">
                                    {{ __('main.seasons') }}
                                    <a href="{{ route('seasons.create') }}" class="text-blue-600 text-2sm">
                                        {{ __('main.add') }}
                                    </a>
                                </label>

                                <select name="season_ids[]" id="season_ids" class="kt-select basic-multiple"
                                    multiple="multiple">
                                    @foreach ($seasons as $season)
                                        <option value="{{ $season->id }}"
                                            {{ in_array($season->id, array_column($seasonsSelected, 'id')) ? 'selected' : '' }}>
                                            {{ $season->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('season_ids')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Room -->
                            <div class="align-self-end">
                                <label for="room_ids" class="kt-label flex items-center justify-between mb-2">
                                    {{ __('main.rooms') }}
                                    <a href="{{ route('rooms.create') }}" class="text-blue-600 text-2sm">
                                        {{ __('main.add') }}
                                    </a>
                                </label>
                                <select name="room_ids[]" id="room_ids" class="kt-select basic-multiple"
                                    multiple="multiple">
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}"
                                            {{ in_array($room->id, array_column($roomsSelected, 'id')) ? 'selected' : '' }}>
                                            {{ $room->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('room_ids')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Meal -->
                            <div class="align-self-end">
                                <label for="meal_ids" class="kt-label flex items-center justify-between mb-2">
                                    {{ __('main.meals') }}
                                    <a href="{{ route('meals.create') }}" class="text-blue-600 text-2sm">
                                        {{ __('main.add') }}
                                    </a>
                                </label>
                                <select name="meal_ids[]" id="meal_ids" class="kt-select basic-multiple"
                                    multiple="multiple">
                                    @foreach ($meals as $meal)
                                        <option value="{{ $meal->id }}"
                                            {{ in_array($meal->id, array_column($mealsSelected, 'id')) ? 'selected' : '' }}>
                                            {{ $meal->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('meal_ids')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Info Note -->
                        <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                            <p class="text-sm text-blue-800">
                                <i class="ki-filled ki-information-2 text-blue-600 me-1"></i>
                                <strong>{{ __('main.note') }}:</strong>
                                {!! __('messages.accommodation_rates_records_info', ['link' => route('accommodations-rates.index')]) !!}
                            </p>
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
                        <h3 class="kt-card-title">{{ __('main.location_information') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            <!-- Currency -->
                            <div class="align-self-end">
                                <label for="currency_id" class="kt-label flex items-center justify-between mb-2">
                                    {{ __('main.currency') }}
                                    <a href="{{ route('currencies.create') }}" class="text-blue-600 text-2sm">
                                        {{ __('main.add') }}
                                    </a>
                                </label>
                                <select name="currency_id" id="currency_id" class="kt-select basic-single">
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
                            <div class="align-self-end">
                                <label for="street" class="kt-label">Street Address</label>
                                <input type="text" name="street" id="street" class="kt-input h-[45px]"
                                    value="{{ $accommodation->street }}" placeholder="Enter street address">
                                @error('street')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Latitude -->
                            <div class="align-self-end">
                                <label for="latitude" class="kt-label">Latitude</label>
                                <input type="number" name="latitude" id="latitude" step="0.0000001"
                                    class="kt-input h-[45px]" value="{{ $accommodation->latitude }}"
                                    placeholder="e.g., 31.2001">
                                @error('latitude')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Longitude -->
                            <div class="align-self-end">
                                <label for="longitude" class="kt-label">Longitude</label>
                                <input type="number" name="longitude" id="longitude" step="0.0000001"
                                    class="kt-input h-[45px]" value="{{ $accommodation->longitude }}"
                                    placeholder="e.g., 29.9187">
                                @error('longitude')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Timezone -->
                            <div class="align-self-end">
                                <label for="timezone_id" class="kt-label mb-2">{{ __('main.timezone') }}</label>
                                <select name="timezone_id" id="timezone_id" class="kt-select basic-single">
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
                            <div class="align-self-end">
                                <label for="general_mobile" class="kt-label">General Mobile</label>
                                <input type="tel" name="general_mobile" id="general_mobile"
                                    class="kt-input h-[45px]" value="{{ $accommodation->general_mobile }}"
                                    placeholder="+1234567890">
                                @error('general_mobile')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- General Email -->
                            <div class="align-self-end">
                                <label for="general_email" class="kt-label">General Email</label>
                                <input type="email" name="general_email" id="general_email" class="kt-input h-[45px]"
                                    value="{{ $accommodation->general_email }}" placeholder="info@accommodation.com">
                                @error('general_email')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6 mb-4">
                            <!-- Phone -->
                            <div class="align-self-end">
                                <label for="phone" class="kt-label">Phone</label>
                                <input type="tel" name="phone" id="phone" class="kt-input h-[45px]"
                                    value="{{ $accommodation->phone }}" placeholder="+1234567890">
                                @error('phone')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Website -->
                            <div class="align-self-end">
                                <label for="website" class="kt-label">Website</label>
                                <input type="url" name="website" id="website" class="kt-input h-[45px]"
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
                                <div class="align-self-end">
                                    <label for="contact_person" class="kt-label">Contact Person Name</label>
                                    <input type="text" name="contact_person" id="contact_person"
                                        class="kt-input h-[45px]" value="{{ $accommodation->contact_person }}"
                                        placeholder="John Doe">
                                    @error('contact_person')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="align-self-end">
                                    <label for="contact_position" class="kt-label">Position</label>
                                    <input type="text" name="contact_position" id="contact_position"
                                        class="kt-input h-[45px]" value="{{ $accommodation->contact_position }}"
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
                                        class="kt-input h-[45px]" value="{{ $accommodation->contact_mobile }}"
                                        placeholder="+1234567890">
                                    @error('contact_mobile')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="align-self-end">
                                    <label for="contact_email" class="kt-label">Contact Email</label>
                                    <input type="email" name="contact_email" id="contact_email"
                                        class="kt-input h-[45px]" value="{{ $accommodation->contact_email }}"
                                        placeholder="manager@accommodation.com">
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
                filterByForeignId("region_id", "subregion", "subregion_id", "edit");
                filterByForeignId("subregion_id", "country", "country_id", "edit");
                filterByForeignId("country_id", "state", "state_id", "edit");
                filterByForeignId("state_id", "city", "city_id", "edit");
            }, 500);
        });
    </script>
@endpush

@include('components.regions.script-cascading')
