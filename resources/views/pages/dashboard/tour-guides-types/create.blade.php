@extends('layouts.master')

@section('title', __('main.add_type', ['type' => __('main.tour-guide-type')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.add_type', ['type' => __('main.tour-guide-type')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.add_type_description', ['type' => __('main.tour-guide-type')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('tour-guides-types.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['type' => __('main.tour-guide-type')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-5 lg:gap-7.5">
            <!-- Tour Guides Types Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.tour-guide-type')]) }}</h3>
                </div>
                <div class="kt-card-body">
                    <form method="POST" action="{{ route('tour-guides-types.store') }}" enctype="multipart/form-data"
                        class="space-y-6 p-4">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-4">
                            <!-- Type -->
                            <div class="">
                                <label for="type" class="kt-label required mb-2">{{ __('main.type') }}</label>
                                <input type="text" name="type" id="type" class="kt-input h-[45px]" required
                                    value="{{ old('type') }}">
                                @error('type')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Price -->
                            <div class="">
                                <label for="price" class="kt-label required mb-2">{{ __('main.price') }}</label>
                                <input type="text" name="price" min="1" id="price" class="kt-input h-[45px]"
                                    required value="{{ old('price') }}">
                                @error('price')
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

                            <!-- State -->
                            <div class="">
                                <label for="multi_states" class="kt-label mb-2">
                                    <input type="hidden" name="multi_states" value="0">
                                    <input type="checkbox" name="multi_states" id="multi_states" class="kt-checkbox"
                                        style="width: 17px; height: 17px;"
                                        onchange="document.getElementById('state_id').disabled = this.checked;"
                                        value="1" {{ old('multi_states', '1') ? 'checked' : '' }}>
                                    {{ __('main.all_types', ['types' => __('main.states')]) }}
                                </label>
                                <select name="state_id" id="state_id" class="kt-select h-[45px]" disabled special-multiple>
                                    <option value="">--</option>
                                    @foreach ($states as $state)
                                        <option value="{{ $state->id }}"
                                            {{ old('state_id') == $state->id ? 'selected' : '' }}>
                                            {{ $state->name }} {{ $state->name_ar ? ' - ' . $state->name_ar : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('state_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- City -->
                            <div class="">
                                <label for="multi_cities" class="kt-label mb-2">
                                    <input type="hidden" name="multi_cities" value="0">
                                    <input type="checkbox" name="multi_cities" id="multi_cities" class="kt-checkbox"
                                        style="width: 17px; height: 17px;"
                                        onchange="document.getElementById('city_id').disabled = this.checked;"
                                        value="1" {{ old('multi_cities', '1') ? 'checked' : '' }}>
                                    {{ __('main.all_types', ['types' => __('main.cities')]) }}
                                </label>
                                <select name="city_id" id="city_id" class="kt-select h-[45px]" disabled special-multiple>
                                    <option value="">--</option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}"
                                            {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }} {{ $city->name_ar ? ' - ' . $city->name_ar : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('city_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Region -->
                            <div class="">
                                <label for="region_id" class="kt-label mb-2">{{ __('main.region') }}</label>
                                <select name="region_id" id="region_id" class="kt-select h-[45px]">
                                    <option value="">--</option>
                                    @foreach ($regions as $region)
                                        <option value="{{ $region->id }}"
                                            {{ old('region_id') == $region->id ? 'selected' : '' }}>
                                            {{ $region->name }} {{ $region->name_ar ? ' - ' . $region->name_ar : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('region_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Subregion -->
                            <div class="">
                                <label for="subregion_id" class="kt-label mb-2">{{ __('main.subregion') }}</label>
                                <select name="subregion_id" id="subregion_id" class="kt-select h-[45px]">
                                    <option value="">--</option>
                                    @foreach ($subregions as $subregion)
                                        <option value="{{ $subregion->id }}"
                                            {{ old('subregion_id') == $subregion->id ? 'selected' : '' }}>
                                            {{ $subregion->name }}
                                            {{ $subregion->name_ar ? ' - ' . $subregion->name_ar : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('subregion_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center gap-4">
                            <button type="submit" class="kt-btn kt-btn-primary">
                                <i class="ki-filled ki-check text-sm me-2"></i>
                                {{ __('main.save_type', ['type' => __('main.tour-guide-type')]) }}
                            </button>
                            <button type="submit" name="save_and_add" value="1"
                                class="kt-btn kt-btn-outline kt-btn-outline-primary">
                                <i class="ki-filled ki-plus text-sm me-2"></i>
                                {{ __('main.save_and_add_another') }}
                            </button>
                            <a href="{{ route('tour-guides-types.index') }}" class="kt-btn kt-btn-outline">
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
                                    {{ __('main.must_select_type1_before_creating_type2', ['type1' => __('main.gender'), 'type2' => __('main.tour-guide-type')]) }}
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
                                    {{ __('main.must_select_type1_before_creating_type2', ['type1' => __('main.country'), 'type2' => __('main.tour-guide-type')]) }}
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
                                    {{ __('main.must_select_type1_before_creating_type2', ['type1' => __('main.currency'), 'type2' => __('main.tour-guide-type')]) }}
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
