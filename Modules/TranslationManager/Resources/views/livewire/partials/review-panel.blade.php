{{-- Review Panel: Pending & History tabs for admin suggestion review --}}
<div class="kt-card bg-info-light border border-info border-dashed shadow-sm mb-5 w-full min-w-0" x-data="{ tab: 'pending' }">
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

    {{-- PENDING TAB --}}
    <div class="w-full overflow-x-auto custom-scrollbar" x-show="tab === 'pending'">
        @if (count($pendingSuggestions) > 0)
            <table class="kt-table table-auto text-nowrap w-full">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                        <th class="px-4 py-3 text-start text-lg font-extrabold text-gray-900 dark:text-white uppercase w-10">#</th>
                        <th class="px-4 py-3 text-start text-lg font-extrabold text-gray-900 dark:text-white uppercase min-w-[150px]">{{ __('Language') }}</th>
                        <th class="px-4 py-3 text-start text-lg font-extrabold text-gray-900 dark:text-white uppercase min-w-[200px]">{{ __('Key & English') }}</th>
                        <th class="px-4 py-3 text-start text-lg font-extrabold text-gray-900 dark:text-white uppercase min-w-[250px]">{{ __('Current Translation') }}</th>
                        <th class="px-4 py-3 text-start text-lg font-extrabold text-gray-900 dark:text-white uppercase min-w-[250px]">{{ __('Suggested Replacement') }}</th>
                        <th class="px-4 py-3 text-center text-lg font-extrabold text-gray-900 dark:text-white uppercase w-[150px]">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 font-medium">
                    @foreach ($pendingSuggestions as $index => $suggestion)
                        <tr class="hover:bg-primary/10 transition-colors border-b border-gray-200 dark:border-gray-700">
                            <td class="px-4 py-3 align-middle text-center">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 align-middle">
                                <span class="kt-badge kt-badge-light rounded-full px-3 py-1 font-bold border border-gray-300 dark:border-gray-600 flex items-center gap-2 w-fit">
                                    @if (isset($localePhotos[$suggestion['locale']]))
                                        <img src="{{ Storage::url($localePhotos[$suggestion['locale']]) }}" alt="{{ $suggestion['locale'] }}" class="w-4 h-4 rounded-full object-cover">
                                    @else
                                        <i class="fas fa-globe"></i>
                                    @endif
                                    {{ strtoupper($suggestion['locale']) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <div class="font-bold break-all mb-1 text-gray-900 dark:text-gray-100" title="{{ $suggestion['key'] }}">{{ $suggestion['key'] }}</div>
                                <div class="text-xs italic pt-1 text-gray-500 dark:text-gray-400">{{ $referenceTranslations[$suggestion['key']] ?? 'N/A' }}</div>
                            </td>
                            <td class="px-4 py-3 align-top whitespace-normal break-words">
                                <div class="border rounded p-3 text-sm bg-gray-50 dark:bg-gray-800 border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white" dir="auto">
                                    {{ $suggestion['current_value'] ?: __('(empty)') }}
                                </div>
                            </td>
                            <td class="px-4 py-3 align-top whitespace-normal break-words">
                                <div class="border rounded p-3 text-sm font-bold bg-success-light/30 border-success text-success" dir="auto">
                                    <input type="text" wire:model.defer="editingSuggestedValues.{{ $suggestion['id'] }}"
                                        class="kt-input kt-input-sm border border-transparent hover:border-success-light focus:border-success bg-transparent w-full font-bold text-success">
                                </div>
                                @if ($suggestion['reason'])
                                    <div class="rounded p-2 text-xs border italic bg-warning/10 border-warning/40 text-warning mt-1">
                                        <i class="fas fa-comment-dots me-1"></i> "{{ $suggestion['reason'] }}"
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center align-middle">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <input type="text" wire:model.defer="reviewNote" class="kt-input kt-input-sm w-full text-xs text-center mb-1" placeholder="{{ __('Add a note...') }}">
                                    <div class="flex gap-2 w-full">
                                        <button wire:click="rejectSuggestion({{ $suggestion['id'] }})" class="kt-btn kt-btn-sm kt-btn-danger flex-1 font-bold p-1"><i class="fas fa-times text-white"></i></button>
                                        <button wire:click="approveSuggestion({{ $suggestion['id'] }})" class="kt-btn kt-btn-sm kt-btn-success flex-1 font-bold text-white p-1"><i class="fas fa-check text-white"></i></button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="text-center py-10">
                <div class="w-20 h-20 rounded-full bg-info-light dark:bg-info/10 mx-auto mb-4 flex items-center justify-center"><i class="fas fa-clipboard-check text-4xl text-info"></i></div>
                <div class="text-xl font-bold text-gray-900 dark:text-white">{{ __('No pending suggestions!') }}</div>
                <div class="text-sm text-gray-500 mt-2">{{ __('You are all caught up.') }}</div>
            </div>
        @endif
    </div>

    {{-- HISTORY TAB --}}
    <div class="kt-card-body pt-3 w-full min-w-0 overflow-x-auto" x-show="tab === 'history'" x-cloak style="display: none;">
        @if (count($historySuggestions) > 0)
            <div class="flex justify-end mb-4">
                <button wire:click="clearSuggestionHistory" wire:confirm="{{ __('Are you sure you want to clear the entire suggestion history?') }}" class="kt-btn kt-btn-sm kt-btn-light kt-btn-danger font-bold">
                    <i class="fas fa-trash-alt me-1"></i> {{ __('Clear History') }}
                </button>
            </div>
            <table class="kt-table table-auto text-nowrap w-full">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                        <th class="px-4 py-3 text-start text-lg font-extrabold text-gray-900 dark:text-white uppercase w-10">#</th>
                        <th class="px-4 py-3 text-start text-lg font-extrabold text-gray-900 dark:text-white uppercase min-w-[100px]">{{ __('Locale / Key') }}</th>
                        <th class="px-4 py-3 text-start text-lg font-extrabold text-gray-900 dark:text-white uppercase min-w-[250px]">{{ __('Suggested Value') }}</th>
                        <th class="px-4 py-3 text-end text-lg font-extrabold text-gray-900 dark:text-white uppercase min-w-[150px]">{{ __('Status / Reviewer') }}</th>
                    </tr>
                </thead>
                <tbody class="font-medium">
                    @foreach ($historySuggestions as $index => $history)
                        <tr class="hover:bg-primary/10 transition-colors border-b border-gray-200 dark:border-gray-700">
                            <td class="px-4 py-3 align-middle">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 align-middle">
                                <div class="flex flex-col gap-2">
                                    <div class="flex items-center gap-2">
                                        @if (isset($localePhotos[$history['locale']]))
                                            <img src="{{ asset('storage/' . $localePhotos[$history['locale']]) }}" alt="{{ $history['locale'] }}" class="w-5 h-5 rounded-full object-cover shadow-sm bg-white border border-gray-200 dark:border-gray-600">
                                        @else
                                            <div class="w-5 h-5 rounded-full bg-gray-200 dark:bg-gray-700 font-bold text-[10px] flex items-center justify-center text-gray-500 uppercase">{{ $history['locale'] }}</div>
                                        @endif
                                        <span class="font-bold text-gray-800 dark:text-gray-200">{{ $availableLocales[$history['locale']] ?? strtoupper($history['locale']) }}</span>
                                    </div>
                                    <div class="text-xs truncate max-w-[200px] text-gray-600 dark:text-gray-400 font-mono bg-gray-100 dark:bg-gray-800/50 px-2 py-1 rounded w-fit" title="{{ $history['key'] }}">{{ $history['key'] }}</div>
                                </div>
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <div class="text-sm font-bold truncate text-gray-800 dark:text-gray-200" dir="auto" title="{{ $history['suggested_value'] }}">{{ $history['suggested_value'] }}</div>
                                @if ($history['review_note'])
                                    <div class="mt-2 text-xs italic text-gray-500 dark:text-gray-400"><i class="fas fa-reply w-3"></i> {{ $history['review_note'] }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-end align-middle">
                                <span class="kt-badge kt-badge-md font-bold mb-1 {{ $history['status'] === 'approved' ? 'kt-badge-success' : 'kt-badge-danger' }}">{{ ucfirst($history['status']) }}</span>
                                @if ($history['status'] === 'rejected')
                                    <div class="mt-2 block">
                                        <button wire:click="approveSuggestion({{ $history['id'] }})" class="kt-btn kt-btn-sm kt-btn-outline kt-btn-success px-2 py-1 text-xs">
                                            <i class="fas fa-undo me-1"></i> {{ __('Re-Approve') }}
                                        </button>
                                    </div>
                                @endif
                                <div class="text-xs mt-1 text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($history['reviewed_at'])->diffForHumans() }}</div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="text-center py-10">
                <div class="w-20 h-20 rounded-full bg-gray-100 dark:bg-gray-800 mx-auto mb-4 flex items-center justify-center"><i class="fas fa-history text-4xl text-gray-400"></i></div>
                <div class="text-xl font-bold text-gray-900 dark:text-white">{{ __('No history yet!') }}</div>
                <div class="text-sm text-gray-500 mt-2">{{ __('Processed translation suggestions will appear here indefinitely.') }}</div>
            </div>
        @endif
    </div>
</div>
