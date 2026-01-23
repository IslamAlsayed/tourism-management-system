@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.tourist-service')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.tourist-service')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.tourist-service')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('tourist-services.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tourist-services')]) }}
                </a>
            </div>
        </div>

        @include('components.must-add-first', [
            'requirements' => [
                [
                    'condition' => \App\Models\TouristSite::count() > 0,
                    'route' => route('tourist-sites.index'),
                    'label' => __('main.tourist_sites'),
                ],
                [
                    'condition' => \App\Models\Currency::count() > 0,
                    'route' => route('currencies.index'),
                    'label' => __('main.currencies'),
                ],
            ],
        ])
    </div>

    <div class="kt-container-fixed">
        <form action="{{ route('tourist-services.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-4 lg:gap-6">

                <!-- Site Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.site')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-6">
                            <!-- Site -->
                            <div>
                                <label for="site_id" class="kt-label required">
                                    {{ __('main.site') }} <span class="text-red-600">*</span>
                                </label>
                                <select name="site_id" id="site_id" class="kt-select basic-single" required>
                                    <option value="" selected>--</option>
                                    @foreach ($sites as $site)
                                        <option value="{{ $site->id }}"
                                            {{ old('site_id') == $site->id || request()->site_id == $site->id ? 'selected' : '' }}>
                                            {{ $site->name }} {{ $site->name_ar ? ' - ' . $site->name_ar : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('site_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Currency -->
                            @include('components.selects.currency')

                            <!-- total_day_visit -->
                            <div>
                                <label for="total_day_visit" class="kt-label">{{ __('main.total_day_visit') }}</label>
                                <input type="number" step="0.01" name="total_day_visit" id="total_day_visit"
                                    class="kt-input h-[45px]" value="{{ old('total_day_visit') }}">
                            </div>

                            <!-- Sort Order -->
                            <div>
                                <label for="sort_order" class="kt-label">{{ __('main.sort_order') }}</label>
                                <input type="number" step="0.01" name="sort_order" id="sort_order"
                                    class="kt-input h-[45px]" value="{{ old('sort_order') }}">
                            </div>

                            <div class="col-span-full flex flex-wrap" style="gap: 10px 40px;">
                                <!-- Include Unified Ticket -->
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="include_unified_ticket" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'include_unified_ticket',
                                        'id' => 'include_unified_ticket',
                                        'value' => '1',
                                        'label' => __('main.include_unified_ticket'),
                                    ])
                                </div>

                                <!-- Credit Cards -->
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="credit_cards" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'credit_cards',
                                        'id' => 'credit_cards',
                                        'value' => '1',
                                        'label' => __('main.credit_cards'),
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pricing - Foreigners -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.pricing_foreigners')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="per_adult_foreigners"
                                    class="kt-label">{{ __('main.per_adult_foreigners') }}</label>
                                <input type="number" step="0.01" name="per_adult_foreigners" id="per_adult_foreigners"
                                    class="kt-input h-[45px]" value="{{ old('per_adult_foreigners') }}">
                            </div>
                            <div>
                                <label for="per_child_foreigners"
                                    class="kt-label">{{ __('main.per_child_foreigners') }}</label>
                                <input type="number" step="0.01" name="per_child_foreigners" id="per_child_foreigners"
                                    class="kt-input h-[45px]" value="{{ old('per_child_foreigners') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pricing - Local -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.pricing_local')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="per_adult_local" class="kt-label">{{ __('main.per_adult_local') }}</label>
                                <input type="number" step="0.01" name="per_adult_local" id="per_adult_local"
                                    class="kt-input h-[45px]" value="{{ old('per_adult_local') }}">
                            </div>
                            <div>
                                <label for="per_child_local" class="kt-label">{{ __('main.per_child_local') }}</label>
                                <input type="number" step="0.01" name="per_child_local" id="per_child_local"
                                    class="kt-input h-[45px]" value="{{ old('per_child_local') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pricing - Arab -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.pricing_arab')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="per_adult_arab" class="kt-label">{{ __('main.per_adult_arab') }}</label>
                                <input type="number" step="0.01" name="per_adult_arab" id="per_adult_arab"
                                    class="kt-input h-[45px]" value="{{ old('per_adult_arab') }}">
                            </div>
                            <div>
                                <label for="per_child_arab" class="kt-label">{{ __('main.per_child_arab') }}</label>
                                <input type="number" step="0.01" name="per_child_arab" id="per_child_arab"
                                    class="kt-input h-[45px]" value="{{ old('per_child_arab') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pricing - Residents -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.pricing_residents')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="per_adult_residents"
                                    class="kt-label">{{ __('main.per_adult_residents') }}</label>
                                <input type="number" step="0.01" name="per_adult_residents" id="per_adult_residents"
                                    class="kt-input h-[45px]" value="{{ old('per_adult_residents') }}">
                            </div>
                            <div>
                                <label for="per_child_residents"
                                    class="kt-label">{{ __('main.per_child_residents') }}</label>
                                <input type="number" step="0.01" name="per_child_residents" id="per_child_residents"
                                    class="kt-input h-[45px]" value="{{ old('per_child_residents') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Non-accommodated Visitors -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.non_accommodated_visitors')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="non_accommodated_visitors_adult"
                                    class="kt-label">{{ __('main.non_accommodated_visitors_adult') }}</label>
                                <input type="number" step="0.01" name="non_accommodated_visitors_adult"
                                    id="non_accommodated_visitors_adult" class="kt-input h-[45px]"
                                    value="{{ old('non_accommodated_visitors_adult') }}">
                            </div>
                            <div>
                                <label for="non_accommodated_visitors_child"
                                    class="kt-label">{{ __('main.non_accommodated_visitors_child') }}</label>
                                <input type="number" step="0.01" name="non_accommodated_visitors_child"
                                    id="non_accommodated_visitors_child" class="kt-input h-[45px]"
                                    value="{{ old('non_accommodated_visitors_child') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Operating Hours -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.operating_hours')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            <div>
                                <label for="summer_opening_time"
                                    class="kt-label">{{ __('main.summer_opening_time') }}</label>
                                <input type="time" name="summer_opening_time" id="summer_opening_time"
                                    class="kt-input h-[45px]" value="{{ old('summer_opening_time') }}">
                            </div>
                            <div>
                                <label for="summer_closing_time"
                                    class="kt-label">{{ __('main.summer_closing_time') }}</label>
                                <input type="time" name="summer_closing_time" id="summer_closing_time"
                                    class="kt-input h-[45px]" value="{{ old('summer_closing_time') }}">
                            </div>
                            <div>
                                <label for="winter_opening_time"
                                    class="kt-label">{{ __('main.winter_opening_time') }}</label>
                                <input type="time" name="winter_opening_time" id="winter_opening_time"
                                    class="kt-input h-[45px]" value="{{ old('winter_opening_time') }}">
                            </div>
                            <div>
                                <label for="winter_closing_time"
                                    class="kt-label">{{ __('main.winter_closing_time') }}</label>
                                <input type="time" name="winter_closing_time" id="winter_closing_time"
                                    class="kt-input h-[45px]" value="{{ old('winter_closing_time') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Operating Days -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.operating_days')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="flex flex-wrap" style="gap: 10px 40px;">
                            @foreach (['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $day)
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="" value="">
                                    @include('components.elements.checkbox-button', [
                                        'name' => "operating_days[{$day}]",
                                        'id' => "operating_days_{$day}",
                                        'value' => $day,
                                        'checked' =>
                                            is_array(old('operating_days')) &&
                                            in_array($day, old('operating_days', [])),
                                        'label' => __('main.' . $day),
                                    ])
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Annual Holidays -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.annual_holidays')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-6"
                            id="annual_holidays_container">
                            @if (is_array(old('annual_holidays')) && count(old('annual_holidays')) > 0)
                                @foreach (old('annual_holidays') as $index => $date)
                                    <div class="flex gap-2 mb-3 annual-holidays-item">
                                        <input type="date" name="annual_holidays[]" class="kt-input h-[45px] flex-1"
                                            value="{{ $date }}">
                                        <button type="button"
                                            class="w-[45px] h-[45px] kt-btn kt-btn-sm bg-danger text-white remove-annual-holidays"
                                            toggle-button>
                                            <i class="fas fa-trash-can text-white"></i>
                                        </button>
                                    </div>
                                @endforeach
                            @else
                                <div class="flex gap-2 mb-3 annual-holidays-item">
                                    <input type="date" name="annual_holidays[]" class="kt-input h-[45px] flex-1">
                                    <button type="button"
                                        class="w-[45px] h-[45px] kt-btn kt-btn-sm bg-danger text-white remove-annual-holidays"
                                        toggle-button>
                                        <i class="fas fa-trash-can text-white"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <button type="button" id="add-annual-holidays" class="kt-btn kt-btn-primary mt-3">
                            <i class="fas fa-plus"></i> {{ __('main.add') }}
                        </button>
                        @error('annual_holidays')
                            <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Yearly Holidays -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.yearly_holidays')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <datalist id="holidays-list">
                            <option value="Ramadan">
                            <option value="Eid al-Fitr">
                            <option value="Eid al-Adha">
                            <option value="Islamic New Year">
                            <option value="Prophet Birthday">
                            <option value="New Year">
                        </datalist>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-6"
                            id="yearly_holidays_container">
                            @if (is_array(old('yearly_holidays')) && count(old('yearly_holidays')) > 0)
                                @foreach (old('yearly_holidays') as $index => $holiday)
                                    <div class="flex gap-2 mb-3 yearly-holidays-item">
                                        <input type="text" name="yearly_holidays[]" class="kt-input h-[45px] flex-1"
                                            list="holidays-list" placeholder="{{ __('main.holiday') }}"
                                            value="{{ $holiday }}">
                                        <button type="button"
                                            class="w-[45px] h-[45px] kt-btn kt-btn-sm bg-danger text-white remove-yearly-holidays"
                                            toggle-button>
                                            <i class="fas fa-trash-can text-white"></i>
                                        </button>
                                    </div>
                                @endforeach
                            @else
                                <div class="flex gap-2 mb-3 yearly-holidays-item">
                                    <input type="text" name="yearly_holidays[]" class="kt-input h-[45px] flex-1"
                                        list="holidays-list" placeholder="{{ __('main.holiday') }}">
                                    <button type="button"
                                        class="w-[45px] h-[45px] kt-btn kt-btn-sm bg-danger text-white remove-yearly-holidays"
                                        toggle-button>
                                        <i class="fas fa-trash-can text-white"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <button type="button" id="add-yearly-holidays" class="kt-btn kt-btn-primary mt-3">
                            <i class="fas fa-plus"></i> {{ __('main.add') }}
                        </button>
                        @error('yearly_holidays')
                            <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Day Off -->
                    <div class="kt-card">
                        <div class="kt-card-header">
                            <h3 class="kt-card-title">
                                {{ __('main.type_information', ['type' => __('main.day_off')]) }}
                            </h3>
                        </div>
                        <div class="kt-card-body p-4">
                            <div class="flex flex-wrap" style="gap: 10px 40px;">
                                @foreach (['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $day)
                                    <div class="flex items-center gap-3">
                                        <input type="hidden" name="" value="">
                                        @include('components.elements.checkbox-button', [
                                            'name' => "day_off[{$day}]",
                                            'id' => "day_off_{$day}",
                                            'value' => $day,
                                            'checked' =>
                                                is_array(old('day_off')) && in_array($day, old('day_off', [])),
                                            'label' => __('main.' . $day),
                                        ])
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Special Schedules -->
                {{-- <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.special_schedules')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        @include('components.elements.input-text-editor', [
                            'name' => 'special_schedules',
                            'value' => old('special_schedules'),
                            'placeholder' =>
                                '{"date": "2025-12-25", "opening_time": "10:00", "closing_time": "16:00"}',
                        ])
                    </div>
                </div> --}}

                <!-- Contact Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.contact')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            <div>
                                <label for="phone" class="kt-label">{{ __('main.phone') }}</label>
                                <input type="tel" name="phone" id="phone" class="kt-input h-[45px]"
                                    value="{{ old('phone') }}">
                            </div>
                            <div>
                                <label for="fax" class="kt-label">{{ __('main.fax') }}</label>
                                <input type="tel" name="fax" id="fax" class="kt-input h-[45px]"
                                    value="{{ old('fax') }}">
                            </div>
                            <div>
                                <label for="mobile_01" class="kt-label">{{ __('main.mobile_01') }}</label>
                                <input type="tel" name="mobile_01" id="mobile_01" class="kt-input h-[45px]"
                                    value="{{ old('mobile_01') }}">
                            </div>
                            <div>
                                <label for="mobile_02" class="kt-label">{{ __('main.mobile_02') }}</label>
                                <input type="tel" name="mobile_02" id="mobile_02" class="kt-input h-[45px]"
                                    value="{{ old('mobile_02') }}">
                            </div>
                            <div>
                                <label for="person_name_01" class="kt-label">{{ __('main.person_name_01') }}</label>
                                <input type="text" name="person_name_01" id="person_name_01"
                                    class="kt-input h-[45px]" value="{{ old('person_name_01') }}">
                            </div>
                            <div>
                                <label for="person_name_02" class="kt-label">{{ __('main.person_name_02') }}</label>
                                <input type="text" name="person_name_02" id="person_name_02"
                                    class="kt-input h-[45px]" value="{{ old('person_name_02') }}">
                            </div>
                            <div>
                                <label for="email_01" class="kt-label">{{ __('main.email_01') }}</label>
                                <input type="email" name="email_01" id="email_01" class="kt-input h-[45px]"
                                    value="{{ old('email_01') }}">
                            </div>
                            <div>
                                <label for="email_02" class="kt-label">{{ __('main.email_02') }}</label>
                                <input type="email" name="email_02" id="email_02" class="kt-input h-[45px]"
                                    value="{{ old('email_02') }}">
                            </div>
                            <div>
                                <label for="website" class="kt-label">{{ __('main.website') }}</label>
                                <input type="url" name="website" id="website" class="kt-input h-[45px]"
                                    value="{{ old('website') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Local Guide -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.local_guide')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-4">
                            @for ($i = 1; $i <= 3; $i++)
                                <div>
                                    <label for="local_guide_fees_0{{ $i }}"
                                        class="kt-label">{{ __('main.local_guide_fees_0' . $i) }}</label>
                                    <input type="number" step="0.01" name="local_guide_fees_0{{ $i }}"
                                        id="local_guide_fees_0{{ $i }}" class="kt-input h-[45px]"
                                        value="{{ old('local_guide_fees_0' . $i) }}">
                                </div>
                            @endfor
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-6 mb-4">
                            @for ($i = 4; $i <= 5; $i++)
                                <div>
                                    <label for="local_guide_fees_0{{ $i }}"
                                        class="kt-label">{{ __('main.local_guide_fees_0' . $i) }}</label>
                                    <input type="number" step="0.01" name="local_guide_fees_0{{ $i }}"
                                        id="local_guide_fees_0{{ $i }}" class="kt-input h-[45px]"
                                        value="{{ old('local_guide_fees_0' . $i) }}">
                                </div>
                            @endfor
                        </div>

                        <div class="col-span-full flex items-center gap-3">
                            <input type="hidden" name="local_guide_available" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'local_guide_available',
                                'id' => 'local_guide_available',
                                'value' => '1',
                                'checked' => old('local_guide_available', 1),
                                'label' => __('main.local_guide_available'),
                            ])
                        </div>
                    </div>
                </div>

                <!-- Club Cars -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.club_cars')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="club_cars_available" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'club_cars_available',
                                'id' => 'club_cars_available',
                                'value' => '1',
                                'checked' => old('club_cars_available', 1),
                                'label' => __('main.club_cars_available'),
                            ])
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-4">
                            @for ($i = 1; $i <= 8; $i++)
                                <div>
                                    <label for="club_car_prices_0{{ $i }}"
                                        class="kt-label">{{ __('main.club_car_prices_0' . $i) }}</label>
                                    <input type="number" step="0.01" name="club_car_prices_0{{ $i }}"
                                        id="club_car_prices_0{{ $i }}" class="kt-input h-[45px]"
                                        value="{{ old('club_car_prices_0' . $i) }}">
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

                <!-- Additional Fields -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.additional_fields')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                            <div>
                                <label for="ext1" class="kt-label">{{ __('main.ext1') }}</label>
                                <input type="text" name="ext1" id="ext1" class="kt-input h-[45px]"
                                    value="{{ old('ext1') }}">
                            </div>
                            <div>
                                <label for="ext2" class="kt-label">{{ __('main.ext2') }}</label>
                                <input type="text" name="ext2" id="ext2" class="kt-input h-[45px]"
                                    value="{{ old('ext2') }}">
                            </div>
                            <div>
                                <label for="ext3" class="kt-label">{{ __('main.ext3') }}</label>
                                <input type="text" name="ext3" id="ext3" class="kt-input h-[45px]"
                                    value="{{ old('ext3') }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                @include('components.elements.input-text-editor', [
                    'name' => 'description',
                    'value' => old('description'),
                ])

                {{-- Notes --}}
                @include('components.elements.input-text-editor', [
                    'name' => 'notes',
                    'value' => old('notes'),
                ])

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

                <!-- Save Submit -->
                @include('components.elements.save-submit', [
                    'models' => 'tourist-services',
                    'model' => 'tourist-service',
                ])
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        // Annual Holidays Dynamic Inputs
        document.getElementById('add-annual-holidays').addEventListener('click', function() {
            const container = document.getElementById('annual_holidays_container');
            const newItem = document.createElement('div');
            newItem.className = 'flex gap-2 mb-3 annual-holidays-item';
            newItem.innerHTML = `
                <input type="date" name="annual_holidays[]" class="kt-input h-[45px] flex-1">
                <button type="button" class="w-[45px] h-[45px] kt-btn kt-btn-sm bg-danger text-white remove-annual-holidays">
                    <i class="fas fa-trash"></i>
                </button>
            `;
            container.appendChild(newItem);
            attachRemoveListeners();
        });

        // Yearly Holidays Dynamic Inputs
        document.getElementById('add-yearly-holidays').addEventListener('click', function() {
            const container = document.getElementById('yearly_holidays_container');
            const newItem = document.createElement('div');
            newItem.className = 'flex gap-2 mb-3 yearly-holidays-item';
            newItem.innerHTML = `
                <input type="text" name="yearly_holidays[]" class="kt-input h-[45px] flex-1" list="holidays-list" placeholder="{{ __('main.holiday') }}">
                <button type="button" class="w-[45px] h-[45px] kt-btn kt-btn-sm bg-danger text-white remove-yearly-holidays">
                    <i class="fas fa-trash-can text-white"></i>
                </button>
            `;
            container.appendChild(newItem);
            attachRemoveListeners();
        });

        function attachRemoveListeners() {
            // Remove Annual Holidays
            document.querySelectorAll('.remove-annual-holidays').forEach(btn => {
                btn.removeEventListener('click', removeAnnualHoliday);
                btn.addEventListener('click', removeAnnualHoliday);
            });

            // Remove Yearly Holidays
            document.querySelectorAll('.remove-yearly-holidays').forEach(btn => {
                btn.removeEventListener('click', removeYearlyHoliday);
                btn.addEventListener('click', removeYearlyHoliday);
            });
        }

        function removeAnnualHoliday(e) {
            e.preventDefault();
            const container = document.getElementById('annual_holidays_container');
            if (container.querySelectorAll('.annual-holidays-item').length > 1) {
                this.closest('.annual-holidays-item').remove();
            } else {
                alert('{{ __('messages.must_have_one_item') }}');
            }
        }

        function removeYearlyHoliday(e) {
            e.preventDefault();
            const container = document.getElementById('yearly_holidays_container');
            if (container.querySelectorAll('.yearly-holidays-item').length > 1) {
                this.closest('.yearly-holidays-item').remove();
            } else {
                alert('{{ __('messages.must_have_one_item') }}');
            }
        }

        // Initialize on page load
        attachRemoveListeners();
    </script>
@endpush
