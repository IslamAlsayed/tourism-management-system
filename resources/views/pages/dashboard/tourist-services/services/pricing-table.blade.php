{{--
    Pricing Table Partial - Main pricing table for Tourist Services
    Uses Blade-first approach following project conventions
    
    @param string $prefix - Field name prefix (e.g., 'seasonal_prices[Standard]')
    @param string $seasonName - Season identifier (e.g., 'Standard', 'Winter 2024')
    @param bool $isStandard - Whether this is the default/flat rate table
    @param Collection $nationalities - Available nationalities for custom rows
    @param Collection $subregions - Available subregions for region-based pricing
--}}

@php
    $tableId = \Illuminate\Support\Str::slug($seasonName, '_');
    $baseNationalities = [
        ['key' => 'foreigner', 'label' => __('main.foreigner'), 'color' => 'blue'],
        ['key' => 'arab', 'label' => __('main.arab'), 'color' => 'green'],
        ['key' => 'resident', 'label' => __('main.resident'), 'color' => 'pink'],
        ['key' => 'local', 'label' => __('main.local_citizen'), 'color' => 'orange'],
    ];
@endphp

<div class="kt-card mb-4 pricing-table-card" id="pricing-table-{{ $tableId }}" data-season="{{ $seasonName }}">
    {{-- Header --}}
    <div class="kt-card-header bg-gray-100/50 py-3 px-4 border-b flex items-center justify-between">
        <h4 class="flex items-center gap-2 text-sm font-bold text-gray-700">
            <span class="w-3 h-3 rounded-full {{ $isStandard ?? false ? 'bg-blue-500' : 'bg-green-500' }}"></span>
            {{ $seasonName }} {{ __('main.rates') }}
        </h4>
        @if ($isStandard ?? false)
            <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded">{{ __('main.default') }}</span>
        @else
            <span class="text-xs background border px-2 py-1 rounded text-gray-500 font-mono">{{ __('main.season') }}:
                {{ $seasonName }}</span>
        @endif
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto p-0">
        <table class="w-full text-sm text-center border-collapse" id="table-{{ $tableId }}">
            <thead class="bg-gray-100/80 text-gray-600 font-bold uppercase text-xs">
                <tr>
                    <th class="p-4 text-left w-32">{{ __('main.nationality') }}</th>

                    {{-- Adult Column --}}
                    <th class="p-2 border-b min-w-[140px] bg-blue-50/50 text-blue-800 col-adult">
                        <div class="flex flex-col">
                            <span class="header-label">{{ __('main.adult') }}</span>
                            <span class="text-[9px] font-normal opacity-70 header-sub">({{ __('main.adult_age_range') }})</span>
                        </div>
                    </th>

                    {{-- Child Young Column (2-6 years) --}}
                    <th class="p-2 border-b min-w-[140px] bg-pink-50/50 text-pink-800 col-child-young">
                        <div class="flex flex-col">
                            <span>{{ __('main.child') }}</span>
                            <span class="text-[9px] font-normal opacity-70">(2-6 {{ __('main.years') }})</span>
                        </div>
                    </th>

                    {{-- Child Older Column (7-11 years) --}}
                    <th class="p-2 border-b min-w-[140px] bg-indigo-50/50 text-indigo-800 col-child-older">
                        <div class="flex flex-col">
                            <span>{{ __('main.child') }}</span>
                            <span class="text-[9px] font-normal opacity-70">(7-11 {{ __('main.years') }})</span>
                        </div>
                    </th>

                    {{-- Infant Column --}}
                    <th class="p-2 border-b min-w-[140px] bg-orange-100/50 text-orange-800 col-infant">
                        <div class="flex flex-col">
                            <span>{{ __('main.infant') }}</span>
                            <span class="text-[9px] font-normal opacity-70">({{ __('main.infant_age_range') }})</span>
                        </div>
                    </th>

                    <th class="p-3 w-40 border-b">{{ __('main.notes') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 background">
                {{-- Base Nationalities (Foreigner, Arab, Resident) --}}
                @foreach ($baseNationalities as $nat)
                    @include('pages.dashboard.tourist-services.services.pricing-row', [
                        'prefix' => $prefix,
                        'seasonId' => $tableId,
                        'nationalityKey' => $nat['key'],
                        'nationalityLabel' => $nat['label'],
                        'nationalityColor' => $nat['color'],
                        'isCustom' => false,
                        'savedData' => $savedData ?? [],
                    ])
                @endforeach

                {{-- Custom Nationalities Container --}}
            <tbody id="custom-nationalities-{{ $tableId }}" class="custom-nationalities-container">
                @if (isset($savedData['custom_nationalities']) && is_array($savedData['custom_nationalities']))
                    @foreach ($savedData['custom_nationalities'] as $cIndex => $customRow)
                        @include('pages.dashboard.tourist-services.services.pricing-row', [
                            'prefix' => $prefix,
                            'seasonId' => $tableId,
                            'nationalityKey' => 'custom',
                            'nationalityLabel' => 'Custom',
                            'nationalityColor' => 'teal',
                            'isCustom' => true,
                            'customIndex' => $cIndex,
                            'savedData' => $customRow,
                        ])
                    @endforeach
                @endif
            </tbody>

            {{-- Add Custom Nationality Button --}}

            </tbody>
        </table>
    </div>

    {{-- Unified Action Buttons Bar --}}
    <div class="border-t bg-gradient-to-r from-gray-50 to-slate-50 p-4">
        <div class="flex flex-wrap items-center justify-center gap-3">
            {{-- Add Custom Nationality Button --}}
            <button type="button" onclick="window.addCustomNationalityRow('{{ $tableId }}', '{{ $prefix }}')"
                class="inline-flex items-center gap-2 px-4 py-2.5 text-xs font-bold text-teal-700 background cursor-pointer hover:bg-teal-50 border-custom-1 rounded-xl shadow-sm"
                toggle-button>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                {{ __('main.add_custom_nationality') }}
            </button>

            {{-- Add Subregion Pricing Button --}}
            <button type="button" onclick="window.addSubregionPricing('{{ $tableId }}', '{{ $prefix }}')"
                class="inline-flex items-center gap-2 px-4 py-2.5 text-xs font-bold text-amber-700 background cursor-pointer hover:bg-amber-50 border-custom-1 rounded-xl shadow-sm"
                toggle-button>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                {{ __('main.add_subregion_pricing') }}
            </button>
        </div>
    </div>

    {{-- Custom Nationalities Container (items added here dynamically) --}}
    <div id="custom-nationalities-wrapper-{{ $tableId }}" class="custom-nationalities-section border-t">
        <div class="bg-teal-50/30 p-4">
            <h5 class="text-xs font-bold text-teal-700 uppercase mb-3 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                {{ __('main.custom_nationalities') ?? 'Custom Nationalities' }}
            </h5>
            <div id="custom-nationalities-{{ $tableId }}" class="custom-nationalities-container space-y-2"></div>
        </div>
    </div>

    {{-- Subregion Pricing Container (items added here dynamically) --}}
    <div id="subregion-pricing-wrapper-{{ $tableId }}" class="subregion-section border-t">
        <div class="bg-amber-50/30 p-4">
            <h5 class="text-xs font-bold text-amber-700 uppercase mb-3 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                {{ __('main.subregion_pricing') ?? 'Subregion-Based Pricing' }}
            </h5>
            <div id="subregion-pricing-{{ $tableId }}" class="subregion-pricing-container space-y-4"></div>
        </div>
    </div>
</div>
