{{--
    Pricing Logic Script - Clean Blade-based JavaScript for pricing functionality
    Handles: Custom nationalities, Subregion pricing, Commission toggles
    
    This file should be included at the bottom of create.blade.php and edit.blade.php
--}}

<script>
    // ============================================
    // PRICING ENGINE - JAVASCRIPT FUNCTIONS
    // ============================================

    // Translation strings from Blade
    const PRICING_TRANS = {
        selectNationality: '{{ __('main.select_nationality') }}',
        selectSubregions: '{{ __('main.select_one_or_more') }}',
        adult: '{{ __('main.adult') }}',
        childYoung: '{{ __('main.child') }} (2-6)',
        childOlder: '{{ __('main.child') }} (7-11)',
        infant: '{{ __('main.infant') }}',
        foreigner: '{{ __('main.foreigner') }}',
        arab: '{{ __('main.arab') }}',
        resident: '{{ __('main.resident') }}',
        percentage: '{{ __('main.percentage') }}',
        fixedAmount: '{{ __('main.fixed_amount') }}',
        commissionFor: '{{ __('main.commission_for') ?? 'Commission for' }}',
    };

    // Nationality options from PHP (populated by Blade)
    const NATIONALITY_OPTIONS =
        `<?php if(isset($nationalities)): foreach($nationalities as $nat): ?><option value="<?php echo $nat->id; ?>"><?php echo $nat->name; ?></option><?php endforeach; endif; ?>`;

    // Subregion options from PHP
    const SUBREGION_OPTIONS =
        `<?php if(isset($subregions)): foreach($subregions as $sub): ?><option value="<?php echo $sub->id; ?>"><?php echo $sub->name; ?></option><?php endforeach; endif; ?>`;

    // Counters for dynamic rows
    let customNationalityCounters = {};
    let subregionPricingCounters = {};

    /* 
    // MOVED TO pricing-logic.blade.php
    // ============================================
    // CUSTOM NATIONALITY FUNCTIONS
    // ============================================
    
    function addCustomNationalityRow(seasonId, prefix) {
       // ... disabled
    }
    
    function generateCustomNationalityRowHtml(prefix, seasonId, index, rowId) {
        // ... disabled
    }
    
    function generatePriceCellHtml(prefix, type, nationalityKey, uniqueId, seasonId) {
        // ... disabled
    }
    
    function removeCustomNationalityRow(btn) {
        // ... disabled
    }
    */

    /*
    // MOVED TO pricing-logic.blade.php
    // ============================================
    // SUBREGION PRICING FUNCTIONS
    // ============================================
    
    function addSubregionPricing(seasonId, prefix) {
       // ... disabled
    }

    function generateSubregionPricingHtml(prefix, seasonId, index) {
        // ... disabled
    }

    function removeSubregionPricing(btn) {
        // ... disabled
    }
    */

    /*
    // MOVED TO pricing-logic.blade.php
    // ============================================
    // COMMISSION TOGGLE FUNCTIONS
    // ============================================
    
    function handleCommissionToggle(checkbox) {
       // ... disabled
    }

    function generateCommissionItemHtml(seasonId, type, nationality, label, prefix) {
        // ... disabled
    }

    function removeCommissionSetting(btn) {
        // ... disabled
    }
    */

    // ============================================
    // CURRENCY UPDATE FUNCTION
    // ============================================

    function updateCurrencySymbols(symbol) {
        document.querySelectorAll('.currency-symbol').forEach(el => {
            el.textContent = symbol;
        });
    }

    // ============================================
    // INITIALIZATION
    // ============================================

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize currency selector listener
        const currencySelect = document.querySelector('select[name="currency_id"]');
        if (currencySelect) {
            currencySelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const symbol = selectedOption.dataset.symbol || selectedOption.text.split(' ')[0] ||
                '$';
                updateCurrencySymbols(symbol);
            });
        }

        // Initialize any existing commission toggles
        document.querySelectorAll('.commission-toggle:checked').forEach(toggle => {
            handleCommissionToggle(toggle);
        });
    });
</script>
