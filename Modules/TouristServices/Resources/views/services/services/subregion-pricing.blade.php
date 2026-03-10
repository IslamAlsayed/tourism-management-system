{{--
    Subregion Pricing Partial - Pricing table for specific subregions
    
    @param string $prefix - Field name prefix
    @param string $seasonId - Season identifier
    @param int $index - Subregion pricing block index
    @param Collection $subregions - Available subregions
    @param Collection $nationalities - Available nationalities for custom rows
--}}

@php
    $blockId = $seasonId . '_subregion_' . ($index ?? 0);
    $baseNationalities = [
        ['key' => 'foreigner', 'label' => __('main.foreigner'), 'color' => 'blue'],
        ['key' => 'arab', 'label' => __('main.arab'), 'color' => 'green'],
        ['key' => 'resident', 'label' => __('main.resident'), 'color' => 'pink'],
    ];
@endphp

<div class="subregion-pricing-block border border-amber-200 rounded-lg background overflow-hidden" id="subregion-block-{{ $blockId }}"
    data-index="{{ $index ?? 0 }}">

    {{-- Header with Subregion Selector --}}
    <div class="bg-amber-50 p-3 border-b border-amber-200 flex items-center justify-between gap-4">
        <div class="flex-1">
            <label class="text-xs font-bold text-amber-800 mb-1 block">
                {{ __('main.select_subregions') ?? 'Select Subregions' }}
            </label>
            <select name="{{ $prefix }}[subregion_pricing][{{ $index ?? 0 }}][subregion_ids][]" class="kt-select w-full h-[38px] subregion-select"
                multiple data-placeholder="{{ __('main.select_one_or_more') }}">
                @isset($subregions)
                    @foreach ($subregions as $subregion)
                        <option value="{{ $subregion->id }}">{{ $subregion->name }}</option>
                    @endforeach
                @endisset
            </select>
        </div>
        <button type="button" onclick="removeSubregionPricing(this)"
            class="w-8 h-8 flex items-center justify-center text-red-500 hover:text-red-700 hover:bg-red-100 rounded-full transition mt-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </button>
    </div>

    {{-- Pricing Table for Subregion --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-center border-collapse">
            <thead class="bg-gray-100/80 text-gray-600 font-bold uppercase text-xs">
                <tr>
                    <th class="p-3 text-left w-28 border-b">{{ __('main.nationality') }}</th>
                    <th class="p-2 border-b min-w-[120px] bg-blue-50/50 text-blue-800">
                        <span class="text-[10px]">{{ __('main.adult') }}</span>
                    </th>
                    <th class="p-2 border-b min-w-[120px] bg-pink-50/50 text-pink-800">
                        <span class="text-[10px]">{{ __('main.child') }} (2-6)</span>
                    </th>
                    <th class="p-2 border-b min-w-[120px] bg-indigo-50/50 text-indigo-800">
                        <span class="text-[10px]">{{ __('main.child') }} (7-11)</span>
                    </th>
                    <th class="p-2 border-b min-w-[120px] bg-orange-100/50 text-orange-800">
                        <span class="text-[10px]">{{ __('main.infant') }}</span>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 background">
                @foreach ($baseNationalities as $nat)
                    <tr class="hover:bg-gray-100/50 transition">
                        <td class="p-2 text-left border-r border-dashed border-gray-200">
                            <span class="text-xs font-bold text-gray-600">{{ $nat['label'] }}</span>
                        </td>

                        {{-- Adult --}}
                        <td class="p-1.5 border-r border-dashed border-gray-200 bg-blue-50/30">
                            <input type="number" step="0.01" min="0"
                                name="{{ $prefix }}[subregion_pricing][{{ $index ?? 0 }}][{{ $nat['key'] }}][adult]"
                                class="kt-input h-[32px] text-xs text-center w-full" placeholder="0">
                        </td>

                        {{-- Child Young --}}
                        <td class="p-1.5 border-r border-dashed border-gray-200 bg-pink-50/30">
                            <input type="number" step="0.01" min="0"
                                name="{{ $prefix }}[subregion_pricing][{{ $index ?? 0 }}][{{ $nat['key'] }}][child_young]"
                                class="kt-input h-[32px] text-xs text-center w-full" placeholder="0">
                        </td>

                        {{-- Child Older --}}
                        <td class="p-1.5 border-r border-dashed border-gray-200 bg-indigo-50/30">
                            <input type="number" step="0.01" min="0"
                                name="{{ $prefix }}[subregion_pricing][{{ $index ?? 0 }}][{{ $nat['key'] }}][child_older]"
                                class="kt-input h-[32px] text-xs text-center w-full" placeholder="0">
                        </td>

                        {{-- Infant --}}
                        <td class="p-1.5 bg-orange-100/30">
                            <input type="number" step="0.01" min="0"
                                name="{{ $prefix }}[subregion_pricing][{{ $index ?? 0 }}][{{ $nat['key'] }}][infant]"
                                class="kt-input h-[32px] text-xs text-center w-full" placeholder="0">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
