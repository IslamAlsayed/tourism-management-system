@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.tourist-site')]))

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.tourist-site')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.tourist-site')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.touristsites.sites.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tourist-sites')]) }}
                </a>
            </div>
        </div>

        @include('components.must-add-first', [
            'requirements' => [
                [
                    'condition' => \Modules\Geography\Entities\Country::count() > 0,
                    'route' => route('dashboard.geography.countries.index'),
                    'label' => __('main.countries'),
                ],
                [
                    'condition' => \Modules\Geography\Entities\State::count() > 0,
                    'route' => route('dashboard.geography.states.index'),
                    'label' => __('main.states'),
                ],
                [
                    'condition' => \Modules\Geography\Entities\City::count() > 0,
                    'route' => route('dashboard.geography.cities.index'),
                    'label' => __('main.cities'),
                ],
            ],
        ])
    </div>

    <div class="container-fixed">
        <form action="{{ route('dashboard.touristsites.sites.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-4 lg:gap-6">
                <!-- Location Information -->
                <div class="kt-card pb-2.5">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.location')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-content grid gap-5">
                        {{-- Regions [country, state, city] --}}
                        @livewire('geography::livewire.regions.location-select-base')

                        <!-- Latitude -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label for="latitude" class="kt-form-label max-w-56">{{ __('main.latitude') }}</label>
                            <input type="number" step="0.00000001" min="-90" max="90" name="latitude"
                                id="latitude" class="kt-input" value="{{ old('latitude') }}" placeholder="-90 to 90">
                        </div>

                        <!-- Longitude -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label for="longitude" class="kt-form-label max-w-56">{{ __('main.longitude') }}</label>
                            <input type="number" step="0.00000001" min="-180" max="180" name="longitude"
                                id="longitude" class="kt-input" value="{{ old('longitude') }}" placeholder="-180 to 180">
                        </div>

                        <!-- Postal Code -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label for="postal_code" class="kt-form-label max-w-56">{{ __('main.postal_code') }}</label>
                            <input type="text" name="postal_code" id="postal_code" class="kt-input"
                                value="{{ old('postal_code') }}" placeholder="Postal code">
                        </div>

                        <!-- Currency -->
                        @include('components.selects.currency')

                        <!-- address -->
                        @include('components.elements.input-text-editor', [
                            'column' => 'address',
                            'value' => old('address'),
                        ])
                    </div>
                </div>

                <!-- Basic Information -->
                <div class="kt-card pb-2.5">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.tourist-site')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-content grid gap-5">
                        <!-- UNESCO Site Checkbox -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label class="kt-form-label max-w-56">{{ __('main.unesco_site') }}</label>
                            <div class="flex items-center gap-4">
                                <input type="hidden" name="unesco_site" value="0">
                                @include('components.elements.checkbox-button', [
                                    'name' => 'unesco_site',
                                    'id' => 'unesco_site',
                                    'value' => '1',
                                    'checked' => old('unesco_site', 0) == 1,
                                    'label' => __('main.unesco_site'),
                                ])
                            </div>
                        </div>

                        <!-- Name -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label for="name" class="kt-form-label max-w-56 required">
                                {{ __('main.name') }}
                                <span class="text-red-600 text-2xl">*</span>
                            </label>
                            <input type="text" name="name" id="name" class="kt-input" required
                                value="{{ old('name') }}" placeholder="Enter site name">
                        </div>

                        <!-- Arabic Name -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label for="name_ar" class="kt-form-label max-w-56">{{ __('main.name_ar') }}</label>
                            <input type="text" name="name_ar" id="name_ar" class="kt-input"
                                value="{{ old('name_ar') }}" placeholder="الاسم بالعربية">
                        </div>

                        <!-- Site Type -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5 border-t pt-4">
                            <label class="kt-form-label max-w-56">{{ __('main.site_type') }}</label>
                            <div class="flex flex-wrap gap-3 flex-1">
                                @foreach ($site_types as $type)
                                    <div class="flex items-center gap-2">
                                        <input type="checkbox" name="site_type[]" id="site_type_{{ $type->key }}"
                                            value="{{ $type->key }}" class="kt-checkbox"
                                            {{ in_array($type->key, old('site_type', [])) ? 'checked' : '' }}>
                                        <label for="site_type_{{ $type->key }}"
                                            class="text-sm cursor-pointer">{{ $type->display_name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5 border-t pt-4">
                            <label class="kt-form-label max-w-56">{{ __('main.category') }}</label>
                            <div class="flex flex-wrap gap-3 flex-1">
                                @foreach ($site_categories as $cat)
                                    <div class="flex items-center gap-2">
                                        <input type="checkbox" name="category[]" id="category_{{ $cat->key }}"
                                            value="{{ $cat->key }}" class="kt-checkbox"
                                            {{ in_array($cat->key, old('category', [])) ? 'checked' : '' }}>
                                        <label for="category_{{ $cat->key }}"
                                            class="text-sm cursor-pointer">{{ $cat->display_name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Supplier Type -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5 border-t pt-4">
                            <label class="kt-form-label max-w-56">{{ __('main.supplier_type') }}</label>
                            <div class="flex flex-wrap gap-3 flex-1">
                                @foreach ($supplier_types as $stype)
                                    <div class="flex items-center gap-2">
                                        <input type="checkbox" name="supplier_type[]"
                                            id="supplier_type_{{ $stype->key }}" value="{{ $stype->key }}"
                                            class="kt-checkbox"
                                            {{ in_array($stype->key, old('supplier_type', [])) ? 'checked' : '' }}>
                                        <label for="supplier_type_{{ $stype->key }}"
                                            class="text-sm cursor-pointer">{{ $stype->display_name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Sites Theme -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5 border-t pt-4">
                            <label class="kt-form-label max-w-56">{{ __('main.sites_theme') }}</label>
                            <div class="flex flex-wrap gap-3 flex-1">
                                @foreach ($site_themes as $theme)
                                    <div class="flex items-center gap-2">
                                        <input type="checkbox" name="sites_theme[]" id="sites_theme_{{ $theme->key }}"
                                            value="{{ $theme->key }}" class="kt-checkbox"
                                            {{ in_array($theme->key, old('sites_theme', [])) ? 'checked' : '' }}>
                                        <label for="sites_theme_{{ $theme->key }}"
                                            class="text-sm cursor-pointer">{{ $theme->display_name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Supplier Name -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label for="supplier_name"
                                class="kt-form-label max-w-56">{{ __('main.supplier_name') }}</label>
                            <input type="text" name="supplier_name" id="supplier_name" class="kt-input"
                                value="{{ old('supplier_name') }}" placeholder="Supplier name">
                        </div>

                        <!-- Sort Order -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label for="sort_order" class="kt-form-label max-w-56">{{ __('main.sort_order') }}</label>
                            <input type="number" name="sort_order" id="sort_order" class="kt-input"
                                value="{{ old('sort_order', 0) }}">
                        </div>
                    </div>
                </div>

                <!-- Entry Fees -->
                <div class="kt-card pb-2.5">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.entry_fees') }}</h3>
                    </div>
                    <div class="kt-card-content grid gap-5">
                        <!-- Free Entry Checkbox -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label class="kt-form-label max-w-56">{{ __('main.is_free_entry') }}</label>
                            <div class="flex items-center gap-4">
                                <input type="hidden" name="is_free_entry" value="0">
                                @include('components.elements.checkbox-button', [
                                    'name' => 'is_free_entry',
                                    'id' => 'is_free_entry',
                                    'value' => '1',
                                    'checked' => old('is_free_entry', 0) == 1,
                                    'label' => __('main.is_free_entry'),
                                ])
                            </div>
                        </div>

                        <!-- Entry Fees Table -->
                        <div class="flex flex-col gap-4">
                            <!-- Add Nationality Control -->
                            <div class="flex items-center gap-4">
                                <label
                                    class="kt-form-label font-bold text-lg min-w-fit">{{ __('main.entry_fees') }}</label>
                                <div class="flex-1 flex items-center gap-2">
                                    <select id="nationalitySelect" class="kt-select w-64 h-[40px]">
                                        <option value="">{{ __('main.select') }} {{ __('main.nationality') }}
                                        </option>
                                        @foreach ($nationalities as $nationality)
                                            <option value="{{ $nationality->id }}">{{ $nationality->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" id="addNationalityBtn"
                                        class="kt-btn kt-btn-primary h-[40px] px-4">
                                        {{ __('main.add') }}
                                    </button>
                                </div>
                            </div>

                            <div class="flex-1 overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg"
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
                                            <!-- Dynamic Nationality Headers will be appended here -->
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <!-- Adult Row -->
                                        <tr class="hover:bg-gray-50 entry_feesCheckBox" id="adultRow">
                                            <td
                                                class="px-4 py-3 text-sm font-medium text-gray-900 border-r bg-blue-50 whitespace-nowrap">
                                                👨 {{ __('main.adult') }}
                                            </td>
                                            <td class="px-2 py-2 border-r">
                                                <input type="number" step="0.01" min="0"
                                                    name="entry_fee_adult" id="entry_fee_adult"
                                                    class="kt-input text-center w-full"
                                                    value="{{ old('entry_fee_adult') }}" placeholder="0.00">
                                            </td>
                                            <td class="px-2 py-2 border-r">
                                                <input type="number" step="0.01" min="0"
                                                    name="entry_fee_foreigner_adult" class="kt-input text-center w-full"
                                                    value="{{ old('entry_fee_foreigner_adult') }}" placeholder="0.00">
                                            </td>
                                            <td class="px-2 py-2 border-r">
                                                <input type="number" step="0.01" min="0"
                                                    name="entry_fee_arab_adult" class="kt-input text-center w-full"
                                                    value="{{ old('entry_fee_arab_adult') }}" placeholder="0.00">
                                            </td>
                                            <td class="px-2 py-2 border-r">
                                                <input type="number" step="0.01" min="0"
                                                    name="entry_fee_local_adult" class="kt-input text-center w-full"
                                                    value="{{ old('entry_fee_local_adult') }}" placeholder="0.00">
                                            </td>
                                            <td class="px-2 py-2 border-r">
                                                <input type="number" step="0.01" min="0"
                                                    name="entry_fee_resident_adult" class="kt-input text-center w-full"
                                                    value="{{ old('entry_fee_resident_adult') }}" placeholder="0.00">
                                            </td>
                                            <!-- Dynamic Adult Inputs -->
                                        </tr>

                                        <!-- Child Row -->
                                        <tr class="hover:bg-gray-50 entry_feesCheckBox" id="childRow">
                                            <td
                                                class="px-4 py-3 text-sm font-medium text-gray-900 border-r bg-green-50 whitespace-nowrap">
                                                👶 {{ __('main.child') }}
                                            </td>
                                            <td class="px-2 py-2 border-r">
                                                <input type="number" step="0.01" min="0"
                                                    name="entry_fee_child" class="kt-input text-center w-full"
                                                    value="{{ old('entry_fee_child') }}" placeholder="0.00">
                                            </td>
                                            <td class="px-2 py-2 border-r">
                                                <input type="number" step="0.01" min="0"
                                                    name="entry_fee_foreigner_child" class="kt-input text-center w-full"
                                                    value="{{ old('entry_fee_foreigner_child') }}" placeholder="0.00">
                                            </td>
                                            <td class="px-2 py-2 border-r">
                                                <input type="number" step="0.01" min="0"
                                                    name="entry_fee_arab_child" class="kt-input text-center w-full"
                                                    value="{{ old('entry_fee_arab_child') }}" placeholder="0.00">
                                            </td>
                                            <td class="px-2 py-2 border-r">
                                                <input type="number" step="0.01" min="0"
                                                    name="entry_fee_local_child" class="kt-input text-center w-full"
                                                    value="{{ old('entry_fee_local_child') }}" placeholder="0.00">
                                            </td>
                                            <td class="px-2 py-2 border-r">
                                                <input type="number" step="0.01" min="0"
                                                    name="entry_fee_resident_child" class="kt-input text-center w-full"
                                                    value="{{ old('entry_fee_resident_child') }}" placeholder="0.00">
                                            </td>
                                            <!-- Dynamic Child Inputs -->
                                        </tr>

                                        <!-- Student Row -->
                                        <tr class="hover:bg-gray-50 entry_feesCheckBox">
                                            <td
                                                class="px-4 py-3 text-sm font-medium text-gray-900 border-r bg-purple-50 whitespace-nowrap">
                                                🎓 {{ __('main.student') }}
                                            </td>
                                            <td class="px-2 py-2" colspan="5" class="colspan-dynamic">
                                                <input type="number" step="0.01" min="0"
                                                    name="entry_fee_student" class="kt-input text-center w-full"
                                                    value="{{ old('entry_fee_student') }}" placeholder="0.00">
                                            </td>
                                        </tr>

                                        <!-- Senior Row -->
                                        <tr class="hover:bg-gray-50 entry_feesCheckBox">
                                            <td
                                                class="px-4 py-3 text-sm font-medium text-gray-900 border-r bg-orange-50 whitespace-nowrap">
                                                👴 {{ __('main.senior') }}
                                            </td>
                                            <td class="px-2 py-2" colspan="5" class="colspan-dynamic">
                                                <input type="number" step="0.01" min="0"
                                                    name="entry_fee_senior" class="kt-input text-center w-full"
                                                    value="{{ old('entry_fee_senior') }}" placeholder="0.00">
                                            </td>
                                        </tr>

                                        <!-- Group Row -->
                                        <tr class="hover:bg-gray-50 entry_feesCheckBox">
                                            <td
                                                class="px-4 py-3 text-sm font-medium text-gray-900 border-r bg-yellow-50 whitespace-nowrap">
                                                👥 {{ __('main.group') }}
                                            </td>
                                            <td class="px-2 py-2" colspan="5" class="colspan-dynamic">
                                                <input type="number" step="0.01" min="0"
                                                    name="entry_fee_group" class="kt-input text-center w-full"
                                                    value="{{ old('entry_fee_group') }}" placeholder="0.00">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Operating Hours -->
                <div class="kt-card pb-2.5">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.operating_hours') }}</h3>
                    </div>
                    <div class="kt-card-content grid gap-5">
                        <!-- 24/7 Checkbox -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label class="kt-form-label max-w-56">{{ __('main.is_24_7') }}</label>
                            <div class="flex items-center gap-4">
                                <input type="hidden" name="is_24_7" value="0">
                                @include('components.elements.checkbox-button', [
                                    'name' => 'is_24_7',
                                    'id' => 'is_24_7',
                                    'value' => '1',
                                    'checked' => old('is_24_7', 1) == 1,
                                    'label' => __('main.is_24_7'),
                                ])
                            </div>
                        </div>

                        <!-- Opening Time -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5 disabled" id="opening_time">
                            <label for="opening_time"
                                class="kt-form-label max-w-56">{{ __('main.opening_time') }}</label>
                            <input type="time" name="opening_time" id="opening_time" class="kt-input"
                                value="{{ old('opening_time') }}">
                        </div>

                        <!-- Closing Time -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5 disabled" id="closing_time">
                            <label for="closing_time"
                                class="kt-form-label max-w-56">{{ __('main.closing_time') }}</label>
                            <input type="time" name="closing_time" id="closing_time" class="kt-input"
                                value="{{ old('closing_time') }}">
                        </div>

                        <!-- Operating Days -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label for="operating_days"
                                class="kt-form-label max-w-56">{{ __('main.operating_days') }}</label>
                            <div class="flex flex-wrap gap-4">
                                @foreach (['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $day)
                                    <div class="flex items-center gap-4">
                                        <input type="hidden" name="" value="">
                                        @include('components.elements.checkbox-button', [
                                            'name' => 'operating_days[]',
                                            'id' => 'operating_day_' . $day,
                                            'value' => $day,
                                            'checked' =>
                                                old('operating_days', []) &&
                                                in_array($day, old('operating_days', [])),
                                            'label' => __('main.' . $day),
                                        ])
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="kt-card pb-2.5">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.contact_information') }}</h3>
                    </div>
                    <div class="kt-card-content grid gap-5">
                        <!-- Phone -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label for="phone" class="kt-form-label max-w-56">{{ __('main.phone') }}</label>
                            <input type="tel" name="phone" id="phone" class="kt-input"
                                value="{{ old('phone') }}" placeholder="Phone number">
                        </div>

                        <!-- Mobile -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label for="mobile" class="kt-form-label max-w-56">{{ __('main.mobile') }}</label>
                            <input type="tel" name="mobile" id="mobile" class="kt-input"
                                value="{{ old('mobile') }}" placeholder="Mobile number">
                        </div>

                        <!-- Email -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label for="email" class="kt-form-label max-w-56">{{ __('main.email') }}</label>
                            <input type="email" name="email" id="email" class="kt-input"
                                value="{{ old('email') }}" placeholder="Email address">
                        </div>

                        <!-- Fax -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label for="fax" class="kt-form-label max-w-56">{{ __('main.fax') }}</label>
                            <input type="tel" name="fax" id="fax" class="kt-input"
                                value="{{ old('fax') }}" placeholder="Fax number">
                        </div>

                        <!-- Contact Person -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label for="contact_person"
                                class="kt-form-label max-w-56">{{ __('main.contact_person') }}</label>
                            <input type="text" name="contact_person" id="contact_person" class="kt-input"
                                value="{{ old('contact_person') }}" placeholder="Contact person name">
                        </div>

                        <!-- Website URL -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label for="website_url" class="kt-form-label max-w-56">{{ __('main.website_url') }}</label>
                            <input type="url" name="website_url" id="website_url" class="kt-input"
                                value="{{ old('website_url') }}" placeholder="https://example.com">
                        </div>

                        <!-- Facebook URL -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label for="facebook_url"
                                class="kt-form-label max-w-56">{{ __('main.facebook_url') }}</label>
                            <input type="url" name="facebook_url" id="facebook_url" class="kt-input"
                                value="{{ old('facebook_url') }}" placeholder="https://facebook.com/...">
                        </div>

                        <!-- Instagram URL -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label for="instagram_url"
                                class="kt-form-label max-w-56">{{ __('main.instagram_url') }}</label>
                            <input type="url" name="instagram_url" id="instagram_url" class="kt-input"
                                value="{{ old('instagram_url') }}" placeholder="https://instagram.com/...">
                        </div>

                        <!-- Twitter URL -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label for="twitter_url" class="kt-form-label max-w-56">{{ __('main.twitter_url') }}</label>
                            <input type="url" name="twitter_url" id="twitter_url" class="kt-input"
                                value="{{ old('twitter_url') }}" placeholder="https://twitter.com/...">
                        </div>
                    </div>
                </div>

                <!-- Facilities & Services -->
                <div class="kt-card pb-2.5">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.facilities_services') }}</h3>
                    </div>
                    <div class="kt-card-content grid gap-5">
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label class="kt-form-label max-w-56">{{ __('main.facilities_services') }}</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 flex-1">
                                @foreach ($facilities as $facility)
                                    <div class="flex items-center gap-4">
                                        @include('components.elements.checkbox-button', [
                                            'name' => 'facilities[]',
                                            'id' => 'facility_' . $facility->id,
                                            'value' => $facility->id,
                                            'checked' => in_array($facility->id, old('facilities', [])),
                                            'label' => $facility->display_name,
                                        ])
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Pricing -->
                <div class="kt-card pb-2.5">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.additional_pricing') }}</h3>
                    </div>
                    <div class="kt-card-content grid gap-5">
                        <!-- Local Guide Price -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label for="local_guide_price"
                                class="kt-form-label max-w-56">{{ __('main.local_guide_price') }}</label>
                            <div class="flex-1 flex items-center gap-2 relative">
                                <input type="number" step="0.01" min="0" name="local_guide_price"
                                    id="local_guide_price" class="kt-input" style="padding-right: 50px;"
                                    value="{{ old('local_guide_price') }}" placeholder="0.00">
                                <select name="local_guide_price_unit_id" class="kt-select h-[45px]"
                                    style="width: 180px;">
                                    <option value="">--</option>
                                    @foreach ($pricing_units as $unit)
                                        <option value="{{ $unit->id }}"
                                            {{ old('local_guide_price_unit_id') == $unit->id ? 'selected' : '' }}>
                                            {{ $unit->display_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Club Car Price -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label for="club_car_price"
                                class="kt-form-label max-w-56">{{ __('main.club_car_price') }}</label>
                            <div class="flex-1 flex items-center gap-2 relative">
                                <input type="number" step="0.01" min="0" name="club_car_price"
                                    id="club_car_price" class="kt-input" style="padding-right: 50px;"
                                    value="{{ old('club_car_price') }}" placeholder="0.00">
                                <select name="club_car_price_unit_id" class="kt-select h-[45px]" style="width: 180px;">
                                    <option value="">--</option>
                                    @foreach ($pricing_units as $unit)
                                        <option value="{{ $unit->id }}"
                                            {{ old('club_car_price_unit_id') == $unit->id ? 'selected' : '' }}>
                                            {{ $unit->display_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Has Unified Ticket -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label class="kt-form-label max-w-56">{{ __('main.has_unified_ticket') }}</label>
                            <div class="flex items-center gap-4">
                                <input type="hidden" name="has_unified_ticket" value="0">
                                @include('components.elements.checkbox-button', [
                                    'name' => 'has_unified_ticket',
                                    'id' => 'has_unified_ticket',
                                    'value' => '1',
                                    'checked' => old('has_unified_ticket', 0) == 1,
                                    'label' => __('main.has_unified_ticket'),
                                ])
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Visitor Information -->
                <div class="kt-card pb-2.5">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.visitor_information') }}</h3>
                    </div>
                    <div class="kt-card-content grid gap-5">
                        <!-- Average Rating -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label for="average_rating"
                                class="kt-form-label max-w-56">{{ __('main.average_rating') }}</label>
                            <input type="number" step="0.01" min="0" max="5" name="average_rating"
                                id="average_rating" class="kt-input" value="{{ old('average_rating') }}">
                        </div>

                        <!-- Total Reviews -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label for="total_reviews"
                                class="kt-form-label max-w-56">{{ __('main.total_reviews') }}</label>
                            <input type="number" min="0" name="total_reviews" id="total_reviews"
                                class="kt-input" value="{{ old('total_reviews') }}">
                        </div>

                        <!-- Popularity Score -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label for="popularity_score"
                                class="kt-form-label max-w-56">{{ __('main.popularity_score') }}</label>
                            <input type="number" min="0" max="100" name="popularity_score"
                                id="popularity_score" class="kt-input" value="{{ old('popularity_score') }}">
                        </div>

                        <!-- Estimated Visit Duration -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label for="estimated_visit_duration"
                                class="kt-form-label max-w-56">{{ __('main.estimated_visit_duration') }}
                                (minutes)</label>
                            <input type="number" min="0" name="estimated_visit_duration"
                                id="estimated_visit_duration" class="kt-input"
                                value="{{ old('estimated_visit_duration') }}">
                        </div>

                        <!-- Difficulty Level -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label for="difficulty_level"
                                class="kt-form-label max-w-56">{{ __('main.difficulty_level') }}</label>
                            <select name="difficulty_level" id="difficulty_level" class="kt-select basic-single">
                                <option value="" selected>--</option>
                                @foreach ($difficulty_level as $level)
                                    <option value="{{ $level }}"
                                        {{ old('difficulty_level') == $level ? 'selected' : '' }}>
                                        {{ $level }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label for="status" class="kt-form-label max-w-56">{{ __('main.status') }}</label>
                            <select name="status" id="status" class="kt-select basic-single">
                                <option value="" selected>--</option>
                                @foreach ($status as $stat)
                                    <option value="{{ $stat }}" {{ old('status') == $stat ? 'selected' : '' }}>
                                        {{ $stat }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Additional Status Fields -->
                <div class="kt-card pb-2.5">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.additional_options') }}</h3>
                    </div>
                    <div class="kt-card-content grid gap-5">
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label class="kt-form-label max-w-56">{{ __('main.additional_options') }}</label>
                            <div class="flex flex-wrap gap-4">
                                <div class="flex items-center gap-4">
                                    <input type="hidden" name="is_featured" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'is_featured',
                                        'id' => 'is_featured',
                                        'value' => '1',
                                        'checked' => old('is_featured', 0) == 1,
                                        'label' => __('main.is_featured'),
                                    ])
                                </div>
                                <div class="flex items-center gap-4">
                                    <input type="hidden" name="is_verified" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'is_verified',
                                        'id' => 'is_verified',
                                        'value' => '1',
                                        'checked' => old('is_verified', 0) == 1,
                                        'label' => __('main.is_verified'),
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Media Information -->
                <div class="kt-card pb-2.5">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.media')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-content grid gap-5">
                        <!-- Photo -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label for="photo" class="kt-form-label max-w-56">{{ __('main.photo') }}</label>
                            <div class="flex-1">
                                <div class="dropzone border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-primary transition-colors cursor-pointer"
                                    data-input="photo">
                                    <i class="far fa-cloud-arrow-up text-5xl text-gray-600"></i>
                                    <p class="mt-4">{{ __('main.click_or_drag_image_here') }}</p>
                                </div>
                                <input type="file" id="photo" name="photo" accept="image/*" hidden>
                                <div id="preview-photo" class="hidden flex flex-wrap gap-4 mt-6"></div>
                            </div>
                        </div>

                        <!-- Gallery -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label for="gallery" class="kt-form-label max-w-56">{{ __('main.gallery') }}</label>
                            <div class="flex-1">
                                <div class="dropzone border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-primary transition-colors cursor-pointer"
                                    data-input="gallery">
                                    <i class="far fa-cloud-arrow-up text-5xl text-gray-600"></i>
                                    <p class="mt-4">{{ __('main.click_or_drag_image_here_multiple') }}</p>
                                </div>
                                <input type="file" id="gallery" name="gallery[]" accept="image/*" hidden multiple>
                                <div id="preview-gallery" class="hidden flex flex-wrap gap-4 mt-6"></div>
                            </div>
                        </div>

                        <!-- Video URL -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label for="video_url" class="kt-form-label max-w-56">{{ __('main.video_url') }}</label>
                            <input type="url" name="video_url" id="video_url" class="kt-input"
                                value="{{ old('video_url') }}" placeholder="https://youtube.com/...">
                        </div>

                        <!-- Virtual Tour URL -->
                        <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <label for="virtual_tour_url"
                                class="kt-form-label max-w-56">{{ __('main.virtual_tour_url') }}</label>
                            <input type="url" name="virtual_tour_url" id="virtual_tour_url" class="kt-input"
                                value="{{ old('virtual_tour_url') }}" placeholder="https://example.com/virtual-tour">
                        </div>
                    </div>
                </div>

                <!-- description -->
                @include('components.elements.input-text-editor', [
                    'column' => 'description',
                    'value' => old('description'),
                ])

                <!-- nearby_attractions -->
                @include('components.elements.input-text-editor', [
                    'column' => 'nearby_attractions',
                    'value' => old('nearby_attractions'),
                ])

                <!-- notes -->
                @include('components.elements.input-text-editor', [
                    'column' => 'notes',
                    'value' => old('notes'),
                ])

                <x-custom-fields module-name="tourists" entity-type="TouristSite" />

                <!-- is_active -->
                <div class="flex items-center gap-4">
                    <input type="hidden" name="is_active" value="0">
                    @include('components.elements.checkbox-button', [
                        'name' => 'is_active',
                        'id' => 'is_active',
                        'value' => '1',
                        'checked' => old('is_active', 1) == 1,
                        'label' => __('main.is_active'),
                    ])
                </div>

                <!-- Save Submit -->
                @include('components.elements.save-submit', [
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
            if (this.checked) {
                entryFeesCheckBoxes.forEach(element => element.classList.add('disabled'));
            } else {
                entryFeesCheckBoxes.forEach(element => element.classList.remove('disabled'));
            }
        });

        // Dynamic Nationality Columns
        const addedNationalities = new Set();
        const tableHeaderRow = document.getElementById('tableHeaderRow');
        const adultRow = document.getElementById('adultRow');
        const childRow = document.getElementById('childRow');
        const colspanCells = document.querySelectorAll('.colspan-dynamic');

        document.getElementById('addNationalityBtn').addEventListener('click', function() {
            const select = document.getElementById('nationalitySelect');
            const id = select.value;
            const name = select.options[select.selectedIndex].text;

            if (!id) return;
            if (addedNationalities.has(id)) {
                alert('{{ __('main.nationality_already_added') }}'); // Assuming translation exists or fallback
                return;
            }

            addedNationalities.add(id);

            // 1. Add Header
            const th = document.createElement('th');
            th.className =
                'px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-b border-l relative group min-w-[120px]';
            th.innerHTML = `
                ${name}
                <button type="button" class="absolute top-1 right-1 text-red-500 hover:text-red-700 font-bold"
                    onclick="removeNationalityColumn('${id}', this)">
                    &times;
                </button>
            `;
            tableHeaderRow.appendChild(th);

            // 2. Add Adult Input
            const tdAdult = document.createElement('td');
            tdAdult.className = 'px-2 py-2 border-l';
            tdAdult.innerHTML = `
                <input type="hidden" name="nationality_entry_fees[${id}][nationality_id]" value="${id}">
                <input type="number" step="0.01" min="0" 
                    name="nationality_entry_fees[${id}][adult_price]" 
                    class="kt-input text-center w-full" placeholder="0.00">
            `;
            adultRow.appendChild(tdAdult);

            // 3. Add Child Input
            const tdChild = document.createElement('td');
            tdChild.className = 'px-2 py-2 border-l';
            tdChild.innerHTML = `
                <input type="number" step="0.01" min="0" 
                    name="nationality_entry_fees[${id}][child_price]" 
                    class="kt-input text-center w-full" placeholder="0.00">
            `;
            childRow.appendChild(tdChild);

            // 4. Update Colspans
            updateColspans();

            // Reset select
            select.value = '';
        });

        window.removeNationalityColumn = function(id, btn) {
            const th = btn.closest('th');
            // Find index of this TH among all THs in the row
            const index = Array.from(tableHeaderRow.children).indexOf(th);

            if (index > -1) {
                tableHeaderRow.removeChild(th);

                // Remove corresponding cells in body rows
                // Note: The index in body rows corresponds to the index in header
                if (adultRow.children[index]) adultRow.removeChild(adultRow.children[index]);
                if (childRow.children[index]) childRow.removeChild(childRow.children[index]);

                addedNationalities.delete(id);
                updateColspans();
            }
        };

        function updateColspans() {
            // Base static price columns is 5 (General, Foreigner, Arab, Local, Resident)
            // Plus dynamic columns
            const total = 5 + addedNationalities.size;
            colspanCells.forEach(cell => {
                cell.setAttribute('colspan', total);
            });
        }
    </script>
@endpush
