{{--
    Commission Settings Partial - Configuration panel for enabled commissions
    
    @param string $seasonId - Season identifier
    @param string $prefix - Field name prefix
    @param string $type - Price type (adult, child_young, etc.)
    @param string $nationalityKey - Nationality key
    @param string $label - Display label for the commission item
--}}

@php
    $itemId = $seasonId . '_' . $type . '_' . $nationalityKey;
@endphp

<div class="commission-setting-item background border border-green-200 rounded-lg p-3 flex items-center gap-4" id="commission-item-{{ $itemId }}"
    data-type="{{ $type }}" data-nationality="{{ $nationalityKey }}">

    {{-- Label --}}
    <div class="flex-1">
        <span class="text-xs font-bold text-gray-700">
            {{ $label ?? ucfirst(str_replace('_', ' ', $type)) . ' - ' . ucfirst($nationalityKey) }}
        </span>
    </div>

    {{-- Commission Type --}}
    <div class="w-32">
        <select name="{{ $prefix }}[{{ $type }}][{{ $nationalityKey }}][commission_type]" class="kt-input h-[32px] text-xs w-full">
            <option value="percentage">{{ __('main.percentage') }}</option>
            <option value="fixed">{{ __('main.fixed_amount') }}</option>
        </select>
    </div>

    {{-- Commission Value --}}
    <div class="w-24">
        <div class="flex items-center border border-gray-300 rounded overflow-hidden h-[32px] background">
            <input type="number" step="0.01" min="0" name="{{ $prefix }}[{{ $type }}][{{ $nationalityKey }}][commission_value]"
                class="flex-1 w-full h-full border-0 px-2 text-center text-xs font-bold text-gray-700 outline-none bg-transparent" placeholder="0">
            <span class="h-full bg-gray-100 border-l border-gray-300 px-2 flex items-center justify-center text-xs text-gray-500 select-none">
                %
            </span>
        </div>
    </div>

    {{-- Remove Button --}}
    <button type="button" onclick="removeCommissionSetting(this)"
        class="w-6 h-6 flex items-center justify-center text-red-400 hover:text-red-600 rounded transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
