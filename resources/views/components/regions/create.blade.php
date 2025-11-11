{{-- create-regions.blade.php --}}
{{-- Usage: include with optional 'exclude' and optional 'replaces' --}}
{{-- example: @include('components.create-regions', ['exclude' => ['country'], 'replaces' => ['country_id','subregion_id']]) --}}

@if (isset($levels) && in_array('region', $levels))
    <div class="{{ isset($regions) && count($regions) <= 0 ? 'loading' : '' }}">
        <label for="region_id" class="kt-label required mb-2 flex items-center justify-between">
            <div>
                {{ __('main.region') }}
                <strong
                    class="dataLength text-primary">({{ isset($regions) && count($regions) ? count($regions) : 0 }})</strong>
                @if (isset($regions) && count($regions) <= 0)
                    <span id="region_id-info" class="text-red-600 text-sm span-info show">
                        (Not regions found)
                    </span>
                @endif
            </div>
            <a href="{{ route('regions.create') }}" class="text-blue-600 text-2sm">{{ __('main.add') }}</a>
        </label>
        <select name="region_id" id="region_id" class="kt-select h-[45px]" special-search>
            <option value="">--</option>
            @if (isset($regions))
                @foreach ($regions as $region)
                    <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>
                        {{ app()->getLocale() == 'ar' ? ($region->name_ar ?: $region->name) : $region->name }}
                    </option>
                @endforeach
            @endif
        </select>
        @error('region_id')
            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>
@endif

@if (isset($levels) && in_array('subregion', $levels))
    <div class="loading">
        <label for="subregion_id" class="kt-label required mb-2 flex items-center justify-between">
            <div>
                {{ __('main.subregion') }}
                <strong class="dataLength text-primary"></strong>
                <i id="subregion_id-loader" class="i-loader fas fa-refresh fa-spin text-primary"></i>
                <span id="subregion_id-info" class="text-red-600 text-sm span-info show">
                    ({{ __('main.select_type_first', ['type' => __('main.region')]) }})
                </span>
            </div>
            <a href="{{ route('subregions.create') }}" class="text-blue-600 text-2sm">{{ __('main.add') }}</a>
        </label>

        <select name="subregion_id" id="subregion_id" class="kt-select h-[45px]" special-search>
            <option value="">--</option>
        </select>
        @error('subregion_id')
            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>
@endif

@if (isset($levels) && in_array('country', $levels))
    <div class="loading">
        <label for="country_id" class="kt-label required mb-2 flex items-center justify-between">
            <div>
                {{ __('main.country') }}
                <strong class="dataLength text-primary"></strong>
                <i id="country_id-loader" class="i-loader fas fa-refresh fa-spin text-primary"></i>
                <span id="country_id-info" class="text-red-600 text-sm span-info show">
                    ({{ __('main.select_type_first', ['type' => __('main.subregion')]) }})
                </span>
            </div>
            <a href="{{ route('countries.create') }}" class="text-blue-600 text-2sm">{{ __('main.add') }}</a>
        </label>

        <select name="country_id" id="country_id" class="kt-select h-[45px]" special-search>
            <option value="">--</option>
        </select>
        @error('country_id')
            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>
@endif

@if (isset($levels) && in_array('state', $levels))
    <div class="loading">
        <label for="all_states" class="kt-label required mb-2 flex items-center justify-between">
            <div class="flex items-center justify-between gap-1">
                <div class="flex items-center justify-between gap-1">
                    @if (isset($multiple) && $multiple)
                        <input type="hidden" name="all_states" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'all_states',
                            'id' => 'all_states',
                            'value' => '1',
                            'styles' => 'width: 15px !important; height: 15px !important;',
                            'label' => __('main.all_types', ['types' => __('main.states')]),
                        ])

                        {{-- <div class="custom-input">
                            <span class="pseudo-checkbox" style="width: 15px; height: 15px;"></span>
                            <input type="checkbox" name="all_states" id="all_states" value="1"
                                {{ old('all_states') ? 'checked' : '' }}>
                            <label for="all_states">{{ __('main.all_types', ['types' => __('main.states')]) }}</label>
                        </div> --}}
                    @else
                        {{ __('main.state') }}
                    @endif
                    <strong class="dataLength text-primary"></strong>
                    <i id="state_id-loader" class="i-loader fas fa-refresh fa-spin text-primary"></i>
                </div>
                <span id="state_id-info" class="text-red-600 text-sm span-info show">
                    ({{ __('main.select_type_first', ['type' => __('main.country')]) }})
                </span>
            </div>
            <a href="{{ route('states.create') }}" class="text-blue-600 text-2sm">{{ __('main.add') }}</a>
        </label>

        <select name="{{ isset($multiple) && $multiple ? 'state_id[]' : 'state_id' }}" id="state_id"
            class="kt-select h-[45px]" {{ isset($multiple) && $multiple ? 'special-multiple' : 'special-search' }}>
            <option value="">--</option>
        </select>

        @error('state_id')
            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>
@endif

@if (isset($levels) && in_array('city', $levels))
    <div class="loading">
        <label for="all_cities" class="kt-label required mb-2 flex items-center justify-between">
            <div class="flex items-center justify-between gap-1">
                <div class="flex items-center justify-between gap-1">
                    @if (isset($multiple) && $multiple)
                        <input type="hidden" name="all_cities" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'all_cities',
                            'id' => 'all_cities',
                            'value' => '1',
                            'styles' => 'width: 15px !important; height: 15px !important;',
                            'label' => __('main.all_types', ['types' => __('main.cities')]),
                        ])
                        {{-- <div class="custom-input">
                            <span class="pseudo-checkbox" style="width: 15px; height: 15px;"></span>
                            <input type="checkbox" name="all_cities" id="all_cities" value="1"
                                {{ old('all_cities') ? 'checked' : '' }}>
                            <label for="all_cities">{{ __('main.all_types', ['types' => __('main.cities')]) }}</label>
                        </div> --}}
                    @else
                        {{ __('main.city') }}
                    @endif
                    <strong class="dataLength text-primary"></strong>
                    <i id="city_id-loader" class="i-loader fas fa-refresh fa-spin text-primary"></i>
                </div>
                <span id="city_id-info" class="text-red-600 text-sm span-info show">
                    ({{ __('main.select_type_first', ['type' => __('main.state')]) }})
                </span>
            </div>
            <a href="{{ route('cities.create') }}" class="text-blue-600 text-2sm">{{ __('main.add') }}</a>
        </label>

        <select name="{{ isset($multiple) && $multiple ? 'city_id[]' : 'city_id' }}" id="city_id"
            class="kt-select h-[45px]" {{ isset($multiple) && $multiple ? 'special-multiple' : 'special-search' }}>
            <option value="">--</option>
        </select>

        @error('city_id')
            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>
@endif
