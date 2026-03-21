<div class="px-5 py-5 pt-7 w-full min-w-0 overflow-x-hidden sm:overflow-visible tm-wrap" x-data>
    <style>
        /* === Translation Manager Dark Mode Color Fixes === */
        /* These are standard CSS rules (no Tailwind JIT needed) */

        /* All text inside the wrapper should be light in dark mode */
        [data-bs-theme="dark"] .tm-wrap { color: var(--bs-body-color); }

        /* History & Pending table text */
        [data-bs-theme="dark"] .tm-wrap .tm-suggested-value {
            color: #e2e8f0 !important;
        }
        [data-bs-theme="dark"] .tm-wrap .tm-key-text {
            color: #f1f5f9 !important;
        }
        [data-bs-theme="dark"] .tm-wrap .tm-muted-text {
            color: #94a3b8 !important;
        }

        /* Review boxes (Current Translation / Suggested Replacement) */
        [data-bs-theme="dark"] .tm-wrap .tm-review-box {
            background-color: #1e2130 !important;
            border-color: #3f4254 !important;
            color: #e2e8f0 !important;
        }
        [data-bs-theme="dark"] .tm-wrap .tm-review-badge {
            background-color: #1e2130 !important;
            border-color: #3f4254 !important;
            color: #94a3b8 !important;
        }
        [data-bs-theme="dark"] .tm-wrap .tm-review-box-success {
            background-color: rgba(80, 205, 137, 0.1) !important;
            border-color: var(--bs-success) !important;
            color: var(--bs-success) !important;
        }

        /* Modal inner content */
        [data-bs-theme="dark"] .tm-wrap .tm-info-box {
            background-color: #1e2130 !important;
            border-color: #3f4254 !important;
            color: #e2e8f0 !important;
        }

        /* General table border in dark */
        [data-bs-theme="dark"] .tm-wrap .tm-table-cell {
            border-color: #2d3148 !important;
        }
    </style>
    @php
        $flagMap = [
            'en' => 'us',
            'ar' => 'sa',
            'he' => 'il',
            'ja' => 'jp',
            'zh' => 'cn',
            'ko' => 'kr',
            'pt' => 'pt',
            'ur' => 'pk',
            'hi' => 'in',
            'ru' => 'ru',
            'tr' => 'tr',
            'de' => 'de',
            'es' => 'es',
            'fr' => 'fr',
            'it' => 'it'
        ];
    @endphp
    <!-- Main Header -->
    <div class="kt-card shadow-sm mb-5 mb-xl-10 w-full min-w-0">
        <div class="kt-card-header border-0 pt-6 px-6 flex justify-between items-center w-full min-w-0">
            <div class="card-title m-0">
                <h3 class="font-bold text-xl m-0 flex items-center">
                    <i class="fas fa-language text-2xl text-primary me-2"></i>
                    {{ __('sidebar.translation manager') }}
                </h3>
            </div>
            <div class="card-toolbar flex gap-3 flex-wrap">
                <input type="file" wire:model="importFile" class="hidden" id="importFile" accept=".csv">
                <label for="importFile" class="kt-btn kt-btn-sm kt-btn-light kt-btn-success font-bold me-2 cursor-pointer mb-0">
                    <i class="fas fa-file-import text-xl me-1"></i>
                    <span wire:loading.remove wire:target="importFile">{{ __('Import CSV') }}</span>
                    <span wire:loading wire:target="importFile">{{ __('Uploading...') }}</span>
                </label>
                <button wire:click="exportCSV" class="kt-btn kt-btn-sm kt-btn-light kt-btn-info font-bold me-4 mb-2 lg:mb-0">
                    <i class="fas fa-file-export text-xl me-1"></i> {{ __('Export CSV') }}
                </button>
                @if(in_array(getActiveUser()->role, ['superadmin', 'admin']))
                    <button type="button" wire:click="scanProjectMissingKeys" class="kt-btn kt-btn-sm kt-btn-light kt-btn-warning font-bold me-2 mb-2 lg:mb-0" wire:loading.attr="disabled">
                        <i class="fas fa-sync text-xl me-1" wire:loading.class="fa-spin" wire:target="scanProjectMissingKeys"></i> 
                        <span wire:loading.remove wire:target="scanProjectMissingKeys">{{ __('Auto-Scan Files') }}</span>
                        <span wire:loading wire:target="scanProjectMissingKeys">{{ __('Scanning...') }}</span>
                    </button>
                    <button type="button" @click="$dispatch('open-add-key-modal')" class="kt-btn kt-btn-sm kt-btn-primary font-bold me-2 mb-2 lg:mb-0">
                        <i class="fas fa-plus-circle text-xl me-1"></i> {{ __('Add New Text') }}
                    </button>
                @endif
                @if(in_array(getActiveUser()->role, ['superadmin', 'admin']))
                    <button wire:click="toggleReviewPanel" class="kt-btn kt-btn-sm font-bold {{ $showReviewPanel ? 'kt-btn-primary' : 'kt-btn-light kt-btn-primary' }}">
                        <i class="fas fa-clipboard-check text-xl me-1"></i> {{ __('Review Suggestions') }}
                        @if(count($pendingSuggestions) > 0)
                            <span class="kt-badge kt-badge-danger rounded-full ms-2 shrink-0">{{ count($pendingSuggestions) }}</span>
                        @endif
                    </button>
                @endif
            </div>
        </div>
        <div class="kt-card-body pt-0 pb-6 px-6 text-gray-500 text-sm">
            {{ __('Manage and edit translations for all languages from one place.') }}
        </div>
    </div>

    <!-- Admin Review Alert -->
    @if(!$showReviewPanel && count($pendingSuggestions) > 0 && in_array(getActiveUser()->role, ['superadmin', 'admin']))
    <div class="kt-card bg-warning-light/50 border border-warning border-dashed shadow-sm mb-5 mb-xl-10 w-full min-w-0 flex flex-col sm:flex-row items-center justify-between p-4 px-6">
        <div class="flex items-center gap-4 mb-3 sm:mb-0">
            <div class="w-12 h-12 bg-warning/20 rounded-full flex items-center justify-center shrink-0">
                <i class="fas fa-exclamation-triangle text-warning text-xl"></i>
            </div>
            <div>
                <h4 class="text-warning-800 dark:text-warning font-bold text-lg mb-0.5">{{ count($pendingSuggestions) }} {{ __('Pending Translation Suggestions') }}</h4>
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-0">{{ __('Community members have suggested improvements to the translations. Please review them.') }}</p>
            </div>
        </div>
        <button wire:click="toggleReviewPanel" class="kt-btn kt-btn-warning text-white font-bold shrink-0">
            <i class="fas fa-search me-2 text-white"></i> {{ __('Review Suggestions Now') }}
        </button>
    </div>
    @endif

    <!-- Admin Review Panel -->
    @if($showReviewPanel && in_array(getActiveUser()->role, ['superadmin', 'admin']))
    <div class="kt-card bg-info-light border border-info border-dashed shadow-sm mb-5 mb-xl-10 w-full min-w-0" x-data="{ tab: 'pending' }">
        <div class="kt-card-header border-0 pt-6">
            <h3 class="card-title flex items-start flex-col">
                <span class="card-label font-bold text-2xl mb-1 text-info flex items-center">
                    <i class="fas fa-inbox text-2xl text-info me-2"></i>{{ __('Translation Suggestions & History') }}
                </span>
                <span class="text-gray-500 mt-1 font-bold text-sm">{{ count($pendingSuggestions) }} {{ __('pending review') }}</span>
            </h3>
            <div class="card-toolbar flex gap-2">
                <button class="kt-btn kt-btn-sm font-bold" :class="tab === 'pending' ? 'kt-btn-primary' : 'kt-btn-light'" @click="tab = 'pending'">{{ __('Pending') }}</button>
                <button class="kt-btn kt-btn-sm font-bold" :class="tab === 'history' ? 'kt-btn-primary' : 'kt-btn-light'" @click="tab = 'history'">{{ __('History') }}</button>
            </div>
        </div>
        
        <!-- PENDING TAB -->
        <div class="kt-card-body pt-3 w-full min-w-0 overflow-x-auto" x-show="tab === 'pending'">
            @if(count($pendingSuggestions) > 0)
            <table class="kt-table" data-kt-datatable-table="true">
                <thead>
                    <tr>
                        <th scope="col" class="w-10 border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-center"><span class="kt-table-col"><span class="kt-table-col-label">#</span></span></th>
                        <th scope="col" style="min-width:150px;" class="border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 px-3"><span class="kt-table-col"><span class="kt-table-col-label">{{ __('Language') }}</span></span></th>
                        <th scope="col" style="min-width:200px;" class="border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 px-3"><span class="kt-table-col"><span class="kt-table-col-label">{{ __('Key & English') }}</span></span></th>
                        <th scope="col" style="min-width:250px;" class="border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 px-3"><span class="kt-table-col"><span class="kt-table-col-label">{{ __('Current & Suggestion') }}</span></span></th>
                        <th scope="col" class="text-center w-[150px] border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 px-3"><span class="kt-table-col"><span class="kt-table-col-label">{{ __('Actions') }}</span></span></th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 font-medium">
                    @foreach($pendingSuggestions as $index => $suggestion)
                    <tr>
                        <td class="text-center border border-gray-200 dark:border-gray-700">{{ $index + 1 }}</td>
                        <td class="border border-gray-200 dark:border-gray-700 px-3">
                            <span class="kt-badge kt-badge-light rounded-full px-3 py-1 font-bold border border-gray-300 dark:border-gray-600 flex items-center gap-2 w-fit">
                                @if(isset($localePhotos[$suggestion['locale']]))
                                    <img src="{{ Storage::url($localePhotos[$suggestion['locale']]) }}" alt="{{ $suggestion['locale'] }}" class="w-4 h-4 rounded-full object-cover">
                                @else
                                    <i class="fas fa-globe"></i>
                                @endif
                                {{ strtoupper($suggestion['locale']) }}
                            </span>
                        </td>
                        <td class="border border-gray-200 tm-table-cell px-3">
                            <div class="tm-key-text font-bold break-all mb-1" title="{{ $suggestion['key'] }}">{{ $suggestion['key'] }}</div>
                            <div class="tm-muted-text text-xs italic border-t border-dashed border-gray-300 pt-1">{{ $referenceTranslations[$suggestion['key']] ?? 'N/A' }}</div>
                        </td>
                        <td class="border border-gray-200 dark:border-gray-700 p-3">
                            <div class="flex flex-col gap-3">
                                <div class="relative mt-2">
                                    <span class="absolute -top-3 left-2 tm-review-badge border text-[10px] px-2 py-0.5 font-bold uppercase rounded-sm z-10 shadow-sm">{{ __('Current Translation') }}</span>
                                    <div class="tm-review-box border rounded p-3 pt-4 text-sm" dir="auto" title="{{ $suggestion['current_value'] ?: __('(empty)') }}">{{ $suggestion['current_value'] ?: __('(empty)') }}</div>
                                </div>
                                <div class="relative mt-2">
                                    <span class="absolute -top-3 left-2 tm-review-badge border border-success text-success text-[10px] px-2 py-0.5 font-bold uppercase rounded-sm z-10 shadow-sm">{{ __('Suggested Replacement') }}</span>
                                    <div class="tm-review-box-success border border-success rounded p-3 pt-4 text-sm font-bold" dir="auto" title="{{ $suggestion['suggested_value'] }}">{{ $suggestion['suggested_value'] }}</div>
                                </div>
                                @if($suggestion['reason'])
                                <div class="rounded p-2 text-xs border italic" style="background-color: rgba(var(--bs-warning-rgb), 0.1); border-color: rgba(var(--bs-warning-rgb), 0.4); color: var(--bs-warning);">
                                    <i class="fas fa-comment-dots me-1"></i> "{{ $suggestion['reason'] }}"
                                </div>
                                @endif
                            </div>
                        </td>
                        <td class="text-center align-middle border border-gray-200 dark:border-gray-700 px-3">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <input type="text" wire:model.defer="reviewNote" class="kt-input kt-input-sm w-full text-xs text-center mb-1" placeholder="{{ __('Add a note...') }}">
                                <div class="flex gap-2 w-full">
                                    <button wire:click="rejectSuggestion({{ $suggestion['id'] }})" class="kt-btn kt-btn-sm kt-btn-danger flex-1 font-bold p-1"><i class="fas fa-times me-0 text-white"></i></button>
                                    <button wire:click="approveSuggestion({{ $suggestion['id'] }})" class="kt-btn kt-btn-sm kt-btn-success flex-1 font-bold text-white p-1"><i class="fas fa-check me-0 text-white"></i></button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
                <div class="text-center py-10">
                    <div class="w-20 h-20 rounded-full bg-info-light dark:bg-info/10 mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-clipboard-check text-4xl text-info"></i>
                    </div>
                    <div class="text-xl font-bold text-gray-900 dark:text-white">{{ __('No pending suggestions!') }}</div>
                    <div class="text-sm text-gray-500 mt-2">{{ __('You are all caught up.') }}</div>
                </div>
            @endif
        </div>

        <!-- HISTORY TAB -->
        <div class="kt-card-body pt-3 w-full min-w-0 overflow-x-auto" x-show="tab === 'history'" x-cloak style="display: none;">
            @if(count($historySuggestions) > 0)
            <div class="flex justify-end mb-4">
                <button wire:click="clearSuggestionHistory" wire:confirm="{{ __('Are you sure you want to clear the entire suggestion history?') }}" class="kt-btn kt-btn-sm kt-btn-light kt-btn-danger font-bold">
                    <i class="fas fa-trash-alt me-1"></i> {{ __('Clear History') }}
                </button>
            </div>
            <table class="kt-table" data-kt-datatable-table="true">
                <thead>
                    <tr>
                        <th scope="col" class="w-10"><span class="kt-table-col"><span class="kt-table-col-label">#</span></span></th>
                        <th scope="col" style="min-width:100px;"><span class="kt-table-col"><span class="kt-table-col-label">{{ __('Locale / Key') }}</span></span></th>
                        <th scope="col" style="min-width:250px;"><span class="kt-table-col"><span class="kt-table-col-label">{{ __('Suggested Value') }}</span></span></th>
                        <th scope="col" class="text-end" style="min-width:150px;"><span class="kt-table-col"><span class="kt-table-col-label">{{ __('Status / Reviewer') }}</span></span></th>
                    </tr>
                </thead>
                <tbody class="font-medium">
                    @foreach($historySuggestions as $index => $history)
                    <tr>
                        <td class="tm-table-cell border border-gray-200 px-3">
                            <div class="flex flex-col gap-1">
                                <span class="kt-badge kt-badge-light kt-badge-primary rounded-full px-3 py-1 font-bold w-fit">{{ $history['locale'] }}</span>
                                <div class="tm-key-text font-bold truncate max-w-[200px]" title="{{ $history['key'] }}">{{ $history['key'] }}</div>
                            </div>
                        </td>
                        <td class="tm-table-cell">
                            <div class="tm-suggested-value text-sm font-bold truncate" dir="auto" title="{{ $history['suggested_value'] }}">{{ $history['suggested_value'] }}</div>
                            @if($history['review_note'])
                                <div class="mt-2 text-xs tm-muted-text italic"><i class="fas fa-reply w-3"></i> {{ $history['review_note'] }}</div>
                            @endif
                        </td>
                        <td class="text-end">
                            <span class="kt-badge kt-badge-md font-bold mb-1 {{ $history['status'] === 'approved' ? 'kt-badge-success' : 'kt-badge-danger' }}">
                                {{ ucfirst($history['status']) }}
                            </span>
                            @if($history['status'] === 'rejected')
                                <div class="mt-2 block">
                                    <button wire:click="approveSuggestion({{ $history['id'] }})" class="kt-btn kt-btn-sm kt-btn-outline kt-btn-success px-2 py-1 text-xs">
                                        <i class="fas fa-undo me-1"></i> {{ __('Re-Approve') }}
                                    </button>
                                </div>
                            @endif
                            <div class="text-xs tm-muted-text mt-1">{{ \Carbon\Carbon::parse($history['reviewed_at'])->diffForHumans() }}</div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
                <div class="text-center py-10">
                    <div class="w-20 h-20 rounded-full bg-gray-100 dark:bg-gray-800 mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-history text-4xl text-gray-400"></i>
                    </div>
                    <div class="text-xl font-bold text-gray-900 dark:text-white">{{ __('No history yet!') }}</div>
                    <div class="text-sm text-gray-500 mt-2">{{ __('Processed translation suggestions will appear here indefinitely.') }}</div>
                </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Language Progress Overview -->
    <div class="kt-card shadow-sm mb-5 w-full min-w-0 overflow-hidden relative">
        <div class="kt-card-header py-5 px-6">
            <h3 class="kt-card-title font-bold text-lg">
                <i class="fas fa-chart-pie text-primary me-2"></i> {{ __('Translation Progress') }} 
                <span class="text-xs text-gray-500 font-normal ms-2">
                    @if(str_starts_with($selectedFile, 'global::'))
                        global / {{ str_replace('global::', '', $selectedFile) }}.php
                    @elseif(str_contains($selectedFile, '::'))
                        @php $parts = explode('::', $selectedFile); @endphp
                        Module: {{ $parts[0] }} / {{ $parts[1] }}.php
                    @else
                        {{ basename($selectedFile) }}
                    @endif
                </span>
            </h3>
        </div>
        <div class="kt-card-body p-6 w-full min-w-0">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 lg:gap-6">
                @foreach($localeStats as $code => $stat)
                <div class="w-full min-w-0">
                    <div wire:click="$set('selectedLocale', '{{ $code }}')" class="kt-card cursor-pointer border w-full min-w-0 hover:shadow-lg transition-all h-full {{ $selectedLocale === $code ? 'border-primary shadow-sm bg-primary-light dark:bg-primary/10' : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900' }}">
                        <div class="kt-card-body p-5 h-full w-full min-w-0 flex flex-col justify-between">
                            <div class="flex justify-between items-center mb-4 min-w-0 w-full">
                                <div class="flex items-center min-w-0">
                                    <span class="w-8 h-8 rounded-full overflow-hidden me-3 flex items-center justify-center border border-gray-100 dark:border-gray-700 shadow-sm shrink-0">
                                        <img src="{{ !empty($stat['photo']) ? (str_contains($stat['photo'], '/') ? asset('storage/' . $stat['photo']) : asset('assets/media/flags/' . $stat['photo'])) : asset('assets/media/flags/' . ($flagMap[$code] ?? $code) . '.svg') }}" alt="" class="w-full h-full object-cover">
                                    </span>
                                    <div class="text-lg font-bold truncate {{ $selectedLocale === $code ? 'text-primary' : 'text-gray-900 dark:text-gray-100' }}">{{ $stat['name'] }}</div>
                                </div>
                                <div class="kt-badge {{ $selectedLocale === $code ? 'kt-badge-primary' : 'kt-badge-outline' }} rounded-full text-xs font-bold shrink-0">{{ strtoupper($code) }}</div>
                            </div>
                            <div class="flex flex-col w-full min-w-0">
                                <div class="flex justify-between text-gray-400 font-bold text-xs mb-2 min-w-0 w-full">
                                    <span class="truncate pr-2">{{ $stat['translated'] }} / {{ $stat['total'] }}</span>
                                    <span class="font-bold shrink-0 {{ $stat['percentage'] >= 80 ? 'text-success' : ($stat['percentage'] >= 40 ? 'text-warning' : 'text-danger') }}">{{ $stat['percentage'] }}%</span>
                                </div>
                                <div class="h-2 bg-gray-100 dark:bg-gray-800 w-full mb-4 rounded overflow-hidden">
                                    <div class="h-full {{ $stat['percentage'] >= 80 ? 'bg-success' : ($stat['percentage'] >= 40 ? 'bg-warning' : 'bg-danger') }}" style="width: {{ $stat['percentage'] }}%"></div>
                                </div>
                            </div>
                            @if($stat['missing'] > 0)
                                <div class="flex items-center bg-danger-light rounded p-2 px-3 justify-center w-full min-w-0 truncate">
                                    <i class="fas fa-exclamation-triangle text-danger text-sm me-2 shrink-0"></i>
                                    <span class="font-bold text-danger text-xs truncate">{{ $stat['missing'] }} {{ __('missing') }}</span>
                                </div>
                            @else
                                <div class="flex items-center bg-success-light rounded p-2 px-3 justify-center w-full min-w-0 truncate">
                                    <i class="fas fa-check-circle text-success text-sm me-2 shrink-0"></i>
                                    <span class="font-bold text-success text-xs truncate">{{ __('Complete!') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Main Editor -->
    <div class="kt-card w-full min-w-0 space-y-5 shadow-sm mb-0 dark:bg-gray-900" x-data="{
        init() {
            setTimeout(() => this.updateWidth(), 200);
            window.addEventListener('resize', () => { setTimeout(() => this.updateWidth(), 100); });
            const observer = new MutationObserver(() => this.updateWidth());
            if (this.$refs.actualTable) observer.observe(this.$refs.actualTable, { childList: true, subtree: true });
        },
        syncTop(e) { this.$refs.bottomScroll.scrollLeft = e.target.scrollLeft; },
        syncBottom(e) { this.$refs.topScroll.scrollLeft = e.target.scrollLeft; },
        updateWidth() {
            if(this.$refs.actualTable && this.$refs.dummyContent) {
                this.$refs.dummyContent.style.width = this.$refs.actualTable.scrollWidth + 'px';
            }
        }
    }">
        <div class="kt-card-header min-h-16 py-5 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4 border-b border-gray-200 dark:border-gray-800">
            <div class="flex items-center relative w-full lg:w-auto">
                <i class="lucide lucide-search absolute left-4 text-gray-400 w-5 h-5"></i>
                <input type="text" wire:model.live.debounce.300ms="search" class="kt-input w-full sm:w-64 pl-12 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200" placeholder="{{ __('Search translations...') }}">
            </div>
            <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
                <!-- Theme Switcher -->
                <div class="flex items-center gap-2" data-kt-dropdown="true" data-kt-dropdown-trigger="click">
                    <button class="kt-btn kt-btn-icon kt-btn-light kt-btn-clear" data-kt-dropdown-toggle="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sun flex dark:hidden opacity-95 text-gray-600 w-5 h-5" aria-hidden="true"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2"></path><path d="M12 20v2"></path><path d="m4.93 4.93 1.41 1.41"></path><path d="m17.66 17.66 1.41 1.41"></path><path d="M2 12h2"></path><path d="M20 12h2"></path><path d="m6.34 17.66-1.41 1.41"></path><path d="m19.07 4.93-1.41 1.41"></path></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-moon hidden dark:flex opacity-95 text-gray-400 w-5 h-5" aria-hidden="true"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path></svg>
                    </button>
                    <div class="kt-dropdown-menu" data-kt-dropdown-menu="true">
                        <ul class="kt-dropdown-menu-sub w-40" data-kt-dropdown-menu="true">
                            <li>
                                <button class="kt-dropdown-menu-link kt-theme-switch-light:bg-accent" data-kt-dropdown-dismiss="true" data-kt-theme-switch-set="light">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sun w-4 h-4" aria-hidden="true"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2"></path><path d="M12 20v2"></path><path d="m4.93 4.93 1.41 1.41"></path><path d="m17.66 17.66 1.41 1.41"></path><path d="M2 12h2"></path><path d="M20 12h2"></path><path d="m6.34 17.66-1.41 1.41"></path><path d="m19.07 4.93-1.41 1.41"></path></svg>Light
                                </button>
                            </li>
                            <li>
                                <button class="kt-dropdown-menu-link kt-theme-switch-dark:bg-accent" data-kt-dropdown-dismiss="true" data-kt-theme-switch-set="dark">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-moon w-4 h-4" aria-hidden="true"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path></svg>Dark
                                </button>
                            </li>
                            <li>
                                <button class="kt-dropdown-menu-link kt-theme-switch-system:bg-accent" data-kt-dropdown-dismiss="true" data-kt-theme-switch-set="system">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-monitor w-4 h-4" aria-hidden="true"><rect width="20" height="14" x="2" y="3" rx="2"></rect><line x1="8" x2="16" y1="21" y2="21"></line><line x1="12" x2="12" y1="17" y2="21"></line></svg>System
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <span class="text-gray-500 font-bold text-xs uppercase">{{ __('File:') }}</span>
                    <select wire:model.live="selectedFile" class="kt-select w-full sm:w-48 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200">
                        @foreach($availableFiles as $file)
                            @php
                                $displayLabel = $file . '.php';
                                if (str_starts_with($file, 'global::')) {
                                    $displayLabel = 'global / ' . str_replace('global::', '', $file) . '.php';
                                } elseif (str_contains($file, '::')) {
                                    $parts = explode('::', $file);
                                    if(count($parts) === 2){
                                        $displayLabel = 'Module: ' . $parts[0] . ' / ' . $parts[1] . '.php';
                                    }
                                }
                            @endphp
                            <option value="{{ $file }}">{{ $displayLabel }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <span class="text-gray-500 font-bold text-xs uppercase">{{ __('Lang:') }}</span>
                    <select wire:model.live="selectedLocale" class="kt-select w-full sm:w-48 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200">
                        @foreach($availableLocales as $code => $name)
                            <option value="{{ $code }}">
                                {{ $code === 'en' ? '🇺🇸' : ($code === 'ar' ? '🇸🇦' : '🌐') }} {{ $name }} ({{ strtoupper($code) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center gap-2 flex-wrap w-full sm:w-auto mt-3 sm:mt-0 p-1 bg-gray-100 dark:bg-gray-800 rounded border border-gray-200 dark:border-gray-700">
                    <button wire:click="$set('filterMode', 'all')" 
                            class="kt-btn kt-btn-sm font-bold border-0 transition-colors {{ $filterMode === 'all' ? 'shadow-sm' : 'hover:opacity-80' }}"
                            style="{{ $filterMode === 'all' ? 'background-color: #2563eb !important; color: #ffffff !important;' : 'background-color: #dbeafe !important; color: #1d4ed8 !important;' }}">
                        {{ __('All') }} <span class="ms-1 text-xs opacity-75 hidden sm:inline">({{ $stats['total'] ?? 0 }})</span>
                    </button>
                    
                    <button wire:click="$set('filterMode', 'missing')" 
                            class="kt-btn kt-btn-sm font-bold border-0 transition-colors {{ $filterMode === 'missing' ? 'shadow-sm' : 'hover:opacity-80' }}"
                            style="{{ $filterMode === 'missing' ? 'background-color: #dc2626 !important; color: #ffffff !important;' : 'background-color: #fee2e2 !important; color: #b91c1c !important;' }}">
                        {{ __('Missing') }} <span class="ms-1 text-xs opacity-75 hidden sm:inline">({{ $stats['missing'] ?? 0 }})</span>
                    </button>
                    
                    <button wire:click="$set('filterMode', 'translated')" 
                            class="kt-btn kt-btn-sm font-bold border-0 transition-colors {{ $filterMode === 'translated' ? 'shadow-sm' : 'hover:opacity-80' }}"
                            style="{{ $filterMode === 'translated' ? 'background-color: #16a34a !important; color: #ffffff !important;' : 'background-color: #dcfce7 !important; color: #15803d !important;' }}">
                        {{ __('Done') }} <span class="ms-1 text-xs opacity-75 hidden sm:inline">({{ $stats['translated'] ?? 0 }})</span>
                    </button>
                    
                    <div class="w-px h-6 bg-gray-300 dark:bg-gray-600 mx-1 hidden md:block"></div>
                    
                    <button wire:click="$toggle('showKeyColumn')" 
                            class="kt-btn kt-btn-sm font-bold border-0 transition-colors {{ $showKeyColumn ? 'shadow-sm' : 'hover:opacity-80' }}"
                            style="{{ $showKeyColumn ? 'background-color: #1f2937 !important; color: #ffffff !important;' : 'background-color: #f3f4f6 !important; color: #374151 !important;' }}">
                        <i class="fas fa-key text-sm {{ $showKeyColumn ? 'text-white' : '' }}"></i> {{ __('Key') }}
                    </button>
                </div>
            </div>
        </div>
        
        <div class="kt-card-table w-full min-w-0" data-kt-datatable="true">
            <div wire:loading wire:target="selectedFile, selectedLocale" class="w-full flex justify-center py-12">
                <div class="flex flex-col items-center gap-3">
                    <div class="w-10 h-10 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
                    <span class="font-bold text-gray-500">{{ __('Loading translations...') }}</span>
                </div>
            </div>

            <div wire:loading.remove wire:target="selectedFile, selectedLocale" class="w-full relative min-w-0">
                <div class="kt-table-wrapper kt-scrollable">
                    <table class="kt-table border-collapse border border-gray-200 dark:border-gray-700 w-full" data-kt-datatable-table="true">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                                @if($showKeyColumn)
                                <th scope="col" style="min-width:150px;" class="border-e border-gray-200 dark:border-gray-700 p-3">
                                    <span class="kt-table-col"><span class="kt-table-col-label font-bold">{{ __('Key') }}</span></span>
                                </th>
                                @endif
                                <th scope="col" style="min-width:250px;" class="border-e border-gray-200 dark:border-gray-700 p-3">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label flex items-center gap-2 font-bold">
                                            <div class="kt-avatar size-5">
                                                <div class="kt-avatar-image">
                                                    <img src="{{ !empty($localePhotos['en']) ? (str_contains($localePhotos['en'], '/') ? asset('storage/' . $localePhotos['en']) : asset('assets/media/flags/' . $localePhotos['en'])) : asset('assets/media/flags/' . ($flagMap['en'] ?? 'us') . '.svg') }}" alt="">
                                                </div>
                                            </div>
                                            {{ __('English Reference') }}
                                        </span>
                                    </span>
                                </th>
                                <th scope="col" style="min-width:250px;" class="border-e border-gray-200 dark:border-gray-700 p-3">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label flex items-center gap-2 font-bold">
                                            <div class="kt-avatar size-5">
                                                <div class="kt-avatar-image">
                                                    <img src="{{ !empty($localePhotos[$selectedLocale]) ? (str_contains($localePhotos[$selectedLocale], '/') ? asset('storage/' . $localePhotos[$selectedLocale]) : asset('assets/media/flags/' . $localePhotos[$selectedLocale])) : asset('assets/media/flags/' . ($flagMap[$selectedLocale] ?? $selectedLocale) . '.svg') }}" alt="">
                                                </div>
                                            </div>
                                            {{ $availableLocales[$selectedLocale] ?? $selectedLocale }}
                                        </span>
                                    </span>
                                </th>
                                <th scope="col" style="min-width:100px;" class="p-3 text-center">
                                    <span class="kt-table-col justify-center"><span class="kt-table-col-label font-bold w-full text-center">{{ __('Status') }}</span></span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($filteredTranslations as $key => $value)
                                <tr class="border-b border-gray-200 dark:border-gray-700 {{ $value === '' || $value === null ? 'bg-danger-light/20 dark:bg-danger/10' : '' }} transition-colors">
                                    @if($showKeyColumn)
                                    <td class="border-e border-gray-200 dark:border-gray-700 p-3 align-top">
                                        <span class="kt-badge kt-badge-light kt-badge-secondary py-1 px-2 whitespace-normal break-all font-mono" dir="ltr">{{ $key }}</span>
                                    </td>
                                    @endif
                                    <td class="border-e border-gray-200 dark:border-gray-700 p-3 align-top">
                                        <div class="text-foreground text-sm" style="line-height: 1.5;">{{ $referenceTranslations[$key] ?? '' }}</div>
                                    </td>
                                    <td class="border-e border-gray-200 dark:border-gray-700 p-3 align-top">
                                        @if($editingKey === $key)
                                            <div class="relative" dir="{{ in_array($selectedLocale, ['ar', 'he', 'ur', 'fa', 'ku']) ? 'rtl' : 'ltr' }}">
                                                <textarea wire:model="editingValue" wire:keydown.enter.prevent="saveTranslation" wire:keydown.escape="cancelEditing" class="kt-textarea border-primary focus:ring-primary w-full pe-20 shadow-sm" style="min-height: 60px;" autofocus dir="auto"></textarea>
                                                <div class="absolute bottom-2 end-2 flex gap-1 z-10">
                                                    <button wire:click="saveTranslation" class="kt-btn kt-btn-sm kt-btn-success text-white px-2 py-1"><i class="fas fa-check"></i> {{ __('Save') }}</button>
                                                    <button wire:click="cancelEditing" class="kt-btn kt-btn-sm kt-btn-danger text-white px-2 py-1"><i class="fas fa-times"></i></button>
                                                </div>
                                            </div>
                                        @else
                                            <div wire:click="startEditing('{{ addslashes($key) }}')" class="cursor-text p-3 text-sm rounded border border-transparent transition-colors {{ $value ? 'text-foreground hover:bg-gray-50 dark:hover:bg-gray-800' : 'text-danger border-danger border-dashed bg-danger-light/5 hover:bg-danger-light/20' }}" style="white-space: pre-wrap; min-height: 40px;" dir="auto">
                                                {{ $value ?: __('Click to translate...') }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="p-3 text-center align-middle">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            @if($value)
                                                <span class="kt-badge kt-badge-success kt-badge-outline w-full justify-center py-2"><i class="fas fa-check me-1 text-success"></i> {{ __('Done') }}</span>
                                            @else
                                                <span class="kt-badge kt-badge-danger kt-badge-outline w-full justify-center py-2 border-dashed">{{ __('Missing') }}</span>
                                            @endif
                                            <button wire:click="openSuggestionModal('{{ addslashes($key) }}')" class="kt-btn kt-btn-sm kt-btn-light kt-btn-color-warning w-full mt-1" data-kt-tooltip="true" data-kt-tooltip-placement="top">
                                                <i class="fas fa-lightbulb"></i> {{ __('Suggest') }}
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center p-10 text-muted-foreground border-b border-gray-200 dark:border-gray-700">
                                        <i class="fas fa-inbox text-3xl mb-3 text-muted"></i><br>
                                        {{ __('No translations found.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!--begin:pagination-->
        <div class="kt-datatable-toolbar border-t border-gray-200 dark:border-gray-800">
            <div class="kt-datatable-length">
                {{ __('Show') }}
                <select wire:model.live="perPage" class="kt-select kt-select-sm w-16" data-kt-datatable-size="true">
                    <option value="15">15</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="250">250</option>
                    <option value="500">500</option>
                </select>
                {{ __('per page') }}
            </div>

            <div class="kt-datatable-info">
                <span data-kt-datatable-info="true">
                    @if($filteredTranslations->hasPages())
                        {{ $filteredTranslations->firstItem() ?? 0 }} - {{ $filteredTranslations->lastItem() ?? 0 }} {{ __('of') }} {{ $filteredTranslations->total() }}
                    @endif
                </span>

                @if($filteredTranslations->hasPages())
                <div class="kt-datatable-pagination flex gap-1 items-center">
                    {{-- Previous Page --}}
                    <button wire:click="previousPage" class="kt-btn kt-btn-icon kt-btn-light kt-btn-sm" @if($filteredTranslations->onFirstPage()) disabled @endif>
                        <i class="fas fa-chevron-left text-xs"></i>
                    </button>

                    {{-- First Page --}}
                    <button wire:click="gotoPage(1)" wire:key="tm-page-1" class="kt-btn kt-btn-sm {{ $filteredTranslations->currentPage() == 1 ? 'kt-btn-primary text-white font-bold' : 'kt-btn-light text-gray-600' }}">
                        1
                    </button>

                    {{-- Left Dots --}}
                    @if($filteredTranslations->currentPage() > 4)
                        <div class="kt-btn kt-btn-icon kt-btn-light kt-btn-sm disabled">
                            <i class="fas fa-ellipsis-h text-xs"></i>
                        </div>
                    @endif

                    {{-- Middle Pages --}}
                    @php
                        $start = max(2, $filteredTranslations->currentPage() - 2);
                        $end = min($filteredTranslations->lastPage() - 1, $filteredTranslations->currentPage() + 2);
                        if ($filteredTranslations->currentPage() <= 3) {
                            $end = min(6, $filteredTranslations->lastPage() - 1);
                        }
                        if ($filteredTranslations->currentPage() >= $filteredTranslations->lastPage() - 2) {
                            $start = max($filteredTranslations->lastPage() - 5, 2);
                        }
                    @endphp

                    @for($i = $start; $i <= $end; $i++)
                        <button wire:click="gotoPage({{ $i }})" wire:key="tm-page-{{ $i }}" class="kt-btn kt-btn-sm {{ $i == $filteredTranslations->currentPage() ? 'kt-btn-primary text-white font-bold' : 'kt-btn-light text-gray-600' }}">
                            {{ $i }}
                        </button>
                    @endfor

                    {{-- Right Dots --}}
                    @if($filteredTranslations->currentPage() < $filteredTranslations->lastPage() - 3)
                        <div class="kt-btn kt-btn-icon kt-btn-light kt-btn-sm disabled">
                            <i class="fas fa-ellipsis-h text-xs"></i>
                        </div>
                    @endif

                    {{-- Last Page --}}
                    @if($filteredTranslations->lastPage() > 1)
                        <button wire:click="gotoPage({{ $filteredTranslations->lastPage() }})" wire:key="tm-page-last" class="kt-btn kt-btn-sm {{ $filteredTranslations->currentPage() == $filteredTranslations->lastPage() ? 'kt-btn-primary text-white font-bold' : 'kt-btn-light text-gray-600' }}">
                            {{ $filteredTranslations->lastPage() }}
                        </button>
                    @endif

                    {{-- Next Page --}}
                    <button wire:click="nextPage" class="kt-btn kt-btn-icon kt-btn-light kt-btn-sm" @if(!$filteredTranslations->hasMorePages()) disabled @endif>
                        <i class="fas fa-chevron-right text-xs"></i>
                    </button>
                </div>
                @endif
            </div>
        </div>
        <!--end:pagination-->
    <!-- Suggestion Modal -->
    <div x-data="{ show: @entangle('showSuggestionModal') }">
        <template x-teleport="body">
            <div x-show="show" x-cloak
                 style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; z-index: 100000; background-color: rgba(0,0,0,0.5); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; direction: {{ in_array(app()->getLocale(), ['ar', 'he', 'fa', 'ur']) ? 'rtl' : 'ltr' }};"
                 @click.self="show = false">
                
                <!-- Modal Content -->
                <div class="kt-card relative w-[95%] max-w-[650px] rounded-xl shadow-2xl flex flex-col text-start m-4" 
                     @click.stop
                     x-show="show" x-transition>
                    <div class="kt-card-header flex items-center justify-between border-b p-4 shrink-0">
                        <h3 class="text-lg font-bold flex items-center gap-2 text-gray-900 dark:text-white">
                            <i class="fas fa-lightbulb text-warning"></i>
                            {{ __('Suggest Translation Correction') }}
                        </h3>
                        <button type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 w-8 h-8 rounded-full flex items-center justify-center hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors" @click="show = false">
                            <i class="lucide lucide-x w-5 h-5"></i>
                        </button>
                    </div>

                <div class="p-4 overflow-y-auto space-y-5 flex-1">
                    <div class="text-gray-500 dark:text-gray-400 text-sm">{{ __('Help improve our translations by suggesting a better alternative.') }}</div>
                    
                    <div class="flex items-center kt-bg-light rounded p-4 border">
                        <span class="kt-badge kt-badge-light rounded-full px-3 py-1 font-bold border border-gray-300 dark:border-gray-600 flex items-center gap-2 w-fit me-3">
                            @if(isset($localePhotos[$selectedLocale]))
                                <img src="{{ Storage::url($localePhotos[$selectedLocale]) }}" alt="{{ $selectedLocale }}" class="w-4 h-4 rounded-full object-cover">
                            @else
                                <i class="fas fa-globe"></i>
                            @endif
                            {{ strtoupper($selectedLocale) }}
                        </span>
                        <code class="text-gray-900 dark:text-gray-100 font-bold text-sm" dir="ltr">{{ $selectedFile }}.{{ $suggestionKey }}</code>
                    </div>

                    <div class="space-y-2">
                        <label class="flex items-center text-sm font-bold text-gray-900 dark:text-gray-100">
                            <span>{{ __('English (Reference)') }}</span>
                        </label>
                        <div class="p-4 kt-bg-light border rounded font-medium text-sm">{{ $referenceTranslations[$suggestionKey] ?? '-' }}</div>
                    </div>

                    <div class="space-y-2">
                        <label class="flex items-center text-sm font-bold text-gray-900 dark:text-gray-100">
                            <span>{{ __('Current Translation') }}</span>
                        </label>
                        <div class="p-4 kt-bg-light border rounded font-medium text-sm" dir="auto">{{ $suggestionCurrentValue ?: __('(empty - not translated yet)') }}</div>
                    </div>

                    <div class="space-y-2">
                        <label class="flex items-center text-sm font-bold text-gray-900 dark:text-gray-100">
                            <span class="required">{{ __('Your Suggested Translation') }}</span>
                        </label>
                        <input type="text" wire:model="suggestionValue" class="kt-input border-gray-300 w-full" dir="auto" placeholder="{{ __('Enter the correct translation here...') }}" wire:keydown.enter="submitSuggestion">
                        @error('suggestionValue') <div class="text-red-500 text-sm font-medium">{{ $message }}</div> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="flex items-center text-sm font-bold text-gray-900 dark:text-gray-100">{{ __('Reason (Optional)') }}</label>
                        <textarea wire:model="suggestionReason" class="kt-textarea border-gray-300 w-full" rows="3" placeholder="{{ __('Why do you think the current translation is incorrect?') }}"></textarea>
                    </div>
                </div>

                    <div class="kt-card-footer flex items-center justify-end gap-3 border-t p-4 rounded-b-xl shrink-0">
                        <button type="button" @click="show = false" class="kt-btn kt-btn-outline">{{ __('Cancel') }}</button>
                        <button type="button" wire:click="submitSuggestion" @click="setTimeout(() => show = false, 500)" class="kt-btn kt-btn-warning text-white">
                            <i class="lucide lucide-send me-2 w-4 h-4 text-white"></i>{{ __('Submit Suggestion') }}
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Add New Key Modal (Super Admin) -->
    <div x-data="{ showAddKeyModal: false }" @open-add-key-modal.window="showAddKeyModal = true">
        <template x-teleport="body">
            <div x-show="showAddKeyModal" x-cloak
                 style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; z-index: 100000; background-color: rgba(0,0,0,0.5); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; direction: {{ in_array(app()->getLocale(), ['ar', 'he', 'fa', 'ur']) ? 'rtl' : 'ltr' }};"
                 @click.self="showAddKeyModal = false">
                
                <!-- Modal Content -->
                <div class="kt-card relative w-[95%] max-w-[650px] rounded-xl shadow-2xl flex flex-col text-start m-4"
                     @click.stop
                     x-show="showAddKeyModal"
                     x-transition>
                    <div class="kt-card-header flex items-center justify-between border-b p-4 shrink-0">
                    <h3 class="text-lg font-bold flex items-center gap-2">
                        <i class="fas fa-plus-circle text-primary"></i>
                        {{ __('Add New Translation Text manually') }}
                    </h3>
                    <button type="button" class="text-muted w-8 h-8 rounded-full flex items-center justify-center hover:bg-gray-100 transition-colors" @click="showAddKeyModal = false">
                        <i class="lucide lucide-x w-5 h-5"></i>
                    </button>
                </div>

                <div class="p-4 overflow-y-auto space-y-5 flex-1">
                    <div class="text-gray-500 dark:text-gray-400 text-sm">{{ __('Create a brand new text string to be translated across all languages.') }}</div>
                    
                    <div class="flex items-center tm-info-box rounded p-4 border">
                        <span class="kt-badge kt-badge-primary me-3 font-bold">{{ __('FILE') }}</span>
                        <strong class="text-sm" dir="ltr">
                        @if(str_starts_with($selectedFile, 'global::'))
                            global / {{ str_replace('global::', '', $selectedFile) }}.php
                        @elseif(str_contains($selectedFile, '::'))
                            @php $parts = explode('::', $selectedFile); @endphp
                            Module: {{ $parts[0] }} / {{ $parts[1] }}.php
                        @else
                            {{ basename($selectedFile) }}.php
                        @endif
                        </strong>
                        <span class="ms-2 text-xs text-muted">({{ __('Texts will be added to this file') }})</span>
                    </div>

                    <div class="space-y-2">
                        <label class="flex items-center text-sm font-bold">
                            <span class="required">{{ __('Text Code (Key)') }}</span>
                            <i class="lucide lucide-info ms-2 text-muted w-4 h-4 cursor-pointer" data-kt-tooltip="true" data-kt-tooltip-placement="top">
                                <span data-kt-tooltip-content="true" class="kt-tooltip">{{ __('Use English words with underscores, no spaces. E.g: welcome_message, checkout_button') }}</span>
                            </i>
                        </label>
                        <input type="text" wire:model.defer="newKeyName" class="kt-input border-gray-300 w-full" placeholder="{{ __('e.g., welcome_message') }}" dir="ltr">
                        @error('newKeyName') <div class="text-red-500 text-sm font-medium">{{ $message }}</div> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="flex items-center text-sm font-bold">
                            <span class="required">{{ __('English (Reference Text)') }}</span>
                        </label>
                        <textarea wire:model.defer="newKeyValue" class="kt-textarea border-gray-300 w-full" rows="3" placeholder="{{ __('e.g., Welcome to our new feature!') }}" dir="ltr"></textarea>
                        @error('newKeyValue') <div class="text-red-500 text-sm font-medium">{{ $message }}</div> @enderror
                    </div>

                    <div class="kt-alert kt-alert-primary mt-4">
                        <div class="kt-alert-icon"><i class="lucide lucide-info text-primary"></i></div>
                        <div class="flex flex-col">
                            <div class="kt-alert-title font-bold text-primary">{{ __('Note:') }}</div>
                            <span class="text-sm text-gray-900 dark:text-white">{{ __('Once saved, this new text will immediately appear in the translation table as "Missing" so you can translate it.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-gray-200 dark:border-gray-800 p-4 bg-gray-50/50 dark:bg-gray-900/50 rounded-b-xl">
                    <button type="button" class="kt-btn kt-btn-outline" @click="showAddKeyModal = false">{{ __('Cancel') }}</button>
                    <button type="button" class="kt-btn kt-btn-primary" wire:click="saveNewKey" @click="setTimeout(() => showAddKeyModal = false, 500)">
                        <i class="lucide lucide-save me-2 w-4 h-4 text-white"></i><span class="text-white font-bold">{{ __('Save New Text') }}</span>
                    </button>
                </div>
            </div>
        </template>
    </div>
</div>
