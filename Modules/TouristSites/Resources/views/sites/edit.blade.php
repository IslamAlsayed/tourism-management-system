@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.tourist-site')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.tourist-site')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.tourist-site')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.touristsites.sites.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tourist-sites')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <form action="{{ route('dashboard.touristsites.sites.update', $touristSite->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid gap-4 lg:gap-6">
                <!-- Location Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.location')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        {{-- Regions [country, state, city] --}}
                        @livewire('geography::livewire.regions.location-select-base', ['record' => $touristSite])

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            <div>
                                <label for="latitude" class="kt-label">{{ __('main.latitude') }}</label>
                                <input type="number" step="0.00000001" min="-90" max="90" name="latitude"
                                    id="latitude" class="kt-input h-[45px]" value="{{ $touristSite->latitude }}">
                            </div>
                            <div>
                                <label for="longitude" class="kt-label">{{ __('main.longitude') }}</label>
                                <input type="number" step="0.00000001" min="-180" max="180" name="longitude"
                                    id="longitude" class="kt-input h-[45px]" value="{{ $touristSite->longitude }}">
                            </div>

                            @include('components.selects.currency', ['record' => $touristSite->currency])
                        </div>

                        <!-- address -->
                        <div>
                            <label for="address" class="kt-label mb-2">{{ __('main.address') }}</label>
                            <textarea name="address" id="address" class="kt-input" rows="2" placeholder="{{ __('main.address') }}">{{ $touristSite->address }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Basic Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.tourist-site')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            {{-- Name Fields First --}}
                            <div class="align-self-end">
                                <label for="name" class="kt-label">{{ __('main.name') }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]"
                                    value="{{ $touristSite->name }}">
                            </div>
                            <div class="align-self-end">
                                <label for="name_ar" class="kt-label">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
                                    value="{{ $touristSite->name_ar }}">
                            </div>
                            <div class="align-self-end">
                                <label for="supplier_name" class="kt-label">{{ __('main.supplier_name') }}</label>
                                <input type="text" name="supplier_name" id="supplier_name" class="kt-input h-[45px]"
                                    value="{{ $touristSite->supplier_name }}">
                                <span class="text-xs text-gray-400 mt-1 block">{{ __('main.supplier_module_note') }}</span>
                            </div>

                            {{-- Site Type - Checkboxes --}}
                            <div class="col-span-full border-t pt-4 mt-2">
                                <label class="kt-label mb-2 block font-semibold">{{ __('main.site_type') }}</label>
                                <div class="flex flex-wrap gap-3">
                                    @foreach ($site_types as $type)
                                        <div class="flex items-center gap-2">
                                            <input type="checkbox" name="site_type[]" id="site_type_{{ $type->key }}"
                                                value="{{ $type->key }}" class="kt-checkbox"
                                                {{ in_array($type->key, explode(',', $touristSite->site_type ?? '')) ? 'checked' : '' }}>
                                            <label for="site_type_{{ $type->key }}"
                                                class="text-sm cursor-pointer">{{ $type->display_name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Category - Checkboxes --}}
                            <div class="col-span-full border-t pt-4 mt-2">
                                <label class="kt-label mb-2 block font-semibold">{{ __('main.category') }}</label>
                                <div class="flex flex-wrap gap-3">
                                    @foreach ($site_categories as $cat)
                                        <div class="flex items-center gap-2">
                                            <input type="checkbox" name="category[]" id="category_{{ $cat->key }}"
                                                value="{{ $cat->key }}" class="kt-checkbox"
                                                {{ in_array($cat->key, explode(',', $touristSite->category ?? '')) ? 'checked' : '' }}>
                                            <label for="category_{{ $cat->key }}"
                                                class="text-sm cursor-pointer">{{ $cat->display_name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Supplier Type - Checkboxes --}}
                            <div class="col-span-full border-t pt-4 mt-2">
                                <label class="kt-label mb-2 block font-semibold">{{ __('main.supplier_type') }}</label>
                                <div class="flex flex-wrap gap-3">
                                    @foreach ($supplier_types as $stype)
                                        <div class="flex items-center gap-2">
                                            <input type="checkbox" name="supplier_type[]"
                                                id="supplier_type_{{ $stype->key }}" value="{{ $stype->key }}"
                                                class="kt-checkbox"
                                                {{ in_array($stype->key, explode(',', $touristSite->supplier_type ?? '')) ? 'checked' : '' }}>
                                            <label for="supplier_type_{{ $stype->key }}"
                                                class="text-sm cursor-pointer">{{ $stype->display_name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Sites Theme - Checkboxes --}}
                            <div class="col-span-full border-t pt-4 mt-2">
                                <label class="kt-label mb-2 block font-semibold">{{ __('main.sites_theme') }}</label>
                                <div class="flex flex-wrap gap-3">
                                    @foreach ($site_themes as $theme)
                                        <div class="flex items-center gap-2">
                                            <input type="checkbox" name="sites_theme[]"
                                                id="sites_theme_{{ $theme->key }}" value="{{ $theme->key }}"
                                                class="kt-checkbox"
                                                {{ in_array($theme->key, explode(',', $touristSite->sites_theme ?? '')) ? 'checked' : '' }}>
                                            <label for="sites_theme_{{ $theme->key }}"
                                                class="text-sm cursor-pointer">{{ $theme->display_name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- International Designations - Compact --}}
                            <div class="col-span-full border-t pt-4 mt-2">
                                <h4 class="kt-card-title text-sm font-semibold mb-2">
                                    {{ __('main.international_designations') }}</h4>
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-2">
                                    @foreach (['unesco_site', 'iucn_green_list', 'gstc_certified', 'blue_flag', 'green_destinations', 'earthcheck_certified'] as $designation)
                                        <div
                                            class="flex items-center gap-2 p-2 border rounded bg-gray-50/50 cursor-pointer hover:bg-gray-100 transition">
                                            <input type="hidden" name="{{ $designation }}" value="0">
                                            <input type="checkbox" name="{{ $designation }}" id="{{ $designation }}"
                                                value="1" class="kt-checkbox w-4 h-4 shrink-0"
                                                {{ $touristSite->$designation ? 'checked' : '' }}>
                                            <label for="{{ $designation }}"
                                                class="text-xs cursor-pointer select-none leading-tight">
                                                {{ __('main.' . $designation) }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- sort_order --}}
                            <div class="align-self-end">
                                <label for="sort_order" class="kt-label">{{ __('main.sort_order') }}</label>
                                <input type="number" name="sort_order" id="sort_order" class="kt-input h-[45px]"
                                    value="{{ $touristSite->sort_order }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Entry Fees -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.entry_fees') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="flex items-center gap-4 mb-4">
                            <input type="hidden" name="is_free_entry" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'is_free_entry',
                                'id' => 'is_free_entry',
                                'value' => '1',
                                'checked' => $touristSite->is_free_entry,
                                'label' => __('main.is_free_entry'),
                            ])
                        </div>

                        <div id="entryFeesContainer"
                            class="flex flex-col gap-4 {{ $touristSite->is_free_entry == 1 ? 'disabled-option' : '' }}">
                            <div class="overflow-x-auto">
                                <div class="inline-block min-w-full align-middle">
                                    <div class="overflow-hidden border border-gray-200 rounded-lg">
                                        <table
                                            class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg"
                                            id="entryFeesTable">
                                            <thead class="bg-gray-50">
                                                <tr id="tableHeaderRow">
                                                    <th
                                                        class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-b border-r bg-gray-100">
                                                        {{ __('main.category') }}
                                                    </th>
                                                    <th
                                                        class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-b border-r">
                                                        {{ __('main.general') }}
                                                    </th>
                                                    <th
                                                        class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-b border-r">
                                                        {{ __('main.foreigner') }}
                                                    </th>
                                                    <th
                                                        class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-b border-r">
                                                        {{ __('main.arab') }}
                                                    </th>
                                                    <th
                                                        class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-b border-r">
                                                        {{ __('main.local') }}
                                                    </th>
                                                    <th
                                                        class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-b">
                                                        {{ __('main.resident') }}
                                                    </th>
                                                    <!-- Dynamic Headers -->
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                <!-- Adult Row -->
                                                <tr class="hover:bg-gray-50 entry_feesCheckBox" id="adultRow">
                                                    <td
                                                        class="px-4 py-3 text-sm font-medium text-gray-900 border-r bg-blue-50 whitespace-nowrap">
                                                        👨 {{ __('main.adult') }}
                                                    </td>
                                                    <td class="px-2 py-2 border-r relative">
                                                        <div class="flex items-center">
                                                            <input type="number" step="0.01" min="0"
                                                                name="entry_fee_adult" id="entry_fee_adult"
                                                                class="kt-input text-center w-full pr-12"
                                                                value="{{ old('entry_fee_adult', $touristSite->entry_fee_adult) }}"
                                                                placeholder="0.00">
                                                            <span
                                                                class="currency-code text-[10px] text-gray-400 absolute right-4">{{ $touristSite->currency?->code }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="px-2 py-2 border-r relative">
                                                        <div class="flex items-center">
                                                            <input type="number" step="0.01" min="0"
                                                                name="entry_fee_foreigner_adult"
                                                                id="entry_fee_foreigner_adult"
                                                                class="kt-input text-center w-full pr-12"
                                                                value="{{ old('entry_fee_foreigner_adult', $touristSite->entry_fee_foreigner_adult) }}"
                                                                placeholder="0.00">
                                                            <span
                                                                class="currency-code text-[10px] text-gray-400 absolute right-4">{{ $touristSite->currency?->code }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="px-2 py-2 border-r relative">
                                                        <div class="flex items-center">
                                                            <input type="number" step="0.01" min="0"
                                                                name="entry_fee_arab_adult" id="entry_fee_arab_adult"
                                                                class="kt-input text-center w-full pr-12"
                                                                value="{{ old('entry_fee_arab_adult', $touristSite->entry_fee_arab_adult) }}"
                                                                placeholder="0.00">
                                                            <span
                                                                class="currency-code text-[10px] text-gray-400 absolute right-4">{{ $touristSite->currency?->code }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="px-2 py-2 border-r relative">
                                                        <div class="flex items-center">
                                                            <input type="number" step="0.01" min="0"
                                                                name="entry_fee_local_adult" id="entry_fee_local_adult"
                                                                class="kt-input text-center w-full pr-12"
                                                                value="{{ old('entry_fee_local_adult', $touristSite->entry_fee_local_adult) }}"
                                                                placeholder="0.00">
                                                            <span
                                                                class="currency-code text-[10px] text-gray-400 absolute right-4">{{ $touristSite->currency?->code }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="px-2 py-2 relative">
                                                        <div class="flex items-center">
                                                            <input type="number" step="0.01" min="0"
                                                                name="entry_fee_resident_adult"
                                                                id="entry_fee_resident_adult"
                                                                class="kt-input text-center w-full pr-12"
                                                                value="{{ old('entry_fee_resident_adult', $touristSite->entry_fee_resident_adult) }}"
                                                                placeholder="0.00">
                                                            <span
                                                                class="currency-code text-[10px] text-gray-400 absolute right-4">{{ $touristSite->currency?->code }}</span>
                                                        </div>
                                                    </td>
                                                    <!-- Dynamic Inputs -->
                                                </tr>

                                                <!-- Child Row -->
                                                <tr class="hover:bg-gray-50 entry_feesCheckBox" id="childRow">
                                                    <td
                                                        class="px-4 py-3 text-sm font-medium text-gray-900 border-r bg-green-50 whitespace-nowrap">
                                                        👶 {{ __('main.child') }}
                                                    </td>
                                                    <td class="px-2 py-2 border-r relative">
                                                        <div class="flex items-center">
                                                            <input type="number" step="0.01" min="0"
                                                                name="entry_fee_child" id="entry_fee_child"
                                                                class="kt-input text-center w-full pr-12"
                                                                value="{{ old('entry_fee_child', $touristSite->entry_fee_child) }}"
                                                                placeholder="0.00">
                                                            <span
                                                                class="currency-code text-[10px] text-gray-400 absolute right-4">{{ $touristSite->currency?->code }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="px-2 py-2 border-r">
                                                        <input type="number" step="0.01" min="0"
                                                            name="entry_fee_foreigner_child"
                                                            id="entry_fee_foreigner_child"
                                                            class="kt-input text-center w-full"
                                                            value="{{ old('entry_fee_foreigner_child', $touristSite->entry_fee_foreigner_child) }}"
                                                            placeholder="0.00">
                                                    </td>
                                                    <td class="px-2 py-2 border-r">
                                                        <input type="number" step="0.01" min="0"
                                                            name="entry_fee_arab_child" id="entry_fee_arab_child"
                                                            class="kt-input text-center w-full"
                                                            value="{{ old('entry_fee_arab_child', $touristSite->entry_fee_arab_child) }}"
                                                            placeholder="0.00">
                                                    </td>
                                                    <td class="px-2 py-2 border-r">
                                                        <input type="number" step="0.01" min="0"
                                                            name="entry_fee_local_child" id="entry_fee_local_child"
                                                            class="kt-input text-center w-full"
                                                            value="{{ old('entry_fee_local_child', $touristSite->entry_fee_local_child) }}"
                                                            placeholder="0.00">
                                                    </td>
                                                    <td class="px-2 py-2">
                                                        <input type="number" step="0.01" min="0"
                                                            name="entry_fee_resident_child" id="entry_fee_resident_child"
                                                            class="kt-input text-center w-full"
                                                            value="{{ old('entry_fee_resident_child', $touristSite->entry_fee_resident_child) }}"
                                                            placeholder="0.00">
                                                    </td>
                                                    <!-- Dynamic Inputs -->
                                                </tr>

                                                <!-- Student Row -->
                                                <tr class="hover:bg-gray-50 entry_feesCheckBox">
                                                    <td
                                                        class="px-4 py-3 text-sm font-medium text-gray-900 border-r bg-purple-50 whitespace-nowrap">
                                                        🎓 {{ __('main.student') }}
                                                    </td>
                                                    <td class="px-2 py-2 text-center relative" colspan="5"
                                                        class="colspan-dynamic">
                                                        <div class="flex items-center justify-center">
                                                            <input type="number" step="0.01" min="0"
                                                                name="entry_fee_student" id="entry_fee_student"
                                                                class="kt-input text-center w-1/4 inline-block pr-12"
                                                                value="{{ old('entry_fee_student', $touristSite->entry_fee_student) }}"
                                                                placeholder="0.00">
                                                            <span
                                                                class="currency-code text-[10px] text-gray-400 ml-[-45px] z-10">{{ $touristSite->currency?->code }}</span>
                                                            <span
                                                                class="text-xs text-gray-500 ml-4">({{ __('main.all_nationalities') }})</span>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Senior Row -->
                                                <tr class="hover:bg-gray-50 entry_feesCheckBox">
                                                    <td
                                                        class="px-4 py-3 text-sm font-medium text-gray-900 border-r bg-orange-50 whitespace-nowrap">
                                                        👴 {{ __('main.senior') }}
                                                    </td>
                                                    <td class="px-2 py-2 text-center relative" colspan="5"
                                                        class="colspan-dynamic">
                                                        <div class="flex items-center justify-center">
                                                            <input type="number" step="0.01" min="0"
                                                                name="entry_fee_senior" id="entry_fee_senior"
                                                                class="kt-input text-center w-1/4 inline-block pr-12"
                                                                value="{{ old('entry_fee_senior', $touristSite->entry_fee_senior) }}"
                                                                placeholder="0.00">
                                                            <span
                                                                class="currency-code text-[10px] text-gray-400 ml-[-45px] z-10">{{ $touristSite->currency?->code }}</span>
                                                            <span
                                                                class="text-xs text-gray-500 ml-4">({{ __('main.all_nationalities') }})</span>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Group Row -->
                                                <tr class="hover:bg-gray-50 entry_feesCheckBox">
                                                    <td
                                                        class="px-4 py-3 text-sm font-medium text-gray-900 border-r bg-yellow-50 whitespace-nowrap">
                                                        👥 {{ __('main.group') }}
                                                    </td>
                                                    <td class="px-2 py-2 text-center relative" colspan="5"
                                                        class="colspan-dynamic">
                                                        <div class="flex items-center justify-center">
                                                            <input type="number" step="0.01" min="0"
                                                                name="entry_fee_group" id="entry_fee_group"
                                                                class="kt-input text-center w-1/4 inline-block pr-12"
                                                                value="{{ old('entry_fee_group', $touristSite->entry_fee_group) }}"
                                                                placeholder="0.00">
                                                            <span
                                                                class="currency-code text-[10px] text-gray-400 ml-[-45px] z-10">{{ $touristSite->currency?->code }}</span>
                                                            <span
                                                                class="text-xs text-gray-500 ml-4">({{ __('main.all_nationalities') }})</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {{-- Add Nationality Controls (after table) --}}
                            <div class="border-t pt-4 mt-2">
                                <div class="flex items-center gap-4 flex-wrap">
                                    <label class="kt-form-label font-bold text-base min-w-fit">{{ __('main.add') }}
                                        {{ __('main.nationality') }}</label>
                                    <div class="flex-1 flex items-center gap-2 flex-wrap">
                                        <!-- Nationality Select -->
                                        <select id="nationalitySelect" class="kt-select" style="width: 400px;">
                                            <option value="">{{ __('main.select_nationality') }}</option>
                                            @foreach ($nationalities as $nationality)
                                                <option value="{{ $nationality->id }}">
                                                    {{ $nationality->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="button" id="addNationalityBtn"
                                            class="kt-btn kt-btn-primary h-[40px] px-4">
                                            {{ __('main.add') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Nationality Entry Fees Cards (displayed vertically) -->
                        <div id="nationalityCardsContainer" class="flex flex-col gap-3 mt-4"></div>
                    </div>
                </div>
            </div>

            <!-- Additional Pricing -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.additional_pricing') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        {{-- Local Guide Price --}}
                        <div class="border rounded-lg p-4 bg-gray-50/30">
                            <label for="local_guide_price"
                                class="kt-label font-semibold mb-2 block">{{ __('main.local_guide_price') }}</label>
                            <div class="flex items-center gap-3">
                                <input type="number" step="0.01" min="0" name="local_guide_price"
                                    id="local_guide_price" class="kt-input h-[45px] flex-1 pr-12"
                                    value="{{ $touristSite->local_guide_price }}" placeholder="0.00">
                                <span
                                    class="currency-code text-[10px] text-gray-400 absolute right-[195px] mt-[1px]">{{ $touristSite->currency?->code }}</span>
                                <select name="local_guide_price_unit_id" class="kt-select h-[45px]"
                                    style="width: 180px;">
                                    <option value="">--</option>
                                    @foreach ($pricing_units as $unit)
                                        <option value="{{ $unit->id }}"
                                            {{ ($touristSite->local_guide_price_unit_id ?? '') == $unit->id ? 'selected' : '' }}>
                                            {{ $unit->display_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Club Car / Golf Cart Price --}}
                        <div class="border rounded-lg p-4 bg-gray-50/30">
                            <label for="club_car_price"
                                class="kt-label font-semibold mb-2 block">{{ __('main.club_car_price') }}</label>
                            <div class="flex items-center gap-3">
                                <input type="number" step="0.01" min="0" name="club_car_price"
                                    id="club_car_price" class="kt-input h-[45px] flex-1 pr-12"
                                    value="{{ $touristSite->club_car_price }}" placeholder="0.00">
                                <span
                                    class="currency-code text-[10px] text-gray-400 absolute right-[195px] mt-[1px]">{{ $touristSite->currency?->code }}</span>
                                <select name="club_car_price_unit_id" class="kt-select h-[45px]" style="width: 180px;">
                                    <option value="">--</option>
                                    @foreach ($pricing_units as $unit)
                                        <option value="{{ $unit->id }}"
                                            {{ ($touristSite->club_car_price_unit_id ?? '') == $unit->id ? 'selected' : '' }}>
                                            {{ $unit->display_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Unified Ticket / Travel Pass --}}
                        <div class="col-span-full border rounded-lg p-4 bg-blue-50/30 border-blue-200">
                            <div class="flex items-center gap-4 mb-3">
                                <input type="hidden" name="has_unified_ticket" value="0">
                                <input type="checkbox" name="has_unified_ticket" id="has_unified_ticket" value="1"
                                    class="kt-checkbox w-5 h-5" {{ $touristSite->has_unified_ticket ? 'checked' : '' }}>
                                <label for="has_unified_ticket"
                                    class="kt-label font-semibold cursor-pointer text-blue-800">
                                    🎫 {{ __('main.has_unified_ticket') }}
                                </label>
                            </div>

                            <div id="travelPassesContainer"
                                class="mt-2 {{ $touristSite->has_unified_ticket ? '' : 'hidden' }}">
                                <label class="kt-label text-sm mb-1">{{ __('main.select_travel_pass') }}</label>
                                <select name="travel_passes[]" id="travel_passes" class="kt-select-multiple w-full"
                                    multiple>
                                    @foreach ($travelPasses as $pass)
                                        <option value="{{ $pass->id }}"
                                            {{ in_array($pass->id, $touristSite->travelPasses->pluck('id')->toArray()) ? 'selected' : '' }}>
                                            {{ $pass->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Facilities & Services -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.facilities_services') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach ($facilities as $facility)
                            <div class="flex items-center gap-4">
                                @include('components.elements.checkbox-button', [
                                    'name' => 'facilities[]',
                                    'id' => 'facility_' . $facility->id,
                                    'value' => $facility->id,
                                    'checked' => in_array(
                                        $facility->id,
                                        old('facilities', $touristSite->facilities->pluck('id')->toArray())),
                                    'label' => $facility->display_name,
                                ])
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Operating Hours -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.operating_hours') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                        <div class="col-span-full">
                            <div class="flex items-center gap-4">
                                <input type="hidden" name="is_24_7" value="0">
                                @include('components.elements.checkbox-button', [
                                    'name' => 'is_24_7',
                                    'id' => 'is_24_7',
                                    'value' => '1',
                                    'checked' => $touristSite->is_24_7,
                                    'label' => __('main.is_24_7'),
                                ])
                            </div>
                        </div>
                        <div class="{{ $touristSite->is_24_7 == 1 ? 'disabled-option' : '' }}"
                            id="opening_time_container">
                            <label for="opening_time" class="kt-label">{{ __('main.opening_time') }}</label>
                            <input type="time" name="opening_time" id="opening_time" class="kt-input h-[45px]"
                                value="{{ $touristSite->opening_time }}">
                        </div>
                        <div class="{{ $touristSite->is_24_7 == 1 ? 'disabled-option' : '' }}"
                            id="closing_time_container">
                            <label for="closing_time" class="kt-label">{{ __('main.closing_time') }}</label>
                            <input type="time" name="closing_time" id="closing_time" class="kt-input h-[45px]"
                                value="{{ $touristSite->closing_time }}">
                        </div>
                        <div class="col-span-full">
                            <label for="operating_days" class="kt-label">{{ __('main.operating_days') }}</label>
                            <div class="flex flex-wrap gap-4 mt-2">
                                @foreach (['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $day)
                                    <div class="flex items-center gap-4">
                                        <input type="hidden" name="" value="">
                                        @include('components.elements.checkbox-button', [
                                            'name' => 'operating_days[]',
                                            'id' => 'operating_day_' . $day,
                                            'value' => $day,
                                            'checked' =>
                                                $touristSite->operating_days &&
                                                in_array($day, $touristSite->operating_days),
                                            'label' => __('main.' . $day),
                                        ])
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-span-full border-t pt-4 mt-2">
                            <label class="kt-label mb-2 block font-semibold">{{ __('main.special_hours') }}</label>

                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <div class="flex items-end gap-3 mb-3">
                                    <div class="flex-1">
                                        <label class="text-xs text-gray-500 mb-1 block">{{ __('main.day') }}</label>
                                        <select id="sh_day" class="kt-select w-full h-[40px]">
                                            @foreach (['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $day)
                                                <option value="{{ $day }}">{{ __('main.' . $day) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label
                                            class="text-xs text-gray-500 mb-1 block">{{ __('main.opening_time') }}</label>
                                        <input type="time" id="sh_open" class="kt-input h-[40px]">
                                    </div>
                                    <div>
                                        <label
                                            class="text-xs text-gray-500 mb-1 block">{{ __('main.closing_time') }}</label>
                                        <input type="time" id="sh_close" class="kt-input h-[40px]">
                                    </div>
                                    <button type="button" id="addSpecialHourBtn" class="kt-btn kt-btn-primary h-[40px]">
                                        <i class="las la-plus"></i>
                                    </button>
                                </div>

                                <div id="specialHoursList" class="flex flex-col gap-2">
                                    <!-- Dynamic Rows -->
                                </div>

                                <input type="hidden" name="special_hours" id="special_hours_input"
                                    value="{{ $touristSite->special_hours }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Site Holidays -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.site_holidays') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div id="holidaysContainer">
                        @if ($touristSite->holidays && $touristSite->holidays->count() > 0)
                            @foreach ($touristSite->holidays as $index => $holiday)
                                <div
                                    class="holiday-row grid grid-cols-1 sm:grid-cols-5 gap-3 mb-3 p-3 bg-gray-50 rounded-lg border border-gray-200 items-end">
                                    <div>
                                        <label class="text-xs text-gray-500 mb-1 block">{{ __('main.type') }}</label>
                                        <select name="holidays[{{ $index }}][type]"
                                            class="kt-select w-full h-[40px] holiday-type-select"
                                            onchange="toggleHolidayFields(this)">
                                            <option value="weekly" {{ $holiday->type === 'weekly' ? 'selected' : '' }}>
                                                {{ __('main.weekly') }}</option>
                                            <option value="annual" {{ $holiday->type === 'annual' ? 'selected' : '' }}>
                                                {{ __('main.annual') }}</option>
                                            <option value="one_time"
                                                {{ $holiday->type === 'one_time' ? 'selected' : '' }}>
                                                {{ __('main.one_time') }}</option>
                                        </select>
                                    </div>
                                    <div class="holiday-day-field"
                                        style="{{ $holiday->type === 'weekly' ? '' : 'display:none' }}">
                                        <label class="text-xs text-gray-500 mb-1 block">{{ __('main.day') }}</label>
                                        <select name="holidays[{{ $index }}][day_of_week]"
                                            class="kt-select w-full h-[40px]">
                                            <option value="">--</option>
                                            @foreach (['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $day)
                                                <option value="{{ $day }}"
                                                    {{ $holiday->day_of_week === $day ? 'selected' : '' }}>
                                                    {{ __('main.' . $day) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="holiday-date-field"
                                        style="{{ $holiday->type !== 'weekly' ? '' : 'display:none' }}">
                                        <label class="text-xs text-gray-500 mb-1 block">{{ __('main.date') }}</label>
                                        <input type="date" name="holidays[{{ $index }}][holiday_date]"
                                            class="kt-input h-[40px] w-full"
                                            value="{{ $holiday->holiday_date?->format('Y-m-d') }}">
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-500 mb-1 block">{{ __('main.name') }}</label>
                                        <input type="text" name="holidays[{{ $index }}][name]"
                                            class="kt-input h-[40px] w-full" value="{{ $holiday->name }}"
                                            placeholder="{{ __('main.holiday_name') }}">
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-500 mb-1 block">{{ __('main.name_ar') }}</label>
                                        <input type="text" name="holidays[{{ $index }}][name_ar]"
                                            class="kt-input h-[40px] w-full" value="{{ $holiday->name_ar }}"
                                            placeholder="{{ __('main.holiday_name_ar') }}" dir="rtl">
                                    </div>
                                    <div class="flex items-end">
                                        <button type="button" class="kt-btn kt-btn-danger h-[40px]"
                                            onclick="this.closest('.holiday-row').remove()"
                                            title="{{ __('main.remove') }}">
                                            <i class="las la-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <button type="button" onclick="addHolidayRow()" class="kt-btn kt-btn-light mt-2">
                        <i class="las la-plus me-1"></i> {{ __('main.add_holiday') }}
                    </button>
                </div>
            </div>

            <!-- Seasonal Hours (Ramadan, Summer, etc.) -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.seasonal_hours') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div id="seasonalHoursContainer">
                        @if ($touristSite->seasonalHours && $touristSite->seasonalHours->count() > 0)
                            @foreach ($touristSite->seasonalHours as $index => $sh)
                                <div
                                    class="seasonal-row grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 mb-3 p-3 bg-gray-50 rounded-lg border border-gray-200 items-end">
                                    <div>
                                        <label
                                            class="text-xs text-gray-500 mb-1 block">{{ __('main.season_name') }}</label>
                                        <input type="text" name="seasonal_hours[{{ $index }}][season_name]"
                                            class="kt-input h-[40px] w-full" value="{{ $sh->season_name }}"
                                            placeholder="e.g. Ramadan, Summer">
                                    </div>
                                    <div>
                                        <label
                                            class="text-xs text-gray-500 mb-1 block">{{ __('main.season_name_ar') }}</label>
                                        <input type="text" name="seasonal_hours[{{ $index }}][season_name_ar]"
                                            class="kt-input h-[40px] w-full" value="{{ $sh->season_name_ar }}"
                                            placeholder="مثل: رمضان، صيف" dir="rtl">
                                    </div>
                                    <div>
                                        <label
                                            class="text-xs text-gray-500 mb-1 block">{{ __('main.start_date') }}</label>
                                        <input type="date" name="seasonal_hours[{{ $index }}][start_date]"
                                            class="kt-input h-[40px] w-full"
                                            value="{{ $sh->start_date?->format('Y-m-d') }}">
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-500 mb-1 block">{{ __('main.end_date') }}</label>
                                        <input type="date" name="seasonal_hours[{{ $index }}][end_date]"
                                            class="kt-input h-[40px] w-full"
                                            value="{{ $sh->end_date?->format('Y-m-d') }}">
                                    </div>
                                    <div>
                                        <label
                                            class="text-xs text-gray-500 mb-1 block">{{ __('main.opening_time') }}</label>
                                        <input type="time" name="seasonal_hours[{{ $index }}][opening_time]"
                                            class="kt-input h-[40px] w-full" value="{{ $sh->opening_time }}">
                                    </div>
                                    <div>
                                        <label
                                            class="text-xs text-gray-500 mb-1 block">{{ __('main.closing_time') }}</label>
                                        <input type="time" name="seasonal_hours[{{ $index }}][closing_time]"
                                            class="kt-input h-[40px] w-full" value="{{ $sh->closing_time }}">
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="seasonal_hours[{{ $index }}][is_closed]"
                                                value="1" class="kt-checkbox"
                                                {{ $sh->is_closed ? 'checked' : '' }}>
                                            <span class="text-sm">{{ __('main.closed') }}</span>
                                        </label>
                                    </div>
                                    <div class="flex items-end">
                                        <button type="button" class="kt-btn kt-btn-danger h-[40px]"
                                            onclick="this.closest('.seasonal-row').remove()"
                                            title="{{ __('main.remove') }}">
                                            <i class="las la-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <button type="button" onclick="addSeasonalRow()" class="kt-btn kt-btn-light mt-2">
                        <i class="las la-plus me-1"></i> {{ __('main.add_seasonal_hours') }}
                    </button>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.contact_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                        <div>
                            <label for="phone" class="kt-label">{{ __('main.phone') }}</label>
                            <input type="tel" name="phone" id="phone" class="kt-input h-[45px]"
                                value="{{ $touristSite->phone }}">
                        </div>
                        <div>
                            <label for="mobile" class="kt-label">{{ __('main.mobile') }}</label>
                            <input type="tel" name="mobile" id="mobile" class="kt-input h-[45px]"
                                value="{{ $touristSite->mobile }}">
                        </div>
                        <div>
                            <label for="email" class="kt-label">{{ __('main.email') }}</label>
                            <input type="email" name="email" id="email" class="kt-input h-[45px]"
                                value="{{ $touristSite->email }}">
                        </div>
                        <div>
                            <label for="fax" class="kt-label">{{ __('main.fax') }}</label>
                            <input type="tel" name="fax" id="fax" class="kt-input h-[45px]"
                                value="{{ $touristSite->fax }}">
                        </div>
                        <div>
                            <label for="contact_person" class="kt-label">{{ __('main.contact_person') }}</label>
                            <input type="text" name="contact_person" id="contact_person" class="kt-input h-[45px]"
                                value="{{ $touristSite->contact_person }}">
                        </div>
                        <div>
                            <label for="website_url" class="kt-label">{{ __('main.website_url') }}</label>
                            <input type="url" name="website_url" id="website_url" class="kt-input h-[45px]"
                                value="{{ $touristSite->website_url }}">
                        </div>
                        <div>
                            <label for="facebook_url" class="kt-label">{{ __('main.facebook_url') }}</label>
                            <input type="url" name="facebook_url" id="facebook_url" class="kt-input h-[45px]"
                                value="{{ $touristSite->facebook_url }}">
                        </div>
                        <div>
                            <label for="instagram_url" class="kt-label">{{ __('main.instagram_url') }}</label>
                            <input type="url" name="instagram_url" id="instagram_url" class="kt-input h-[45px]"
                                value="{{ $touristSite->instagram_url }}">
                        </div>
                        <div>
                            <label for="twitter_url" class="kt-label">{{ __('main.twitter_url') }}</label>
                            <input type="url" name="twitter_url" id="twitter_url" class="kt-input h-[45px]"
                                value="{{ $touristSite->twitter_url }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Visitor Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.visitor_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        <div>
                            <label for="average_rating" class="kt-label">{{ __('main.average_rating') }}</label>
                            <input type="number" step="0.01" min="0" max="5" name="average_rating"
                                id="average_rating" class="kt-input h-[45px]"
                                value="{{ $touristSite->average_rating }}">
                        </div>
                        <div>
                            <label for="total_reviews" class="kt-label">{{ __('main.total_reviews') }}</label>
                            <input type="number" min="0" name="total_reviews" id="total_reviews"
                                class="kt-input h-[45px]" value="{{ $touristSite->total_reviews }}">
                        </div>
                        <div>
                            <label for="popularity_score" class="kt-label">{{ __('main.popularity_score') }}</label>
                            <input type="number" min="0" max="100" name="popularity_score"
                                id="popularity_score" class="kt-input h-[45px]"
                                value="{{ $touristSite->popularity_score }}">
                        </div>
                        <div>
                            <label for="estimated_visit_duration"
                                class="kt-label">{{ __('main.estimated_visit_duration') }} (minutes)</label>
                            <input type="number" min="0" name="estimated_visit_duration"
                                id="estimated_visit_duration" class="kt-input h-[45px]"
                                value="{{ $touristSite->estimated_visit_duration }}">
                        </div>
                        <div>
                            <label for="difficulty_level" class="kt-label">{{ __('main.difficulty_level') }}</label>
                            <select name="difficulty_level" id="difficulty_level" class="kt-select basic-single">
                                <option value="" selected>--</option>
                                @foreach ($difficulty_level as $level)
                                    <option value="{{ $level }}"
                                        {{ $touristSite->difficulty_level == $level ? 'selected' : '' }}>
                                        {{ $level }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="status" class="kt-label">{{ __('main.status') }}</label>
                            <select name="status" id="status" class="kt-select basic-single">
                                <option value="" selected>--</option>
                                @foreach ($status as $stat)
                                    <option value="{{ $stat }}"
                                        {{ $touristSite->status == $stat ? 'selected' : '' }}>{{ $stat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Status Fields -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.additional_options') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="flex flex-wrap gap-4">
                        <div class="flex items-center gap-4">
                            <input type="hidden" name="is_featured" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'is_featured',
                                'id' => 'is_featured',
                                'value' => '1',
                                'checked' => $touristSite->is_featured,
                                'label' => __('main.is_featured'),
                            ])
                        </div>
                        <div class="flex items-center gap-4">
                            <input type="hidden" name="is_verified" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'is_verified',
                                'id' => 'is_verified',
                                'value' => '1',
                                'checked' => $touristSite->is_verified,
                                'label' => __('main.is_verified'),
                            ])
                        </div>
                    </div>
                </div>
            </div>

            <!-- Media Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">
                        {{ __('main.type_information', ['type' => __('main.media')]) }}
                    </h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="photo" class="kt-label">{{ __('main.main_image') }}</label>
                            <div class="dropzone mt-2 border-2 border-dashed border-gray-200 rounded-lg p-4 text-center hover:border-primary transition-colors cursor-pointer"
                                data-input="photo" data-preview="preview-photo">
                                <i class="far fa-cloud-arrow-up text-5xl text-gray-600"></i>
                                <p class="mt-4">{{ __('main.click_or_drag_image_here') }}</p>
                            </div>
                            <input type="file" name="photo" id="photo" accept="image/*" hidden>
                            <input type="hidden" name="remove_photo" id="remove_photo" value="0">

                            {{-- Existing photo (edit mode) --}}
                            @if (!empty($touristSite->photo))
                                <div id="existing-photo" class="relative w-fit mt-8">
                                    <img src="{{ asset('storage/' . $touristSite->photo) }}" class="h-32 w-32 rounded">
                                    <button type="button"
                                        class="remove-existing-photo absolute -top-2 -right-2 bg-danger cursor-pointer text-white w-6 h-6 rounded-full">
                                        ×
                                    </button>
                                </div>
                            @endif

                            <div id="preview-photo" class="hidden mt-8"></div>
                        </div>
                        <div>
                            <label for="gallery" class="kt-label">{{ __('main.gallery_images') }}</label>
                            <div class="dropzone mt-2 border-2 border-dashed border-gray-200 rounded-lg p-4 text-center hover:border-primary transition-colors cursor-pointer"
                                data-input="gallery" data-preview="preview-gallery">
                                <i class="far fa-cloud-arrow-up text-5xl text-gray-600"></i>
                                <p class="mt-4">{{ __('main.click_or_drag_image_here_multiple') }}</p>
                            </div>
                            <input type="file" name="gallery[]" id="gallery" accept="image/*" hidden multiple>
                            <input type="hidden" name="removed_gallery" id="removed_gallery" value="[]">

                            <!-- Existing Gallery Images -->
                            <div class="mt-4 flex flex-wrap gap-4">
                                @if (is_array($touristSite->gallery))
                                    @foreach ($touristSite->gallery as $index => $img)
                                        <div id="existing_gallery_{{ $index }}" class="relative">
                                            <img src="{{ asset('storage/' . $img) }}" class="h-32 w-32 rounded">
                                            <button type="button"
                                                class="remove-existing-gallery absolute -top-2 -right-2 bg-danger cursor-pointer text-white w-6 h-6 rounded-full"
                                                data-index="{{ $index }}" data-path="{{ $img }}">
                                                ×
                                            </button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <div id="preview-gallery" class="hidden flex gap-3 mt-3"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- description -->
            @include('components.elements.input-text-editor', [
                'column' => 'description',
                'value' => $touristSite->description?->body ?? '',
            ])

            <!-- nearby_attractions -->
            @include('components.elements.input-text-editor', [
                'column' => 'nearby_attractions',
                'value' => $touristSite->nearby_attractions?->body ?? '',
            ])

            <!-- notes -->
            @include('components.elements.input-text-editor', [
                'column' => 'notes',
                'value' => $touristSite->notes?->body ?? '',
            ])

            <x-custom-fields module-name="tourists" entity-type="TouristSite" :entity="$touristSite" />

            <!-- is_active -->
            <div class="flex items-center gap-4">
                <input type="hidden" name="is_active" value="0">
                @include('components.elements.checkbox-button', [
                    'name' => 'is_active',
                    'id' => 'is_active',
                    'value' => '1',
                    'checked' => $touristSite->is_active,
                    'label' => __('main.is_active'),
                ])
            </div>

            <!-- Update Submit -->
            @include('components.elements.update-submit', [
                'models' => 'dashboard.touristsites.sites',
                'model' => 'tourist-site',
            ])
    </div>
    </form>
    </div>
@endsection

@push('scripts')
    @include('components.scripts.drag-drop-images', [
        'fieldsMap' => ['photo' => 'photo', 'gallery' => 'gallery'],
    ])

    <script>
        const is_24_7Checkbox = document.getElementById('is_24_7');
        const openingTimeInput = document.getElementById('opening_time');
        const closingTimeInput = document.getElementById('closing_time');
        is_24_7Checkbox.addEventListener('change', function() {
            if (this.checked) {
                openingTimeInput.classList.add('disabled');
                closingTimeInput.classList.add('disabled');
            } else {
                openingTimeInput.classList.remove('disabled');
                closingTimeInput.classList.remove('disabled');
            }
        });

        const isFreeEntryCheckbox = document.getElementById('is_free_entry');
        const entryFeesCheckBoxes = document.querySelectorAll('.entry_feesCheckBox');
        isFreeEntryCheckbox.addEventListener('change', function() {
            console.log('status', this.checked);

            if (this.checked) {
                entryFeesCheckBoxes.forEach(element => element.classList.add('disabled'));
            } else {
                entryFeesCheckBoxes.forEach(element => element.classList.remove('disabled'));
            }
        });

        // Initialize Select2 on nationality dropdown for searchable filtering
        const $nationalitySelect = $('#nationalitySelect').select2({
            allowClear: true,
            width: '400px'
        });

        // Initialize other Select2 inputs
        $('.kt-select-multiple').select2({
            width: '100%',
            closeOnSelect: false
        });

        // Unified Ticket Toggle
        const unifiedTicketCheckbox = document.getElementById('has_unified_ticket');
        const travelPassesContainer = document.getElementById('travelPassesContainer');
        if (unifiedTicketCheckbox) {
            unifiedTicketCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    travelPassesContainer.classList.remove('hidden');
                } else {
                    travelPassesContainer.classList.add('hidden');
                }
            });
        }

        // Special Hours Logic
        const specialHoursInput = document.getElementById('special_hours_input');
        const specialHoursList = document.getElementById('specialHoursList');
        let specialHoursData = {};

        try {
            // specialized logic to handle if value is object or string
            let rawVal = specialHoursInput.value;
            // logic to handle different json formats if necessary
            if (rawVal && rawVal !== '[]' && rawVal !== '{}') {
                // specific check if it's already an object (unlikely in hidden input value unless blade printed array)
                // Based on blade json directive, it should be a valid JSON string
                specialHoursData = JSON.parse(rawVal);
            }
        } catch (e) {
            console.warn("Parsing special_hours", e);
        }

        function renderSpecialHours() {
            specialHoursList.innerHTML = '';
            if (specialHoursData && typeof specialHoursData === 'object') {
                for (const [day, times] of Object.entries(specialHoursData)) {
                    if (!times) continue;
                    // Check if times is object {opening, closing}
                    const open = times.opening || '??';
                    const close = times.closing || '??';

                    const row = document.createElement('div');
                    row.className = 'flex items-center gap-3 bg-white p-2 border rounded shadow-sm';
                    row.innerHTML = `
                         <div class="flex-1 font-medium capitalize flex items-center gap-2">
                            <span class="w-24 text-sm font-bold text-gray-700">${day}</span>
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded border">${open} - ${close}</span>
                        </div>
                        <button type="button" class="text-red-500 hover:text-red-700 p-1" onclick="removeSpecialHour('${day}')">
                            <i class="las la-trash text-lg"></i>
                        </button>
                    `;
                    specialHoursList.appendChild(row);
                }
            }
            specialHoursInput.value = JSON.stringify(specialHoursData);
        }

        document.getElementById('addSpecialHourBtn').addEventListener('click', function() {
            const day = document.getElementById('sh_day').value;
            const open = document.getElementById('sh_open').value;
            const close = document.getElementById('sh_close').value;

            if (!day || !open || !close) {
                alert('Please select day and times');
                return;
            }

            specialHoursData[day] = {
                opening: open,
                closing: close
            };
            renderSpecialHours();

            // Reset inputs
            document.getElementById('sh_open').value = '';
            document.getElementById('sh_close').value = '';
        });

        window.removeSpecialHour = function(day) {
            delete specialHoursData[day];
            renderSpecialHours();
        };

        renderSpecialHours();

        // Dynamic Nationality Cards (vertical layout instead of horizontal columns)
        const addedNationalities = new Set();
        const cardsContainer = document.getElementById('nationalityCardsContainer');

        function addNationalityCard(id, name, adultPrice = '', childPrice = '') {
            if (!id || addedNationalities.has(id)) return;
            if (document.querySelector(`input[name="nationality_entry_fees[${id}][nationality_id]"]`)) return;

            addedNationalities.add(id);

            const card = document.createElement('div');
            card.className = 'border border-gray-200 rounded-lg p-3 bg-gray-50 hover:bg-white transition-colors';
            card.id = `nationality-card-${id}`;
            card.innerHTML = `
                <div class="flex items-center justify-between gap-4 flex-wrap">
                    <div class="flex items-center gap-2 min-w-[180px]">
                        <span class="text-sm font-semibold text-gray-800">🌍 ${name}</span>
                        <input type="hidden" name="nationality_entry_fees[${id}][nationality_id]" value="${id}">
                    </div>
                    <div class="flex items-center gap-4 flex-wrap flex-1">
                        <div class="flex items-center gap-2 relative">
                            <label class="text-xs text-gray-500 whitespace-nowrap">👨 {{ __('main.adult') }}:</label>
                            <div class="relative flex items-center">
                                <input type="number" step="0.01" min="0" 
                                    name="nationality_entry_fees[${id}][adult_price]" 
                                    class="kt-input text-center w-32 pr-12" 
                                    value="${adultPrice}"
                                    placeholder="0.00">
                                <span class="currency-code text-[10px] text-gray-400 absolute right-3 font-semibold">${getCurrencyCode()}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 relative">
                            <label class="text-xs text-gray-500 whitespace-nowrap">👶 {{ __('main.child') }}:</label>
                            <div class="relative flex items-center">
                                <input type="number" step="0.01" min="0" 
                                    name="nationality_entry_fees[${id}][child_price]" 
                                    class="kt-input text-center w-32 pr-12" 
                                    value="${childPrice}"
                                    placeholder="0.00">
                                <span class="currency-code text-[10px] text-gray-400 absolute right-3 font-semibold">${getCurrencyCode()}</span>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="text-red-500 hover:text-red-700 font-bold text-lg px-2"
                        onclick="removeNationalityCard('${id}')">
                        &times;
                    </button>
                </div>
            `;
            cardsContainer.appendChild(card);
        }

        document.getElementById('addNationalityBtn').addEventListener('click', function() {
            const select = document.getElementById('nationalitySelect');
            const id = select.value;
            const name = select.options[select.selectedIndex]?.text?.trim();

            if (!id) return;
            if (addedNationalities.has(id)) {
                alert('{{ __('main.nationality_already_added') }}');
                return;
            }

            addNationalityCard(id, name);
            // Reset Select2
            $('#nationalitySelect').val('').trigger('change');
        });

        window.removeNationalityCard = function(id) {
            const card = document.getElementById(`nationality-card-${id}`);
            if (card) {
                card.remove();
                addedNationalities.delete(id);
            }
        };

        // Initialize existing fees from database
        const existingFees = @json($touristSite->nationalityEntryFees->load('nationality'));
        if (existingFees && Array.isArray(existingFees)) {
            existingFees.forEach(fee => {
                if (fee.nationality) {
                    addNationalityCard(
                        String(fee.nationality.id),
                        fee.nationality.name,
                        fee.adult_price,
                        fee.child_price
                    );
                }
            });
        }

        // Handle old() input values if validation failed
        const oldFees = @json(old('nationality_entry_fees'));
        if (oldFees) {
            Object.keys(oldFees).forEach(id => {
                if (!addedNationalities.has(id)) {
                    const selectEl = document.getElementById('nationalitySelect');
                    const option = selectEl.querySelector(`option[value="${id}"]`);
                    const name = option ? option.text.trim() : `Nationality #${id}`;
                    addNationalityCard(id, name, oldFees[id].adult_price || '', oldFees[id].child_price || '');
                }
            });
        }
        // ========== Currency Code Display ==========
        function getCurrencyCode() {
            var currencySelect = document.getElementById('currency_id');
            if (!currencySelect || !currencySelect.value) return '';
            var selectedOption = currencySelect.options[currencySelect.selectedIndex];
            if (!selectedOption || !selectedOption.text) return '';
            // Format: "JOD - Jordanian Dinar" → extract "JOD"
            return selectedOption.text.trim().split(' ')[0] || '';
        }

        function updateCurrencyLabels() {
            var code = getCurrencyCode();
            var badges = document.querySelectorAll('.currency-badge');
            badges.forEach(function(badge) {
                badge.textContent = code;
            });
        }

        function addCurrencyBadges() {
            // Unify all currency badges to use the same class and logic
            var code = getCurrencyCode();
            document.querySelectorAll('.currency-code').forEach(function(span) {
                span.textContent = code;
            });
        }

        // Initialize currency labels
        addCurrencyBadges();

        // Listen for currency dropdown change (Select2 + native)
        var currencyEl = document.getElementById('currency_id');
        if (currencyEl) {
            if (typeof $ !== 'undefined' && $.fn.select2) {
                $('#currency_id').on('change', function() {
                    updateCurrencyLabels();
                });
            } else {
                currencyEl.addEventListener('change', function() {
                    updateCurrencyLabels();
                });
            }
        }

        // Handle Unified Ticket Toggle
        const unifiedTicketCheckbox = document.getElementById('has_unified_ticket');
        const travelPassesContainer = document.getElementById('travelPassesContainer');
        if (unifiedTicketCheckbox && travelPassesContainer) {
            unifiedTicketCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    travelPassesContainer.classList.remove('hidden');
                } else {
                    travelPassesContainer.classList.add('hidden');
                }
            });
        }
        // Handle Free Entry Toggle
        const freeEntryCheckbox = document.getElementById('is_free_entry');
        const entryFeesContainer = document.getElementById('entryFeesContainer');
        if (freeEntryCheckbox && entryFeesContainer) {
            freeEntryCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    entryFeesContainer.classList.add('disabled-option');
                } else {
                    entryFeesContainer.classList.remove('disabled-option');
                }
            });
        }

        // Handle 24/7 Toggle
        const is247Checkbox = document.getElementById('is_24_7');
        const openingTimeContainer = document.getElementById('opening_time_container');
        const closingTimeContainer = document.getElementById('closing_time_container');
        if (is247Checkbox) {
            is247Checkbox.addEventListener('change', function() {
                if (this.checked) {
                    if (openingTimeContainer) openingTimeContainer.classList.add('disabled-option');
                    if (closingTimeContainer) closingTimeContainer.classList.add('disabled-option');
                } else {
                    if (openingTimeContainer) openingTimeContainer.classList.remove('disabled-option');
                    if (closingTimeContainer) closingTimeContainer.classList.remove('disabled-option');
                }
            });
        }

        // ========== Holidays Dynamic Rows ==========
        @php
            $holidayDaysData = [];
            foreach (['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $d) {
                $holidayDaysData[] = ['value' => $d, 'label' => __('main.' . $d)];
            }
        @endphp

        window._holidayIndex = document.querySelectorAll('.holiday-row').length;
        window._holidayDays = {!! json_encode($holidayDaysData) !!};
        window._seasonalIndex = document.querySelectorAll('.seasonal-row').length;

        window.addHolidayRow = function() {
            const i = window._holidayIndex++;
            const dayOptions = window._holidayDays.map(d => `<option value="${d.value}">${d.label}</option>`).join('');
            const html = `
                <div class="holiday-row grid grid-cols-1 sm:grid-cols-5 gap-3 mb-3 p-3 bg-gray-50 rounded-lg border border-gray-200 items-end">
                    <div>
                        <label class="text-xs text-gray-500 mb-1 block">{{ __('main.type') }}</label>
                        <select name="holidays[${i}][type]" class="kt-select w-full h-[40px] holiday-type-select" onchange="toggleHolidayFields(this)">
                            <option value="weekly">{{ __('main.weekly') }}</option>
                            <option value="annual">{{ __('main.annual') }}</option>
                            <option value="one_time">{{ __('main.one_time') }}</option>
                        </select>
                    </div>
                    <div class="holiday-day-field">
                        <label class="text-xs text-gray-500 mb-1 block">{{ __('main.day') }}</label>
                        <select name="holidays[${i}][day_of_week]" class="kt-select w-full h-[40px]">
                            <option value="">--</option>
                            ${dayOptions}
                        </select>
                    </div>
                    <div class="holiday-date-field" style="display:none">
                        <label class="text-xs text-gray-500 mb-1 block">{{ __('main.date') }}</label>
                        <input type="date" name="holidays[${i}][holiday_date]" class="kt-input h-[40px] w-full">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 mb-1 block">{{ __('main.name') }}</label>
                        <input type="text" name="holidays[${i}][name]" class="kt-input h-[40px] w-full" placeholder="{{ __('main.holiday_name') }}">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 mb-1 block">{{ __('main.name_ar') }}</label>
                        <input type="text" name="holidays[${i}][name_ar]" class="kt-input h-[40px] w-full" placeholder="{{ __('main.holiday_name_ar') }}" dir="rtl">
                    </div>
                    <div class="flex items-end">
                        <button type="button" class="kt-btn kt-btn-danger h-[40px]" onclick="this.closest('.holiday-row').remove()" title="{{ __('main.remove') }}">
                            <i class="las la-trash"></i>
                        </button>
                    </div>
                </div>`;
            document.getElementById('holidaysContainer').insertAdjacentHTML('beforeend', html);
        };

        // Holiday: Toggle day/date fields based on type
        window.toggleHolidayFields = function(select) {
            const row = select.closest('.holiday-row');
            const dayField = row.querySelector('.holiday-day-field');
            const dateField = row.querySelector('.holiday-date-field');
            if (select.value === 'weekly') {
                dayField.style.display = '';
                dateField.style.display = 'none';
            } else {
                dayField.style.display = 'none';
                dateField.style.display = '';
            }
        };

        // ========== Seasonal Hours Dynamic Rows ==========
        window.addSeasonalRow = function() {
            const i = window._seasonalIndex++;
            const html = `
                <div class="seasonal-row grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 mb-3 p-3 bg-gray-50 rounded-lg border border-gray-200 items-end">
                    <div>
                        <label class="text-xs text-gray-500 mb-1 block">{{ __('main.season_name') }}</label>
                        <input type="text" name="seasonal_hours[${i}][season_name]" class="kt-input h-[40px] w-full" placeholder="e.g. Ramadan, Summer">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 mb-1 block">{{ __('main.season_name_ar') }}</label>
                        <input type="text" name="seasonal_hours[${i}][season_name_ar]" class="kt-input h-[40px] w-full" placeholder="مثل: رمضان، صيف" dir="rtl">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 mb-1 block">{{ __('main.start_date') }}</label>
                        <input type="date" name="seasonal_hours[${i}][start_date]" class="kt-input h-[40px] w-full">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 mb-1 block">{{ __('main.end_date') }}</label>
                        <input type="date" name="seasonal_hours[${i}][end_date]" class="kt-input h-[40px] w-full">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 mb-1 block">{{ __('main.opening_time') }}</label>
                        <input type="time" name="seasonal_hours[${i}][opening_time]" class="kt-input h-[40px] w-full">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 mb-1 block">{{ __('main.closing_time') }}</label>
                        <input type="time" name="seasonal_hours[${i}][closing_time]" class="kt-input h-[40px] w-full">
                    </div>
                    <div class="flex items-center gap-3">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="seasonal_hours[${i}][is_closed]" value="1" class="kt-checkbox">
                            <span class="text-sm">{{ __('main.closed') }}</span>
                        </label>
                    </div>
                    <div class="flex items-end">
                        <button type="button" class="kt-btn kt-btn-danger h-[40px]" onclick="this.closest('.seasonal-row').remove()" title="{{ __('main.remove') }}">
                            <i class="las la-trash"></i>
                        </button>
                    </div>
                </div>`;
            document.getElementById('seasonalHoursContainer').insertAdjacentHTML('beforeend', html);
        };
    </script>
@endpush
