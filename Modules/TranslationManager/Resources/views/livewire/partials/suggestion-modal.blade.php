{{-- Suggestion Modal --}}
<div x-data="{ show: @entangle('showSuggestionModal') }">
    <template x-teleport="body">
        <div x-show="show" x-cloak
            style="position: fixed; inset: 0; z-index: 100000; background-color: rgba(0,0,0,0.5); overflow-y: auto; direction: {{ in_array(app()->getLocale(), $rtlLocales) ? 'rtl' : 'ltr' }};"
            @click.self="show = false">
            <div class="flex items-center justify-center min-h-screen p-4" @click.self="show = false">
                <div class="kt-card shadow-sm m-auto flex flex-col w-full text-start rounded-lg" style="max-width: 600px;" @click.stop x-show="show" x-transition>
                    <div class="kt-card-header flex items-center justify-between px-5 py-4 shrink-0 border-b border-border">
                        <h3 class="kt-card-title text-base font-bold flex items-center gap-2 m-0">
                            <i class="fas fa-lightbulb text-warning"></i>
                            <span>{{ __('Suggest Translation Correction') }}</span>
                        </h3>
                        <button type="button" class="kt-btn kt-btn-sm kt-btn-icon kt-btn-light" @click="show = false">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="kt-card-body px-5 py-4 overflow-y-auto flex-col gap-4 flex-1 flex custom-scrollbar">
                        <div class="text-xs text-muted-foreground">{{ __('Help improve our translations by suggesting a better alternative.') }}</div>
                        <div class="rounded p-4 border border-dashed border-border bg-muted/30 flex items-center">
                            <span class="kt-badge kt-badge-light me-3 font-bold px-2 py-1 flex items-center gap-1 w-fit text-xs border border-border">
                                @if (isset($localePhotos[$selectedLocale]))
                                    <img src="{{ Storage::url($localePhotos[$selectedLocale]) }}" alt="{{ $selectedLocale }}" class="w-5 h-5 rounded-full object-cover">
                                @else
                                    <i class="fas fa-globe text-[10px]"></i>
                                @endif
                                {{ strtoupper($selectedLocale) }}
                            </span>
                            <code class="font-bold text-xs" dir="ltr">{{ $selectedFile }}.{{ $suggestionKey }}</code>
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="flex items-center text-xs font-bold text-foreground">{{ __('English (Reference)') }}</label>
                            <div class="p-3 border border-dashed border-border rounded bg-muted/30 font-medium text-xs text-foreground">{{ $referenceTranslations[$suggestionKey] ?? '-' }}</div>
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="flex items-center text-xs font-bold text-foreground">{{ __('Current Translation') }}</label>
                            <div class="p-3 border border-dashed border-border rounded bg-muted/30 font-medium text-xs text-foreground" dir="auto">{{ $suggestionCurrentValue ?: __('(empty - not translated yet)') }}</div>
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="flex items-center text-xs font-bold text-foreground"><span class="required">{{ __('Your Suggested Translation') }}</span></label>
                            <input type="text" wire:model="suggestionValue" class="kt-input kt-input-sm w-full" dir="auto" placeholder="{{ __('Enter the correct translation here...') }}" wire:keydown.enter="submitSuggestion">
                            @error('suggestionValue') <div class="text-danger text-xs font-medium">{{ $message }}</div> @enderror
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="flex items-center text-xs font-bold text-foreground">{{ __('Reason (Optional)') }}</label>
                            <textarea wire:model="suggestionReason" class="kt-textarea w-full text-sm" rows="2" placeholder="{{ __('Why do you think the current translation is incorrect?') }}"></textarea>
                        </div>
                    </div>
                    <div class="kt-card-footer flex items-center justify-end gap-3 px-5 py-4 shrink-0 border-t border-border">
                        <button type="button" @click="show = false" class="kt-btn kt-btn-sm kt-btn-light">{{ __('Cancel') }}</button>
                        <button type="button" wire:click="submitSuggestion" @click="setTimeout(() => show = false, 500)" class="kt-btn kt-btn-sm kt-btn-warning font-bold">
                            <i class="fas fa-paper-plane me-1 text-xs"></i>
                            <span class="font-bold text-sm">{{ __('Submit Suggestion') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
