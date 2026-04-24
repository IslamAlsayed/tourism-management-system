{{-- Add New Key Modal (Super Admin) --}}
<div x-data="{ showAddKeyModal: false }" @open-add-key-modal.window="showAddKeyModal = true">
    <template x-teleport="body">
        <div x-show="showAddKeyModal" x-cloak
            style="position: fixed; inset: 0; z-index: 100000; background-color: rgba(0,0,0,0.5); overflow-y: auto; direction: {{ in_array(app()->getLocale(), $rtlLocales) ? 'rtl' : 'ltr' }};"
            @click.self="showAddKeyModal = false">
            <div class="flex items-center justify-center min-h-screen p-4" @click.self="showAddKeyModal = false">
                <div class="kt-card shadow-sm m-auto flex flex-col w-full text-start rounded-lg" style="max-width: 500px;" @click.stop x-show="showAddKeyModal" x-transition>
                    <div class="kt-card-header flex items-center justify-between px-5 py-4 shrink-0 border-b border-border">
                        <h3 class="kt-card-title text-lg font-bold flex items-center gap-2 m-0">
                            <i class="fas fa-plus-circle text-primary"></i>
                            {{ __('Add New Translation Text manually') }}
                        </h3>
                        <button type="button" class="kt-btn kt-btn-sm kt-btn-icon kt-btn-light" @click="showAddKeyModal = false">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="kt-card-body px-5 py-4 overflow-y-auto space-y-5 flex-1">
                        <div class="text-sm text-muted-foreground">{{ __('Create a brand new text string to be translated across all languages.') }}</div>
                        <div class="rounded p-4 border border-dashed border-border bg-muted/30 flex items-center">
                            <span class="kt-badge kt-badge-primary me-3 font-bold">{{ __('FILE') }}</span>
                            <strong class="text-sm text-foreground" dir="ltr">
                                @if (str_starts_with($selectedFile, 'global::'))
                                    global / {{ str_replace('global::', '', $selectedFile) }}.php
                                @elseif(str_contains($selectedFile, '::'))
                                    @php $parts = explode('::', $selectedFile); @endphp
                                    Module: {{ $parts[0] }} / {{ $parts[1] }}.php
                                @else
                                    {{ basename($selectedFile) }}.php
                                @endif
                            </strong>
                            <span class="ms-2 text-xs text-muted-foreground">({{ __('Texts will be added to this file') }})</span>
                        </div>
                        <div class="space-y-2">
                            <label class="flex items-center text-sm font-bold text-foreground">
                                <span class="required">{{ __('Text Code (Key)') }}</span>
                            </label>
                            <input type="text" wire:model.defer="newKeyName" class="kt-input kt-input-sm w-full" placeholder="{{ __('e.g., welcome_message') }}" dir="ltr">
                            @error('newKeyName') <div class="text-danger text-sm font-medium">{{ $message }}</div> @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="flex items-center text-sm font-bold text-foreground">
                                <span class="required">{{ __('English (Reference Text)') }}</span>
                            </label>
                            <textarea wire:model.defer="newKeyValue" class="kt-textarea w-full" rows="3" placeholder="{{ __('e.g., Welcome to our new feature!') }}" dir="ltr"></textarea>
                            @error('newKeyValue') <div class="text-danger text-sm font-medium">{{ $message }}</div> @enderror
                        </div>
                        <div class="kt-alert kt-alert-primary mt-4 flex items-center p-4">
                            <i class="fas fa-info-circle text-primary me-3 text-2xl"></i>
                            <div class="flex flex-col">
                                <div class="font-bold text-primary text-sm">{{ __('Note:') }}</div>
                                <span class="text-xs text-primary">{{ __('Once saved, this new text will immediately appear in the translation table as \"Missing\" so you can translate it.') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="kt-card-footer flex items-center justify-end gap-3 px-5 py-4 shrink-0 border-t border-border">
                        <button type="button" class="kt-btn kt-btn-sm kt-btn-light" @click="showAddKeyModal = false">{{ __('Cancel') }}</button>
                        <button type="button" class="kt-btn kt-btn-sm kt-btn-primary font-bold" wire:click="saveNewKey" @click="setTimeout(() => showAddKeyModal = false, 500)">
                            <i class="fas fa-save me-2"></i>
                            <span class="font-bold">{{ __('Save New Text') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
