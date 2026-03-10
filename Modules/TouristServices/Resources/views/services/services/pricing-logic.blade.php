<script>
    // Prevent duplicate execution if included multiple times
    if (typeof window.pricingLogicInitialized === 'undefined') {
        window.pricingLogicInitialized = true;

        // === TRANSLATION STRINGS ===
        window.TRANS = {
            nationality: '{{ __('main.nationality') }}',
            adult: '{{ __('main.adult') }}',
            child: '{{ __('main.child') }}',
            infant: '{{ __('main.infant') }}',
            adult_age: '{{ __('main.adult_age_range') }}',
            child_young_age: '2-6 {{ __('main.years') }}',
            child_older_age: '7-11 {{ __('main.years') }}',
            infant_age: '{{ __('main.infant_age_range') }}',
            notes: '{{ __('main.notes') }}',
            foreigner: '{{ __('main.foreigner') }}',
            arab: '{{ __('main.arab') }}',
            resident: '{{ __('main.resident') }}',
            local_citizen: '{{ __('main.local_citizen') }}',
            rates: '{{ __('main.rates') }}',
            season: '{{ __('main.season') }}',
            default_label: '{{ __('main.default') }}',
            comm: '{{ __('main.comm') }}',
            add_season_prompt: '{{ __('main.add_season_names_to_generate') }}',
            add_custom_nationality: '{{ __('main.add_custom_nationality') ?? 'Add Custom Nationality' }}',
            select_nationality: '{{ __('main.select_nationality') ?? 'Select Nationality' }}',
            enter_prices_for_the_selected_subregions: '{{ __('main.enter_prices_for_the_selected_subregions') }}'
        };

        // === NATIONALITY OPTIONS (Generated from PHP) ===
        window.NATIONALITY_OPTIONS = `
            @if (isset($nationalities))
                @foreach ($nationalities as $nat)
                    <option value="{{ $nat->id }}">{{ $nat->name }}</option>
                @endforeach
            @endif
        `;

        // === SUBREGION OPTIONS (Generated from PHP) ===
        window.SUBREGION_OPTIONS = `
            @if (isset($subregions))
                @foreach ($subregions as $sub)
                    <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                @endforeach
            @endif
        `;

        // === GLOBAL FUNCTIONS (Accessible by HTML onchange/onclick) ===

        // 1. Handle Pricing Type Switch (Flat vs Seasonal)
        window.handlePricingTypeChange = function(type) {
            const flatDatesContainer = document.getElementById('flat_pricing_container');
            const seasonalContainer = document.getElementById('seasonal_pricing_container');
            const pricingEngineSection = document.getElementById('pricing_engine_section');

            // If "Flat" is chosen, show flat dates container (if it exists)
            // But also, we need to show the Pricing Tables (Standard Season)

            if (type === 'flat') {
                if (flatDatesContainer) flatDatesContainer.classList.remove('hidden');
                if (seasonalContainer) seasonalContainer.classList.add('hidden');
                // Always show the pricing engine section, but in "Flat" mode we might want to auto-generate a 'Standard' table
                if (pricingEngineSection) pricingEngineSection.classList.remove('hidden');

                window.renderPricingTables(['Standard']);
            } else {
                if (flatDatesContainer) flatDatesContainer.classList.add('hidden');
                if (seasonalContainer) seasonalContainer.classList.remove('hidden');
                if (pricingEngineSection) pricingEngineSection.classList.add(
                    'hidden'); // Initially hidden until seasons generated

                // Clear existing tables if switching to seasonal to avoid confusion? 
                // modify as needed. For now we keep it simple.
            }
        };


        // 2. Update Tables based on Season Names
        window.updateSeasonalPricingTables = function() {
            const generatedTablesContainer = document.getElementById('generated_pricing_tables');
            if (!generatedTablesContainer) return;

            const seasonNames = [];
            // Get unique names from inputs
            const seasonNameInputs = [
                ...document.querySelectorAll('input[name^="service_seasons"][name$="[name]"]'),
                ...document.querySelectorAll('input[name^="seasons"][name$="[name]"]'),
                ...document.querySelectorAll('input[name^="season_groups"][name$="[name]"]')
            ];

            seasonNameInputs.forEach(input => {
                const val = input.value.trim();
                if (val && !seasonNames.includes(val)) {
                    seasonNames.push(val);
                }
            });

            if (seasonNames.length === 0) {
                // Fix: Do NOT overwrite generatedTablesContainer as it deletes seasonal_tables_container
                const seasonalContainer = document.getElementById('seasonal_tables_container');
                if (seasonalContainer) {
                    seasonalContainer.innerHTML =
                        `<div class="text-center p-8 bg-gray-100 border border-dashed rounded text-gray-400 italic">${TRANS.add_season_prompt}</div>`;
                    seasonalContainer.classList.remove('hidden');
                }
                return;
            }

            window.renderPricingTables(seasonNames);
        }

        // 3. Render the Actual Tables (Only for Seasonal mode - Flat rate uses Blade partials)
        window.renderPricingTables = function(names) {
            // Ensure we are looking for the correct container IDs
            const flatRateContainer = document.getElementById(
                'flat_rate_table_container'); // Wraps the Blade partial
            const seasonalContainer = document.getElementById(
                'seasonal_tables_container'); // Where dynamic tables go

            // If Standard mode (Flat Rate)
            if (names.length === 1 && names[0] === 'Standard') {
                if (flatRateContainer) {
                    flatRateContainer.classList.remove('hidden');
                    flatRateContainer.style.display = 'block'; // Explicitly set display
                }
                if (seasonalContainer) {
                    seasonalContainer.classList.add('hidden');
                    seasonalContainer.style.display = 'none';
                    seasonalContainer.innerHTML = ''; // Clear to prevent ID conflicts
                }

                // Update currency in the now-visible flat table
                const symbol = typeof window.getCurrentCurrencySymbol === 'function' ? window
                    .getCurrentCurrencySymbol() :
                    '$';
                window.updateCurrencySymbolsInTables(symbol);
                return;
            }

            // Seasonal Mode
            if (flatRateContainer) {
                flatRateContainer.classList.add('hidden');
                flatRateContainer.style.display = 'none';
            }

            if (seasonalContainer) {
                seasonalContainer.classList.remove('hidden');
                seasonalContainer.style.display = 'block';
                seasonalContainer.innerHTML = ''; // Clear old seasonal tables

                let allHtml = '';
                names.forEach((name, index) => {
                    allHtml += window.generateTableHTML(name, index);
                });
                seasonalContainer.insertAdjacentHTML('beforeend', allHtml);
            }

            // Re-apply currency symbols
            const symbol = typeof window.getCurrentCurrencySymbol === 'function' ? window
                .getCurrentCurrencySymbol() :
                '$';
            window.updateCurrencySymbolsInTables(symbol);
        }

        // 4. Generate HTML for a Single Table
        // This function creates the card and table structure for a given season.
        window.generateTableHTML = function(seasonName, index) {
            const isStandard = seasonName === 'Standard';
            const fieldPrefix = `seasonal_prices[${seasonName}]`; // Easy mapping for Backend

            // Check pricing unit
            const pricingUnitInput = document.getElementById('pricing_unit');
            const unitVal = pricingUnitInput ? pricingUnitInput.value : '';
            // Group units list
            const groupUnits = [
                'per_group', 'group', // some aliases just in case
                'per_bus', 'bus',
                'per_trip', 'trip',
                'per_unit', 'unit',
                'per_group_per_day', 'group_day',
                'per_group_per_night', 'group_night',
                'per_extra_hour_per_group', 'extra_hour_group',
                'per_extra_hour_per_vehicle', 'extra_hour_vehicle'
            ];
            const isGroupUnit = groupUnits.includes(unitVal);

            let tableHeader = '';
            if (isGroupUnit) {
                // Simplified Header
                tableHeader = `
                <tr>
                    <th class="p-4 text-left w-32">${TRANS.nationality}</th>
                    <th class="p-2 border-b min-w-[200px] bg-blue-50/50 text-blue-800">
                        <div class="flex flex-col">
                            <span>${TRANS.rates}</span>
                        </div>
                    </th>
                    <th class="p-3 w-40 border-b">${TRANS.notes}</th>
                </tr>
            `;
            } else {
                // Standard Pax Header
                tableHeader = `
                <tr>
                    <th class="p-4 text-left w-32">${TRANS.nationality}</th>
                    
                    <!-- Adult Column -->
                    <th class="p-2 border-b min-w-[140px] bg-blue-50/50 text-blue-800">
                        <div class="flex flex-col">
                            <span>${TRANS.adult}</span>
                            <span class="text-[9px] font-normal opacity-70">(${TRANS.adult_age})</span>
                        </div>
                    </th>
                    
                    <!-- Child Young Column (2-6 years) -->
                    <th class="p-2 border-b min-w-[140px] bg-pink-50/50 text-pink-800">
                        <div class="flex flex-col">
                            <span>${TRANS.child}</span>
                            <span class="text-[9px] font-normal opacity-70">(${TRANS.child_young_age})</span>
                        </div>
                    </th>
                    
                    <!-- Child Older Column (7-11 years) -->
                    <th class="p-2 border-b min-w-[140px] bg-indigo-50/50 text-indigo-800">
                        <div class="flex flex-col">
                            <span>${TRANS.child}</span>
                            <span class="text-[9px] font-normal opacity-70">(${TRANS.child_older_age})</span>
                        </div>
                    </th>
                    
                    <!-- Infant Column -->
                    <th class="p-2 border-b min-w-[140px] bg-orange-100/50 text-orange-800">
                        <div class="flex flex-col">
                            <span>${TRANS.infant}</span>
                            <span class="text-[9px] font-normal opacity-70">(${TRANS.infant_age})</span>
                        </div>
                    </th>

                     <th class="p-3 w-40 border-b">${TRANS.notes}</th>
                </tr>
            `;
            }

            // Horizontal Table Structure
            // Generate Safe ID
            const safeSeasonID = seasonName.replace(/[^a-z0-9]/gi, '_').toLowerCase();

            return `
            <div class="mb-8 border rounded-lg overflow-hidden background shadow-sm transition-all duration-300 hover:shadow-md pricing-table-card" id="pricing-table-${safeSeasonID}" data-season="${seasonName}">
                <div class="bg-gray-100 px-4 py-3 border-b flex justify-between items-center">
                    <h4 class="font-bold text-gray-600 flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full ${isStandard ? 'bg-blue-100' : 'bg-green-100'}"></span>
                        ${seasonName} ${TRANS.rates}
                    </h4>
                    ${!isStandard ? `<span class="text-xs background border px-2 py-1 rounded text-gray-600 font-mono">${TRANS.season}: ${seasonName}</span>` : `<span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded">${TRANS.default_label}</span>`}
                </div>
                
                <div class="overflow-x-auto p-0">
                    <table class="w-full text-sm text-center border-collapse" id="table-${safeSeasonID}">
                        <thead class="bg-gray-100/80 text-gray-600 font-bold uppercase text-xs">
                            ${tableHeader}
                        </thead>
                        <tbody class="divide-y divide-gray-100 background">
                            ${window.generateHorizontalRows(fieldPrefix, safeSeasonID, isGroupUnit)}
                            
                            <!-- Container for Custom Nationalities -->
                            <tbody id="custom-nationalities-${safeSeasonID}" class="custom-nationalities-container"></tbody>
                        </tbody>
                    </table>
                </div>

                <!-- Unified Action Buttons Bar -->
                <div class="border-t bg-gradient-to-r from-gray-50 to-slate-50 p-4">
                    <div class="flex flex-wrap items-center justify-center gap-3">
                        <!-- Add Custom Nationality Button -->
                        <button type="button" onclick="window.addCustomNationalityRow('${safeSeasonID}', '${fieldPrefix}')"
                            class="inline-flex items-center gap-2 px-4 py-2.5 text-xs font-bold text-teal-700 background hover:bg-teal-50 border-2 border-teal-300 hover:border-teal-400 rounded-xl shadow-sm transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            ${TRANS.add_custom_nationality}
                        </button>

                        <!-- Add Subregion Pricing Button -->
                        <button type="button" onclick="window.addSubregionPricing('${safeSeasonID}', '${fieldPrefix}')"
                            class="inline-flex items-center gap-2 px-4 py-2.5 text-xs font-bold text-amber-700 background hover:bg-amber-50 border-2 border-amber-300 hover:border-amber-400 rounded-xl shadow-sm transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ __('main.add_subregion_pricing') ?? 'Add Subregion Pricing' }}
                        </button>
                    </div>
                </div>

                <!-- Custom Nationalities Wrapper -->
                <div id="custom-nationalities-wrapper-${safeSeasonID}" class="custom-nationalities-section hidden border-t">
                    <div class="bg-teal-50/30 p-4">
                        <h5 class="text-xs font-bold text-teal-700 uppercase mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            ${TRANS.add_custom_nationality}
                        </h5>
                        <!-- No internal div needed mostly if we append to tbody, but keeping consistent structure optional -->
                    </div>
                </div>
                
                <!-- Subregion Pricing Container -->
                <div id="subregion-pricing-wrapper-${safeSeasonID}" class="subregion-section hidden border-t">
                    <div class="bg-amber-50/30 p-4">
                        <h5 class="text-xs font-bold text-amber-700 uppercase mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ __('main.subregion_pricing') ?? 'Subregion-Based Pricing' }}
                        </h5>
                        <div id="subregion-pricing-${safeSeasonID}" class="subregion-pricing-container space-y-4"></div>
                    </div>
                </div>
                
            </div>`;
        }

        window.generateHorizontalRows = function(prefix, seasonID, isGroupUnit = false) {
            const nationalities = [{
                    key: 'foreigner',
                    label: TRANS.foreigner,
                    color: 'blue'
                },
                {
                    key: 'arab',
                    label: TRANS.arab,
                    color: 'green'
                },
                {
                    key: 'resident',
                    label: TRANS.resident,
                    color: 'pink'
                },
                {
                    key: 'local',
                    label: TRANS.local_citizen,
                    color: 'orange'
                }
            ];

            const safeSeasonID = seasonID.replace(/[^a-z0-9]/gi, '_').toLowerCase();
            let html = '';

            nationalities.forEach(nat => {
                const badgeClass = `bg-${nat.color}-50 text-${nat.color}-700 border-${nat.color}-100`;

                html += `
            <tr class="hover:bg-gray-100/50 transition group border-custom">
                <!-- Nationality Header -->
                <td class="p-3 text-left border-r border-dashed border-gray-200">
                    <span class="inline-flex items-center px-2.5 py-1.5 rounded text-xs font-bold border ${badgeClass}">
                        ${nat.label}
                    </span>
                </td>
            `;

                if (isGroupUnit) {
                    // Single Cell for Group Unit (Mapped to 'cost_adult' or just 'cost' internally but we keep 'adult' key for DB mapping simplicity or use a specific 'unit' key)
                    // Existing DB structure expects 'price_foreigner_adult' etc.
                    // We will map this single input to 'adult' for now, as that's the primary price column.
                    html += `
                    <td class="p-2 border-r border-dashed border-gray-200 bg-blue-100">
                        ${window.generatePriceCell(prefix, 'adult', nat.key, safeSeasonID)}
                    </td>
                `;
                } else {
                    // Pax Cells
                    html += `
                    <!-- Adult Cell -->
                    <td class="p-2 border-r border-dashed border-gray-200 bg-blue-100">
                        ${window.generatePriceCell(prefix, 'adult', nat.key, safeSeasonID)}
                    </td>

                    <!-- Child Young Cell (2-6 years) -->
                    <td class="p-2 border-r border-dashed border-gray-200 bg-pink-100">
                        ${window.generatePriceCell(prefix, 'child_young', nat.key, safeSeasonID)}
                    </td>

                    <!-- Child Older Cell (7-11 years) -->
                    <td class="p-2 border-r border-dashed border-gray-200 bg-indigo-100">
                        ${window.generatePriceCell(prefix, 'child_older', nat.key, safeSeasonID)}
                    </td>

                    <!-- Infant Cell -->
                    <td class="p-2 border-r border-dashed border-gray-200 bg-orange-100">
                        ${window.generatePriceCell(prefix, 'infant', nat.key, safeSeasonID)}
                    </td>
                `;
                }

                html += `
                <!-- Notes -->
                <td class="p-2">
                     <input type="text" 
                        name="${prefix}[notes][${nat.key}]" 
                        class="kt-input h-[36px] text-xs bg-gray-100/50 focus:background w-full" 
                        placeholder="...">
                </td>
            </tr>
            `;
            });

            // Add custom nationality row container and button (Standalone button removed here)
            html += `
        <tr class="custom-nationality-rows-container" data-prefix="${prefix}" data-season="${safeSeasonID}"></tr>
        `;

            return html;
        }

        // Custom nationality row counter per season
        let customNatCounters = {};

        window.addCustomNationalityRow = function(seasonId, prefix) {
            // Initialize counter for this season if not exists
            if (!customNatCounters[seasonId]) {
                customNatCounters[seasonId] = 0;
            }

            const index = customNatCounters[seasonId]++;
            const container = document.getElementById(`custom-nationalities-${seasonId}`);
            const wrapper = document.getElementById(`custom-nationalities-wrapper-${seasonId}`);

            if (!container) {
                console.error('Custom nationalities container not found:', seasonId);
                return;
            }

            // Show wrapper
            if (wrapper) wrapper.classList.remove('hidden');

            const newRow = document.createElement('tr');
            newRow.className = 'hover:bg-gray-100/50 transition group border-custom custom-nationality-row bg-teal-50/30';
            newRow.innerHTML = window.generateCustomNationalityRowHTML(prefix, seasonId, index);

            container.appendChild(newRow);
        }

        window.generateCustomNationalityRowHTML = function(prefix, safeSeasonID, index) {
            const natKey = `custom_${index}`;
            return `
            <!-- Nationality Select -->
            <td class="p-3 text-left border-r border-dashed border-gray-200">
                <div class="flex items-center gap-2">
                    <button type="button" onclick="window.removeCustomNationalityRow(this)" 
                        class="w-8 h-8 flex items-center justify-center text-red-600 cursor-pointer hover:text-red-700 hover:bg-red-100 rounded" toggle-button>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                    <select name="${prefix}[custom_nationalities][${index}][nationality_id]" 
                        class="kt-input h-[36px] text-xs font-bold min-w-[120px]"
                        onchange="window.updateCommissionLabelsForCustomRow(this)">
                        <option value="">${TRANS.select_nationality}</option>
                        ${NATIONALITY_OPTIONS}
                    </select>
                </div>
            </td>

            <!-- Adult Cell -->
            <td class="p-2 border-r border-dashed border-gray-200 bg-blue-100 group-hover:bg-blue-100/50 transition">
                ${window.generatePriceCell(prefix + '[custom_nationalities][' + index + ']', 'adult', natKey, safeSeasonID)}
            </td>

            <!-- Child Young Cell -->
            <td class="p-2 border-r border-dashed border-gray-200 bg-pink-100 group-hover:bg-pink-100/50 transition">
                ${window.generatePriceCell(prefix + '[custom_nationalities][' + index + ']', 'child_young', natKey, safeSeasonID)}
            </td>

            <!-- Child Older Cell -->
            <td class="p-2 border-r border-dashed border-gray-200 bg-violet-100 group-hover:bg-indigo-100/50 transition">
                ${window.generatePriceCell(prefix + '[custom_nationalities][' + index + ']', 'child_older', natKey, safeSeasonID)}
            </td>

            <!-- Infant Cell -->
            <td class="p-2 border-r border-dashed border-gray-200 bg-orange-100 group-hover:bg-orange-100/50 transition">
                ${window.generatePriceCell(prefix + '[custom_nationalities][' + index + ']', 'infant', natKey, safeSeasonID)}
            </td>

            <!-- Notes -->
            <td class="p-2">
                <input type="text" 
                    name="${prefix}[custom_nationalities][${index}][notes]" 
                    class="kt-input h-[36px] text-xs bg-gray-100/50 focus:background w-full" 
                    placeholder="...">
            </td>
        `;
        }

        window.removeCustomNationalityRow = function(btn) {
            const row = btn.closest('tr');
            const container = row.parentNode;

            // Find wrapper
            // The container ID format is custom-nationalities-{seasonId}
            const seasonId = container.id.replace('custom-nationalities-', '');
            const wrapper = document.getElementById(`custom-nationalities-wrapper-${seasonId}`);

            row.remove();

            // Check if empty
            if (container.children.length === 0 && wrapper) {
                wrapper.classList.add('hidden');
            }
        }

        // ============================================
        // SUBREGION PRICING FUNCTIONS
        // ============================================

        let subregionPricingCounters = {};

        window.addSubregionPricing = function(seasonId, prefix) {
            // Initialize counter for this season if not exists
            if (!subregionPricingCounters[seasonId]) {
                subregionPricingCounters[seasonId] = 0;
            }

            const index = subregionPricingCounters[seasonId]++;
            const container = document.getElementById(`subregion-pricing-${seasonId}`);
            const wrapper = document.getElementById(`subregion-pricing-wrapper-${seasonId}`);

            if (!container) {
                console.error('Subregion pricing container not found:', seasonId);
                return;
            }

            // Show wrapper
            if (wrapper) wrapper.classList.remove('hidden');

            // Get current currency symbol
            const symbol = typeof window.getCurrentCurrencySymbol === 'function' ? window
                .getCurrentCurrencySymbol() :
                '$';

            const blockHtml = window.generateSubregionPricingHTML(prefix, seasonId, index, symbol);
            container.insertAdjacentHTML('beforeend', blockHtml);

            // Initialize Select2 for the newly added block
            const blockId = `${seasonId}_subregion_${index}`;
            const newBlock = document.getElementById(`subregion-block-${blockId}`);
            if (newBlock) {
                const select = newBlock.querySelector('.subregion-select');
                if (select && typeof $(select).select2 === 'function') {
                    $(select).select2({
                        placeholder: "Select subregions...",
                        allowClear: true,
                        width: '100%'
                    });
                }
            }
        }

        window.generateSubregionPricingHTML = function(prefix, seasonId, index, symbol = '$') {
            const blockId = `${seasonId}_subregion_${index}`;

            return `
            <div class="subregion-pricing-block border border-amber-200 rounded-lg background overflow-hidden mt-4" 
                id="subregion-block-${blockId}" data-index="${index}">
                <div class="bg-amber-50 p-3 border-b border-amber-200 flex items-center justify-between gap-4">
                    <div class="flex-1">
                        <label class="text-xs font-bold text-amber-800 mb-1 block">Select Subregions</label>
                        <select name="${prefix}[subregion_pricing][${index}][subregion_ids][]" 
                            class="kt-select w-full h-[38px] subregion-select" multiple>
                            ${SUBREGION_OPTIONS}
                        </select>
                    </div>
                    <button type="button" onclick="window.removeSubregionPricing(this)" 
                        class="w-8 h-8 flex items-center justify-center text-red-600 cursor-pointer hover:text-red-700 hover:bg-red-100 rounded-full mt-4" toggle-button>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
                
                <div class="overflow-x-auto p-4">
                    <p class="text-xs text-gray-500 mb-3">${TRANS.enter_prices_for_the_selected_subregions}:</p>
                    <div class="grid grid-cols-4 gap-3">
                        <!-- Adult -->
                        <div class="flex flex-col">
                            <label class="text-[10px] font-bold text-blue-700 uppercase mb-1">${TRANS.adult}</label>
                            <div class="flex items-center border border-gray-300 rounded overflow-hidden h-[36px] background">
                                <input type="number" step="0.01" min="0"
                                    name="${prefix}[subregion_pricing][${index}][adult]" 
                                    class="flex-1 w-full h-full border-0 px-2 text-sm font-bold text-gray-700 outline-none" 
                                    placeholder="0">
                                <div class="h-full bg-blue-100 border-l border-gray-300 px-2 flex items-center justify-center text-xs font-bold text-blue-600 select-none min-w-[35px] currency-symbol">${symbol}</div>
                            </div>
                        </div>
                        <!-- Child Young (2-6) -->
                        <div class="flex flex-col">
                            <label class="text-[10px] font-bold text-pink-700 uppercase mb-1">${TRANS.child_young_age}</label>
                            <div class="flex items-center border border-gray-300 rounded overflow-hidden h-[36px] background">
                                <input type="number" step="0.01" min="0"
                                    name="${prefix}[subregion_pricing][${index}][child_young]" 
                                    class="flex-1 w-full h-full border-0 px-2 text-sm font-bold text-gray-700 outline-none" 
                                    placeholder="0">
                                <div class="h-full bg-pink-100 border-l border-gray-300 px-2 flex items-center justify-center text-xs font-bold text-pink-600 select-none min-w-[35px] currency-symbol">${symbol}</div>
                            </div>
                        </div>
                        <!-- Child Older (7-11) -->
                        <div class="flex flex-col">
                            <label class="text-[10px] font-bold text-indigo-700 uppercase mb-1">${TRANS.child_older_age}</label>
                            <div class="flex items-center border border-gray-300 rounded overflow-hidden h-[36px] background">
                                <input type="number" step="0.01" min="0"
                                    name="${prefix}[subregion_pricing][${index}][child_older]" 
                                    class="flex-1 w-full h-full border-0 px-2 text-sm font-bold text-gray-700 outline-none" 
                                    placeholder="0">
                                <div class="h-full bg-violet-100 border-l border-gray-300 px-2 flex items-center justify-center text-xs font-bold text-indigo-600 select-none min-w-[35px] currency-symbol">${symbol}</div>
                            </div>
                        </div>
                        <!-- Infant -->
                        <div class="flex flex-col">
                            <label class="text-[10px] font-bold text-orange-700 uppercase mb-1">${TRANS.infant}</label>
                            <div class="flex items-center border border-gray-300 rounded overflow-hidden h-[36px] background">
                                <input type="number" step="0.01" min="0"
                                    name="${prefix}[subregion_pricing][${index}][infant]" 
                                    class="flex-1 w-full h-full border-0 px-2 text-sm font-bold text-gray-700 outline-none" 
                                    placeholder="0">
                                <div class="h-full bg-orange-100 border-l border-gray-300 px-2 flex items-center justify-center text-xs font-bold text-orange-600 select-none min-w-[35px] currency-symbol">${symbol}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        }

        window.removeSubregionPricing = function(btn) {
            const block = btn.closest('.subregion-pricing-block');
            const container = block?.parentNode;

            if (block) {
                block.remove();
            }

            // Hide wrapper if empty
            if (container) {
                // Find wrapper - structure is container -> wrapper -> subregion-pricing-{seasonId}
                // ID format: subregion-pricing-{seasonId}
                const seasonId = container.id.replace('subregion-pricing-', '');
                const wrapper = document.getElementById(`subregion-pricing-wrapper-${seasonId}`);

                if (container.children.length === 0 && wrapper) {
                    wrapper.classList.add('hidden');
                }
            }
        }

        window.generatePriceCell = function(prefix, type, nat, seasonID) {
            const uniqueId = `comm_${seasonID}_${type}_${nat}`;
            const wrapperId = `wrap_${uniqueId}`; // Unique Wrapper ID

            // Use global currency helper if available, else default to $
            const symbol = typeof window.getCurrentCurrencySymbol === 'function' ? window
                .getCurrentCurrencySymbol() :
                '$';

            return `
        <div class="flex flex-col gap-2 relative group-cell">
            <!-- Cost Input Group -->
            <div class="flex items-center border border-gray-300 rounded overflow-hidden h-[36px] background transition-colors focus-within:border-blue-400 focus-within:ring-1 focus-within:ring-blue-400 w-full relative">
                <input type="number" step="0.01" 
                    name="${prefix}[${type}][${nat}][cost]" 
                    class="flex-1 w-full h-full border-0 px-2 text-center text-sm font-bold text-gray-700 outline-none placeholder-gray-300 bg-transparent" 
                    placeholder="0">
                <div class="h-full bg-gray-100 border-l border-gray-300 px-2 flex items-center justify-center text-xs font-bold text-gray-500 select-none min-w-[35px] currency-symbol">
                    ${symbol}
                </div>
            </div>
            
            <!-- Commission Toggle & Input -->
            <div class="bg-gray-100 rounded p-1.5 border border-dashed border-gray-300">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wide select-none">
                        ${TRANS.comm}
                    </span>
                    <div class="toggle-hold mt-0 scale-75 origin-right">
                        <input type="checkbox" id="${uniqueId}" 
                            name="${prefix}[${type}][${nat}][has_commission]" 
                            value="1" 
                            class="toggle-input"
                            onchange="window.toggleCommissionInput(this, '${wrapperId}')">
                        <label for="${uniqueId}"><span></span></label>
                    </div>
                </div>

                <!-- Hidden Commission Value Input -->
                <div id="${wrapperId}" class="commission-input-wrapper hidden mt-1 pt-1 border-t border-gray-200">
                    <div class="flex gap-1 mb-1">
                         <select name="${prefix}[${type}][${nat}][commission_type]" 
                                 onchange="window.updateCommissionSymbol(this)"
                                 class="w-full text-[10px] h-[22px] background border border-gray-200 rounded px-1 outline-none text-gray-600 font-bold focus:border-pink-300">
                             <option value="percentage">Percent (%)</option>
                             <option value="fixed">Fixed (${symbol})</option>
                         </select>
                    </div>
                    <div class="flex items-center border border-pink-200 rounded overflow-hidden h-[28px] background">
                        <input type="number" step="0.01" 
                            name="${prefix}[${type}][${nat}][commission_amount]" 
                            class="flex-1 w-full h-full border-0 px-1 text-center text-xs font-bold text-pink-700 outline-none placeholder-gray-300" 
                            placeholder="0">
                        <div class="h-full bg-pink-100 border-l border-pink-200 px-1 flex items-center justify-center text-[10px] font-bold text-pink-600 select-none min-w-[25px] commission-symbol-span">
                            %
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `;
        }

        // Helper to toggle commission input visibility
        // Helper to toggle commission input visibility
        window.toggleCommissionInput = function(checkbox, wrapperId) {
            let wrapper;

            // 1. Try direct ID (Best)
            if (wrapperId) {
                wrapper = document.getElementById(wrapperId);
            } else if (checkbox.dataset && checkbox.dataset.wrapperId) {
                wrapper = document.getElementById(checkbox.dataset.wrapperId);
            }

            // 2. Try inferred ID (Backup)
            if (!wrapper && checkbox.id) {
                wrapper = document.getElementById('wrap_' + checkbox.id);
            }

            // 3. Fallback to DOM traversal (Worst case)
            if (!wrapper) {
                const container = checkbox.closest('.border-dashed');
                if (container) {
                    wrapper = container.querySelector('.commission-input-wrapper');
                }
            }

            if (wrapper) {
                if (checkbox.checked) {
                    wrapper.classList.remove('hidden');
                    wrapper.style.display = 'block';
                } else {
                    wrapper.classList.add('hidden');
                    wrapper.style.display = 'none';
                }
            } else {
                console.error('Commission wrapper not found for checkbox:', checkbox);
            }
        }


        // Helper to update commission symbol based on type selection
        window.updateCommissionSymbol = function(select) {
            const wrapper = select.closest('.commission-input-wrapper');
            const symbolSpan = wrapper.querySelector('.commission-symbol-span');
            const currentCurrency = typeof window.getCurrentCurrencySymbol === 'function' ? window
                .getCurrentCurrencySymbol() : '$';

            if (select.value === 'percentage') {
                symbolSpan.textContent = '%';
            } else {
                symbolSpan.textContent = currentCurrency;
            }
        }

        // 5. Update Currency Symbols Helper
        window.updateCurrencySymbolsInTables = function(symbol) {
            document.querySelectorAll('.currency-symbol').forEach(el => el.textContent = symbol);
        }


        // 6. Validation (Global)
        window.validateSeasonDates = function(input) {
            const row = input.closest('.range-row') || input.closest('.season-row'); // Support new and old
            if (!row) return;

            const startDateInput = row.querySelector('.season-start-date') || row.querySelector(
                'input[name*="[start]"]');
            const endDateInput = row.querySelector('.season-end-date') || row.querySelector('input[name*="[end]"]');

            const startDate = startDateInput?.value;
            const endDate = endDateInput?.value;

            // Update min/max for this row
            if (startDate) {
                endDateInput.min = startDate;
            }
            if (endDate) {
                startDateInput.max = endDate;
            }



            if (startDate && endDate) {
                if (new Date(startDate) > new Date(endDate)) {
                    alert('Start date cannot be after end date.');
                    input.value = '';
                    return;
                }

                // Overlap check
                const allRanges = [];

                // Collect all OTHER ranges
                // 1. New Season Groups
                document.querySelectorAll('.season-group').forEach(group => {
                    const groupName = group.querySelector('.season-name-input')?.value || 'Unnamed Season';
                    group.querySelectorAll('.range-row').forEach(r => {
                        if (r === row) return; // Skip self

                        const s = r.querySelector('.season-start-date')?.value;
                        const e = r.querySelector('.season-end-date')?.value;

                        if (s && e) {
                            allRanges.push({
                                start: s,
                                end: e,
                                name: groupName
                            });
                        }
                    });
                });

                // 2. Old Flat Repeater (Legacy support)
                document.querySelectorAll('.season-row').forEach(r => {
                    if (r === row) return;
                    const s = r.querySelector('input[name*="[start]"]')?.value;
                    const e = r.querySelector('input[name*="[end]"]')?.value;
                    const n = r.querySelector('input[name*="[name]"]')?.value || 'Unnamed Season';

                    if (s && e) {
                        allRanges.push({
                            start: s,
                            end: e,
                            name: n
                        });
                    }
                });

                let overlap = false;
                let overlapSeasonName = '';

                const s1 = new Date(startDate);
                const e1 = new Date(endDate);

                for (const other of allRanges) {
                    const s2 = new Date(other.start);
                    const e2 = new Date(other.end);

                    if (s1 <= e2 && s2 <= e1) {
                        overlap = true;
                        overlapSeasonName = other.name;
                        break;
                    }
                }

                if (overlap) {
                    alert(`This date range overlaps with "${overlapSeasonName}". Please choose different dates.`);
                    input.value = '';
                }
            }
        }

        // Helper function to update all date restrictions
        window.updateAllSeasonDateRestrictions = function() {
            const allRows = document.querySelectorAll('.season-row');

            allRows.forEach(row => {
                const startInput = row.querySelector('input[name*="[start]"]');
                const endInput = row.querySelector('input[name*="[end]"]');

                if (!startInput || !endInput) return;

                const startDate = startInput.value;
                const endDate = endInput.value;

                // Set min for end date based on start date
                if (startDate) {
                    endInput.min = startDate;
                } else {
                    endInput.removeAttribute('min');
                }

                // Set max for start date based on end date
                if (endDate) {
                    startInput.max = endDate;
                } else {
                    startInput.removeAttribute('max');
                }
            });
        }
        // === TOGGLE GROUP PRICING COLUMNS (MUST BE OUTSIDE DOMContentLoaded) ===
        window.toggleGroupPricingColumns = function() {
            const pricingUnitInput = document.getElementById('pricing_unit');
            const unitVal = pricingUnitInput ? pricingUnitInput.value : '';
            const groupUnits = [
                'per_group', 'group', 'per_bus', 'bus', 'per_trip', 'trip', 'per_unit', 'unit',
                'per_group_per_day', 'group_day', 'per_group_per_night', 'group_night',
                'per_extra_hour_per_group', 'extra_hour_group', 'per_extra_hour_per_vehicle', 'extra_hour_vehicle'
            ];
            const isGroupUnit = groupUnits.includes(unitVal);
            const childCols = document.querySelectorAll('.col-child-young, .col-child-older');
            const infantCols = document.querySelectorAll('.col-infant');
            const adultCols = document.querySelectorAll('.col-adult');
            if (isGroupUnit) {
                childCols.forEach(el => el.style.display = 'none');
                infantCols.forEach(el => el.style.display = 'none');
                adultCols.forEach(el => {
                    const label = el.querySelector('.header-label');
                    const sub = el.querySelector('.header-sub');
                    if (label) label.textContent = '{{ __('main.rates') }}';
                    if (sub) sub.style.display = 'none';
                });
            } else {
                childCols.forEach(el => el.style.display = '');
                infantCols.forEach(el => el.style.display = '');
                adultCols.forEach(el => {
                    const label = el.querySelector('.header-label');
                    const sub = el.querySelector('.header-sub');
                    if (label) label.textContent = '{{ __('main.adult') }}';
                    if (sub) sub.style.display = '';
                });
            }
        };



        // === INITIALIZATION ===
        // === FLATPICKR HELPER FUNCTIONS (MUST BE OUTSIDE DOMContentLoaded) ===
        window.getAllOccupiedRanges = function(excludeStartInput = null, excludeEndInput = null) {
            const ranges = [];
            const processRow = (sInput, eInput) => {
                if (!sInput || !eInput) return;
                if (sInput === excludeStartInput || eInput === excludeEndInput) return;
                const startVal = sInput.value;
                const endVal = eInput.value;
                if (startVal && endVal) {
                    ranges.push({
                        from: startVal,
                        to: endVal
                    });
                }
            };
            document.querySelectorAll('.season-group .range-row').forEach(row => {
                const s = row.querySelector('.season-start-date');
                const e = row.querySelector('.season-end-date');
                processRow(s, e);
            });
            document.querySelectorAll('.season-row').forEach(row => {
                const s = row.querySelector('input[name*="[start]"]');
                const e = row.querySelector('input[name*="[end]"]');
                processRow(s, e);
            });
            return ranges;
        };

        window.initializeFlatpickrForSeasons = function() {
            const allStartInputs = document.querySelectorAll('.season-start-date, .season-row input[name*="[start]"]');
            allStartInputs.forEach(startInput => {
                const row = startInput.closest('.range-row') || startInput.closest('.season-row');
                if (!row) return;
                const endInput = row.querySelector('.season-end-date') || row.querySelector('input[name*="[end]"]');
                if (!endInput) return;
                if (startInput._flatpickr) startInput._flatpickr.destroy();
                if (endInput._flatpickr) endInput._flatpickr.destroy();
                const commonConfig = {
                    dateFormat: "Y-m-d",
                    monthSelectorType: 'static',
                    yearSelectorType: 'static',
                    animate: true,
                    showMonths: 1,
                    static: false,
                    disable: window.getAllOccupiedRanges(startInput, endInput),
                    locale: {
                        firstDayOfWeek: 1
                    },
                    onDayCreate: function(dObj, dStr, fp, dayElem) {
                        if (dayElem.classList.contains('flatpickr-disabled')) {
                            dayElem.className += " occupied-date";
                            dayElem.style.backgroundColor = '#f3f4f6';
                            dayElem.style.color = '#9ca3af';
                            dayElem.style.textDecoration = 'line-through';
                            dayElem.style.opacity = '1';
                            dayElem.style.cursor = 'not-allowed';
                        }
                    },
                    allowInput: true
                };
                const startPicker = flatpickr(startInput, {
                    ...commonConfig,
                    onChange: function(selectedDates, dateStr) {
                        if (dateStr) {
                            endPicker.set('minDate', dateStr);
                            window.refreshAllSeasonPickers();
                        }
                    }
                });
                const endPicker = flatpickr(endInput, {
                    ...commonConfig,
                    minDate: startInput.value || null,
                    onChange: function(selectedDates, dateStr) {
                        if (dateStr) {
                            startPicker.set('maxDate', dateStr);
                            window.refreshAllSeasonPickers();
                        }
                    }
                });
                startInput._flatpickr = startPicker;
                endInput._flatpickr = endPicker;
            });
        };

        window.refreshAllSeasonPickers = function() {
            const allStartInputs = document.querySelectorAll('.season-start-date, .season-row input[name*="[start]"]');
            allStartInputs.forEach(startInput => {
                const row = startInput.closest('.range-row') || startInput.closest('.season-row');
                const endInput = row?.querySelector('.season-end-date') || row?.querySelector('input[name*="[end]"]');
                if (startInput._flatpickr) {
                    const occupied = window.getAllOccupiedRanges(startInput, endInput);
                    startInput._flatpickr.set('disable', occupied);
                }
                if (endInput && endInput._flatpickr) {
                    const occupied = window.getAllOccupiedRanges(startInput, endInput);
                    endInput._flatpickr.set('disable', occupied);
                }
            });
        };

        window.initializeFlatpickrForFlatRate = function() {
            const startInput = document.querySelector('input[name="flat_start_date"]');
            const endInput = document.querySelector('input[name="flat_end_date"]');
            if (!startInput || !endInput) return;
            if (startInput._flatpickr) startInput._flatpickr.destroy();
            if (endInput._flatpickr) endInput._flatpickr.destroy();
            const startPicker = flatpickr(startInput, {
                dateFormat: "Y-m-d",
                allowInput: true,
                onChange: function(selectedDates, dateStr) {
                    if (dateStr) endPicker.set('minDate', dateStr);
                }
            });
            const endPicker = flatpickr(endInput, {
                dateFormat: "Y-m-d",
                minDate: startInput.value || null,
                allowInput: true,
                onChange: function(selectedDates, dateStr) {
                    if (dateStr) startPicker.set('maxDate', dateStr);
                }
            });
            startInput._flatpickr = startPicker;
            endInput._flatpickr = endPicker;
        };

        document.addEventListener('DOMContentLoaded', function() {
            // Elements
            const pricingTypeRadios = document.querySelectorAll('input[name="pricing_type"]');

            // Initial State
            const currentType = document.querySelector('input[name="pricing_type"]:checked')?.value || 'flat';
            window.handlePricingTypeChange(currentType);

            // Initialize Flatpickr (Now Safe to Call)
            window.initializeFlatpickrForSeasons();
            window.initializeFlatpickrForFlatRate();
            initializeFlatpickrForFlatRate();

            // Validation Listeners (kept for backward compatibility)
            document.addEventListener('change', function(e) {
                if (e.target.matches('.season-row input[type="date"]')) {
                    validateSeasonDates(e.target);
                }
            });

            // ROBUST EVENT DELEGATION FOR COMMISSION TOGGLES
            // This ensures it works even for dynamically added rows
            document.body.addEventListener('change', function(e) {
                // Check if it's a commission toggle
                if (e.target && e.target.matches('input[type="checkbox"][name*="has_commission"]')) {
                    window.toggleCommissionInput(e.target);
                }
                // Check if it's a commission type select
                if (e.target && e.target.matches('select[name*="commission_type"]')) {
                    window.updateCommissionSymbol(e.target);
                }
            });



            // Listen for Pricing Unit Change -> Re-render tables and toggle columns
            const pricingUnitSelect = document.querySelector('select[name="pricing_unit"]');
            if (pricingUnitSelect) {
                pricingUnitSelect.addEventListener('change', function() {
                    if (document.querySelector('input[name="pricing_type"]:checked').value ===
                        'seasonal') {
                        window.updateSeasonalPricingTables();
                    }
                    window.toggleGroupPricingColumns(); // Update existing/server-rendered tables
                });
                // Initial call
                window.toggleGroupPricingColumns();
            }

            // Listen needed for seasons container inputs (name) for dynamic updates
            const seasonsContainer = document.getElementById('seasons_container');
            if (seasonsContainer) {
                seasonsContainer.addEventListener('input', function(e) {
                    if (e.target.matches('input[name*="[name]"]')) {
                        if (document.querySelector('input[name="pricing_type"]:checked').value ===
                            'seasonal') {
                            window.updateSeasonalPricingTables();
                        }
                    }
                });
            }

            // Event delegation for commission toggles (dynamically generated)
            document.addEventListener('change', function(e) {
                if (e.target.matches('input[name*="[commission]"]')) {
                    window.handleCommissionToggle(e.target);
                }
            });


            // ============================================
            // COMMISSION TOGGLE - Link to Section 4
            // ============================================
            // ... existing handleCommissionToggle code ... (Assuming it's outside)

            // (Note: function generateCommissionItemHTML is here too)

            // GLOBAL FLATPICKR INITIALIZATION (Defined Outside DOMContentLoaded)


            // Helper to get all occupied date ranges from all OTHER season inputs

            // ============================================
            // COMMISSION TOGGLE - Link to Section 4
            // ============================================

            // ============================================
            // COMMISSION TOGGLE - Link to Section 4
            // ============================================

            window.handleCommissionToggle = function(checkbox) {
                const commissionSection = document.getElementById('commission_section');
                const commissionContainer = document.getElementById('commission_container');
                const hasCommissionInput = document.getElementById('has_commission_input');

                if (!commissionContainer || !commissionSection) {
                    console.error('Commission container or section not found');
                    return;
                }

                // Get details from the checkbox
                const type = checkbox.dataset?.type || 'adult';
                const nationality = checkbox.dataset?.nationality || 'foreigner';
                const season = checkbox.dataset?.season || 'standard';
                let label = checkbox.dataset?.label || `${type} - ${nationality}`;

                // Handle Custom Nationality Label
                if (nationality.startsWith('custom_')) {
                    const row = checkbox.closest('tr');
                    const select = row?.querySelector('select[name*="[nationality_id]"]');
                    if (select) {
                        const selectedText = select.options[select.selectedIndex]?.text;
                        if (selectedText && selectedText !== TRANS.select_nationality) {
                            label = `${type} - ${selectedText}`;
                        } else {
                            label = `${type} - ${TRANS.add_custom_nationality}`;
                        }
                    }
                }

                const inputName = checkbox.name ? checkbox.name.replace('[commission]', '') : '';

                const itemId = `comm_item_${season}_${type}_${nationality}`;

                if (checkbox.checked) {
                    // Show Section 4
                    commissionSection.classList.remove('hidden');
                    if (hasCommissionInput) hasCommissionInput.value = '1';

                    // Check if item already exists
                    if (!document.getElementById(itemId)) {
                        const itemHtml = window.generateCommissionItemHTML(itemId, label, inputName, type,
                            nationality,
                            season);
                        commissionContainer.insertAdjacentHTML('beforeend', itemHtml);
                    }
                } else {
                    // Remove the commission item
                    const existingItem = document.getElementById(itemId);
                    if (existingItem) {
                        existingItem.remove();
                    }

                    // If no more items, hide Section 4
                    if (commissionContainer.children.length === 0) {
                        commissionSection.classList.add('hidden');
                        if (hasCommissionInput) hasCommissionInput.value = '0';
                    }
                }
            }

            window.generateCommissionItemHTML = function(itemId, label, inputName, type, nationality, season) {
                return `
<div id="${itemId}"
    class="commission-item flex items-center gap-4 p-3 background border border-pink-200 rounded-lg shadow-sm"
    data-type="${type}" data-nationality="${nationality}" data-season="${season}">
    <div class="flex-1">
        <span class="text-sm font-bold text-gray-700">${label}</span>
        <input type="hidden" name="${inputName}[commission_enabled]" value="1">
    </div>
    <div class="w-32">
        <select name="${inputName}[commission_type]" class="kt-input h-[32px] text-xs w-full"
            onchange="window.updateCommissionSymbol(this)">
            <option value="percentage">%</option>
            <option value="fixed">Fixed</option>
        </select>
    </div>
    <div class="w-24">
        <div class="flex items-center border border-gray-300 rounded overflow-hidden h-[32px] background">
            <input type="number" step="0.01" min="0" name="${inputName}[commission_value]"
                class="flex-1 w-full h-full border-0 px-2 text-center text-xs font-bold text-gray-700 outline-none bg-transparent"
                placeholder="0">
            <span
                class="h-full bg-gray-100 border-l border-gray-300 px-2 flex items-center justify-center text-xs text-gray-500 select-none commission-unit">%</span>
        </div>
    </div>
    <button type="button" onclick="window.removeCommissionItem(this)"
        class="w-6 h-6 flex items-center justify-center text-red-400 hover:text-red-600 rounded transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
`;
            }

            window.updateCommissionSymbol = function(select) {
                const item = select.closest('.commission-item');
                const symbolSpan = item.querySelector('.commission-unit');

                if (select.value === 'percentage') {
                    symbolSpan.textContent = '%';
                } else {
                    // Get currently selected currency symbol using global helper
                    const symbol = typeof window.getCurrentCurrencySymbol === 'function' ? window
                        .getCurrentCurrencySymbol() :
                        '$';
                    symbolSpan.textContent = symbol;
                }
            }

            window.removeCommissionItem = function(btn) {
                const item = btn.closest('.commission-item');
                if (!item) return;

                const type = item.dataset.type;
                const nationality = item.dataset.nationality;
                const season = item.dataset.season;

                // Uncheck the corresponding toggle in pricing table
                const selector =
                    `input[data-type="${type}"][data-nationality="${nationality}"][data-season="${season}"]`;
                const toggle = document.querySelector(selector);
                if (toggle) {
                    toggle.checked = false;
                }

                item.remove();
            }

            window.updateCommissionLabelsForCustomRow = function(select) {
                const row = select.closest('tr');
                if (!row) return;

                const selectedText = select.options[select.selectedIndex]?.text;
                const newLabelName = (selectedText && selectedText !== TRANS.select_nationality) ?
                    selectedText : TRANS
                    .add_custom_nationality;

                // Find all commission toggles in this row
                const toggles = row.querySelectorAll('input[name*="[commission]"]');
                toggles.forEach(toggle => {
                    const type = toggle.dataset.type;
                    const season = toggle.dataset.season;
                    const nationality = toggle.dataset.nationality; // "custom_X"

                    // Update Label for future toggles
                    toggle.dataset.label = `${type} - ${newLabelName}`;

                    // Check if active commission exists and update IT
                    const itemId = `comm_item_${season}_${type}_${nationality}`;
                    const activeItem = document.getElementById(itemId);

                    if (activeItem) {
                        // Find label span within the active item
                        const labelDiv = activeItem.querySelector('.flex-1');
                        const labelSpan = labelDiv ? labelDiv.querySelector('span') : null;
                        if (labelSpan) {
                            labelSpan.textContent = `${type} - ${newLabelName}`;
                        }
                    }
                });
            }

            // Handle commission toggle visual feedback
            // Handle commission toggle visual feedback
            function toggleCommission(label, event) {
                event.preventDefault();

                const checkbox = label.querySelector('.comm-checkbox');
                const switchEl = label.querySelector('.comm-switch');
                const dot = label.querySelector('.comm-dot');
                const labelText = label.querySelector('.comm-label');

                if (!checkbox || !switchEl || !dot) return;

                // Toggle checkbox state
                checkbox.checked = !checkbox.checked;

                // Update visual state
                if (checkbox.checked) {
                    switchEl.classList.remove('bg-gray-200', 'border-gray-300');
                    switchEl.classList.add('bg-green-500', 'border-green-500');
                    dot.style.transform = 'translateX(18px)';

                    if (labelText) {
                        labelText.classList.remove('text-gray-400');
                        labelText.classList.add('text-green-600');
                    }
                } else {
                    switchEl.classList.add('bg-gray-200', 'border-gray-300');
                    switchEl.classList.remove('bg-green-500', 'border-green-500');
                    dot.style.transform = 'translateX(0)';

                    if (labelText) {
                        labelText.classList.add('text-gray-400');
                        labelText.classList.remove('text-green-600');
                    }
                }
            }

            // Initialize Flatpickr for all season date inputs
            // Global removal function
            // Global Event Delegation for Season Removal
            // Global Removal Function (Fallback for reliability)
            window.manualRemoveSeason = function(btn) {
                // e.preventDefault() is implied by button type="button" but good to be safe if passed event
                // But here we receive 'btn' element directly from onclick="manualRemoveSeason(this)"

                // Debug
                // console.log('Manual Remove Triggered');

                if (!confirm('Are you sure you want to remove this season?')) return;

                const group = btn.closest('.season-group');
                if (group) {
                    group.remove();
                    if (typeof window.updateSeasonalPricingTables === 'function') {
                        window.updateSeasonalPricingTables();
                    }

                    // Show no seasons message if empty
                    const container = document.getElementById('seasons_container');
                    if (container && container.children.length === 0) {
                        const noMsg = document.getElementById('no_seasons_msg');
                        if (noMsg) noMsg.style.display = 'block';
                    }
                }
            };

            // Keep Event Delegation just in case (optional, but let's remove it to avoid double-firing if we add onclick)
        }); // End of DOMContentLoaded
    } // End of singleton check
</script>
