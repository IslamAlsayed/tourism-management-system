<div>
<div class="kt-container-fixed py-5 pt-7 w-full min-w-0 text-foreground" x-data>
    @php
        $flagMap = ['en'=>'us','ar'=>'sa','he'=>'il','ja'=>'jp','zh'=>'cn','ko'=>'kr','pt'=>'pt','ur'=>'pk','hi'=>'in','ru'=>'ru','tr'=>'tr','de'=>'de','es'=>'es','fr'=>'fr','it'=>'it'];
        $isSuperAdmin = getActiveUser() && in_array(strtolower(getActiveUser()->role ?? ''), ['superadmin', 'admin']);
        $rtlLocales = ['ar', 'he', 'ur', 'fa', 'ku'];
        $isRtlLocale = in_array($selectedLocale, $rtlLocales);
        $pendingTotalCount = $isSuperAdmin ? \Modules\TranslationManager\Entities\TranslationSuggestion::where('status','pending')->count() : 0;
    @endphp

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- SECTION 1: Page Header Card --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    <div class="kt-card shadow-sm mb-5 w-full min-w-0">
        <div class="kt-card-header border-0 pt-6 px-6 flex justify-between items-center w-full min-w-0">
            <div class="card-title m-0">
                <h3 class="font-bold text-xl m-0 flex items-center">
                    <i class="fas fa-language text-2xl text-primary me-2"></i>
                    {{ __('sidebar.translation manager') }}
                </h3>
            </div>
            <div class="card-toolbar flex gap-2 flex-wrap">
                {{-- Import CSV --}}
                <input type="file" wire:model="importFile" class="hidden" id="importFile" accept=".csv">
                <label for="importFile" class="kt-btn kt-btn-sm kt-btn-light kt-btn-success font-bold cursor-pointer mb-0">
                    <i class="fas fa-file-import me-1"></i>
                    <span wire:loading.remove wire:target="importFile">{{ __('Import CSV') }}</span>
                    <span wire:loading wire:target="importFile">{{ __('Uploading...') }}</span>
                </label>

                {{-- Export Dropdown (KTUI native) --}}
                <div class="inline-flex" data-kt-dropdown="true" data-kt-dropdown-trigger="click" data-kt-dropdown-placement="bottom-start">
                    <button type="button" data-kt-dropdown-toggle="true" class="kt-btn kt-btn-sm kt-btn-light kt-btn-info font-bold flex items-center gap-2">
                        <i class="fas fa-file-export"></i> {{ __('Export') }}
                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200 kt-dropdown-open:rotate-180"></i>
                    </button>
                    <div class="kt-dropdown w-52 py-2 bg-popover text-popover-foreground border border-border shadow-lg rounded-lg" data-kt-dropdown-menu="true">
                        <button wire:click="exportCSV" data-kt-dropdown-dismiss="true" class="kt-dropdown-menu-link w-full text-start px-4 py-2.5 text-sm flex items-center gap-3"><i class="fas fa-file-csv text-green-500 w-4 text-center"></i> <span class="font-medium">{{ __('Export CSV') }}</span></button>
                        <button wire:click="exportSelectedExcel" data-kt-dropdown-dismiss="true" class="kt-dropdown-menu-link w-full text-start px-4 py-2.5 text-sm flex items-center gap-3"><i class="fas fa-file-excel text-green-600 w-4 text-center"></i> <span class="font-medium">{{ __('Export Excel') }}</span></button>
                        <button wire:click="exportSelectedPDF" data-kt-dropdown-dismiss="true" class="kt-dropdown-menu-link w-full text-start px-4 py-2.5 text-sm flex items-center gap-3"><i class="fas fa-file-pdf text-red-500 w-4 text-center"></i> <span class="font-medium">{{ __('Export PDF') }}</span></button>
                        <button wire:click="exportSelectedJSON" data-kt-dropdown-dismiss="true" class="kt-dropdown-menu-link w-full text-start px-4 py-2.5 text-sm flex items-center gap-3"><i class="fas fa-code text-blue-500 w-4 text-center"></i> <span class="font-medium">{{ __('Export JSON') }}</span></button>
                        <button wire:click="exportSelectedTXT" data-kt-dropdown-dismiss="true" class="kt-dropdown-menu-link w-full text-start px-4 py-2.5 text-sm flex items-center gap-3"><i class="fas fa-file-alt text-gray-500 w-4 text-center"></i> <span class="font-medium">{{ __('Export TXT') }}</span></button>
                    </div>
                </div>

                @if ($isSuperAdmin)
                    <button type="button" wire:click="scanProjectMissingKeys" class="kt-btn kt-btn-sm kt-btn-light kt-btn-warning font-bold" wire:loading.attr="disabled">
                        <i class="fas fa-sync me-1" wire:loading.class="fa-spin" wire:target="scanProjectMissingKeys"></i>
                        <span wire:loading.remove wire:target="scanProjectMissingKeys">{{ __('Auto-Scan Files') }}</span>
                        <span wire:loading wire:target="scanProjectMissingKeys">{{ __('Scanning...') }}</span>
                    </button>
                    <button type="button" @click="$dispatch('open-add-key-modal')" class="kt-btn kt-btn-sm kt-btn-primary font-bold">
                        <i class="fas fa-plus-circle me-1"></i> {{ __('Add New Text') }}
                    </button>
                    <button wire:click="toggleReviewPanel" class="kt-btn kt-btn-sm font-bold {{ $showReviewPanel ? 'kt-btn-primary' : 'kt-btn-light kt-btn-primary' }}">
                        <i class="fas fa-clipboard-check me-1"></i> {{ __('Review Suggestions') }}
                        @if ($pendingTotalCount > 0)
                            <span class="kt-badge kt-badge-danger rounded-full ms-2">{{ $pendingTotalCount }}</span>
                        @endif
                    </button>
                @endif
            </div>
        </div>
        <div class="kt-card-body pt-0 pb-6 px-6 text-muted-foreground text-sm">
            {{ __('Manage and edit translations for all languages from one place.') }}
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- SECTION 2: Pending Suggestions Alert --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    @if (!$showReviewPanel && $pendingTotalCount > 0 && $isSuperAdmin)
        <div class="kt-card bg-warning-light/50 border border-warning border-dashed shadow-sm mb-5 w-full min-w-0 flex flex-col sm:flex-row items-center justify-between p-4 px-6">
            <div class="flex items-center gap-4 mb-3 sm:mb-0">
                <div class="w-12 h-12 bg-warning/20 rounded-full flex items-center justify-center shrink-0">
                    <i class="fas fa-exclamation-triangle text-warning text-xl"></i>
                </div>
                <div>
                    <h4 class="text-warning-800 dark:text-warning font-bold text-lg mb-0.5">{{ $pendingTotalCount }} {{ __('Pending Translation Suggestions') }}</h4>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-0">{{ __('Community members have suggested improvements to the translations. Please review them.') }}</p>
                </div>
            </div>
            <button wire:click="toggleReviewPanel" class="kt-btn kt-btn-warning text-white font-bold shrink-0">
                <i class="fas fa-search me-2 text-white"></i> {{ __('Review Suggestions Now') }}
            </button>
        </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- SECTION 3: Review Panel (Admin Only) --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    @if ($showReviewPanel && $isSuperAdmin)
        @include('translationmanager::livewire.partials.review-panel', ['pendingSuggestions' => $pendingSuggestions, 'historySuggestions' => $historySuggestions, 'localePhotos' => $localePhotos, 'availableLocales' => $availableLocales, 'referenceTranslations' => $referenceTranslations, 'flagMap' => $flagMap, 'editingSuggestedValues' => $editingSuggestedValues, 'reviewNote' => $reviewNote])
    @endif

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- SECTION 4: Translation Progress (Collapsible) --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    @include('translationmanager::livewire.partials.progress-overview', ['localeStats' => $localeStats, 'selectedLocale' => $selectedLocale, 'flagMap' => $flagMap])

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- SECTION 5: Filter Dropdowns (File + Language) --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    @include('translationmanager::livewire.partials.filter-dropdowns', ['selectedFile' => $selectedFile, 'availableFiles' => $availableFiles, 'selectedLocale' => $selectedLocale, 'availableLocales' => $availableLocales, 'localePhotos' => $localePhotos, 'flagMap' => $flagMap])

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- SECTION 6: Main Translation Table --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    <div class="kt-card kt-card-grid min-w-full">
        {{-- Filter Buttons (All / Missing / Done) --}}
        <div class="kt-card-header border-b border-border pt-5 pb-5 px-6 w-full min-w-0">
            <div class="flex items-center gap-3 flex-wrap w-full">
                <button wire:click="$set('filterMode', 'all')" class="kt-btn kt-btn-lg font-bold flex items-center gap-2 transition-all shadow-sm {{ $filterMode === 'all' ? 'kt-btn-primary' : 'kt-btn-light' }}">
                    <i class="fas fa-list"></i> {{ __('All') }} <span class="ms-1 font-normal opacity-75">({{ $stats['total'] ?? 0 }})</span>
                </button>
                <button wire:click="$set('filterMode', 'missing')" class="kt-btn kt-btn-lg font-bold flex items-center gap-2 transition-all shadow-sm {{ $filterMode === 'missing' ? 'kt-btn-danger' : 'kt-btn-light' }}">
                    <i class="fas fa-exclamation-triangle"></i> {{ __('Missing') }} <span class="ms-1 font-normal opacity-75">({{ $stats['missing'] ?? 0 }})</span>
                </button>
                <button wire:click="$set('filterMode', 'translated')" class="kt-btn kt-btn-lg font-bold flex items-center gap-2 transition-all shadow-sm {{ $filterMode === 'translated' ? 'kt-btn-success' : 'kt-btn-light' }}">
                    <i class="fas fa-check-circle"></i> {{ __('Done') }} <span class="ms-1 font-normal opacity-75">({{ $stats['translated'] ?? 0 }})</span>
                </button>
            </div>
        </div>

        {{-- Standard Toolbar (pagination-info) --}}
        @component('includes.pagination-info', [
            'data' => $filteredTranslations ?? null,
            'title' => __('sidebar.translation manager'),
            'entityName' => __('main.translations'),
            'searchValue' => $search ?? null,
            'showSearch' => true,
            'allColumns' => $allColumns ?? [],
            'pendingColumns' => $pendingColumns ?? [],
            'hasCustomColumns' => false,
        ])
            @if (isset($filteredTranslations) && $filteredTranslations->count() > 0 && isset($allColumns))
                @include('components.columns', [
                    'allColumns' => $allColumns ?? [],
                    'pendingColumns' => $pendingColumns ?? [],
                    'selectedIds' => $selectedIds ?? [],
                    'hideExport' => true,
                ])
            @endif
        @endcomponent

        {{-- Table Content --}}
        <div class="kt-card-body py-4 px-6 w-full min-w-0">
            <div wire:loading wire:target="selectedFile, selectedLocale" class="w-full flex justify-center py-12">
                <div class="flex flex-col items-center gap-3">
                    <div class="w-10 h-10 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
                    <span class="font-bold text-gray-500">{{ __('Loading translations...') }}</span>
                </div>
            </div>

            <div wire:loading.remove wire:target="selectedFile, selectedLocale" class="w-full relative min-w-0">
                <div class="kt-scrollable-x-auto">
                    <table class="kt-table table-auto text-nowrap w-full" id="translation_data_table">
                        <thead>
                            <tr>
                                <th class="w-[60px] px-4 py-3 text-center" style="padding-inline-start: 21px">
                                    <div class="custom-input cursor-pointer">
                                        <input type="checkbox" wire:model.live="selectAll" id="selectAllCheckbox">
                                        <label for="selectAllCheckbox"></label>
                                    </div>
                                </th>
                                @if (in_array('key', $columns))
                                    <th class="px-4 py-4 text-start text-lg font-bold text-gray-900 dark:text-gray-100 uppercase tracking-wider">
                                        <div class="flex items-center gap-2 min-w-[120px]"><span class="uppercase">{{ __('Key') }}</span></div>
                                    </th>
                                @endif
                                @if (in_array('english', $columns))
                                    <th class="px-4 py-4 text-start text-lg font-bold text-gray-900 dark:text-gray-100 uppercase tracking-wider">
                                        <div class="flex items-center gap-2 min-w-[200px]">
                                            <div class="kt-avatar size-5"><div class="kt-avatar-image"><img src="{{ !empty($localePhotos['en']) ? (str_contains($localePhotos['en'], '/') ? asset('storage/' . $localePhotos['en']) : asset('assets/media/flags/' . $localePhotos['en'])) : asset('assets/media/flags/' . ($flagMap['en'] ?? 'us') . '.svg') }}" alt=""></div></div>
                                            <span class="uppercase">{{ __('English Reference') }}</span>
                                        </div>
                                    </th>
                                @endif
                                @if (in_array('translation', $columns))
                                    <th class="px-4 py-4 text-start text-lg font-bold text-gray-900 dark:text-gray-100 uppercase tracking-wider">
                                        <div class="flex items-center gap-2 min-w-[200px]">
                                            <div class="kt-avatar size-5"><div class="kt-avatar-image"><img src="{{ !empty($localePhotos[$selectedLocale]) ? (str_contains($localePhotos[$selectedLocale], '/') ? asset('storage/' . $localePhotos[$selectedLocale]) : asset('assets/media/flags/' . $localePhotos[$selectedLocale])) : asset('assets/media/flags/' . ($flagMap[$selectedLocale] ?? $selectedLocale) . '.svg') }}" alt=""></div></div>
                                            <span class="uppercase">{{ $availableLocales[$selectedLocale] ?? $selectedLocale }}</span>
                                        </div>
                                    </th>
                                @endif
                                @if (in_array('status', $columns))
                                    <th class="px-4 py-4 text-center text-lg font-extrabold text-gray-900 dark:text-gray-100 uppercase tracking-wider">
                                        <div class="flex items-center justify-center gap-2 min-w-[80px]"><span class="uppercase">{{ __('Status') }}</span></div>
                                    </th>
                                @endif
                                @if (in_array('suggest', $columns))
                                    <th class="px-4 py-4 text-center text-lg font-extrabold text-gray-900 dark:text-white uppercase tracking-wider">
                                        <div class="flex items-center justify-center gap-2 min-w-[100px]"><span class="uppercase">{{ __('Suggest') }}</span></div>
                                    </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($filteredTranslations as $key => $value)
                                <tr class="hover:bg-primary/10 transition-colors cursor-pointer {{ $value === '' || $value === null ? 'bg-danger-light/20 dark:bg-danger/10' : '' }}">
                                    <td class="text-center">
                                        <div class="custom-input">
                                            <input type="checkbox" name="selectItem[]" id="checkbox_{{ $loop->index }}" wire:model="selectedIds" value="{{ $key }}">
                                            <label for="checkbox_{{ $loop->index }}"></label>
                                        </div>
                                    </td>
                                    @if (in_array('key', $columns))
                                        <td class="px-4 py-2" dir="ltr">
                                            @php $displayKey = $key; $displayFile = '';
                                                if (str_contains($key, '|||')) { $parts = explode('|||', $key, 2); $displayFile = str_replace('global::', 'global / ', $parts[0]); $displayKey = $parts[1]; }
                                            @endphp
                                            <span class="kt-badge kt-badge-light kt-badge-secondary py-1 px-2 whitespace-normal break-all font-mono text-sm">
                                                @if($displayFile) <span class="text-xs text-primary me-2 font-bold opacity-75">[{{ $displayFile }}]</span> @endif
                                                {{ $displayKey }}
                                            </span>
                                        </td>
                                    @endif
                                    @if (in_array('english', $columns))
                                        <td class="px-4 py-2 text-sm">{{ $activeReference[$key] ?? '' }}</td>
                                    @endif
                                    @if (in_array('translation', $columns))
                                        <td class="px-4 py-2">
                                            @if ($editingKey === $key)
                                                <div class="relative w-full max-w-full" dir="{{ $isRtlLocale ? 'rtl' : 'ltr' }}">
                                                    <textarea wire:model="editingValue" wire:keydown.enter.prevent="saveTranslation" wire:keydown.escape="cancelEditing"
                                                        class="kt-textarea border-primary focus:ring-primary w-full pe-20 shadow-sm" style="min-height: 60px;" autofocus dir="auto"></textarea>
                                                    <div class="absolute bottom-2 end-2 flex gap-1 z-10">
                                                        <button wire:click="saveTranslation" class="kt-btn kt-btn-sm kt-btn-success text-white px-2 py-1 shadow-sm"><i class="fas fa-check"></i> {{ __('Save') }}</button>
                                                        <button wire:click="cancelEditing" class="kt-btn kt-btn-sm kt-btn-danger text-white px-2 py-1 shadow-sm"><i class="fas fa-times"></i></button>
                                                    </div>
                                                </div>
                                            @else
                                                @if($isSuperAdmin)
                                                <div wire:click="startEditing('{{ addslashes($key) }}')" title="{{ __('Click to edit') }}"
                                                    class="cursor-text text-sm rounded border border-transparent transition-colors hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-900 dark:text-white {{ $value ? '' : 'text-danger border-danger border-dashed p-2 bg-danger/5' }}"
                                                    style="white-space: pre-wrap; min-height: 24px; width:100%;" dir="auto">
                                                    {{ $value ?: __('Click to translate...') }}
                                                </div>
                                                @else
                                                <div class="text-sm text-gray-900 dark:text-white {{ $value ? '' : 'text-danger p-2' }}"
                                                    style="white-space: pre-wrap; min-height: 24px; width:100%;" dir="auto">
                                                    {{ $value ?: __('Not translated') }}
                                                </div>
                                                @endif
                                            @endif
                                        </td>
                                    @endif
                                    @if (in_array('status', $columns))
                                        <td class="px-4 py-2 text-center">
                                            @if ($value)
                                                <span class="kt-badge kt-badge-success kt-badge-outline justify-center py-1 px-3"><i class="fas fa-check me-1 text-success"></i> {{ __('Done') }}</span>
                                            @else
                                                <span class="kt-badge kt-badge-danger kt-badge-outline justify-center py-1 px-3 border-dashed">{{ __('Missing') }}</span>
                                            @endif
                                        </td>
                                    @endif
                                    @if (in_array('suggest', $columns))
                                        <td class="px-4 py-2 text-center">
                                            <button x-on:click="$wire.openSuggestionModal({!! json_encode($key) !!})" class="kt-btn kt-btn-sm kt-btn-light kt-btn-color-warning">
                                                <i class="fa-duotone fa-solid fa-lightbulb text-sm me-1"></i> {{ __('Suggest') }}
                                            </button>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-3 text-center text-gray-500">
                                        <div class="w-[90px] h-[90px] mx-auto my-4"><img src="{{ asset('assets/images/other/no-data.svg') }}" alt="no data"></div>
                                        <p class="text-red-600 font-semibold">{{ __('No translations found.') }}</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Standard Pagination --}}
        @if (isset($filteredTranslations) && $filteredTranslations->count() > 0)
            @include('includes.pagination', ['data' => $filteredTranslations])
        @endif
    </div>

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- SECTION 7: Modals --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    @include('translationmanager::livewire.partials.suggestion-modal', ['selectedLocale' => $selectedLocale, 'selectedFile' => $selectedFile, 'localePhotos' => $localePhotos, 'suggestionKey' => $suggestionKey, 'referenceTranslations' => $referenceTranslations, 'suggestionCurrentValue' => $suggestionCurrentValue, 'rtlLocales' => $rtlLocales])
    @include('translationmanager::livewire.partials.add-key-modal', ['selectedFile' => $selectedFile, 'rtlLocales' => $rtlLocales])
</div>
</div>
