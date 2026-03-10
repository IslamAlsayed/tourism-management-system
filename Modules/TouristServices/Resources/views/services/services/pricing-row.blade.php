{{--
    Pricing Row Partial - Single row for nationality pricing
    
    @param string $prefix - Field name prefix
    @param string $seasonId - Season identifier
    @param string $nationalityKey - Nationality key (foreigner, arab, resident, or nationality_id)
    @param string $nationalityLabel - Display label
    @param string $nationalityColor - Badge color (blue, green, pink, teal)
    @param bool $isCustom - Whether this is a custom nationality row
    @param int|null $customIndex - Index for custom nationality rows
--}}

@php
    $badgeColors = [
        'blue' => 'bg-blue-100 text-blue-700 border-blue-100',
        'green' => 'bg-green-100 text-green-700 border-green-100',
        'pink' => 'bg-pink-100 text-pink-700 border-pink-100',
        'teal' => 'bg-teal-50 text-teal-700 border-teal-100',
    ];
    $badgeClass = $badgeColors[$nationalityColor] ?? $badgeColors['blue'];
    $rowId = $seasonId . '_' . ($isCustom ? 'custom_' . ($customIndex ?? 0) : $nationalityKey);
@endphp

<tr class="hover:bg-gray-100/50 transition group border-custom {{ $isCustom ? 'custom-nationality-row bg-teal-50/20' : '' }}" id="row-{{ $rowId }}"
    data-nationality="{{ $nationalityKey }}">

    {{-- Nationality Cell --}}
    <td class="p-3 text-left border-r border-dashed border-gray-200">
        @if ($isCustom)
            <div class="flex items-center gap-2">
                <button type="button" onclick="removeCustomNationalityRow(this)"
                    class="w-7 h-7 flex items-center justify-center text-red-500 hover:text-red-700 hover:bg-red-100 rounded transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <select name="{{ $prefix }}[custom_nationalities][{{ $customIndex ?? 0 }}][nationality_id]"
                    class="kt-input h-[36px] text-xs font-bold min-w-[120px]" required>
                    <option value="">{{ __('main.select_nationality') }}</option>
                    @isset($nationalities)
                        @foreach ($nationalities as $nat)
                            <option value="{{ $nat->id }}">{{ $nat->name }}</option>
                        @endforeach
                    @endisset
                </select>
            </div>
        @else
            <span class="inline-flex items-center px-2.5 py-1.5 rounded text-xs font-bold border {{ $badgeClass }}">
                {{ $nationalityLabel }}
            </span>
        @endif
    </td>

    {{-- Adult Cell --}}
    <td class="p-2 border-r border-dashed border-gray-200 bg-blue-100 group-hover:bg-blue-100/50 transition col-adult">
        @include('touristservices::services.services.price-cell', [
            'prefix' => $isCustom ? $prefix . '[custom_nationalities][' . ($customIndex ?? 0) . ']' : $prefix,
            'type' => 'adult',
            'nationalityKey' => $isCustom ? 'custom' : $nationalityKey,
            'uniqueId' => 'comm_' . $rowId . '_adult',
            'seasonId' => $seasonId,
            'inputValue' => $savedData['adult'][$nationalityKey]['cost'] ?? '',
            'inputCommission' => $savedData['adult'][$nationalityKey]['commission'] ?? 0,
        ])
    </td>

    {{-- Child Young Cell (2-6 years) --}}
    <td class="p-2 border-r border-dashed border-gray-200 bg-pink-100 group-hover:bg-pink-100/50 transition col-child-young">
        @include('touristservices::services.services.price-cell', [
            'prefix' => $isCustom ? $prefix . '[custom_nationalities][' . ($customIndex ?? 0) . ']' : $prefix,
            'type' => 'child_young',
            'nationalityKey' => $isCustom ? 'custom' : $nationalityKey,
            'uniqueId' => 'comm_' . $rowId . '_child_young',
            'seasonId' => $seasonId,
            'inputValue' => $savedData['child_young'][$nationalityKey]['cost'] ?? '',
            'inputCommission' => $savedData['child_young'][$nationalityKey]['commission'] ?? 0,
        ])
    </td>

    {{-- Child Older Cell (7-11 years) --}}
    <td class="p-2 border-r border-dashed border-gray-200 bg-violet-100 group-hover:bg-indigo-100/50 transition col-child-older">
        @include('touristservices::services.services.price-cell', [
            'prefix' => $isCustom ? $prefix . '[custom_nationalities][' . ($customIndex ?? 0) . ']' : $prefix,
            'type' => 'child_older',
            'nationalityKey' => $isCustom ? 'custom' : $nationalityKey,
            'uniqueId' => 'comm_' . $rowId . '_child_older',
            'seasonId' => $seasonId,
            'inputValue' => $savedData['child_older'][$nationalityKey]['cost'] ?? '',
            'inputCommission' => $savedData['child_older'][$nationalityKey]['commission'] ?? 0,
        ])
    </td>

    {{-- Infant Cell --}}
    <td class="p-2 border-r border-dashed border-gray-200 bg-orange-100 group-hover:bg-orange-100/50 transition col-infant">
        @include('touristservices::services.services.price-cell', [
            'prefix' => $isCustom ? $prefix . '[custom_nationalities][' . ($customIndex ?? 0) . ']' : $prefix,
            'type' => 'infant',
            'nationalityKey' => $isCustom ? 'custom' : $nationalityKey,
            'uniqueId' => 'comm_' . $rowId . '_infant',
            'seasonId' => $seasonId,
            'inputValue' => $savedData['infant'][$nationalityKey]['cost'] ?? '',
            'inputCommission' => $savedData['infant'][$nationalityKey]['commission'] ?? 0,
        ])
    </td>

    {{-- Notes Cell --}}
    <td class="p-2">
        <textarea name="{{ $isCustom ? $prefix . '[custom_nationalities][' . ($customIndex ?? 0) . '][notes]' : $prefix . '[notes][' . $nationalityKey . ']' }}"
            class="kt-textarea h-[36px] text-xs bg-gray-100/50 focus:background w-full" placeholder="..." value="{{ $savedData['notes'][$nationalityKey] ?? '' }}"></textarea>
    </td>
</tr>
