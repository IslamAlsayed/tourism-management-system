<div>
<div class="px-5 py-5 pt-7 w-full min-w-0 overflow-x-hidden sm:overflow-visible text-gray-900 dark:text-gray-100" x-data>
    <style>
        .dropdown-item-hover {
            transition: background-color 0.2s, color 0.2s;
        }

        .dropdown-item-hover:hover {
            background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
            color: var(--bs-primary) !important;
        }

        .dropdown-item-hover:hover span,
        .dropdown-item-hover:hover i {
            color: var(--bs-primary) !important;
        }

        /* ── Modal & Dropdown Theme Styles ── */
        .tm-modal-card {
            background-color: #ffffff !important;
            color: #181C32 !important;
        }

        .tm-modal-card .tm-label {
            color: #181C32 !important;
            font-weight: 700 !important;
        }

        .tm-modal-card .tm-text {
            color: #3F4254 !important;
        }

        .tm-modal-card .tm-text-muted {
            color: #A1A5B7 !important;
        }

        .tm-modal-card .tm-input {
            background-color: #ffffff !important;
            color: #181C32 !important;
            border-color: #E1E3EA !important;
        }

        .tm-modal-card .tm-input::placeholder {
            color: #A1A5B7 !important;
        }

        .tm-modal-card .tm-dashed-box {
            background-color: #F9F9F9 !important;
            color: #3F4254 !important;
            border-color: #E1E3EA !important;
        }

        .tm-modal-card .card-header {
            border-color: #E1E3EA !important;
        }

        .tm-modal-card .card-footer {
            border-color: #E1E3EA !important;
        }

        .tm-dropdown {
            background-color: #ffffff !important;
            border-color: #E1E3EA !important;
        }

        /* ── Dark Mode Overrides ── */
        [data-bs-theme="dark"] .tm-modal-card {
            background-color: #1E1E2D !important;
            color: #CDCFDA !important;
        }

        [data-bs-theme="dark"] .tm-modal-card .tm-label {
            color: #FFFFFF !important;
        }

        [data-bs-theme="dark"] .tm-modal-card .tm-text {
            color: #CDCFDA !important;
        }

        [data-bs-theme="dark"] .tm-modal-card .tm-text-muted {
            color: #7E8299 !important;
        }

        [data-bs-theme="dark"] .tm-modal-card .tm-input {
            background-color: #151521 !important;
            color: #CDCFDA !important;
            border-color: #2D2D43 !important;
        }

        [data-bs-theme="dark"] .tm-modal-card .tm-input::placeholder {
            color: #565674 !important;
        }

        [data-bs-theme="dark"] .tm-modal-card .tm-dashed-box {
            background-color: #151521 !important;
            color: #CDCFDA !important;
            border-color: #2D2D43 !important;
        }

        [data-bs-theme="dark"] .tm-modal-card .card-header {
            border-color: #2D2D43 !important;
        }

        [data-bs-theme="dark"] .tm-modal-card .card-footer {
            border-color: #2D2D43 !important;
        }

        [data-bs-theme="dark"] .tm-dropdown {
            background-color: #7f7f7f !important;
            border-color: #2D2D43 !important;
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
            'it' => 'it',
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
                <label for="importFile"
                    class="kt-btn kt-btn-sm kt-btn-light kt-btn-success font-bold me-2 cursor-pointer mb-0">
                    <i class="fas fa-file-import text-xl me-1"></i>
                    <span wire:loading.remove wire:target="importFile">{{ __('Import CSV') }}</span>
                    <span wire:loading wire:target="importFile">{{ __('Uploading...') }}</span>
                </label>
                <div class="relative me-4 mb-2 lg:mb-0" x-data="{ exportOpen: false }" @click.outside="exportOpen = false">
                    <button type="button" @click="exportOpen = !exportOpen"
                        class="kt-btn kt-btn-sm kt-btn-light kt-btn-info font-bold flex items-center gap-2">
                        <i class="fas fa-file-export text-xl"></i>
                        <span>{{ __('Export') }}</span>
                        <i class="ki-outline ki-down text-xs"></i>
                    </button>
                    <div x-show="exportOpen" x-transition x-cloak
                        class="absolute start-0 mt-2 z-50 w-52 py-2 tm-dropdown dark:!bg-[#7f7f7f] rounded-lg"
                        style="box-shadow: 0px 4px 12px rgba(0,0,0,0.15);">
                        <button wire:click="exportCSV" @click="exportOpen = false"
                            class="w-full text-start px-4 py-2.5 text-sm flex items-center gap-3 dropdown-item-hover"
                            style="color: var(--bs-body-color);">
                            <i class="fas fa-file-csv text-green-600 text-lg"></i> {{ __('Export CSV') }}
                        </button>
                        <button wire:click="exportSelectedExcel" @click="exportOpen = false"
                            class="w-full text-start px-4 py-2.5 text-sm flex items-center gap-3 dropdown-item-hover"
                            style="color: var(--bs-body-color);">
                            <i class="fas fa-file-excel text-emerald-600 text-lg"></i> {{ __('Export Excel') }}
                        </button>
                        <button wire:click="exportSelectedPDF" @click="exportOpen = false"
                            class="w-full text-start px-4 py-2.5 text-sm flex items-center gap-3 dropdown-item-hover"
                            style="color: var(--bs-body-color);">
                            <i class="fas fa-file-pdf text-red-600 text-lg"></i> {{ __('Export PDF') }}
                        </button>
                        <button wire:click="exportSelectedJSON" @click="exportOpen = false"
                            class="w-full text-start px-4 py-2.5 text-sm flex items-center gap-3 dropdown-item-hover"
                            style="color: var(--bs-body-color);">
                            <i class="fas fa-code text-blue-600 text-lg"></i> {{ __('Export JSON') }}
                        </button>
                        <button wire:click="exportSelectedTXT" @click="exportOpen = false"
                            class="w-full text-start px-4 py-2.5 text-sm flex items-center gap-3 dropdown-item-hover"
                            style="color: var(--bs-body-color);">
                            <i class="fas fa-file-alt text-gray-600 text-lg"></i> {{ __('Export TXT') }}
                        </button>
                    </div>
                </div>
                @if (in_array(getActiveUser()->role, ['superadmin', 'admin']))
                    <button type="button" wire:click="scanProjectMissingKeys"
                        class="kt-btn kt-btn-sm kt-btn-light kt-btn-warning font-bold me-2 mb-2 lg:mb-0"
                        wire:loading.attr="disabled">
                        <i class="fas fa-sync text-xl me-1" wire:loading.class="fa-spin"
                            wire:target="scanProjectMissingKeys"></i>
                        <span wire:loading.remove
                            wire:target="scanProjectMissingKeys">{{ __('Auto-Scan Files') }}</span>
                        <span wire:loading wire:target="scanProjectMissingKeys">{{ __('Scanning...') }}</span>
                    </button>
                    <button type="button" @click="$dispatch('open-add-key-modal')"
                        class="kt-btn kt-btn-sm kt-btn-primary font-bold me-2 mb-2 lg:mb-0">
                        <i class="fas fa-plus-circle text-xl me-1"></i> {{ __('Add New Text') }}
                    </button>
                @endif
                @if (in_array(getActiveUser()->role, ['superadmin', 'admin']))
                    @php
                        $pendingTotalCount = \Modules\TranslationManager\Entities\TranslationSuggestion::where(
                            'status',
                            'pending',
                        )->count();
                    @endphp
                    <button wire:click="toggleReviewPanel"
                        class="kt-btn kt-btn-sm font-bold {{ $showReviewPanel ? 'kt-btn-primary' : 'kt-btn-light kt-btn-primary' }}">
                        <i class="fas fa-clipboard-check text-xl me-1"></i> {{ __('Review Suggestions') }}
                        @if ($pendingTotalCount > 0)
                            <span
                                class="kt-badge kt-badge-danger rounded-full ms-2 shrink-0">{{ $pendingTotalCount }}</span>
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
    @if (!$showReviewPanel && $pendingTotalCount > 0 && in_array(getActiveUser()->role, ['superadmin', 'admin']))
        <div
            class="kt-card bg-warning-light/50 border border-warning border-dashed shadow-sm mb-5 mb-xl-10 w-full min-w-0 flex flex-col sm:flex-row items-center justify-between p-4 px-6">
            <div class="flex items-center gap-4 mb-3 sm:mb-0">
                <div class="w-12 h-12 bg-warning/20 rounded-full flex items-center justify-center shrink-0">
                    <i class="fas fa-exclamation-triangle text-warning text-xl"></i>
                </div>
                <div>
                    <h4 class="text-warning-800 dark:text-warning font-bold text-lg mb-0.5">{{ $pendingTotalCount }}
                        {{ __('Pending Translation Suggestions') }}</h4>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-0">
                        {{ __('Community members have suggested improvements to the translations. Please review them.') }}
                    </p>
                </div>
            </div>
            <button wire:click="toggleReviewPanel" class="kt-btn kt-btn-warning text-white font-bold shrink-0">
                <i class="fas fa-search me-2 text-white"></i> {{ __('Review Suggestions Now') }}
            </button>
        </div>
    @endif

    <!-- Admin Review Panel -->
    @if ($showReviewPanel && in_array(getActiveUser()->role, ['superadmin', 'admin']))
        <div class="kt-card bg-info-light border border-info border-dashed shadow-sm mb-5 mb-xl-10 w-full min-w-0"
            x-data="{ tab: 'pending' }">
            <div class="kt-card-header border-0 pt-6">
                <h3 class="card-title flex items-start flex-col">
                    <span class="card-label font-bold text-2xl mb-1 text-info flex items-center">
                        <i
                            class="fas fa-inbox text-2xl text-info me-2"></i>{{ __('Translation Suggestions & History') }}
                    </span>
                    <span class="text-gray-500 mt-1 font-bold text-sm">{{ count($pendingSuggestions) }}
                        {{ __('pending review') }}</span>
                </h3>
                <div class="card-toolbar flex gap-2">
                    <button class="kt-btn kt-btn-sm font-bold"
                        :class="tab === 'pending' ? 'kt-btn-primary' : 'kt-btn-light'"
                        @click="tab = 'pending'">{{ __('Pending') }}</button>
                    <button class="kt-btn kt-btn-sm font-bold"
                        :class="tab === 'history' ? 'kt-btn-primary' : 'kt-btn-light'"
                        @click="tab = 'history'">{{ __('History') }}</button>
                </div>
            </div>

            <!-- PENDING TAB -->
            <div class="table-wrapper w-full overflow-x-auto custom-scrollbar" x-data="{
                init() {
                        setTimeout(() => this.updateWidth(), 200);
                    },
                    updateWidth() {}
            }"
                x-show="tab === 'pending'">
                @if (count($pendingSuggestions) > 0)
                    <table class="kt-table table-auto text-nowrap w-full" data-kt-datatable-table="true">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                                <th scope="col"
                                    class="px-4 py-3 text-start text-lg font-extrabold text-[#181C32] dark:text-white uppercase tracking-wider w-10">
                                    #</th>
                                <th scope="col"
                                    class="px-4 py-3 text-start text-lg font-extrabold text-[#181C32] dark:text-white uppercase tracking-wider min-w-[150px]">
                                    {{ __('Language') }}</th>
                                <th scope="col"
                                    class="px-4 py-3 text-start text-lg font-extrabold text-[#181C32] dark:text-white uppercase tracking-wider min-w-[200px]">
                                    {{ __('Key & English') }}</th>
                                <th scope="col"
                                    class="px-4 py-3 text-start text-lg font-extrabold text-[#181C32] dark:text-white uppercase tracking-wider min-w-[250px]">
                                    {{ __('Current Translation') }}</th>
                                <th scope="col"
                                    class="px-4 py-3 text-start text-lg font-extrabold text-[#181C32] dark:text-white uppercase tracking-wider min-w-[250px]">
                                    {{ __('Suggested Replacement') }}</th>
                                <th scope="col"
                                    class="px-4 py-3 text-center text-lg font-extrabold text-[#181C32] dark:text-white uppercase tracking-wider w-[150px]">
                                    {{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 font-medium">
                            @foreach ($pendingSuggestions as $index => $suggestion)
                                <tr
                                    class="hover:bg-primary/10 transition-colors border-b border-gray-200 dark:border-gray-700">
                                    <td class="px-4 py-3 align-middle text-center">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 align-middle">
                                        <span
                                            class="kt-badge kt-badge-light rounded-full px-3 py-1 font-bold border border-gray-300 dark:border-gray-600 flex items-center gap-2 w-fit">
                                            @if (isset($localePhotos[$suggestion['locale']]))
                                                <img src="{{ Storage::url($localePhotos[$suggestion['locale']]) }}"
                                                    alt="{{ $suggestion['locale'] }}"
                                                    class="w-4 h-4 rounded-full object-cover">
                                            @else
                                                <i class="fas fa-globe"></i>
                                            @endif
                                            {{ strtoupper($suggestion['locale']) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 align-middle">
                                        <div class="font-bold break-all mb-1 text-gray-900 dark:text-gray-100"
                                            title="{{ $suggestion['key'] }}">{{ $suggestion['key'] }}</div>
                                        <div class="text-xs italic pt-1 text-gray-500 dark:text-gray-400">
                                            {{ $referenceTranslations[$suggestion['key']] ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-4 py-3 align-top whitespace-normal break-words">
                                        <div class="border rounded p-3 text-sm"
                                            style="background-color: var(--tw-gray-50); border-color: var(--tw-gray-200); color: var(--bs-body-color);"
                                            dir="auto"
                                            title="{{ $suggestion['current_value'] ?: __('(empty)') }}">
                                            {{ $suggestion['current_value'] ?: __('(empty)') }}</div>
                                    </td>
                                    <td class="px-4 py-3 align-top whitespace-normal break-words">
                                        <div class="border rounded p-3 text-sm font-bold bg-success-light/30 border-success text-success"
                                            dir="auto" title="{{ $suggestion['suggested_value'] }}">
                                            <input type="text"
                                                wire:model.defer="editingSuggestedValues.{{ $suggestion['id'] }}"
                                                class="kt-input kt-input-sm border border-transparent hover:border-success-light focus:border-success bg-transparent w-full font-bold text-success">
                                        </div>
                                        @if ($suggestion['reason'])
                                            <div class="rounded p-2 text-xs border italic"
                                                style="background-color: rgba(var(--bs-warning-rgb), 0.1); border-color: rgba(var(--bs-warning-rgb), 0.4); color: var(--bs-warning);">
                                                <i class="fas fa-comment-dots me-1"></i> "{{ $suggestion['reason'] }}"
                                            </div>
                                        @endif
            </div>
            </td>
            <td class="px-4 py-3 text-center align-middle">
                <div class="flex flex-col items-center justify-center gap-2">
                    <input type="text" wire:model.defer="reviewNote"
                        class="kt-input kt-input-sm w-full text-xs text-center mb-1"
                        placeholder="{{ __('Add a note...') }}">
                    <div class="flex gap-2 w-full">
                        <button wire:click="rejectSuggestion({{ $suggestion['id'] }})"
                            class="kt-btn kt-btn-sm kt-btn-danger flex-1 font-bold p-1"><i
                                class="fas fa-times me-0 text-white"></i></button>
                        <button wire:click="approveSuggestion({{ $suggestion['id'] }})"
                            class="kt-btn kt-btn-sm kt-btn-success flex-1 font-bold text-white p-1"><i
                                class="fas fa-check me-0 text-white"></i></button>
                    </div>
                </div>
            </td>
            </tr>
    @endforeach
    </tbody>
    </table>
@else
    <div class="text-center py-10">
        <div
            class="w-20 h-20 rounded-full bg-info-light dark:bg-info/10 mx-auto mb-4 flex items-center justify-center">
            <i class="fas fa-clipboard-check text-4xl text-info"></i>
        </div>
        <div class="text-xl font-bold text-gray-900 dark:text-white">{{ __('No pending suggestions!') }}</div>
        <div class="text-sm text-gray-500 mt-2">{{ __('You are all caught up.') }}</div>
    </div>
    @endif
</div>

<!-- HISTORY TAB -->
<div class="kt-card-body pt-3 w-full min-w-0 overflow-x-auto" x-show="tab === 'history'" x-cloak
    style="display: none;">
    @if (count($historySuggestions) > 0)
        <div class="flex justify-end mb-4">
            <button wire:click="clearSuggestionHistory"
                wire:confirm="{{ __('Are you sure you want to clear the entire suggestion history?') }}"
                class="kt-btn kt-btn-sm kt-btn-light kt-btn-danger font-bold">
                <i class="fas fa-trash-alt me-1"></i> {{ __('Clear History') }}
            </button>
        </div>
        <div class="table-wrapper w-full overflow-x-auto custom-scrollbar">
            <table class="kt-table table-auto text-nowrap w-full" data-kt-datatable-table="true">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                        <th scope="col"
                            class="px-4 py-3 text-start text-lg font-extrabold text-[#181C32] dark:text-white uppercase tracking-wider w-10">
                            #</th>
                        <th scope="col"
                            class="px-4 py-3 text-start text-lg font-extrabold text-[#181C32] dark:text-white uppercase tracking-wider min-w-[100px]">
                            {{ __('Locale / Key') }}</th>
                        <th scope="col"
                            class="px-4 py-3 text-start text-lg font-extrabold text-[#181C32] dark:text-white uppercase tracking-wider min-w-[250px]">
                            {{ __('Suggested Value') }}</th>
                        <th scope="col"
                            class="px-4 py-3 text-end text-lg font-extrabold text-[#181C32] dark:text-white uppercase tracking-wider min-w-[150px]">
                            {{ __('Status / Reviewer') }}</th>
                    </tr>
                </thead>
                <tbody class="font-medium">
                    @foreach ($historySuggestions as $index => $history)
                        <tr
                            class="hover:bg-primary/10 transition-colors border-b border-gray-200 dark:border-gray-700">
                            <td class="px-4 py-3 align-middle">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 align-middle">
                                <div class="flex flex-col gap-2">
                                    <div class="flex items-center gap-2">
                                        @if (isset($localePhotos[$history['locale']]))
                                            <img src="{{ asset('storage/' . $localePhotos[$history['locale']]) }}"
                                                alt="{{ $history['locale'] }}"
                                                class="w-5 h-5 rounded-full object-cover shadow-sm bg-white border border-gray-200 dark:border-gray-600">
                                        @else
                                            <div
                                                class="w-5 h-5 rounded-full bg-gray-200 dark:bg-gray-700 font-bold text-[10px] flex items-center justify-center text-gray-500 uppercase">
                                                {{ $history['locale'] }}</div>
                                        @endif
                                        <span
                                            class="font-bold text-gray-800 dark:text-gray-200">{{ $availableLocales[$history['locale']] ?? strtoupper($history['locale']) }}</span>
                                    </div>
                                    <div class="text-xs truncate max-w-[200px] text-gray-600 dark:text-gray-400 font-mono bg-gray-100 dark:bg-gray-800/50 px-2 py-1 rounded w-fit"
                                        title="{{ $history['key'] }}">{{ $history['key'] }}</div>
                                </div>
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <div class="text-sm font-bold truncate text-gray-800 dark:text-gray-200"
                                    dir="auto" title="{{ $history['suggested_value'] }}">
                                    {{ $history['suggested_value'] }}</div>
                                @if ($history['review_note'])
                                    <div class="mt-2 text-xs italic text-gray-500 dark:text-gray-400"><i
                                            class="fas fa-reply w-3"></i> {{ $history['review_note'] }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-end align-middle">
                                <span
                                    class="kt-badge kt-badge-md font-bold mb-1 {{ $history['status'] === 'approved' ? 'kt-badge-success' : 'kt-badge-danger' }}">
                                    {{ ucfirst($history['status']) }}
                                </span>
                                @if ($history['status'] === 'rejected')
                                    <div class="mt-2 block">
                                        <button wire:click="approveSuggestion({{ $history['id'] }})"
                                            class="kt-btn kt-btn-sm kt-btn-outline kt-btn-success px-2 py-1 text-xs">
                                            <i class="fas fa-undo me-1"></i> {{ __('Re-Approve') }}
                                        </button>
                                    </div>
                                @endif
                                <div class="text-xs mt-1 text-gray-500 dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($history['reviewed_at'])->diffForHumans() }}</div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-10">
            <div
                class="w-20 h-20 rounded-full bg-gray-100 dark:bg-gray-800 mx-auto mb-4 flex items-center justify-center">
                <i class="fas fa-history text-4xl text-gray-400"></i>
            </div>
            <div class="text-xl font-bold text-gray-900 dark:text-white">{{ __('No history yet!') }}</div>
            <div class="text-sm text-gray-500 mt-2">
                {{ __('Processed translation suggestions will appear here indefinitely.') }}</div>
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
        </h3>
    </div>
    <div class="kt-card-body p-6 w-full min-w-0">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 lg:gap-6">
            @foreach ($localeStats as $code => $stat)
                <div class="w-full min-w-0">
                    <div wire:click="$set('selectedLocale', '{{ $code }}')"
                        class="kt-card cursor-pointer border w-full min-w-0 hover:shadow-lg transition-all h-full {{ $selectedLocale === $code ? 'border-primary shadow-sm' : '' }}"
                        style="{{ $selectedLocale === $code ? 'background-color: rgba(var(--bs-primary-rgb), 0.1);' : 'background-color: var(--bs-card-bg); border-color: var(--bs-border-color);' }}">
                        <div class="kt-card-body p-4 lg:p-5 h-full w-full min-w-0 flex flex-col">
                            <div class="flex justify-between items-center mb-4 min-w-0 w-full shrink-0">
                                <div class="flex items-center min-w-0">
                                    <span
                                        class="w-8 h-8 rounded-full overflow-hidden me-3 flex items-center justify-center border border-gray-100 dark:border-gray-700 shadow-sm shrink-0">
                                        <img src="{{ !empty($stat['photo']) ? (str_contains($stat['photo'], '/') ? asset('storage/' . $stat['photo']) : asset('assets/media/flags/' . $stat['photo'])) : asset('assets/media/flags/' . ($flagMap[$code] ?? $code) . '.svg') }}"
                                            alt="" class="w-full h-full object-cover">
                                    </span>
                                    <div class="text-lg font-bold truncate {{ $selectedLocale === $code ? 'text-primary' : '' }}"
                                        style="{{ $selectedLocale === $code ? '' : 'color: var(--bs-heading-color);' }}">
                                        {{ $stat['name'] }}</div>
                                </div>
                                <div
                                    class="kt-badge {{ $selectedLocale === $code ? 'kt-badge-primary' : 'kt-badge-outline' }} rounded-full text-xs font-bold shrink-0">
                                    {{ strtoupper($code) }}</div>
                            </div>

                            <div class="flex flex-col w-full min-w-0 gap-3 flex-grow mb-5">
                                @php
                                    $themeColors = [
                                        ['bg' => 'bg-primary', 'text' => 'text-primary', 'hex' => ''],
                                        ['bg' => 'bg-success', 'text' => 'text-success', 'hex' => ''],
                                        ['bg' => 'bg-info', 'text' => 'text-info', 'hex' => ''],
                                        ['bg' => 'bg-warning', 'text' => 'text-warning', 'hex' => ''],
                                        ['bg' => 'bg-danger', 'text' => 'text-danger', 'hex' => ''],
                                        ['bg' => 'bg-primary', 'text' => 'text-primary', 'hex' => ''],
                                        ['bg' => 'bg-success', 'text' => 'text-success', 'hex' => ''],
                                        ['bg' => 'bg-info', 'text' => 'text-info', 'hex' => ''],
                                    ];
                                @endphp
                                @foreach ($stat['files'] as $index => $fileStat)
                                    @php
                                        $theme = $themeColors[$index % count($themeColors)];
                                        $bgClass = $theme['bg'];
                                        $textClass = $theme['text'];
                                        $hexColor = $theme['hex'];

                                        $textStyle = $hexColor ? "color: {$hexColor} !important;" : '';
                                        $bgStyle = $hexColor
                                            ? "background-color: {$hexColor} !important; width: {$fileStat['percentage']}%;"
                                            : "width: {$fileStat['percentage']}%;";
                                    @endphp
                                    <div class="flex flex-col w-full min-w-0" title="{{ $fileStat['name'] }}">
                                        <div class="flex justify-between font-bold text-[10px] mb-1 min-w-0 w-full"
                                            style="color: var(--bs-heading-color);">
                                            <span class="truncate pr-2">{{ $fileStat['name'] }}
                                                ({{ $fileStat['translated'] }}/{{ $fileStat['total'] }})</span>
                                            <span class="font-bold shrink-0 {{ $textClass }}"
                                                style="{{ $textStyle }}">{{ $fileStat['percentage'] }}%</span>
                                        </div>
                                        <div
                                            class="h-1.5 w-full rounded overflow-hidden bg-gray-200 dark:bg-gray-700 shadow-inner">
                                            <div class="h-full {{ $bgClass }}" style="{{ $bgStyle }}">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="shrink-0 mt-auto">
                                @if ($stat['missing'] > 0)
                                    <div
                                        class="flex items-center bg-danger-light rounded p-2 px-3 justify-center w-full min-w-0 truncate">
                                        <i class="fas fa-exclamation-triangle text-danger text-sm me-2 shrink-0"></i>
                                        <span class="font-bold text-danger text-xs truncate">{{ $stat['missing'] }}
                                            {{ __('missing') }}</span>
                                    </div>
                                @else
                                    <div
                                        class="flex items-center bg-success-light rounded p-2 px-3 justify-center w-full min-w-0 truncate">
                                        <i class="fas fa-check-circle text-success text-sm me-2 shrink-0"></i>
                                        <span
                                            class="font-bold text-success text-xs truncate">{{ __('Complete!') }}</span>
                                    </div>
                                @endif
                            </div>
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
            if (this.$refs.actualTable && this.$refs.dummyContent) {
                this.$refs.dummyContent.style.width = this.$refs.actualTable.scrollWidth + 'px';
            }
        }
}">
    <!-- Unified Dropdown Filters Section -->
    <div class="kt-card-body pt-6 pb-6 px-6 relative z-10 border-b border-gray-200 dark:border-gray-800">
        <div class="rounded-lg p-5 border mx-auto flex flex-col md:flex-row flex-wrap gap-4 items-end w-full"
            style="background-color: var(--bs-gray-100); border-color: var(--bs-border-color);">
            <div class="w-full md:flex-1 min-w-0 md:min-w-[250px] relative" x-data="{ fileOpen: false }" @click.outside="fileOpen = false">
                <span class="font-bold text-xs uppercase mb-2 block"
                    style="color: var(--bs-text-muted);">{{ __('File') }}</span>
                <button type="button" @click="fileOpen = !fileOpen"
                    class="w-full flex items-center justify-between text-start px-3 py-2 border rounded-lg focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary font-medium shadow-sm transition-colors"
                    style="background-color: var(--bs-body-bg); color: var(--bs-body-color); border-color: var(--bs-border-color);">
                    @php
                        $selectedFileLabel = $selectedFile . '.php';
                        if (str_starts_with($selectedFile, 'global::')) {
                            $selectedFileLabel = 'global / ' . str_replace('global::', '', $selectedFile) . '.php';
                        } elseif (str_contains($selectedFile, '::')) {
                            $parts = explode('::', $selectedFile);
                            if (count($parts) === 2) {
                                $selectedFileLabel = 'Module: ' . $parts[0] . ' / ' . $parts[1] . '.php';
                            }
                        }
                    @endphp
                    <span class="truncate font-bold" style="color: var(--bs-heading-color);"><i
                            class="fas fa-file-code me-2 text-primary opacity-50"></i> {{ $selectedFileLabel }}</span>
                    <i class="ki-outline ki-down transition-transform duration-200"
                        :class="fileOpen ? 'rotate-180' : ''" style="color: var(--bs-text-muted);"></i>
                </button>

                <div x-show="fileOpen" x-transition x-cloak
                    class="absolute z-50 w-full mt-1 max-h-60 overflow-y-auto custom-scrollbar py-2 tm-dropdown dark:!bg-[#7f7f7f] rounded-lg"
                    style="box-shadow: 0px 4px 12px rgba(0,0,0,0.15);">
                    @foreach ($availableFiles as $file)
                        @php
                            $displayLabel = $file . '.php';
                            if (str_starts_with($file, 'global::')) {
                                $displayLabel = 'global / ' . str_replace('global::', '', $file) . '.php';
                            } elseif (str_contains($file, '::')) {
                                $parts = explode('::', $file);
                                if (count($parts) === 2) {
                                    $displayLabel = 'Module: ' . $parts[0] . ' / ' . $parts[1] . '.php';
                                }
                            }
                        @endphp
                        <button type="button" wire:click="$set('selectedFile', '{{ $file }}')"
                            @click="fileOpen = false"
                            class="w-full text-start px-3 py-2 flex items-center gap-3 transition-colors dropdown-item-hover"
                            style="{{ $selectedFile === $file ? 'background-color: rgba(var(--bs-primary-rgb), 0.1); color: var(--bs-primary);' : 'color: var(--bs-body-color);' }}">
                            <span class="truncate font-bold"
                                style="{{ $selectedFile === $file ? 'color: var(--bs-primary);' : 'color: var(--bs-body-color);' }}">{{ $displayLabel }}</span>
                            @if ($selectedFile === $file)
                                <i class="fas fa-check ms-auto text-primary text-sm"></i>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>
            <div class="w-full md:flex-1 min-w-0 md:min-w-[200px] relative" x-data="{ langOpen: false }" @click.outside="langOpen = false">
                <span class="font-bold text-xs uppercase mb-2 block"
                    style="color: var(--bs-text-muted);">{{ __('Language') }}</span>
                <button type="button" @click="langOpen = !langOpen"
                    class="w-full flex items-center justify-between text-start px-3 py-2 border rounded-lg focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary font-medium shadow-sm transition-colors"
                    style="background-color: var(--bs-body-bg); color: var(--bs-body-color); border-color: var(--bs-border-color);">
                    <div class="flex items-center gap-2 truncate">
                        @if (isset($localePhotos[$selectedLocale]))
                            <img src="{{ !empty($localePhotos[$selectedLocale]) ? (str_contains($localePhotos[$selectedLocale], '/') ? asset('storage/' . $localePhotos[$selectedLocale]) : asset('assets/media/flags/' . $localePhotos[$selectedLocale])) : asset('assets/media/flags/' . ($flagMap[$selectedLocale] ?? $selectedLocale) . '.svg') }}"
                                alt="" class="w-5 h-5 rounded-sm object-cover shadow-sm border"
                                style="border-color: var(--bs-border-color);">
                        @else
                            <span class="w-5 h-5 flex items-center justify-center rounded-sm text-[10px] font-bold"
                                style="background-color: var(--bs-gray-200); color: var(--bs-gray-700);">{{ strtoupper($selectedLocale) }}</span>
                        @endif
                        <span class="truncate"
                            style="color: var(--bs-heading-color);">{{ $availableLocales[$selectedLocale] ?? strtoupper($selectedLocale) }}
                            ({{ strtoupper($selectedLocale) }})</span>
                    </div>
                    <i class="ki-outline ki-down transition-transform duration-200"
                        :class="langOpen ? 'rotate-180' : ''" style="color: var(--bs-text-muted);"></i>
                </button>

                <div x-show="langOpen" x-transition x-cloak
                    class="absolute z-50 w-full mt-1 rounded-lg shadow-2xl py-1 max-h-60 overflow-y-auto custom-scrollbar tm-dropdown dark:!bg-[#7f7f7f]"
                    style="border: 1px solid var(--bs-border-color);">
                    @foreach ($availableLocales as $code => $name)
                        <button type="button" wire:click="$set('selectedLocale', '{{ $code }}')"
                            @click="langOpen = false"
                            class="w-full text-start px-3 py-2 flex items-center gap-3 transition-colors dropdown-item-hover"
                            style="{{ $selectedLocale === $code ? 'background-color: rgba(var(--bs-primary-rgb), 0.1); color: var(--bs-primary);' : 'color: var(--bs-body-color);' }}">
                            @if (isset($localePhotos[$code]))
                                <img src="{{ !empty($localePhotos[$code]) ? (str_contains($localePhotos[$code], '/') ? asset('storage/' . $localePhotos[$code]) : asset('assets/media/flags/' . $localePhotos[$code])) : asset('assets/media/flags/' . ($flagMap[$code] ?? $code) . '.svg') }}"
                                    alt="" class="w-5 h-5 rounded-sm object-cover shadow-sm border"
                                    style="border-color: var(--bs-border-color);">
                            @else
                                <span class="w-5 h-5 flex items-center justify-center rounded-sm text-[10px] font-bold"
                                    style="background-color: var(--bs-gray-200); color: var(--bs-gray-700);">{{ strtoupper($code) }}</span>
                            @endif
                            <span class="truncate font-medium"
                                style="{{ $selectedLocale === $code ? 'color: var(--bs-primary);' : 'color: var(--bs-body-color);' }}">{{ $name }}
                                ({{ strtoupper($code) }})</span>
                            @if ($selectedLocale === $code)
                                <i class="fas fa-check ms-auto text-primary text-sm"></i>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-3 flex-wrap w-full lg:w-auto">
        <button wire:click="$set('filterMode', 'all')"
            class="kt-btn kt-btn-lg font-bold flex items-center justify-center gap-2 transition-all shadow-sm {{ $filterMode === 'all' ? 'kt-btn-primary' : 'kt-btn-light' }}">
            <i class="fas fa-list text-xl"></i><span>{{ __('All') }}</span><span
                class="ms-1 text-normal font-normal opacity-75">({{ $stats['total'] ?? 0 }})</span>
        </button>

        <button wire:click="$set('filterMode', 'missing')"
            class="kt-btn kt-btn-lg font-bold flex items-center justify-center gap-2 transition-all shadow-sm {{ $filterMode === 'missing' ? 'kt-btn-danger' : 'kt-btn-light' }}">
            <i class="fas fa-exclamation-triangle text-xl"></i><span>{{ __('Missing') }}</span><span
                class="ms-1 text-normal font-normal opacity-75">({{ $stats['missing'] ?? 0 }})</span>
        </button>

        <button wire:click="$set('filterMode', 'translated')"
            class="kt-btn kt-btn-lg font-bold flex items-center justify-center gap-2 transition-all shadow-sm {{ $filterMode === 'translated' ? 'kt-btn-success' : 'kt-btn-light' }}">
            <i class="fas fa-check-circle text-xl"></i><span>{{ __('Done') }}</span><span
                class="ms-1 text-normal font-normal opacity-75">({{ $stats['translated'] ?? 0 }})</span>
        </button>
    </div>
</div>
</div>

<div class="kt-card-header border-0 pt-6 px-6 w-full min-w-0">
    <div class="flex-wrap gap-2 p-2">
        <div class="w-full flex flex-wrap justify-between items-start gap-4">
            {{-- Info text --}}
            <div class="pagination-showing">
                <p class="text-sm text-gray-600 dark:text-gray-400 p-2">
                    {{ __('main.showing') }}
                    <strong class="text-primary">{{ $filteredTranslations->count() }}</strong>
                    {{ __('main.of') }} {{ count($translations ?? []) }}
                    {{ __('main.translations') ?? 'Translations' }}
                </p>
            </div>

            {{-- Toolbar: Columns + Export + Search --}}
            <div class="flex flex-wrap gap-2 items-center">

                {{-- Column Picker --}}
                @if (isset($filteredTranslations) && $filteredTranslations->count() > 0 && isset($allColumns))
                    @include('components.columns', [
                        'allColumns' => $allColumns ?? [],
                        'pendingColumns' => $pendingColumns ?? [],
                        'selectedIds' => $selectedIds ?? [],
                        'hasCustomColumns' => false,
                        'hideExport' => true,
                    ])
                @endif


                {{-- Search Input --}}
                <div class="flex flex-wrap gap-2 lg:gap-5 w-full md:w-auto flex-1 justify-end">
                    <div class="flex items-stretch ms-0 md:ms-2 mt-2 md:mt-0 w-full min-w-[280px] xl:min-w-[450px] rounded-lg border focus-within:border-primary overflow-hidden transition-all"
                        style="background-color: var(--bs-body-bg); border-color: var(--bs-border-color);">
                        <div class="relative flex-grow flex items-center bg-transparent">
                            <div class="ps-3 pointer-events-none" style="color: var(--bs-text-muted);">
                                <i class="ki-outline ki-magnifier text-lg"></i>
                            </div>
                            <input type="text" wire:model.live="search" id="search" @keydown.enter.prevent=""
                                class="w-full border-0 text-sm ps-2 pe-10 py-2.5 outline-none focus:outline-none focus:ring-0 focus:border-transparent min-w-0"
                                placeholder="{{ __('main.search_in') }} {{ __('main.translations') ?? 'Translations' }}..."
                                autocomplete="off"
                                style="color: var(--bs-body-color) !important; box-shadow: none !important; border: none !important; outline: none !important; background-color: transparent !important;" />
                            @if (isset($search) && $search !== '')
                                <div class="absolute end-2 top-1/2 -translate-y-1/2 flex items-center justify-center p-1.5 bg-transparent cursor-pointer group transition-colors z-[10]"
                                    wire:click="$set('search', '')" title="{{ __('main.clear_search') }}">
                                    <i class="ki-outline ki-cross text-base font-bold group-hover:text-red-500"
                                        style="color: var(--bs-text-muted);"></i>
                                </div>
                            @endif
                            <div class="search-load absolute end-8 top-1/2 -translate-y-1/2 pointer-events-none"
                                wire:loading wire:target="search">
                                <span class="spinner-border spinner-border-sm text-primary opacity-50"
                                    role="status"></span>
                            </div>
                        </div>
                        <button type="button"
                            class="bg-primary flex items-center justify-center text-white px-4 hover:bg-blue-700 transition-colors shrink-0 border-0 outline-none ring-0">
                            <i class="ki-outline ki-magnifier text-lg"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="kt-card-body py-4 px-6 w-full min-w-0">

    <div wire:loading wire:target="selectedFile, selectedLocale" class="w-full flex justify-center py-12">
        <div class="flex flex-col items-center gap-3">
            <div class="w-10 h-10 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
            <span class="font-bold text-gray-500">{{ __('Loading translations...') }}</span>
        </div>
    </div>

    <div wire:loading.remove wire:target="selectedFile, selectedLocale" class="w-full relative min-w-0">
        <div class="table-wrapper w-full overflow-x-auto custom-scrollbar" id="tableWrapper" x-ref="bottomScroll"
            @scroll="syncBottom">
            <table x-ref="actualTable" class="kt-table table-auto text-nowrap" id="translation_data_table">
                <thead>
                    <tr>
                        <th class="w-[60px] px-4 py-3 text-center" style="padding-inline-start: 21px">
                            <div class="custom-input cursor-pointer">
                                <input type="checkbox" wire:model.live="selectAll" id="selectAllCheckbox">
                                <label for="selectAllCheckbox"></label>
                            </div>
                        </th>
                        @if (in_array('key', $pendingColumns))
                            <th
                                class="px-4 py-4 text-start text-lg font-bold fw-bold text-[#181C32] dark:text-white uppercase tracking-wider relative group">
                                <div class="flex items-center gap-2 min-w-[120px]">
                                    <span class="uppercase">{{ __('Key') }}</span>
                                </div>
                            </th>
                        @endif
                        @if (in_array('english', $pendingColumns))
                            <th
                                class="px-4 py-4 text-start text-lg font-bold fw-bold text-[#181C32] dark:text-white uppercase tracking-wider relative group">
                                <div class="flex items-center gap-2 min-w-[200px]">
                                    <div class="kt-avatar size-5">
                                        <div class="kt-avatar-image">
                                            <img src="{{ !empty($localePhotos['en']) ? (str_contains($localePhotos['en'], '/') ? asset('storage/' . $localePhotos['en']) : asset('assets/media/flags/' . $localePhotos['en'])) : asset('assets/media/flags/' . ($flagMap['en'] ?? 'us') . '.svg') }}"
                                                alt="">
                                        </div>
                                    </div>
                                    <span class="uppercase">{{ __('English Reference') }}</span>
                                </div>
                            </th>
                        @endif
                        @if (in_array('translation', $pendingColumns))
                            <th
                                class="px-4 py-4 text-start text-lg font-bold fw-bold text-[#181C32] dark:text-white uppercase tracking-wider relative group">
                                <div class="flex items-center gap-2 min-w-[200px]">
                                    <div class="kt-avatar size-5">
                                        <div class="kt-avatar-image">
                                            <img src="{{ !empty($localePhotos[$selectedLocale]) ? (str_contains($localePhotos[$selectedLocale], '/') ? asset('storage/' . $localePhotos[$selectedLocale]) : asset('assets/media/flags/' . $localePhotos[$selectedLocale])) : asset('assets/media/flags/' . ($flagMap[$selectedLocale] ?? $selectedLocale) . '.svg') }}"
                                                alt="">
                                        </div>
                                    </div>
                                    <span
                                        class="uppercase">{{ $availableLocales[$selectedLocale] ?? $selectedLocale }}</span>
                                </div>
                            </th>
                        @endif
                        @if (in_array('status', $pendingColumns))
                            <th
                                class="px-4 py-4 text-center text-lg font-extrabold text-[#181C32] dark:text-white uppercase tracking-wider">
                                <div class="flex items-center justify-center gap-2 min-w-[80px]">
                                    <span class="uppercase">{{ __('Status') }}</span>
                                </div>
                            </th>
                        @endif
                        @if (in_array('suggest', $pendingColumns))
                            <th
                                class="px-4 py-4 text-center text-lg font-extrabold text-[#181C32] dark:text-white uppercase tracking-wider">
                                <div class="flex items-center justify-center gap-2 min-w-[100px]">
                                    <span class="uppercase">{{ __('Suggest') }}</span>
                                </div>
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($filteredTranslations as $key => $value)
                        <tr
                            class="hover:bg-primary/10 transition-colors cursor-pointer {{ $value === '' || $value === null ? 'bg-danger-light/20 dark:bg-danger/10' : '' }}">
                            <td class="text-center">
                                <div class="custom-input">
                                    <input type="checkbox" name="selectItem[]" id="checkbox_{{ $loop->index }}"
                                        wire:model="selectedIds" value="{{ $key }}">
                                    <label for="checkbox_{{ $loop->index }}"></label>
                                </div>
                            </td>
                            @if (in_array('key', $pendingColumns))
                                <td class="px-4 py-2" dir="ltr">
                                    @php
                                        $displayKey = $key;
                                        $displayFile = '';
                                        if (str_contains($key, '|||')) {
                                            $parts = explode('|||', $key, 2);
                                            $displayFile = str_replace('global::', 'global / ', $parts[0]);
                                            $displayKey = $parts[1];
                                        }
                                    @endphp
                                    <span class="kt-badge kt-badge-light kt-badge-secondary py-1 px-2 whitespace-normal break-all font-mono text-sm">
                                        @if($displayFile) <span class="text-xs text-primary me-2 font-bold opacity-75">[{{ $displayFile }}]</span> @endif
                                        {{ $displayKey }}
                                    </span>
                                </td>
                            @endif
                            @if (in_array('english', $pendingColumns))
                                <td class="px-4 py-2 text-sm">
                                    {{ $activeReference[$key] ?? '' }}
                                </td>
                            @endif
                            @if (in_array('translation', $pendingColumns))
                                <td class="px-4 py-2">
                                    @if ($editingKey === $key)
                                        <div class="relative w-full max-w-full"
                                            dir="{{ in_array($selectedLocale, ['ar', 'he', 'ur', 'fa', 'ku']) ? 'rtl' : 'ltr' }}">
                                            <textarea wire:model="editingValue" wire:keydown.enter.prevent="saveTranslation" wire:keydown.escape="cancelEditing"
                                                class="kt-textarea border-primary focus:ring-primary w-full pe-20 shadow-sm" style="min-height: 60px;" autofocus
                                                dir="auto"></textarea>
                                            <div class="absolute bottom-2 end-2 flex gap-1 z-10">
                                                <button wire:click="saveTranslation"
                                                    class="kt-btn kt-btn-sm kt-btn-success text-white px-2 py-1 shadow-sm"><i
                                                        class="fas fa-check"></i> {{ __('Save') }}</button>
                                                <button wire:click="cancelEditing"
                                                    class="kt-btn kt-btn-sm kt-btn-danger text-white px-2 py-1 shadow-sm"><i
                                                        class="fas fa-times"></i></button>
                                            </div>
                                        </div>
                                    @else
                                        <div wire:click="startEditing('{{ addslashes($key) }}')"
                                            class="cursor-text text-sm rounded border border-transparent transition-colors {{ $value ? 'text-foreground hover:bg-gray-50 dark:hover:bg-gray-800' : 'text-danger border-danger border-dashed bg-danger-light/5 hover:bg-danger-light/20 p-2' }}"
                                            style="white-space: pre-wrap; min-height: 24px; width:100%;"
                                            dir="auto">
                                            {{ $value ?: __('Click to translate...') }}
                                        </div>
                                    @endif
                                </td>
                            @endif
                            @if (in_array('status', $pendingColumns))
                                <td class="px-4 py-2 text-center">
                                    @if ($value)
                                        <span
                                            class="kt-badge kt-badge-success kt-badge-outline justify-center py-1 px-3"><i
                                                class="fas fa-check me-1 text-success"></i>
                                            {{ __('Done') }}</span>
                                    @else
                                        <span
                                            class="kt-badge kt-badge-danger kt-badge-outline justify-center py-1 px-3 border-dashed">{{ __('Missing') }}</span>
                                    @endif
                                </td>
                            @endif
                            @if (in_array('suggest', $pendingColumns))
                                <td class="px-4 py-2 text-center">
                                    <button wire:click="openSuggestionModal('{{ addslashes($key) }}')"
                                        class="kt-btn kt-btn-sm kt-btn-light kt-btn-color-warning">
                                        <i class="ki-outline ki-lightbulb text-sm me-1"></i> {{ __('Suggest') }}
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-3 text-center text-gray-500">
                                <div class="w-[90px] h-[90px] mx-auto my-4">
                                    <img src="{{ asset('assets/images/other/no-data.svg') }}" alt="no data">
                                </div>
                                <p class="text-red-600 font-semibold">{{ __('No translations found.') }}</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Custom Pagination Footer --}}
        <div class="border-t border-gray-200 dark:border-gray-700 px-4 py-3">
            <div class="flex flex-wrap items-center justify-between gap-3">
                {{-- Left: Showing info --}}
                <div class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                    <span>
                        {{ __('main.showing') }}
                        <strong class="text-primary">{{ $filteredTranslations->firstItem() ?? 0 }}</strong>
                        -
                        <strong class="text-primary">{{ $filteredTranslations->lastItem() ?? 0 }}</strong>
                        {{ __('main.of') }}
                        <strong>{{ $filteredTranslations->total() }}</strong>
                        {{ __('main.translations') ?? 'Translations' }}
                    </span>
                    @if ($filteredTranslations->hasPages())
                        <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">
                            ({{ __('main.page') }} {{ $filteredTranslations->currentPage() }} {{ __('main.of') }}
                            {{ $filteredTranslations->lastPage() }})
                        </span>
                    @endif
                </div>

                {{-- Center: Per Page Selector --}}
                <div class="flex items-center gap-2 text-sm">
                    <span
                        class="text-gray-500 dark:text-gray-400 text-xs">{{ __('main.per_page') ?? 'Per page' }}:</span>
                    <select wire:model.live="perPage"
                        class="kt-input text-sm py-1 px-2 border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-md w-[70px] text-center">
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>

                {{-- Right: Page Navigation --}}
                @if ($filteredTranslations->hasPages())
                    <div class="flex items-center gap-1">
                        {{-- First Page --}}
                        <button wire:click="gotoPage(1)" @disabled($filteredTranslations->onFirstPage())
                            class="w-8 h-8 flex items-center justify-center rounded-md text-xs font-bold transition-colors {{ $filteredTranslations->onFirstPage() ? 'text-gray-300 dark:text-gray-600 cursor-not-allowed' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                            <i class="fas fa-angles-left text-[10px]"></i>
                        </button>
                        {{-- Previous --}}
                        <button wire:click="previousPage" @disabled($filteredTranslations->onFirstPage())
                            class="w-8 h-8 flex items-center justify-center rounded-md text-xs font-bold transition-colors {{ $filteredTranslations->onFirstPage() ? 'text-gray-300 dark:text-gray-600 cursor-not-allowed' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                            <i class="fas fa-chevron-left text-[10px]"></i>
                        </button>

                        {{-- Page Numbers --}}
                        @php
                            $currentPage = $filteredTranslations->currentPage();
                            $lastPage = $filteredTranslations->lastPage();
                            $startPage = max(1, $currentPage - 2);
                            $endPage = min($lastPage, $currentPage + 2);
                            if ($endPage - $startPage < 4) {
                                if ($startPage == 1) {
                                    $endPage = min($lastPage, 5);
                                } else {
                                    $startPage = max(1, $lastPage - 4);
                                }
                            }
                        @endphp

                        @if ($startPage > 1)
                            <button wire:click="gotoPage(1)"
                                class="w-8 h-8 flex items-center justify-center rounded-md text-xs font-bold text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">1</button>
                            @if ($startPage > 2)
                                <span class="w-6 text-center text-gray-400 text-xs">…</span>
                            @endif
                        @endif

                        @for ($i = $startPage; $i <= $endPage; $i++)
                            <button wire:click="gotoPage({{ $i }})"
                                class="w-8 h-8 flex items-center justify-center rounded-md text-xs font-bold transition-colors {{ $i == $currentPage ? 'bg-primary text-white shadow-sm' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                                {{ $i }}
                            </button>
                        @endfor

                        @if ($endPage < $lastPage)
                            @if ($endPage < $lastPage - 1)
                                <span class="w-6 text-center text-gray-400 text-xs">…</span>
                            @endif
                            <button wire:click="gotoPage({{ $lastPage }})"
                                class="w-8 h-8 flex items-center justify-center rounded-md text-xs font-bold text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">{{ $lastPage }}</button>
                        @endif

                        {{-- Next --}}
                        <button wire:click="nextPage" @disabled($filteredTranslations->currentPage() == $filteredTranslations->lastPage())
                            class="w-8 h-8 flex items-center justify-center rounded-md text-xs font-bold transition-colors {{ $filteredTranslations->currentPage() == $filteredTranslations->lastPage() ? 'text-gray-300 dark:text-gray-600 cursor-not-allowed' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                            <i class="fas fa-chevron-right text-[10px]"></i>
                        </button>
                        {{-- Last Page --}}
                        <button wire:click="gotoPage({{ $filteredTranslations->lastPage() }})"
                            @disabled($filteredTranslations->currentPage() == $filteredTranslations->lastPage())
                            class="w-8 h-8 flex items-center justify-center rounded-md text-xs font-bold transition-colors {{ $filteredTranslations->currentPage() == $filteredTranslations->lastPage() ? 'text-gray-300 dark:text-gray-600 cursor-not-allowed' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                            <i class="fas fa-angles-right text-[10px]"></i>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
<!-- Suggestion Modal -->
<div x-data="{ show: @entangle('showSuggestionModal') }">
    <template x-teleport="body">
        <div x-show="show" x-cloak
            style="position: fixed; inset: 0; z-index: 100000; background-color: rgba(0,0,0,0.5); overflow-y: auto; direction: {{ in_array(app()->getLocale(), ['ar', 'he', 'fa', 'ur']) ? 'rtl' : 'ltr' }};"
            @click.self="show = false">

            <!-- Inner Layout Flex Centering -->
            <div class="flex items-center justify-center min-h-screen p-4" @click.self="show = false">
                <!-- Modal Content -->
                <div class="card shadow-sm m-auto flex flex-col w-full text-start tm-modal-card rounded-lg"
                    style="max-width: 600px;" @click.stop x-show="show" x-transition>
                    <div class="card-header flex items-center justify-between px-5 py-4 shrink-0 border-b">
                        <h3 class="card-title text-base font-bold flex items-center gap-2 m-0 tm-label">
                            <i class="fas fa-lightbulb text-warning"></i>
                            <span>{{ __('Suggest Translation Correction') }}</span>
                        </h3>
                        <button type="button" class="btn btn-sm btn-icon btn-clear btn-active-light"
                            @click="show = false">
                            <i class="lucide lucide-x w-5 h-5"></i>
                        </button>
                    </div>

                    <div
                        class="card-body px-5 py-4 overflow-y-auto flex-col gap-4 flex-1 flex custom-scrollbar line-height-normal">
                        <div class="text-xs tm-text-muted">
                            {{ __('Help improve our translations by suggesting a better alternative.') }}</div>

                        <div class="rounded p-4 border border-dashed flex items-center tm-dashed-box">
                            <span
                                class="badge badge-light me-3 font-bold px-2 py-1 flex items-center gap-1 w-fit text-xs border">
                                @if (isset($localePhotos[$selectedLocale]))
                                    <img src="{{ Storage::url($localePhotos[$selectedLocale]) }}"
                                        alt="{{ $selectedLocale }}"
                                        style="width: 20px; height: 20px; min-width: 20px; min-height: 20px;"
                                        class="rounded-full object-cover">
                                @else
                                    <i class="fas fa-globe text-[10px]"></i>
                                @endif
                                {{ strtoupper($selectedLocale) }}
                            </span>
                            <code class="font-bold text-xs"
                                dir="ltr">{{ $selectedFile }}.{{ $suggestionKey }}</code>
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label class="flex items-center text-xs font-bold tm-label">
                                <span>{{ __('English (Reference)') }}</span>
                            </label>
                            <div class="p-3 border border-dashed rounded flex font-medium text-xs tm-dashed-box">
                                {{ $referenceTranslations[$suggestionKey] ?? '-' }}</div>
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label class="flex items-center text-xs font-bold tm-label">
                                <span>{{ __('Current Translation') }}</span>
                            </label>
                            <div class="p-3 border border-dashed rounded flex font-medium text-xs tm-dashed-box"
                                dir="auto">{{ $suggestionCurrentValue ?: __('(empty - not translated yet)') }}
                            </div>
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label class="flex items-center text-xs font-bold tm-label">
                                <span class="required">{{ __('Your Suggested Translation') }}</span>
                            </label>
                            <input type="text" wire:model="suggestionValue"
                                class="input input-sm w-full text-sm tm-input" dir="auto"
                                placeholder="{{ __('Enter the correct translation here...') }}"
                                wire:keydown.enter="submitSuggestion">
                            @error('suggestionValue')
                                <div class="text-danger text-xs font-medium">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label
                                class="flex items-center text-xs font-bold tm-label">{{ __('Reason (Optional)') }}</label>
                            <textarea wire:model="suggestionReason" class="textarea w-full text-sm tm-input" rows="2"
                                placeholder="{{ __('Why do you think the current translation is incorrect?') }}"></textarea>
                        </div>
                    </div>

                    <div class="card-footer flex items-center justify-end gap-3 px-5 py-4 shrink-0 border-t">
                        <button type="button" @click="show = false"
                            class="btn btn-sm btn-light">{{ __('Cancel') }}</button>
                        <button type="button" wire:click="submitSuggestion"
                            @click="setTimeout(() => show = false, 500)" class="btn btn-sm btn-warning"
                            style="color: #181C32 !important;">
                            <i class="lucide lucide-send me-1 text-xs"
                                style="color: #181C32 !important;"></i><span
                                style="color: #181C32 !important;" class="font-bold text-sm">{{ __('Submit Suggestion') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>

<!-- Add New Key Modal (Super Admin) -->
<div x-data="{ showAddKeyModal: false }" @open-add-key-modal.window="showAddKeyModal = true">
    <template x-teleport="body">
        <div x-show="showAddKeyModal" x-cloak
            style="position: fixed; inset: 0; z-index: 100000; background-color: rgba(0,0,0,0.5); overflow-y: auto; direction: {{ in_array(app()->getLocale(), ['ar', 'he', 'fa', 'ur']) ? 'rtl' : 'ltr' }};"
            @click.self="showAddKeyModal = false">

            <!-- Inner Layout Flex Centering -->
            <div class="flex items-center justify-center min-h-screen p-4" @click.self="showAddKeyModal = false">
                <!-- Modal Content -->
                <!-- Modal Content -->
                <div class="card shadow-sm m-auto flex flex-col w-full text-start tm-modal-card rounded-lg"
                    style="max-width: 500px;" @click.stop x-show="showAddKeyModal" x-transition>
                    <div class="card-header flex items-center justify-between px-5 py-4 shrink-0 border-b">
                        <h3 class="card-title text-lg font-bold flex items-center gap-2 m-0 tm-label">
                            <i class="fas fa-plus-circle text-primary"></i>
                            {{ __('Add New Translation Text manually') }}
                        </h3>
                        <button type="button" class="btn btn-sm btn-icon btn-clear btn-active-light"
                            @click="showAddKeyModal = false">
                            <i class="lucide lucide-x w-5 h-5"></i>
                        </button>
                    </div>
                    <div class="card-body px-5 py-4 overflow-y-auto space-y-5 flex-1 line-height-normal">
                        <div class="text-sm tm-text-muted">
                            {{ __('Create a brand new text string to be translated across all languages.') }}</div>

                        <div class="rounded p-4 border border-dashed flex items-center tm-dashed-box">
                            <span class="badge badge-primary me-3 font-bold">{{ __('FILE') }}</span>
                            <strong class="text-sm tm-text" dir="ltr">
                                @if (str_starts_with($selectedFile, 'global::'))
                                    global / {{ str_replace('global::', '', $selectedFile) }}.php
                                @elseif(str_contains($selectedFile, '::'))
                                    @php $parts = explode('::', $selectedFile); @endphp
                                    Module: {{ $parts[0] }} / {{ $parts[1] }}.php
                                @else
                                    {{ basename($selectedFile) }}.php
                                @endif
                            </strong>
                            <span
                                class="ms-2 text-xs tm-text-muted">({{ __('Texts will be added to this file') }})</span>
                        </div>

                        <div class="space-y-2">
                            <label class="flex items-center text-sm font-bold tm-label">
                                <span class="required">{{ __('Text Code (Key)') }}</span>
                                <i class="lucide lucide-info ms-2 text-muted w-4 h-4 cursor-pointer"
                                    data-kt-tooltip="true" data-kt-tooltip-placement="top">
                                    <span data-kt-tooltip-content="true"
                                        class="kt-tooltip">{{ __('Use English words with underscores, no spaces. E.g: welcome_message, checkout_button') }}</span>
                                </i>
                            </label>
                            <input type="text" wire:model.defer="newKeyName"
                                class="input input-sm w-full tm-input"
                                placeholder="{{ __('e.g., welcome_message') }}" dir="ltr">
                            @error('newKeyName')
                                <div class="text-danger text-sm font-medium">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="flex items-center text-sm font-bold tm-label">
                                <span class="required">{{ __('English (Reference Text)') }}</span>
                            </label>
                            <textarea wire:model.defer="newKeyValue" class="textarea w-full tm-input" rows="3"
                                placeholder="{{ __('e.g., Welcome to our new feature!') }}" dir="ltr"></textarea>
                            @error('newKeyValue')
                                <div class="text-danger text-sm font-medium">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-primary mt-4 flex items-center p-4">
                            <i class="lucide lucide-info text-primary me-3 text-2xl"></i>
                            <div class="flex flex-col">
                                <div class="font-bold text-primary text-sm">{{ __('Note:') }}</div>
                                <span
                                    class="text-xs text-primary">{{ __('Once saved, this new text will immediately appear in the translation table as "Missing" so you can translate it.') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer flex items-center justify-end gap-3 px-5 py-4 shrink-0 border-t">
                        <button type="button" class="btn btn-sm btn-light"
                            @click="showAddKeyModal = false">{{ __('Cancel') }}</button>
                        <button type="button" class="btn btn-sm btn-primary" wire:click="saveNewKey"
                            @click="setTimeout(() => showAddKeyModal = false, 500)" style="color: #181C32 !important;">
                            <i class="lucide lucide-save me-2 w-4 h-4" style="color: #181C32 !important;"></i><span
                                style="color: #181C32 !important;" class="font-bold">{{ __('Save New Text') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
</div>
</div>
