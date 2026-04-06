@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.tourist-service')]))

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $touristService->name ?? __('main.tourist-service') }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    <span>{{ $touristService->city?->name }}</span>
                    @if ($touristService->pricing_type === 'flat')
                        <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded">{{ __('main.flat_rate') }}</span>
                    @else
                        <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">{{ __('main.seasonal_pricing') }}</span>
                    @endif
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.touristservices.services.edit', $touristService->id) }}" class="kt-btn kt-btn-primary">
                    <i class="fa-duotone fa-solid fa-pen text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('dashboard.touristservices.services.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tourist-services')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="container-fixed">
        <div class="grid gap-4 lg:gap-6">

            <!-- 1. Basic Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title flex items-center gap-2">
                        {{ __('main.basic_information') }}
                    </h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.service_name') }}</label>
                            <p class="text-sm text-secondary-foreground font-medium">{{ $touristService->name ?? __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.service_name_ar') }}</label>
                            <p class="text-sm text-secondary-foreground font-medium">{{ $touristService->name_ar ?? __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="font-medium text-gray-600">{{ __('main.code') }}</label>
                            <p class="mt-1 text-gray-900">
                                <span class="kt-badge kt-badge-outline kt-badge-primary">{{ $touristService->code ?? '-' }}</span>
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.currency') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $touristService->currency->name }}
                                <span class="text-primary font-semibold">
                                    ({{ $touristService->currency->code }})
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.location') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $touristService->country?->name }}, {{ $touristService->city?->name }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.address') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $touristService->address ?? __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.sort_order') }}</label>
                            <p class="text-sm text-secondary-foreground font-mono">{{ $touristService->sort_order }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristService->id,
                                    'modelType' => '\\Modules\\TouristServices\\Entities\\TouristService',
                                    'field' => 'is_active',
                                    'value' => (bool) $touristService->is_active,
                                    'table' => 'tourist_services',
                                ])
                            </div>
                        </div>
                        @include('components.elements.displayable-rich-text', [
                            'record' => $touristService,
                            'column' => 'description',
                        ])
                        @include('components.elements.displayable-rich-text', [
                            'record' => $touristService,
                            'column' => 'notes',
                        ])
                    </div>
                </div>
            </div>

            <!-- 2. Pricing Configuration -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title flex items-center gap-2">
                        {{ __('main.pricing_configuration') }}
                    </h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.pricing_model') }}</label>
                            <p class="text-sm text-secondary-foreground font-mono">
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold bg-blue-100 text-blue-700">
                                    {{ $touristService->pricing_model === 'per_person' ? __('main.per_person') : __('main.per_group') }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.pricing_type') }}</label>
                            <p class="text-sm text-secondary-foreground font-mono">
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold {{ $touristService->pricing_type === 'flat' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                                    {{ $touristService->pricing_type === 'flat' ? __('main.flat_rate') : __('main.seasonal_pricing') }}
                                </span>
                            </p>
                        </div>
                        @if ($touristService->pricing_unit)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.pricing_unit') }}</label>
                                <p class="text-sm text-secondary-foreground font-mono">{{ $touristService->pricing_unit }}</p>
                            </div>
                        @endif
                        @if ($touristService->pricing_unit_value)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.pricing_unit_value') }}</label>
                                <p class="text-sm text-secondary-foreground font-mono">{{ $touristService->pricing_unit_value }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- 3. Seasonal Prices / Pricing Tables -->
            @if ($touristService->seasonalPrices && count($touristService->seasonalPrices) > 0)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title flex items-center gap-2">
                            {{ __('main.pricing_details') }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="space-y-6">
                            @foreach ($touristService->seasonalPrices as $seasonalPrice)
                                <div class="border-custom rounded-lg p-4 bg-gray-50">
                                    <div class="flex items-center justify-between mb-4 pb-4 border-b">
                                        <div>
                                            <h4 class="font-bold text-lg text-gray-600">{{ $seasonalPrice->season_name }}</h4>
                                            @if ($seasonalPrice->season_start_date && $seasonalPrice->season_end_date)
                                                <p class="text-sm text-gray-500">
                                                    {{ $seasonalPrice->season_start_date->format('M d, Y') }} -
                                                    {{ $seasonalPrice->season_end_date->format('M d, Y') }}
                                                </p>
                                            @endif
                                        </div>
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full {{ $seasonalPrice->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ $seasonalPrice->is_active ? __('main.active') : __('main.inactive') }}
                                        </span>
                                    </div>

                                    {{-- Display Pricing Matrix --}}
                                    @if ($seasonalPrice->pricing_matrix && is_array($seasonalPrice->pricing_matrix) && count($seasonalPrice->pricing_matrix) > 0)
                                        @php
                                            $matrix = $seasonalPrice->pricing_matrix;
                                            $categories = [
                                                'adult' => __('main.adult'),
                                                'child_young' => __('main.child_young'),
                                                'child_older' => __('main.child_older'),
                                                'infant' => __('main.infant'),
                                            ];
                                            $nationalities = [
                                                'foreigner' => __('main.foreigner'),
                                                'arab' => __('main.arab'),
                                                'resident' => __('main.resident'),
                                                'local' => __('main.local_citizen'),
                                            ];
                                        @endphp
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            @foreach ($categories as $category => $categoryLabel)
                                                @if (isset($matrix[$category]))
                                                    <div class="overflow-x-auto border-custom rounded-lg background">
                                                        <table class="w-full text-sm border-collapse">
                                                            <thead class="bg-gradient-to-r from-blue-100 to-blue-50 text-gray-600 font-bold">
                                                                <tr>
                                                                    <th class="p-2 text-left border">{{ $categoryLabel }}</th>
                                                                    <th class="p-2 text-center border">{{ __('main.cost') }}</th>
                                                                    <th class="p-2 text-center border">{{ __('main.commission') }}</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($nationalities as $nat => $natLabel)
                                                                    @if (isset($matrix[$category][$nat]))
                                                                        <tr class="border-t hover:bg-gray-50 transition">
                                                                            <td class="p-2 border font-medium text-gray-600">{{ $natLabel }}</td>
                                                                            <td class="p-2 border text-center text-gray-900 font-semibold">
                                                                                {{ $matrix[$category][$nat]['cost'] ?? '-' }}
                                                                                {{ $touristService->currency->code }}</td>
                                                                            <td class="p-2 border text-center text-gray-600">
                                                                                {{ $matrix[$category][$nat]['commission'] ?? '-' }}</td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif

                                    {{-- Custom Nationalities --}}
                                    @if (isset($seasonalPrice->pricing_matrix['custom_nationalities']) &&
                                            is_array($seasonalPrice->pricing_matrix['custom_nationalities']) &&
                                            count($seasonalPrice->pricing_matrix['custom_nationalities']) > 0)
                                        <div class="mt-4 border-t pt-4">
                                            <h5 class="text-sm font-bold text-teal-700 mb-3 flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                                {{ __('main.custom_nationalities') ?? 'Custom Nationalities' }}
                                            </h5>
                                            <div class="space-y-3">
                                                @foreach ($seasonalPrice->pricing_matrix['custom_nationalities'] as $custom)
                                                    <div class="border-custom rounded-lg p-3 bg-teal-50">
                                                        <h6 class="font-semibold text-teal-800 mb-2">{{ $custom['nationality'] ?? 'N/A' }}</h6>
                                                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs">
                                                            @foreach ($categories as $category => $categoryLabel)
                                                                @if (isset($custom[$category]))
                                                                    <div class="bg-white rounded p-2">
                                                                        <p class="text-gray-500 font-semibold">{{ $categoryLabel }}</p>
                                                                        <p class="text-gray-900 font-bold">{{ $custom[$category]['cost'] ?? '-' }}
                                                                            {{ $touristService->currency->code }}</p>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Subregion Pricing --}}
                                    @if (isset($seasonalPrice->pricing_matrix['subregion_pricing']) &&
                                            is_array($seasonalPrice->pricing_matrix['subregion_pricing']) &&
                                            count($seasonalPrice->pricing_matrix['subregion_pricing']) > 0)
                                        <div class="mt-4 border-t pt-4">
                                            <h5 class="text-sm font-bold text-amber-700 mb-3 flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                {{ __('main.subregion_pricing') ?? 'Subregion-Based Pricing' }}
                                            </h5>
                                            <div class="space-y-3">
                                                @foreach ($seasonalPrice->pricing_matrix['subregion_pricing'] as $subregion)
                                                    <div class="border-custom rounded-lg p-3 bg-amber-50">
                                                        <h6 class="font-semibold text-amber-800 mb-2">{{ $subregion['subregion'] ?? 'N/A' }}</h6>
                                                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs">
                                                            @foreach ($categories as $category => $categoryLabel)
                                                                @if (isset($subregion[$category]))
                                                                    <div class="bg-white rounded p-2">
                                                                        <p class="text-gray-500 font-semibold">{{ $categoryLabel }}</p>
                                                                        <p class="text-gray-900 font-bold">{{ $subregion[$category]['cost'] ?? '-' }}
                                                                            {{ $touristService->currency->code }}</p>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                    {{-- Seasonal Price notes --}}
                                    {{-- @if ($seasonalPrice->notes)
                                        <div class="mt-4">
                                            <label class="kt-label mb-1">{{ __('main.notes') }}</label>
                                            <p class="text-sm text-secondary-foreground">{{ $seasonalPrice->notes }}</p>
                                        </div>
                                    @endif --}}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- 4. Tax Configurations -->
            @if ($touristService->taxConfigurations && count($touristService->taxConfigurations) > 0)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title flex items-center gap-2">
                            {{ __('main.taxes') }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($touristService->taxConfigurations as $tax)
                                <div class="border-custom rounded-lg p-4 bg-orange-50">
                                    <h5 class="font-bold text-gray-600 mb-2">{{ $tax->name }}</h5>
                                    <div class="space-y-2">
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-600">{{ __('main.type') }}:</span>
                                            <span class="text-sm font-semibold">{{ $tax->type === 'percentage' ? '%' : $touristService->currency->code }}</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-600">{{ __('main.value') }}:</span>
                                            <span class="text-sm font-bold">{{ $tax->value }}</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-600">{{ __('main.is_active') }}:</span>
                                            <span
                                                class="inline-flex text-xs font-semibold px-2 py-1 rounded {{ $tax->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $tax->is_active ? __('main.yes') : __('main.no') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- 5. Commission Configurations -->
            @if ($touristService->commissionConfigurations && count($touristService->commissionConfigurations) > 0)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title flex items-center gap-2">
                            {{ __('main.commissions') }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($touristService->commissionConfigurations as $commission)
                                <div class="border-custom rounded-lg p-4 bg-green-50">
                                    <h5 class="font-bold text-gray-600 mb-2">{{ $commission->name }}</h5>
                                    <div class="space-y-2">
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-600">{{ __('main.applies_to') }}:</span>
                                            <span class="text-sm font-semibold">{{ $commission->applies_to }}</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-600">{{ __('main.type') }}:</span>
                                            <span
                                                class="text-sm font-semibold">{{ $commission->type === 'percentage' ? '%' : $touristService->currency->code }}</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-600">{{ __('main.value') }}:</span>
                                            <span class="text-sm font-bold">{{ $commission->value }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Related Cities -->
            @if ($touristService->modules && $touristService->modules->count() > 0)
                @include('components.state-search', [
                    'type' => 'no-route',
                    'models' => 'target_modules',
                    'column' => 'module_name',
                    'records' => $touristService->modules,
                ])
            @endif

            <!-- 7. Media Files -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.media_resources') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="flex flex-col gap-6">
                        @if ($touristService->photo)
                            <div class="flex flex-col w-fit">
                                <label class="kt-label mb-2">{{ __('main.photo') }}</label>
                                <div class="image-container">
                                    @if ($touristService->photo)
                                        <img src="{{ asset('storage/' . $touristService->photo) }}" alt="Main Image"
                                            class="w-auto h-[250px] object-cover shadow" loading="lazy">
                                    @else
                                        <div class="h-40 bg-gray-200 flex items-center justify-center">
                                            <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                                        </div>
                                    @endif
                                    <div class="image-overlay">
                                        <a href="{{ $touristService->photo ? asset('storage/' . $touristService->photo) : '#' }}"
                                            download="{{ $touristService->photo }}" class="kt-btn kt-btn-sm kt-btn-primary">
                                            <i class="fas fa-download text-sm me-1"></i>
                                            <span>{{ __('main.download') }}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($touristService->gallery && count($touristService->gallery) > 0)
                            <div>
                                <label class="kt-label mb-3">{{ __('main.gallery_images') }}
                                    <span class="text-xs text-primary">
                                        ({{ count($touristService->gallery) }} {{ __('main.images') }})
                                    </span>
                                </label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                    @foreach ($touristService->gallery as $index => $image)
                                        <div class="image-container">
                                            @if ($image)
                                                <img src="{{ asset('storage/' . $image) }}" alt="{{ __('main.gallery') }} {{ $index + 1 }}"
                                                    class="w-full h-32 object-cover" loading="lazy">
                                            @else
                                                <div class="w-full h-32 bg-gray-200 flex items-center justify-center">
                                                    <p class="text-xs text-secondary-foreground">{{ __('main.na') }}</p>
                                                </div>
                                            @endif
                                            <div class="image-overlay">
                                                <a href="{{ $image ? asset('storage/' . $image) : '#' }}" download="{{ $image }}"
                                                    class="kt-btn kt-btn-sm kt-btn-primary">
                                                    <i class="fas fa-download text-sm me-1"></i>
                                                    <span>{{ __('main.download') }}</span>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- 8. Contact Information -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-4">
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.contact')]) }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="flex flex-wrap justify-between" style="gap: 10px 40px">
                            <div>
                                <label class="kt-label mb-1">{{ __('main.contact_person') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <span class="kt-badge kt-badge-info">
                                        {{ $touristService->contact_person ?? __('main.na') }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <label class="kt-label mb-1">{{ __('main.email') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    @if ($touristService->email)
                                        <a href="mailto:{{ $touristService->email }}">
                                            {{ $touristService->email }}
                                        </a>
                                    @else
                                        {{ __('main.na') }}
                                    @endif
                                </p>
                            </div>
                            <div>
                                <label class="kt-label mb-1">{{ __('main.phone') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    @if ($touristService->phone)
                                        <a href="tel:{{ $touristService->phone }}">
                                            {{ $touristService->phone }}
                                        </a>
                                    @else
                                        {{ __('main.na') }}
                                    @endif
                                </p>
                            </div>
                            <div>
                                <label class="kt-label mb-1">{{ __('main.mobile') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    @if ($touristService->mobile)
                                        <a href="tel:{{ $touristService->mobile }}">
                                            {{ $touristService->mobile }}
                                        </a>
                                    @else
                                        {{ __('main.na') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 13. Location Details -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title flex items-center gap-2">
                            {{ __('main.location_details') }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="flex flex-wrap" style="gap: 10px 40px">
                            <div>
                                <label class="kt-label mb-1">{{ __('main.latitude') }}</label>
                                <p class="text-sm text-secondary-foreground font-mono">{{ $touristService->latitude ?? __('main.na') }}</p>
                            </div>
                            <div>
                                <label class="kt-label mb-1">{{ __('main.longitude') }}</label>
                                <p class="text-sm text-secondary-foreground font-mono">{{ $touristService->longitude ?? __('main.na') }}</p>
                            </div>
                            @if ($touristService->latitude && $touristService->longitude)
                                <div class="sm:col-span-2">
                                    <label class="kt-label mb-2">{{ __('main.map_preview') }}</label>
                                    <div class="border-custom rounded-lg overflow-hidden h-64">
                                        <iframe width="100%" height="100%" frameborder="0" style="border:0"
                                            src="https://www.google.com/maps/embed/v1/place?key=&q={{ $touristService->latitude }},{{ $touristService->longitude }}"
                                            allowfullscreen="" aria-hidden="false" tabindex="0">
                                        </iframe>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- 9. Operations & Hours -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title flex items-center gap-2">
                        {{ __('main.operations') }}
                    </h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_24_7') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristService->id,
                                    'modelType' => '\\Modules\\TouristServices\\Entities\\TouristService',
                                    'field' => 'is_24_7',
                                    'value' => (bool) $touristService->is_24_7,
                                    'table' => 'tourist_services',
                                ])
                            </div>
                        </div>
                        @if (!$touristService->is_24_7)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.opening_time') }}</label>
                                <p class="text-sm text-secondary-foreground font-mono">{{ $touristService->opening_time ?? __('main.na') }}</p>
                            </div>
                            <div>
                                <label class="kt-label mb-1">{{ __('main.closing_time') }}</label>
                                <p class="text-sm text-secondary-foreground font-mono">{{ $touristService->closing_time ?? __('main.na') }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.min_participants') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $touristService->min_participants ?? __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.max_participants') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $touristService->max_participants ?? __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.duration_minutes') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $touristService->duration_minutes ? $touristService->duration_minutes . ' ' . __('main.minutes') : __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.booking_required') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristService->id,
                                    'modelType' => '\\Modules\\TouristServices\\Entities\\TouristService',
                                    'field' => 'booking_required',
                                    'value' => (bool) $touristService->booking_required,
                                    'table' => 'tourist_services',
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 10. Age Policies -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Adult Policy -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title flex items-center gap-2">
                            <span class="inline-block w-3 h-3 rounded-full bg-blue-500"></span>
                            {{ __('main.adult') }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="space-y-3">
                            <div>
                                <label class="kt-label mb-1 text-xs">{{ __('main.min_age') }}</label>
                                <p class="text-sm font-semibold">{{ $touristService->adult_min_age ?? __('main.na') }}</p>
                            </div>
                            <div>
                                <label class="kt-label mb-1 text-xs">{{ __('main.max_age') }}</label>
                                <p class="text-sm font-semibold">{{ $touristService->adult_max_age ?? __('main.na') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Young Child Policy -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title flex items-center gap-2">
                            <span class="inline-block w-3 h-3 rounded-full bg-green-500"></span>
                            {{ __('main.child_young') }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="space-y-3">
                            <div>
                                <label class="kt-label mb-1 text-xs">{{ __('main.min_age') }}</label>
                                <p class="text-sm font-semibold">{{ $touristService->child_min_age ?? __('main.na') }}</p>
                            </div>
                            <div>
                                <label class="kt-label mb-1 text-xs">{{ __('main.max_age') }}</label>
                                <p class="text-sm font-semibold">{{ $touristService->child_max_age ?? __('main.na') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Older Child Policy -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title flex items-center gap-2">
                            <span class="inline-block w-3 h-3 rounded-full bg-yellow-500"></span>
                            {{ __('main.child_older') }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="space-y-3">
                            <div>
                                <label class="kt-label mb-1 text-xs">{{ __('main.min_age') }}</label>
                                <p class="text-sm font-semibold">{{ $touristService->child_min_age ?? __('main.na') }}</p>
                            </div>
                            <div>
                                <label class="kt-label mb-1 text-xs">{{ __('main.max_age') }}</label>
                                <p class="text-sm font-semibold">{{ $touristService->child_max_age ?? __('main.na') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Infant Policy -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title flex items-center gap-2">
                            <span class="inline-block w-3 h-3 rounded-full bg-pink-500"></span>
                            {{ __('main.infant') }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="space-y-3">
                            <div>
                                <label class="kt-label mb-1 text-xs">{{ __('main.infant_age_range') }}</label>
                                <p class="text-sm font-semibold">{{ $touristService->infant_min_age ?? __('main.na') }} -
                                    {{ $touristService->infant_max_age ?? __('main.na') }}</p>
                            </div>
                            <div>
                                <label class="kt-label mb-1 text-xs">{{ __('main.is_refundable') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $touristService->id,
                                        'modelType' => '\\Modules\\TouristServices\\Entities\\TouristService',
                                        'field' => 'is_refundable',
                                        'value' => (bool) $touristService->is_refundable,
                                        'table' => 'tourist_services',
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 11. Service Details & Classification -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title flex items-center gap-2">
                        {{ __('main.service_details') }}
                    </h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @if ($touristService->service_type)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.service_type') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <span class="kt-badge kt-badge-info">{{ $touristService->service_type }}</span>
                                </p>
                            </div>
                        @endif
                        @if ($touristService->category)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.category') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $touristService->category }}</p>
                            </div>
                        @endif
                        @if ($touristService->supplier_type)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.supplier_type') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $touristService->supplier_type }}</p>
                            </div>
                        @endif
                        @if ($touristService->supplier_name)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.supplier_name') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $touristService->supplier_name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.difficulty_level') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold
                                    {{ $touristService->difficulty_level === 'easy' ? 'bg-green-100 text-green-700' : ($touristService->difficulty_level === 'medium' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                    {{ __('main.' . $touristService->difficulty_level) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_free') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristService->id,
                                    'modelType' => '\\Modules\\TouristServices\\Entities\\TouristService',
                                    'field' => 'is_free',
                                    'value' => (bool) $touristService->is_free,
                                    'table' => 'tourist_services',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_verified') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristService->id,
                                    'modelType' => '\\Modules\\TouristServices\\Entities\\TouristService',
                                    'field' => 'is_verified',
                                    'value' => (bool) $touristService->is_verified,
                                    'table' => 'tourist_services',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_featured') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristService->id,
                                    'modelType' => '\\Modules\\TouristServices\\Entities\\TouristService',
                                    'field' => 'is_featured',
                                    'value' => (bool) $touristService->is_featured,
                                    'table' => 'tourist_services',
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 12. Ratings & Reviews -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title flex items-center gap-2">
                        {{ __('main.ratings_reviews') }}
                    </h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div class="flex flex-warp gap-6">
                            <div>
                                <label class="kt-label mb-1">{{ __('main.average_rating') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                <div class="flex items-center gap-2">
                                    <span class="text-lg font-bold text-primary">{{ $touristService->rating }}</span>
                                    <span class="text-xs text-gray-500">/ 5.00</span>
                                </div>
                                </p>
                            </div>
                            <div>
                                <label class="kt-label mb-1">{{ __('main.total_reviews') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <span class="text-lg font-bold">{{ $touristService->total_reviews }}</span>
                                </p>
                            </div>
                        </div>

                        @if ($touristService->tags && count($touristService->tags) > 0)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.tags') }}</label>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($touristService->tags as $tag)
                                        <span class="kt-badge kt-badge-info px-2 py-1 text-xs rounded-full">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- 14. Policies -->
            @if ($touristService->cancellation_policy)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title flex items-center gap-2">
                            {{ __('main.policies') }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div>
                            <label class="kt-label mb-2">{{ __('main.cancellation_policy') }}</label>
                            <div class="bg-gray-50 border-custom rounded-lg p-4 text-sm text-secondary-foreground">
                                {!! nl2br(e($touristService->cancellation_policy)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Metadata -->
            @include('components.metadata', ['record' => $touristService])

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
                <a href="{{ route('dashboard.touristservices.services.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tourist-services')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
