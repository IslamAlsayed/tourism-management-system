@extends('layouts.master')

@section('title', __('main.create_vessel'))

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_vessel') }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_vessel_description') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.cruises.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_vessels') }}
                </a>
            </div>
        </div>
    </div>

    <div class="container-fixed">
        <form class="space-y-6" method="POST" action="{{ route('dashboard.cruises.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-8 lg:gap-10">
                <!-- Cruise Photo -->
                @include('components.input-image', ['column' => 'cruise', 'columnName' => 'photo'])

                <!-- Location & Operational Bounds -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.location_and_operations') }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        @livewire('geography::livewire.regions.location-select-base2')

                <!-- Start and End Points -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.main_start_point') }} & {{ __('main.main_end_point') }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Main Start Point -->
                            <div class="space-y-4">
                                <div>
                                    <label for="start_country_id" class="kt-label mb-2">{{ __('main.country') }} ({{ __('main.main_start_point') }})</label>
                                    <div class="kt-input-group">
                                        <span class="kt-input-addon kt-input-addon-icon">
                                            <i class="fa-duotone fa-solid fa-flag"></i>
                                        </span>
                                        <select id="start_country_id" name="start_country_id" class="kt-input" data-control="select2">
                                            <option value="" selected disabled>{{ __('main.select_option') }}</option>
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}" {{ old('start_country_id') == $country->id ? 'selected' : '' }}>
                                                    {{ app()->getLocale() == 'ar' ? $country->name_ar : $country->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label for="main_start_point_id" class="kt-label mb-2">{{ __('main.main_start_point') }} ({{ __('main.city') }})</label>
                                    <div class="kt-input-group">
                                        <span class="kt-input-addon kt-input-addon-icon">
                                            <i class="fa-duotone fa-solid fa-location-dot"></i>
                                        </span>
                                        <select name="main_start_point_id" id="main_start_point_id" class="kt-input" data-control="select2" disabled>
                                            <option value="" selected disabled>{{ __('main.select_option') }}</option>
                                            @foreach($cities as $city)
                                                <option value="{{ $city->id }}" data-country="{{ $city->country_id }}" {{ old('main_start_point_id') == $city->id ? 'selected' : '' }} style="display: none;">
                                                    {{ app()->getLocale() == 'ar' ? $city->name_ar : $city->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('main_start_point_id')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Main End Point -->
                            <div class="space-y-4">
                                <div>
                                    <label for="end_country_id" class="kt-label mb-2">{{ __('main.country') }} ({{ __('main.main_end_point') }})</label>
                                    <div class="kt-input-group">
                                        <span class="kt-input-addon kt-input-addon-icon">
                                            <i class="fa-duotone fa-solid fa-flag"></i>
                                        </span>
                                        <select id="end_country_id" class="kt-input" data-control="select2">
                                            <option value="" selected disabled>{{ __('main.select_option') }}</option>
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}">
                                                    {{ app()->getLocale() == 'ar' ? $country->name_ar : $country->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label for="main_end_point_id" class="kt-label mb-2">{{ __('main.main_end_point') }} ({{ __('main.city') }})</label>
                                    <div class="kt-input-group">
                                        <span class="kt-input-addon kt-input-addon-icon">
                                            <i class="fa-duotone fa-solid fa-location-dot"></i>
                                        </span>
                                        <select name="main_end_point_id" id="main_end_point_id" class="kt-input" data-control="select2" disabled>
                                            <option value="" selected disabled>{{ __('main.select_option') }}</option>
                                            @foreach($cities as $city)
                                                <option value="{{ $city->id }}" data-country="{{ $city->country_id }}" {{ old('main_end_point_id') == $city->id ? 'selected' : '' }} style="display: none;">
                                                    {{ app()->getLocale() == 'ar' ? $city->name_ar : $city->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('main_end_point_id')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- General Information --}}
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.general_information') }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Name --}}
                            <div>
                                <label for="name" class="kt-label required mb-2">{{ __('main.name') }}</label>
                                <div class="kt-input-group">
                                    <span class="kt-input-addon kt-input-addon-icon">
                                        <i class="fa-duotone fa-solid fa-ship"></i>
                                    </span>
                                    <input type="text" name="name" id="name" class="kt-input " value="{{ old('name') }}" required>
                                </div>
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Arabic Name --}}
                            <div>
                                <label for="name_ar" class="kt-label mb-2">{{ __('main.name_ar') }}</label>
                                <div class="kt-input-group">
                                    <span class="kt-input-addon kt-input-addon-icon">
                                        <i class="fa-duotone fa-solid fa-ship"></i>
                                    </span>
                                    <input type="text" name="name_ar" id="name_ar" class="kt-input " value="{{ old('name_ar') }}">
                                </div>
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Vessel Class --}}
                            <div>
                                <label for="vessel_class" class="kt-label mb-2">{{ __('main.vessel_class') }}</label>
                                <div class="kt-input-group">
                                    <span class="kt-input-addon kt-input-addon-icon">
                                        <i class="fa-duotone fa-solid fa-star"></i>
                                    </span>
                                    <select name="vessel_class" id="vessel_class" class="kt-input">
                                        <option value="" selected disabled>{{ __('main.select_option') }}</option>
                                        <option value="Standard" {{ old('vessel_class') == 'Standard' ? 'selected' : '' }}>Standard</option>
                                        <option value="Luxury" {{ old('vessel_class') == 'Luxury' ? 'selected' : '' }}>Luxury</option>
                                        <option value="Mega" {{ old('vessel_class') == 'Mega' ? 'selected' : '' }}>Mega</option>
                                    </select>
                                </div>
                                @error('vessel_class')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Type --}}
                            <div>
                                <label for="type" class="kt-label mb-2">{{ __('main.type') }}</label>
                                <div class="kt-input-group">
                                    <span class="kt-input-addon kt-input-addon-icon">
                                        <i class="fa-duotone fa-solid fa-water"></i>
                                    </span>
                                    <select name="type" id="type" class="kt-input">
                                        <option value="" selected disabled>{{ __('main.select_option') }}</option>
                                        <option value="Ocean" {{ old('type') == 'Ocean' ? 'selected' : '' }}>Ocean</option>
                                        <option value="River" {{ old('type') == 'River' ? 'selected' : '' }}>River</option>
                                    </select>
                                </div>
                                @error('type')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Vessel Nationality -->
                            <div>
                                <label for="vessel_nationality_id" class="kt-label mb-2">{{ __('main.vessel_nationality') }}</label>
                                <div class="kt-input-group">
                                    <span class="kt-input-addon kt-input-addon-icon">
                                        <i class="fa-duotone fa-solid fa-cubes"></i>
                                    </span>
                                    <select name="vessel_nationality_id" id="vessel_nationality_id" class="kt-input" data-control="select2">
                                        <option value="" selected disabled>{{ __('main.select_option') }}</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ old('vessel_nationality_id') == $country->id ? 'selected' : '' }}>
                                                {{ app()->getLocale() == 'ar' ? $country->name_ar : $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('vessel_nationality_id')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Technical Specifications --}}
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.technical_specifications') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                            {{-- Cabins --}}
                            <div>
                                <label for="total_cabins" class="kt-label mb-2">{{ __('main.total_cabins') }}</label>
                                <div class="kt-input-group">
                                    <span class="kt-input-addon kt-input-addon-icon">
                                        <i class="fa-duotone fa-solid fa-store"></i>
                                    </span>
                                    <input type="number" name="total_cabins" id="total_cabins" class="kt-input " value="{{ old('total_cabins') }}" min="0">
                                </div>
                            </div>

                            {{-- Decks --}}
                            <div>
                                <label for="deck_count" class="kt-label mb-2">{{ __('main.deck_count') }}</label>
                                <div class="kt-input-group">
                                    <span class="kt-input-addon kt-input-addon-icon">
                                        <i class="fa-duotone fa-solid fa-table-cells-large"></i>
                                    </span>
                                    <input type="number" name="deck_count" id="deck_count" class="kt-input " value="{{ old('deck_count') }}" min="0">
                                </div>
                            </div>

                            {{-- Built Year --}}
                            <div>
                                <label for="built_year" class="kt-label mb-2">{{ __('main.built_year') }}</label>
                                <div class="kt-input-group">
                                    <span class="kt-input-addon kt-input-addon-icon">
                                        <i class="fa-duotone fa-solid fa-calendar"></i>
                                    </span>
                                    <input type="number" name="built_year" id="built_year" class="kt-input " value="{{ old('built_year') }}" min="1900" max="{{ date('Y') }}">
                                </div>
                            </div>

                            {{-- Renovated Year --}}
                            <div>
                                <label for="renovated_year" class="kt-label mb-2">{{ __('main.renovated_year') }}</label>
                                <div class="kt-input-group">
                                    <span class="kt-input-addon kt-input-addon-icon">
                                        <i class="fa-duotone fa-solid fa-calendar-add"></i>
                                    </span>
                                    <input type="number" name="renovated_year" id="renovated_year" class="kt-input " value="{{ old('renovated_year') }}" min="1900" max="{{ date('Y') }}">
                                </div>
                            </div>

                            {{-- Length --}}
                            <div>
                                <label for="length_meters" class="kt-label mb-2">{{ __('main.length_meters') }}</label>
                                <div class="kt-input-group">
                                    <span class="kt-input-addon kt-input-addon-icon">
                                        <i class="fa-duotone fa-solid fa-drafting-compass"></i>
                                    </span>
                                    <input type="number" step="0.01" name="length_meters" id="length_meters" class="kt-input " value="{{ old('length_meters') }}" min="0">
                                </div>
                            </div>

                            {{-- Draft --}}
                            <div>
                                <label for="draft_meters" class="kt-label mb-2">{{ __('main.draft_meters') }}</label>
                                <div class="kt-input-group">
                                    <span class="kt-input-addon kt-input-addon-icon">
                                        <i class="fa-duotone fa-solid fa-arrow-down-2"></i>
                                    </span>
                                    <input type="number" step="0.01" name="draft_meters" id="draft_meters" class="kt-input " value="{{ old('draft_meters') }}" min="0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Status --}}
                <div class="kt-card">
                    <div class="kt-card-body p-4 flex gap-6">
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="is_active" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'is_active',
                                'id' => 'is_active',
                                'value' => '1',
                                'checked' => old('is_active', 1),
                                'label' => __('main.is_active'),
                            ])
                        </div>

                        <div class="flex items-center gap-3">
                            <input type="hidden" name="is_chartered" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'is_chartered',
                                'id' => 'is_chartered',
                                'value' => '1',
                                'checked' => old('is_chartered', 0),
                                'label' => __('main.is_chartered'),
                            ])
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex justify-end gap-3 mt-4">
                    <a href="{{ route('dashboard.cruises.index') }}" class="kt-btn kt-btn-outline">{{ __('main.cancel') }}</a>
                    <button type="submit" class="kt-btn kt-btn-primary">{{ __('main.save_and_continue') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        function setupLocationDependency(countrySelectId, citySelectId) {
            const countrySelect = $('#' + countrySelectId);
            const citySelect = $('#' + citySelectId);
            
            // If select2 is used
            countrySelect.on('change', function() {
                const countryId = $(this).val();
                
                // Clear city select
                citySelect.val(null).trigger('change');
                
                if (countryId) {
                    // Enable and show generic loader text
                    citySelect.prop('disabled', false);
                    citySelect.find('option').each(function() {
                        const opt = $(this);
                        if (opt.val() === '') return; // skip placeholder
                        
                        if (opt.data('country') == countryId) {
                            opt.show();
                            opt.prop('disabled', false);
                        } else {
                            opt.hide();
                            opt.prop('disabled', true);
                        }
                    });
                    
                    // Re-initialize select2 so it picks up the disabled/hidden states
                    citySelect.select2('destroy');
                    citySelect.select2();
                } else {
                    citySelect.prop('disabled', true);
                }
            });

            // Trigger change on load if value exists
            if (countrySelect.val()) {
                countrySelect.trigger('change');
            }
        }

        setupLocationDependency('start_country_id', 'main_start_point_id');
        setupLocationDependency('end_country_id', 'main_end_point_id');
        
        // Wait for Livewire or other scripts to load Select2 before attaching events
        setTimeout(() => {
            if ($('#start_country_id').data('select2')) {
                $('#start_country_id').trigger('change');
                $('#end_country_id').trigger('change');
            }
        }, 500);
    });
</script>
@endpush
