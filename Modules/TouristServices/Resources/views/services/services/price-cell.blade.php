{{--
    Price Cell Partial - Single price input with commission toggle
    
    @param string $prefix - Field name prefix
    @param string $type - Price type (adult, child_young, child_older, infant)
    @param string $nationalityKey - Nationality key
    @param string $uniqueId - Unique identifier for the commission toggle
    @param string $seasonId - Season identifier for commission panel
--}}

<div class="flex flex-col gap-2">
    {{-- Price Input --}}
    <div
        class="flex items-center border border-gray-300 rounded overflow-hidden h-[36px] background transition-colors focus-within:border-blue-400 focus-within:ring-1 focus-within:ring-blue-400 w-full relative">
        <input type="number" step="0.01" min="0" name="{{ $prefix }}[{{ $type }}][{{ $nationalityKey }}][cost]"
            class="flex-1 w-full h-full border-0 px-2 text-sm font-bold text-gray-700 outline-none placeholder-gray-300 bg-transparent price-input"
            placeholder="0" data-type="{{ $type }}" data-nationality="{{ $nationalityKey }}"
            value="{{ old($prefix . '[' . $type . '][' . $nationalityKey . '][cost]', $inputValue ?? '') }}">
        <div
            class="h-full bg-gray-100 border-l border-gray-300 px-2 flex items-center justify-center text-xs font-bold text-gray-500 select-none min-w-[35px] currency-symbol">
            $
        </div>
    </div>

    {{-- Commission Toggle & Input --}}
    <div class="flex items-center justify-center gap-2 pt-1">
        <div class="toggle-hold mt-0">
            <input type="checkbox" id="{{ $uniqueId }}" name="{{ $prefix }}[{{ $type }}][{{ $nationalityKey }}][has_commission]"
                value="1" class="toggle-input commission-toggle" data-season="{{ $seasonId }}" data-type="{{ $type }}"
                data-nationality="{{ $nationalityKey }}" data-label="{{ ucfirst(str_replace('_', ' ', $type)) }} - {{ ucfirst($nationalityKey) }}"
                onchange="toggleCommissionInput(this)"
                {{ old($prefix . '[' . $type . '][' . $nationalityKey . '][has_commission]', $inputCommission ?? false) ? 'checked' : '' }}>
            <label for="{{ $uniqueId }}"><span></span></label>
        </div>
        <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wide select-none">
            {{ __('main.comm') }}
        </span>
    </div>

    {{-- Commission Input (Hidden by default) --}}
    <div class="commission-input-wrapper {{ old($prefix . '[' . $type . '][' . $nationalityKey . '][has_commission]', $inputCommission ?? false) ? '' : 'hidden' }}"
        data-prefix="{{ $prefix }}" data-type="{{ $type }}" data-nationality="{{ $nationalityKey }}">
        <div
            class="flex items-center border border-gray-300 rounded overflow-hidden h-[36px] background transition-colors focus-within:border-green-400 focus-within:ring-1 focus-within:ring-green-400 w-full relative">
            <input type="number" step="0.01" min="0" name="{{ $prefix }}[{{ $type }}][{{ $nationalityKey }}][commission_value]"
                class="flex-1 w-full h-full border-0 px-2 text-sm font-bold text-gray-700 outline-none placeholder-gray-300 bg-transparent commission-input"
                placeholder="0" value="{{ old($prefix . '[' . $type . '][' . $nationalityKey . '][commission_value]', '') }}">
            <div
                class="h-full bg-green-100 border-l border-gray-300 px-2 flex items-center justify-center text-xs font-bold text-green-600 select-none min-w-[35px]">
                %
            </div>
        </div>
    </div>

    {{-- JavaScript to toggle commission input --}}
    <script>
        function toggleCommissionInput(checkbox) {
            const wrapper = checkbox.closest('.flex.flex-col').querySelector('.commission-input-wrapper');
            if (checkbox.checked) {
                wrapper.classList.remove('hidden');
                wrapper.querySelector('.commission-input').focus();
            } else {
                wrapper.classList.add('hidden');
                wrapper.querySelector('.commission-input').value = '';
            }
        }
    </script>
</div>
