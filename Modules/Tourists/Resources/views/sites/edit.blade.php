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
                <a href="{{ route('dashboard.tourists.sites.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tourist-sites')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <form action="{{ route('dashboard.tourists.sites.update', $touristSite->id) }}" method="POST" enctype="multipart/form-data">
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
                                <input type="number" step="0.00000001" min="-90" max="90" name="latitude" id="latitude" class="kt-input h-[45px]"
                                    value="{{ $touristSite->latitude }}">
                            </div>
                            <div>
                                <label for="longitude" class="kt-label">{{ __('main.longitude') }}</label>
                                <input type="number" step="0.00000001" min="-180" max="180" name="longitude" id="longitude" class="kt-input h-[45px]"
                                    value="{{ $touristSite->longitude }}">
                            </div>
                            <div>
                                <label for="postal_code" class="kt-label">{{ __('main.postal_code') }}</label>
                                <input type="text" name="postal_code" id="postal_code" class="kt-input h-[45px]" value="{{ $touristSite->postal_code }}">
                            </div>
                            @include('components.selects.currency', ['record' => $touristSite->currency])
                        </div>

                        <!-- address -->
                        @include('components.elements.input-text-editor', [
                            'column' => 'address',
                            'value' => $touristSite->address,
                        ])
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
                            <div class="col-span-full">
                                <!-- unesco_site -->
                                <div class="flex items-center gap-4">
                                    <input type="hidden" name="unesco_site" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'unesco_site',
                                        'id' => 'unesco_site',
                                        'value' => '1',
                                        'checked' => $touristSite->unesco_site,
                                        'label' => __('main.unesco_site'),
                                    ])
                                </div>
                            </div>
                            <div class="align-self-end">
                                <label for="name" class="kt-label">{{ __('main.name') }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]" value="{{ $touristSite->name }}">
                            </div>
                            <div class="align-self-end">
                                <label for="name_ar" class="kt-label">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]" value="{{ $touristSite->name_ar }}">
                            </div>
                            <div class="align-self-end">
                                <label for="site_type" class="kt-label">{{ __('main.site_type') }}</label>
                                <input type="text" name="site_type" id="site_type" class="kt-input h-[45px]" value="{{ $touristSite->site_type }}">
                            </div>
                            <div class="align-self-end">
                                <label for="category" class="kt-label">{{ __('main.category') }}</label>
                                <input type="text" list="categoriesList" name="category" id="category" class="kt-input h-[45px]"
                                    value="{{ $touristSite->category }}">
                                <datalist id="categoriesList">
                                    @foreach (['landmark', 'museum', 'park', 'beach', 'monument', 'temple', 'palace', 'garden'] as $cat)
                                        <option value="{{ $cat }}">
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="align-self-end">
                                <label for="supplier_type" class="kt-label">{{ __('main.supplier_type') }}</label>
                                <input type="text" name="supplier_type" id="supplier_type" class="kt-input h-[45px]" value="{{ $touristSite->supplier_type }}">
                            </div>
                            <div class="align-self-end">
                                <label for="sites_theme" class="kt-label">{{ __('main.sites_theme') }}</label>
                                <input type="text" name="sites_theme" id="sites_theme" class="kt-input h-[45px]" value="{{ $touristSite->sites_theme }}">
                            </div>
                            <div class="align-self-end">
                                <label for="supplier_name" class="kt-label">{{ __('main.supplier_name') }}</label>
                                <input type="text" name="supplier_name" id="supplier_name" class="kt-input h-[45px]"
                                    value="{{ $touristSite->supplier_name }}">
                            </div>

                            {{-- sort_order --}}
                            <div class="align-self-end">
                                <label for="sort_order" class="kt-label">{{ __('main.sort_order') }}</label>
                                <input type="number" name="sort_order" id="sort_order" class="kt-input h-[45px]" value="{{ $touristSite->sort_order }}">
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
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            <div class="col-span-full">
                                <div class="flex items-center gap-4">
                                    <input type="hidden" name="is_free_entry" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'is_free_entry',
                                        'id' => 'is_free_entry',
                                        'value' => '1',
                                        'checked' => $touristSite->is_free_entry,
                                        'label' => __('main.is_free_entry'),
                                    ])
                                </div>
                            </div>
                            <div class="entry_feesCheckBox {{ $touristSite->is_free_entry == 1 ? 'disabled' : '' }}">
                                <label for="entry_fee_adult" class="kt-label">{{ __('main.entry_fee_adult') }}</label>
                                <input type="number" step="0.01" min="0" name="entry_fee_adult" id="entry_fee_adult" class="kt-input h-[45px]"
                                    value="{{ $touristSite->entry_fee_adult }}">
                            </div>
                            <div class="entry_feesCheckBox {{ $touristSite->is_free_entry == 1 ? 'disabled' : '' }}">
                                <label for="entry_fee_child" class="kt-label">{{ __('main.entry_fee_child') }}</label>
                                <input type="number" step="0.01" min="0" name="entry_fee_child" id="entry_fee_child" class="kt-input h-[45px]"
                                    value="{{ $touristSite->entry_fee_child }}">
                            </div>
                            <div class="entry_feesCheckBox {{ $touristSite->is_free_entry == 1 ? 'disabled' : '' }}">
                                <label for="entry_fee_student" class="kt-label">{{ __('main.entry_fee_student') }}</label>
                                <input type="number" step="0.01" min="0" name="entry_fee_student" id="entry_fee_student" class="kt-input h-[45px]"
                                    value="{{ $touristSite->entry_fee_student }}">
                            </div>
                            <div class="entry_feesCheckBox {{ $touristSite->is_free_entry == 1 ? 'disabled' : '' }}">
                                <label for="entry_fee_senior" class="kt-label">{{ __('main.entry_fee_senior') }}</label>
                                <input type="number" step="0.01" min="0" name="entry_fee_senior" id="entry_fee_senior" class="kt-input h-[45px]"
                                    value="{{ $touristSite->entry_fee_senior }}">
                            </div>
                            <div class="entry_feesCheckBox {{ $touristSite->is_free_entry == 1 ? 'disabled' : '' }}">
                                <label for="entry_fee_group" class="kt-label">{{ __('main.entry_fee_group') }}</label>
                                <input type="number" step="0.01" min="0" name="entry_fee_group" id="entry_fee_group" class="kt-input h-[45px]"
                                    value="{{ $touristSite->entry_fee_group }}">
                            </div>
                            <div class="entry_feesCheckBox {{ $touristSite->is_free_entry == 1 ? 'disabled' : '' }}">
                                <label for="entry_fee_foreigner_adult" class="kt-label">{{ __('main.entry_fee_foreigner_adult') }}</label>
                                <input type="number" step="0.01" min="0" name="entry_fee_foreigner_adult" id="entry_fee_foreigner_adult"
                                    class="kt-input h-[45px]" value="{{ $touristSite->entry_fee_foreigner_adult }}">
                            </div>
                            <div class="entry_feesCheckBox {{ $touristSite->is_free_entry == 1 ? 'disabled' : '' }}">
                                <label for="entry_fee_foreigner_child" class="kt-label">{{ __('main.entry_fee_foreigner_child') }}</label>
                                <input type="number" step="0.01" min="0" name="entry_fee_foreigner_child" id="entry_fee_foreigner_child"
                                    class="kt-input h-[45px]" value="{{ $touristSite->entry_fee_foreigner_child }}">
                            </div>
                            <div class="entry_feesCheckBox {{ $touristSite->is_free_entry == 1 ? 'disabled' : '' }}">
                                <label for="entry_fee_arab_adult" class="kt-label">{{ __('main.entry_fee_arab_adult') }}</label>
                                <input type="number" step="0.01" min="0" name="entry_fee_arab_adult" id="entry_fee_arab_adult"
                                    class="kt-input h-[45px]" value="{{ $touristSite->entry_fee_arab_adult }}">
                            </div>
                            <div class="entry_feesCheckBox {{ $touristSite->is_free_entry == 1 ? 'disabled' : '' }}">
                                <label for="entry_fee_arab_child" class="kt-label">{{ __('main.entry_fee_arab_child') }}</label>
                                <input type="number" step="0.01" min="0" name="entry_fee_arab_child" id="entry_fee_arab_child"
                                    class="kt-input h-[45px]" value="{{ $touristSite->entry_fee_arab_child }}">
                            </div>
                            <div class="entry_feesCheckBox {{ $touristSite->is_free_entry == 1 ? 'disabled' : '' }}">
                                <label for="entry_fee_local_adult" class="kt-label">{{ __('main.entry_fee_local_adult') }}</label>
                                <input type="number" step="0.01" min="0" name="entry_fee_local_adult" id="entry_fee_local_adult"
                                    class="kt-input h-[45px]" value="{{ $touristSite->entry_fee_local_adult }}">
                            </div>
                            <div class="entry_feesCheckBox {{ $touristSite->is_free_entry == 1 ? 'disabled' : '' }}">
                                <label for="entry_fee_local_child" class="kt-label">{{ __('main.entry_fee_local_child') }}</label>
                                <input type="number" step="0.01" min="0" name="entry_fee_local_child" id="entry_fee_local_child"
                                    class="kt-input h-[45px]" value="{{ $touristSite->entry_fee_local_child }}">
                            </div>
                            <div class="entry_feesCheckBox {{ $touristSite->is_free_entry == 1 ? 'disabled' : '' }}">
                                <label for="entry_fee_resident_adult" class="kt-label">{{ __('main.entry_fee_resident_adult') }}</label>
                                <input type="number" step="0.01" min="0" name="entry_fee_resident_adult" id="entry_fee_resident_adult"
                                    class="kt-input h-[45px]" value="{{ $touristSite->entry_fee_resident_adult }}">
                            </div>
                            <div class="entry_feesCheckBox {{ $touristSite->is_free_entry == 1 ? 'disabled' : '' }}">
                                <label for="entry_fee_resident_child" class="kt-label">{{ __('main.entry_fee_resident_child') }}</label>
                                <input type="number" step="0.01" min="0" name="entry_fee_resident_child" id="entry_fee_resident_child"
                                    class="kt-input h-[45px]" value="{{ $touristSite->entry_fee_resident_child }}">
                            </div>
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
                            <div class="{{ $touristSite->is_24_7 == 1 ? 'disabled' : '' }}" id="opening_time">
                                <label for="opening_time" class="kt-label">{{ __('main.opening_time') }}</label>
                                <input type="time" name="opening_time" id="opening_time" class="kt-input h-[45px]"
                                    value="{{ $touristSite->opening_time }}">
                            </div>
                            <div class="{{ $touristSite->is_24_7 == 1 ? 'disabled' : '' }}" id="closing_time">
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
                                                'checked' => $touristSite->operating_days && in_array($day, $touristSite->operating_days),
                                                'label' => __('main.' . $day),
                                            ])
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-span-full">
                                <label for="special_hours" class="kt-label">{{ __('main.special_hours') }}</label>
                                <textarea name="special_hours" id="special_hours" class="kt-input h-[120px]" placeholder='JSON format: {"friday":{"opening":"09:00","closing":"18:00"}}'>{{ $touristSite->special_hours }}</textarea>
                                <small class="text-secondary-foreground">Format: {"day":{"opening":"HH:MM","closing":"HH:MM"}}</small>
                            </div>
                        </div>
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
                                <input type="tel" name="phone" id="phone" class="kt-input h-[45px]" value="{{ $touristSite->phone }}">
                            </div>
                            <div>
                                <label for="mobile" class="kt-label">{{ __('main.mobile') }}</label>
                                <input type="tel" name="mobile" id="mobile" class="kt-input h-[45px]" value="{{ $touristSite->mobile }}">
                            </div>
                            <div>
                                <label for="email" class="kt-label">{{ __('main.email') }}</label>
                                <input type="email" name="email" id="email" class="kt-input h-[45px]" value="{{ $touristSite->email }}">
                            </div>
                            <div>
                                <label for="fax" class="kt-label">{{ __('main.fax') }}</label>
                                <input type="tel" name="fax" id="fax" class="kt-input h-[45px]" value="{{ $touristSite->fax }}">
                            </div>
                            <div>
                                <label for="contact_person" class="kt-label">{{ __('main.contact_person') }}</label>
                                <input type="text" name="contact_person" id="contact_person" class="kt-input h-[45px]"
                                    value="{{ $touristSite->contact_person }}">
                            </div>
                            <div>
                                <label for="website_url" class="kt-label">{{ __('main.website_url') }}</label>
                                <input type="url" name="website_url" id="website_url" class="kt-input h-[45px]" value="{{ $touristSite->website_url }}">
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
                                <input type="url" name="twitter_url" id="twitter_url" class="kt-input h-[45px]" value="{{ $touristSite->twitter_url }}">
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
                            @foreach (['wheelchair_accessible', 'free_wifi', 'parking', 'restrooms', 'restaurants', 'gift_shop', 'guided_tours', 'audio_guide', 'photography', 'hiking', 'swimming', 'camping', 'shopping', 'dining', 'entertainment', 'educational_tours', 'translation', 'special_events', 'group_bookings', 'online_booking', 'mobile_app', 'virtual_tours'] as $label)
                                <div class="flex items-center gap-4">
                                    <input type="hidden" name="{{ $label }}" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => $label,
                                        'id' => $label,
                                        'value' => '1',
                                        'checked' => old($label, $touristSite->$label) == 1,
                                        'label' => __('main.' . $label),
                                    ])
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Additional Pricing -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.additional_pricing') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                            <div>
                                <label for="local_guide_price" class="kt-label">{{ __('main.local_guide_price') }}</label>
                                <input type="number" step="0.01" min="0" name="local_guide_price" id="local_guide_price" class="kt-input h-[45px]"
                                    value="{{ $touristSite->local_guide_price }}">
                            </div>
                            <div>
                                <label for="club_car_price" class="kt-label">{{ __('main.club_car_price') }}</label>
                                <input type="number" step="0.01" min="0" name="club_car_price" id="club_car_price" class="kt-input h-[45px]"
                                    value="{{ $touristSite->club_car_price }}">
                            </div>
                            <div class="flex items-center gap-4">
                                <input type="hidden" name="has_unified_ticket" value="0">
                                @include('components.elements.checkbox-button', [
                                    'name' => 'has_unified_ticket',
                                    'id' => 'has_unified_ticket',
                                    'value' => '1',
                                    'checked' => (bool) $touristSite->has_unified_ticket,
                                    'label' => __('main.has_unified_ticket'),
                                ])
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
                                <input type="number" step="0.01" min="0" max="5" name="average_rating" id="average_rating"
                                    class="kt-input h-[45px]" value="{{ $touristSite->average_rating }}">
                            </div>
                            <div>
                                <label for="total_reviews" class="kt-label">{{ __('main.total_reviews') }}</label>
                                <input type="number" min="0" name="total_reviews" id="total_reviews" class="kt-input h-[45px]"
                                    value="{{ $touristSite->total_reviews }}">
                            </div>
                            <div>
                                <label for="popularity_score" class="kt-label">{{ __('main.popularity_score') }}</label>
                                <input type="number" min="0" max="100" name="popularity_score" id="popularity_score" class="kt-input h-[45px]"
                                    value="{{ $touristSite->popularity_score }}">
                            </div>
                            <div>
                                <label for="estimated_visit_duration" class="kt-label">{{ __('main.estimated_visit_duration') }} (minutes)</label>
                                <input type="number" min="0" name="estimated_visit_duration" id="estimated_visit_duration" class="kt-input h-[45px]"
                                    value="{{ $touristSite->estimated_visit_duration }}">
                            </div>
                            <div>
                                <label for="difficulty_level" class="kt-label">{{ __('main.difficulty_level') }}</label>
                                <select name="difficulty_level" id="difficulty_level" class="kt-select basic-single">
                                    <option value="" selected>--</option>
                                    @foreach ($difficulty_level as $level)
                                        <option value="{{ $level }}" {{ $touristSite->difficulty_level == $level ? 'selected' : '' }}>
                                            {{ $level }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="status" class="kt-label">{{ __('main.status') }}</label>
                                <select name="status" id="status" class="kt-select basic-single">
                                    <option value="" selected>--</option>
                                    @foreach ($status as $stat)
                                        <option value="{{ $stat }}" {{ $touristSite->status == $stat ? 'selected' : '' }}>{{ $stat }}
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
                    'value' => $touristSite->description,
                ])

                <!-- nearby_attractions -->
                @include('components.elements.input-text-editor', [
                    'column' => 'nearby_attractions',
                    'value' => $touristSite->nearby_attractions,
                ])

                <!-- notes -->
                @include('components.elements.input-text-editor', [
                    'column' => 'notes',
                    'value' => $touristSite->notes,
                ])

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
                    'models' => 'dashboard.tourists.sites',
                    'model' => 'tourist-site',
                ])
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    @include('components.scripts.drag-drop-images', ['fieldsMap' => ['photo' => 'photo', 'gallery' => 'gallery']])

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
    </script>
@endpush
