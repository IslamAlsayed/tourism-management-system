@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.tourist-service')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.tourist-service') }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    Mr. {{ $touristService->person_name_01 }} • {{ $touristService->site?->name }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('tourist-services.edit', $touristService->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('tourist-services.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tourist-services')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">

            <!-- Basic Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.basic')]) }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.site') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                <a href="{{ route('tourist-sites.show', $touristService->site->id) }}"
                                    class="block text-sm text-primary underline">
                                    {{ $touristService->site->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.currency') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $touristService->currency->name ?? __('main.na') }}
                                <span class="text-primary font-semibold">
                                    ({{ $touristService->currency->code ?? __('main.na') }})
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.sort_order') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $touristService->sort_order }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.credit_cards') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristService->id,
                                    'modelType' => '\\App\\Models\\TouristService',
                                    'field' => 'credit_cards',
                                    'value' => (bool) $touristService->credit_cards,
                                    'table' => 'tourist_services',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristService->id,
                                    'modelType' => '\\App\\Models\\TouristService',
                                    'field' => 'is_active',
                                    'value' => (bool) $touristService->is_active,
                                    'table' => 'tourist_services',
                                ])
                            </div>
                        </div>
                        @include('components.elements.display-desc-or-notes', [
                            'record' => $touristService,
                            'column' => 'description',
                        ])
                        @include('components.elements.display-desc-or-notes', [
                            'record' => $touristService,
                            'column' => 'notes',
                        ])
                    </div>
                </div>
            </div>

            <!-- Pricing Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.pricing_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-6">
                        {{-- Ticket --}}
                        <div class="kt-card">
                            <div class="kt-card-header">
                                <h3 class="kt-card-title">{{ __('main.ticket') }}</h3>
                            </div>
                            <div class="kt-card-body p-4 flex flex-wrap justify-between gap-6">
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.include_unified_ticket') }}</label>
                                    <div class="flex items-center gap-2">
                                        @livewire('toggle-switch', [
                                            'modelId' => $touristService->id,
                                            'modelType' => '\\App\\Models\\TouristService',
                                            'field' => 'include_unified_ticket',
                                            'value' => (bool) $touristService->include_unified_ticket,
                                            'table' => 'tourist_services',
                                        ])
                                    </div>
                                </div>
                                @if ($touristService->total_day_visit)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.total_day_visit') }}</label>
                                        <p class="text-sm text-secondary-foreground">{{ $touristService->total_day_visit }}
                                            {{ $touristService->currency->code ?? '' }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Foreigners -->
                        <div class="kt-card">
                            <div class="kt-card-header">
                                <h3 class="kt-card-title">{{ __('main.foreigners') }}</h3>
                            </div>
                            <div class="kt-card-body p-4 flex flex-wrap justify-between gap-6">
                                @if ($touristService->per_adult_foreigners)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.per_adult_foreigners') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $touristService->per_adult_foreigners }}
                                            {{ $touristService->currency->code ?? '' }}</p>
                                    </div>
                                @endif
                                @if ($touristService->per_child_foreigners)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.per_child_foreigners') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $touristService->per_child_foreigners }}
                                            {{ $touristService->currency->code ?? '' }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Local -->
                        <div class="kt-card">
                            <div class="kt-card-header">
                                <h3 class="kt-card-title">{{ __('main.local') }}</h3>
                            </div>
                            <div class="kt-card-body p-4 flex flex-wrap justify-between gap-6">
                                @if ($touristService->per_adult_local)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.per_adult_local') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $touristService->per_adult_local }}
                                            {{ $touristService->currency->code ?? '' }}</p>
                                    </div>
                                @endif
                                @if ($touristService->per_child_local)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.per_child_local') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $touristService->per_child_local }}
                                            {{ $touristService->currency->code ?? '' }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Arab -->
                        <div class="kt-card">
                            <div class="kt-card-header">
                                <h3 class="kt-card-title">{{ __('main.arab') }}</h3>
                            </div>
                            <div class="kt-card-body p-4 flex flex-wrap justify-between gap-6">
                                @if ($touristService->per_adult_arab)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.per_adult_arab') }}</label>
                                        <p class="text-sm text-secondary-foreground">{{ $touristService->per_adult_arab }}
                                            {{ $touristService->currency->code ?? '' }}</p>
                                    </div>
                                @endif
                                @if ($touristService->per_child_arab)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.per_child_arab') }}</label>
                                        <p class="text-sm text-secondary-foreground">{{ $touristService->per_child_arab }}
                                            {{ $touristService->currency->code ?? '' }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Residents -->
                        <div class="kt-card">
                            <div class="kt-card-header">
                                <h3 class="kt-card-title">{{ __('main.residents') }}</h3>
                            </div>
                            <div class="kt-card-body p-4 flex flex-wrap justify-between gap-6">
                                @if ($touristService->per_adult_residents)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.per_adult_residents') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $touristService->per_adult_residents }}
                                            {{ $touristService->currency->code ?? '' }}</p>
                                    </div>
                                @endif
                                @if ($touristService->per_child_residents)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.per_child_residents') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $touristService->per_child_residents }}
                                            {{ $touristService->currency->code ?? '' }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Non Accommodated Visitors -->
                        <div class="kt-card">
                            <div class="kt-card-header">
                                <h3 class="kt-card-title">{{ __('main.non_accommodated_visitors') }}</h3>
                            </div>
                            <div class="kt-card-body p-4 flex flex-wrap justify-between gap-6">
                                @if ($touristService->non_accommodated_visitors_adult)
                                    <div>
                                        <label
                                            class="kt-label mb-1">{{ __('main.non_accommodated_visitors_adult') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $touristService->non_accommodated_visitors_adult }}
                                            {{ $touristService->currency->code ?? '' }}</p>
                                    </div>
                                @endif
                                @if ($touristService->non_accommodated_visitors_child)
                                    <div>
                                        <label
                                            class="kt-label mb-1">{{ __('main.non_accommodated_visitors_child') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $touristService->non_accommodated_visitors_child }}
                                            {{ $touristService->currency->code ?? '' }}</p>
                                    </div>
                                @endif
                            </div>
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
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-6">
                        <!-- Residents -->
                        <div class="kt-card">
                            <div class="kt-card-header">
                                <h3 class="kt-card-title">{{ __('main.residents') }}</h3>
                            </div>
                            <div class="kt-card-body p-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-6">
                                    @if ($touristService->summer_opening_time)
                                        <div>
                                            <label class="kt-label mb-1">{{ __('main.summer_opening_time') }}</label>
                                            <p class="text-sm text-secondary-foreground">
                                                <span class="kt-badge kt-badge-info">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ $touristService->summer_opening_time }}
                                                </span>
                                            </p>
                                        </div>
                                    @endif
                                    @if ($touristService->summer_closing_time)
                                        <div>
                                            <label class="kt-label mb-1">{{ __('main.summer_closing_time') }}</label>
                                            <p class="text-sm text-secondary-foreground">
                                                <span class="kt-badge kt-badge-warning">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ $touristService->summer_closing_time }}
                                                </span>
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Residents -->
                        <div class="kt-card">
                            <div class="kt-card-header">
                                <h3 class="kt-card-title">{{ __('main.residents') }}</h3>
                            </div>
                            <div class="kt-card-body p-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-6">
                                    @if ($touristService->winter_opening_time)
                                        <div>
                                            <label class="kt-label mb-1">{{ __('main.winter_opening_time') }}</label>
                                            <p class="text-sm text-secondary-foreground">
                                                <span class="kt-badge kt-badge-info">
                                                    <i class="fas fa-snowflake me-1"></i>
                                                    {{ $touristService->winter_opening_time }}
                                                </span>
                                            </p>
                                        </div>
                                    @endif
                                    @if ($touristService->winter_closing_time)
                                        <div>
                                            <label class="kt-label mb-1">{{ __('main.winter_closing_time') }}</label>
                                            <p class="text-sm text-secondary-foreground">
                                                <span class="kt-badge kt-badge-warning">
                                                    <i class="fas fa-snowflake me-1"></i>
                                                    {{ $touristService->winter_closing_time }}
                                                </span>
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Operating Schedule -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.operating_schedule') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        @if ($touristService->operating_days && count($touristService->operating_days) > 0)
                            <div>
                                <label class="kt-label mb-2 block">{{ __('main.operating_days') }}</label>
                                <div class="flex gap-2 flex-wrap">
                                    @foreach ($touristService->operating_days as $day)
                                        <span class="kt-badge kt-badge-primary">{{ __('main.' . $day) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if ($touristService->day_off && count($touristService->day_off) > 0)
                            <div>
                                <label class="kt-label mb-2 block">{{ __('main.day_off') }}</label>
                                <div class="flex gap-2 flex-wrap">
                                    @foreach ($touristService->day_off as $day)
                                        <span class="kt-badge kt-badge-danger">{{ __('main.' . $day) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if ($touristService->annual_holidays && count($touristService->annual_holidays) > 0)
                            <div>
                                <label class="kt-label mb-2 block">{{ __('main.annual_holidays') }}</label>
                                <div class="flex gap-2 flex-wrap">
                                    @foreach ($touristService->annual_holidays as $date)
                                        <span class="kt-badge kt-badge-warning">{{ $date }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if ($touristService->yearly_holidays && count($touristService->yearly_holidays) > 0)
                            <div>
                                <label class="kt-label mb-2 block">{{ __('main.yearly_holidays') }}</label>
                                <div class="flex gap-2 flex-wrap">
                                    @foreach ($touristService->yearly_holidays as $holiday)
                                        <span class="kt-badge kt-badge-info">{{ $holiday }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.contact_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @if ($touristService->person_name_01)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.person_name_01') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $touristService->person_name_01 }}</p>
                            </div>
                        @endif
                        @if ($touristService->person_name_02)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.person_name_02') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $touristService->person_name_02 }}</p>
                            </div>
                        @endif
                        @if ($touristService->phone)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.phone') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <a href="tel:{{ $touristService->phone }}" class="text-primary hover:underline">
                                        {{ $touristService->phone }}
                                    </a>
                                </p>
                            </div>
                        @endif
                        @if ($touristService->fax)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.fax') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $touristService->fax }}</p>
                            </div>
                        @endif
                        @if ($touristService->mobile_01)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.mobile_01') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <a href="tel:{{ $touristService->mobile_01 }}" class="text-primary hover:underline">
                                        {{ $touristService->mobile_01 }}
                                    </a>
                                </p>
                            </div>
                        @endif
                        @if ($touristService->mobile_02)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.mobile_02') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <a href="tel:{{ $touristService->mobile_02 }}" class="text-primary hover:underline">
                                        {{ $touristService->mobile_02 }}
                                    </a>
                                </p>
                            </div>
                        @endif
                        @if ($touristService->email_01)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.email_01') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <a href="mailto:{{ $touristService->email_01 }}"
                                        class="text-primary hover:underline">
                                        {{ $touristService->email_01 }}
                                    </a>
                                </p>
                            </div>
                        @endif
                        @if ($touristService->email_02)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.email_02') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <a href="mailto:{{ $touristService->email_02 }}"
                                        class="text-primary hover:underline">
                                        {{ $touristService->email_02 }}
                                    </a>
                                </p>
                            </div>
                        @endif
                        @if ($touristService->website)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.website') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <a href="{{ $touristService->website }}" target="_blank"
                                        class="text-primary hover:underline">
                                        {{ $touristService->website }}
                                    </a>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Local Guide Information -->
            @if ($touristService->local_guide_available || $touristService->local_guide_fees_01)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.local_guide') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @if ($touristService->local_guide_available !== null)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.local_guide_available') }}</label>
                                    <div class="flex items-center gap-2">
                                        @livewire('toggle-switch', [
                                            'modelId' => $touristService->id,
                                            'modelType' => '\\App\\Models\\TouristService',
                                            'field' => 'local_guide_available',
                                            'value' => (bool) $touristService->local_guide_available,
                                            'table' => 'tourist_services',
                                        ])
                                    </div>
                                </div>
                            @endif
                            @if ($touristService->local_guide_fees_01)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.local_guide_fees_01') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $touristService->local_guide_fees_01 }}
                                        {{ $touristService->currency->code ?? '' }}</p>
                                </div>
                            @endif
                            @if ($touristService->local_guide_fees_02)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.local_guide_fees_02') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $touristService->local_guide_fees_02 }}
                                        {{ $touristService->currency->code ?? '' }}</p>
                                </div>
                            @endif
                            @if ($touristService->local_guide_fees_03)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.local_guide_fees_03') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $touristService->local_guide_fees_03 }}
                                        {{ $touristService->currency->code ?? '' }}</p>
                                </div>
                            @endif
                            @if ($touristService->local_guide_fees_04)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.local_guide_fees_04') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $touristService->local_guide_fees_04 }}
                                        {{ $touristService->currency->code ?? '' }}</p>
                                </div>
                            @endif
                            @if ($touristService->local_guide_fees_05)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.local_guide_fees_05') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $touristService->local_guide_fees_05 }}
                                        {{ $touristService->currency->code ?? '' }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Club Cars Information -->
            @if ($touristService->club_cars_available || $touristService->club_car_prices_01)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.club_cars') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @if ($touristService->club_cars_available !== null)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.club_cars_available') }}</label>
                                    <div class="flex items-center gap-2">
                                        @livewire('toggle-switch', [
                                            'modelId' => $touristService->id,
                                            'modelType' => '\\App\\Models\\TouristService',
                                            'field' => 'club_cars_available',
                                            'value' => (bool) $touristService->club_cars_available,
                                            'table' => 'tourist_services',
                                        ])
                                    </div>
                                </div>
                            @endif
                            @for ($i = 1; $i <= 8; $i++)
                                @php
                                    $priceField = 'club_car_prices_0' . $i;
                                @endphp
                                @if ($touristService->$priceField)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.club_car_prices_0' . $i) }}</label>
                                        <p class="text-sm text-secondary-foreground">{{ $touristService->$priceField }}
                                            {{ $touristService->currency->code ?? '' }}</p>
                                    </div>
                                @endif
                            @endfor
                        </div>
                    </div>
                </div>
            @endif

            <!-- Additional Fields -->
            @if ($touristService->ext1 || $touristService->ext2 || $touristService->ext3)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.additional_information') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @if ($touristService->ext1)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.ext1') }}</label>
                                    <p class="text-sm text-secondary-foreground">{{ $touristService->ext1 }}</p>
                                </div>
                            @endif
                            @if ($touristService->ext2)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.ext2') }}</label>
                                    <p class="text-sm text-secondary-foreground">{{ $touristService->ext2 }}</p>
                                </div>
                            @endif
                            @if ($touristService->ext3)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.ext3') }}</label>
                                    <p class="text-sm text-secondary-foreground">{{ $touristService->ext3 }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Metadata -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.metadata') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-6">
                        @if ($touristService->creator)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.created_by') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $touristService->creator->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.created_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $touristService->created_at?->diffForHumans() }}
                            </p>
                        </div>
                        @if ($touristService->updater)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.updated_by') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $touristService->updater->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.updated_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $touristService->updated_at?->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'tourist-services',
                    'id' => $touristService->id,
                ])
                @include('components.elements.delete-form', [
                    'model' => 'tourist-services',
                    'id' => $touristService->id,
                ])
                <a href="{{ route('tourist-services.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tourist-services')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
