<div>
    {{-- Page Header --}}
    <div class="container-fluid py-5">
        <div class="mb-5 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2 m-0">
                    <i class="fa-duotone fa-solid fa-shapes text-primary text-2xl">
                        
                    </i>
                    {{ __('main.ui_icons_manager') ?? 'UI Icons Manager' }}
                </h3>
                <span class="text-gray-500 text-sm mt-1 block">{{ __('main.ui_icons_subtitle') ?? 'Manage & customize system icon appearances across themes' }}</span>
            </div>
            <div class="flex items-center gap-3">
                {{-- View Mode Toggle --}}
                <div class="flex bg-gray-100 dark:bg-coal-300 p-1 rounded-lg">
                    <button type="button" wire:click="$set('viewMode', 'grid')"
                            class="px-3 py-2 rounded-md transition-all duration-200 {{ $viewMode === 'grid' ? 'bg-white shadow-sm dark:bg-coal-500 text-primary' : 'text-gray-500 hover:text-gray-700' }}">
                        <i class="fa-duotone fa-solid fa-grid-2 text-lg"></i>
                    </button>
                    <button type="button" wire:click="$set('viewMode', 'table')"
                            class="px-3 py-2 rounded-md transition-all duration-200 {{ $viewMode === 'table' ? 'bg-white shadow-sm dark:bg-coal-500 text-primary' : 'text-gray-500 hover:text-gray-700' }}">
                        <i class="fa-duotone fa-solid fa-bars text-lg"></i>
                    </button>
                </div>
                {{-- Add New Icon Button --}}
                <button wire:click="addIcon" class="kt-btn kt-btn-primary kt-btn-sm flex items-center gap-2">
                    <i class="fa-duotone fa-solid fa-plus"></i>
                    {{ __('main.add_icon') ?? '+ Add New Icon' }}
                </button>
            </div>
        </div>

        {{-- Main Card --}}
        <div class="card shadow-sm border-0 rounded-xl">
            {{-- Search & Bulk Toolbar --}}
            <div class="card-header border-b border-gray-100 dark:border-gray-800 py-4 px-6">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 w-full">
                    <div class="relative w-full md:w-80">
                        <i class="fa-duotone fa-solid fa-magnifying-glass absolute start-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" wire:model.live.debounce.300ms="search"
                               class="input input-sm w-full ps-10"
                               placeholder="{{ __('main.search_icons') ?? 'Search by key or class...' }}" />
                    </div>
                    <div class="flex items-center gap-3">
                        <label class="flex items-center gap-2 cursor-pointer text-sm font-medium text-gray-600 dark:text-gray-400">
                            <input class="checkbox checkbox-sm" type="checkbox" wire:model.live="selectAll" />
                            {{ __('main.select_all') ?? 'Select All' }}
                        </label>
                        @if(count($selectedIds) > 0)
                            <div class="flex items-center gap-2 ps-3 border-s border-gray-200 dark:border-gray-700">
                                <span class="kt-badge kt-badge-primary kt-badge-outline kt-badge-sm">{{ count($selectedIds) }}</span>
                                <button wire:click="prepareBulkEdit" class="kt-btn kt-btn-sm kt-btn-primary">
                                    <i class="fa-duotone fa-solid fa-gear-2"></i>
                                    {{ __('main.bulk_edit') ?? 'Bulk Edit' }}
                                </button>
                                <button wire:click="resetSelection" class="kt-btn kt-btn-sm kt-btn-icon kt-btn-outline" title="{{ __('main.clear_selection') ?? 'Clear' }}">
                                    <i class="fa-duotone fa-solid fa-xmark"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card-body p-6">
                @if($viewMode === 'grid')
                    {{-- ==================== GRID VIEW ==================== --}}
                    <div class="flex flex-col gap-8">
                        @forelse($groupedIcons as $category => $groupIcons)
                            <div>
                                <div class="flex items-center justify-between mb-4 border-b border-gray-100 dark:border-gray-800 pb-3">
                                    <h4 class="text-sm font-bold text-gray-800 dark:text-gray-200 flex items-center gap-2 m-0">
                                        <i class="fa-duotone fa-solid fa-layer-group text-primary">
                                            
                                        </i>
                                        {{ $category }} {{ __('main.icons') ?? 'Icons' }}
                                    </h4>
                                    <span class="kt-badge kt-badge-outline kt-badge-sm">{{ count($groupIcons) }}</span>
                                </div>

                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3">
                                    @foreach($groupIcons as $icon)
                                        <div class="relative bg-white dark:bg-coal-500 border border-gray-200 dark:border-gray-700 rounded-xl p-4 text-center transition-all duration-200 hover:shadow-md hover:border-primary/40 {{ in_array($icon->id, $selectedIds) ? 'ring-2 ring-primary border-primary bg-primary/5' : '' }}">
                                            {{-- Checkbox --}}
                                            <div class="absolute top-2 end-2">
                                                <input class="checkbox checkbox-sm" type="checkbox" wire:model.live="selectedIds" value="{{ $icon->id }}" />
                                            </div>

                                            {{-- Icon Preview --}}
                                            <div class="mx-auto mt-1 mb-3 flex items-center justify-center rounded-lg"
                                                 style="width: 52px; height: 52px; background-color: {{ $icon->bg_color_light ?: '#f1f5f9' }}; border: 1.5px solid {{ $icon->border_color_light ?: '#e2e8f0' }};">
                                                @if($icon->icon_class)
                                                    <i class="{{ $icon->icon_class }} text-2xl text-gray-700 dark:text-gray-300"></i>
                                                @else
                                                    <i class="fa-duotone fa-solid fa-shapes text-2xl text-gray-400"></i>
                                                @endif
                                            </div>

                                            {{-- Label --}}
                                            <h6 class="text-xs font-semibold text-gray-800 dark:text-gray-200 truncate mb-1" title="{{ $icon->field_key }}">
                                                {{ $icon->field_key }}
                                            </h6>
                                            <span class="text-[10px] text-gray-400 font-mono">{{ $icon->size ?: 'base' }}</span>

                                            {{-- Status Dot --}}
                                            @if(!$icon->is_active)
                                                <span class="absolute top-2 start-2 w-2 h-2 rounded-full bg-red-500" title="{{ __('main.inactive') ?? 'Inactive' }}"></span>
                                            @endif

                                            {{-- Action Buttons --}}
                                            <div class="flex justify-center gap-1 mt-2 pt-2 border-t border-gray-100 dark:border-gray-700">
                                                <button wire:click="editIcon({{ $icon->id }})" class="kt-btn kt-btn-xs kt-btn-icon kt-btn-outline" title="{{ __('main.edit') ?? 'Edit' }}">
                                                    <i class="fa-duotone fa-solid fa-pen text-sm"></i>
                                                </button>
                                                <button wire:click="toggleActive({{ $icon->id }})" class="kt-btn kt-btn-xs kt-btn-icon {{ $icon->is_active ? 'kt-btn-success' : 'kt-btn-destructive' }}" title="{{ $icon->is_active ? __('main.deactivate') : __('main.activate') }}">
                                                    <i class="fa-solid fa-{{ $icon->is_active ? 'check' : 'xmark' }} text-sm"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <div class="flex flex-col items-center justify-center text-center py-16">
                                <i class="fa-duotone fa-solid fa-magnifying-glass-chart text-4xl text-gray-300 mb-3">
                                    
                                </i>
                                <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-1">{{ __('main.no_icons_found') ?? 'No icons found' }}</h4>
                                <p class="text-sm text-gray-500">{{ __('main.no_icons_desc') ?? 'Try a different search term or add a new icon.' }}</p>
                            </div>
                        @endforelse
                    </div>

                @else
                    {{-- ==================== TABLE VIEW ==================== --}}
                    <div class="table-responsive">
                        <table class="kt-table table-auto kt-table-border align-middle text-sm w-full">
                            <thead>
                                <tr class="text-xs uppercase text-gray-500 font-semibold bg-gray-50 dark:bg-coal-400">
                                    <th class="w-10 ps-4 rounded-s"></th>
                                    <th>{{ __('main.preview_details') ?? 'Preview & Details' }}</th>
                                    <th>{{ __('main.styling') ?? 'Styling' }}</th>
                                    <th>{{ __('main.status') ?? 'Status' }}</th>
                                    <th class="text-end w-28 pe-4 rounded-e">{{ __('main.actions') ?? 'Actions' }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($groupedIcons as $category => $groupIcons)
                                    <tr class="bg-gray-50 dark:bg-coal-400">
                                        <td colspan="5" class="py-2 ps-4">
                                            <span class="flex items-center gap-2 text-primary font-bold text-sm">
                                                <i class="fa-duotone fa-solid fa-layer-group"></i>
                                                {{ $category }}
                                                <span class="kt-badge kt-badge-primary kt-badge-outline kt-badge-xs ms-1">{{ count($groupIcons) }}</span>
                                            </span>
                                        </td>
                                    </tr>
                                    @foreach($groupIcons as $icon)
                                        <tr class="hover:bg-gray-50/50 dark:hover:bg-coal-400/50 {{ in_array($icon->id, $selectedIds) ? 'bg-primary/5' : '' }}">
                                            <td class="ps-4">
                                                <input class="checkbox checkbox-sm" type="checkbox" wire:model.live="selectedIds" value="{{ $icon->id }}" />
                                            </td>
                                            <td>
                                                <div class="flex items-center gap-3">
                                                    <div class="flex-shrink-0 flex items-center justify-center rounded-lg"
                                                         style="width: 40px; height: 40px; background-color: {{ $icon->bg_color_light ?: '#f1f5f9' }}; border: 1px solid {{ $icon->border_color_light ?: '#e2e8f0' }};">
                                                        @if($icon->icon_class)
                                                            <i class="{{ $icon->icon_class }} text-lg text-gray-700 dark:text-gray-300"></i>
                                                        @else
                                                            <i class="fa-duotone fa-solid fa-shapes text-lg text-gray-400"></i>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <span class="text-gray-900 dark:text-gray-100 font-bold text-sm">{{ $icon->field_key }}</span>
                                                        <code class="text-gray-400 text-xs font-mono block mt-0.5">{{ $icon->icon_class }}</code>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-xs text-gray-500">{{ $icon->shape ?: 'rounded-sm' }} · {{ $icon->weight ?: 'regular' }} · {{ $icon->size ?: 'base' }}</span>
                                            </td>
                                            <td>
                                                @if($icon->is_active)
                                                    <span class="kt-badge kt-badge-success kt-badge-outline px-3 py-1">{{ __('main.active') ?? 'Active' }}</span>
                                                @else
                                                    <span class="kt-badge kt-badge-destructive kt-badge-outline px-3 py-1">{{ __('main.inactive') ?? 'Inactive' }}</span>
                                                @endif
                                            </td>
                                            <td class="text-end pe-4">
                                                <button wire:click="editIcon({{ $icon->id }})" class="kt-btn kt-btn-icon kt-btn-outline kt-btn-sm me-1" title="{{ __('main.edit') ?? 'Edit' }}">
                                                    <i class="fa-duotone fa-solid fa-pen"></i>
                                                </button>
                                                <button wire:click="toggleActive({{ $icon->id }})" class="kt-btn kt-btn-icon kt-btn-outline kt-btn-sm" title="{{ $icon->is_active ? __('main.deactivate') : __('main.activate') }}">
                                                    <i class="fa-solid fa-{{ $icon->is_active ? 'check' : 'xmark' }}"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-12 text-center text-gray-400">{{ __('main.no_icons_found') ?? 'No icons found' }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ==================== EDIT/ADD MODAL ==================== --}}
    <div class="kt-modal" data-kt-modal="true" data-kt-modal-backdrop-static="true" id="edit_icon_modal" wire:ignore.self>
        <div class="kt-modal-content max-w-[650px] top-[5%]">
                {{-- Header --}}
                <div class="kt-modal-header">
                    <h3 class="kt-modal-title">{{ $editingIconId ? (__('main.edit_icon') ?? 'Edit Icon') : (__('main.add_icon') ?? 'Add New Icon') }}</h3>
                    <button type="button" class="kt-modal-close" aria-label="Close modal" data-kt-modal-dismiss="#edit_icon_modal">
                        <i class="fa-duotone fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>
                {{-- Body --}}
                <div class="kt-modal-body">
                    {{-- Live Preview --}}
                    <div class="mb-6 text-center bg-gray-50 dark:bg-coal-500 p-5 rounded-xl border border-dashed border-gray-200 dark:border-gray-700">
                        <div class="inline-flex items-center justify-center rounded-lg"
                             style="width: 72px; height: 72px; background-color: {{ $editingIcon['bg_color_light'] ?? '#ffffff' }}; border: 2px solid {{ $editingIcon['border_color_light'] ?? '#e4e6ef' }};">
                            @if(!empty($editingIcon['icon_class']))
                                <i class="{{ $editingIcon['icon_class'] }} text-3xl text-gray-700"></i>
                            @else
                                <i class="fa-duotone fa-solid fa-star text-3xl text-gray-400"></i>
                            @endif
                        </div>
                        <p class="text-gray-400 text-xs mt-2">{{ __('main.live_preview') ?? 'Live Preview' }}</p>
                    </div>

                    {{-- Key & Class --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">{{ __('main.icon_key') ?? 'Icon Key' }}</label>
                            <input type="text" wire:model="editingIcon.field_key" class="input input-sm w-full" placeholder="sidebar_dashboard" />
                            @error('editingIcon.field_key') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">{{ __('main.icon_class') ?? 'CSS Class' }}</label>
                            <input type="text" wire:model.live="editingIcon.icon_class" class="input input-sm w-full" placeholder="fa-duotone fa-solid fa-house" />
                            @error('editingIcon.icon_class') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Theme Colors --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="bg-gray-50 dark:bg-coal-500 p-4 rounded-xl border border-gray-200 dark:border-gray-700">
                            <h5 class="font-bold text-xs text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                                <i class="fa-duotone fa-solid fa-sun text-warning"></i>
                                {{ __('main.light_theme') ?? 'Light Theme' }}
                            </h5>
                            <div class="mb-3">
                                <label class="text-xs text-gray-500 mb-1 block">{{ __('main.background_color') ?? 'Background' }}</label>
                                <input type="color" wire:model="editingIcon.bg_color_light" class="w-full h-8 rounded cursor-pointer border border-gray-200" />
                            </div>
                            <div>
                                <label class="text-xs text-gray-500 mb-1 block">{{ __('main.border_color') ?? 'Border' }}</label>
                                <input type="color" wire:model="editingIcon.border_color_light" class="w-full h-8 rounded cursor-pointer border border-gray-200" />
                            </div>
                        </div>
                        <div class="bg-gray-800 p-4 rounded-xl border border-gray-600">
                            <h5 class="font-bold text-xs text-gray-200 mb-3 flex items-center gap-2">
                                <i class="fa-duotone fa-solid fa-moon text-primary"></i>
                                {{ __('main.dark_theme') ?? 'Dark Theme' }}
                            </h5>
                            <div class="mb-3">
                                <label class="text-xs text-gray-400 mb-1 block">{{ __('main.background_color') ?? 'Background' }}</label>
                                <input type="color" wire:model="editingIcon.bg_color_dark" class="w-full h-8 rounded cursor-pointer border border-gray-600" />
                            </div>
                            <div>
                                <label class="text-xs text-gray-400 mb-1 block">{{ __('main.border_color') ?? 'Border' }}</label>
                                <input type="color" wire:model="editingIcon.border_color_dark" class="w-full h-8 rounded cursor-pointer border border-gray-600" />
                            </div>
                        </div>
                    </div>

                    {{-- Shape / Size / Weight --}}
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold mb-1 text-gray-700 dark:text-gray-300">{{ __('main.shape') ?? 'Shape' }}</label>
                            <select wire:model="editingIcon.shape" class="select select-sm w-full">
                                <option value="rounded-0">{{ __('main.square') ?? 'Square' }}</option>
                                <option value="rounded-sm">{{ __('main.slightly_rounded') ?? 'Slightly Rounded' }}</option>
                                <option value="rounded">{{ __('main.rounded') ?? 'Rounded' }}</option>
                                <option value="rounded-circle">{{ __('main.circle') ?? 'Circle' }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold mb-1 text-gray-700 dark:text-gray-300">{{ __('main.size') ?? 'Size' }}</label>
                            <select wire:model="editingIcon.size" class="select select-sm w-full">
                                <option value="sm">Small</option>
                                <option value="base">Base</option>
                                <option value="lg">Large</option>
                                <option value="xl">Extra Large</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold mb-1 text-gray-700 dark:text-gray-300">{{ __('main.weight') ?? 'Weight' }}</label>
                            <select wire:model="editingIcon.weight" class="select select-sm w-full">
                                <option value="regular">Regular</option>
                                <option value="solid">Solid</option>
                                <option value="duotone">Duotone</option>
                            </select>
                        </div>
                    </div>
                </div>
                {{-- Footer --}}
                <div class="kt-modal-footer">
                    <div></div>
                    <div class="flex gap-3">
                        <button type="button" class="kt-btn kt-btn-secondary" data-kt-modal-dismiss="#edit_icon_modal">{{ __('main.cancel') ?? 'Cancel' }}</button>
                        @if($editingIconId)
                            <button wire:click="saveIcon" class="kt-btn kt-btn-primary">
                                <span wire:loading.remove wire:target="saveIcon">
                                    <i class="fa-duotone fa-solid fa-check me-1"></i> {{ __('main.update_config') ?? 'Update' }}
                                </span>
                                <span wire:loading wire:target="saveIcon">
                                    <span class="animate-spin inline-block size-4 border-2 border-current border-t-transparent rounded-full me-2"></span> {{ __('main.saving') ?? 'Saving...' }}
                                </span>
                            </button>
                        @else
                            <button wire:click="saveNewIcon" class="kt-btn kt-btn-primary">
                                <span wire:loading.remove wire:target="saveNewIcon">
                                    <i class="fa-duotone fa-solid fa-plus me-1"></i> {{ __('main.add_icon') ?? 'Add Icon' }}
                                </span>
                                <span wire:loading wire:target="saveNewIcon">
                                    <span class="animate-spin inline-block size-4 border-2 border-current border-t-transparent rounded-full me-2"></span> {{ __('main.saving') ?? 'Saving...' }}
                                </span>
                            </button>
                        @endif
                    </div>
                </div>
        </div>
    </div>

    {{-- ==================== BULK EDIT MODAL ==================== --}}
    <div class="kt-modal" data-kt-modal="true" data-kt-modal-backdrop-static="true" id="bulk_edit_modal" wire:ignore.self>
        <div class="kt-modal-content max-w-[500px] top-[10%]">
                <div class="kt-modal-header">
                    <h3 class="kt-modal-title">{{ __('main.bulk_config') ?? 'Bulk Configuration' }}</h3>
                    <button type="button" class="kt-modal-close" aria-label="Close modal" data-kt-modal-dismiss="#bulk_edit_modal">
                        <i class="fa-duotone fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>
                <div class="kt-modal-body">
                    <div class="bg-primary/5 border border-primary/20 p-4 rounded-xl mb-6 flex items-start gap-3">
                        <i class="fa-duotone fa-solid fa-circle-info text-primary text-2xl mt-0.5"></i>
                        <p class="text-sm text-gray-600 dark:text-gray-300 m-0">{{ __('main.bulk_info') ?? 'Only filled fields will be applied to selected icons.' }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-5">
                        <div>
                            <label class="text-xs font-semibold text-gray-600 mb-1 block">{{ __('main.light_bg') ?? 'Light BG' }}</label>
                            <input type="color" wire:model="bulkState.bg_color_light" class="w-full h-8 rounded cursor-pointer border border-gray-200" />
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-600 mb-1 block">{{ __('main.dark_bg') ?? 'Dark BG' }}</label>
                            <input type="color" wire:model="bulkState.bg_color_dark" class="w-full h-8 rounded cursor-pointer border border-gray-200" />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-semibold text-gray-600 mb-1 block">{{ __('main.shape') ?? 'Shape' }}</label>
                            <select wire:model="bulkState.shape" class="select select-sm w-full">
                                <option value="">-- {{ __('main.no_change') ?? 'No Change' }} --</option>
                                <option value="rounded-0">{{ __('main.square') ?? 'Square' }}</option>
                                <option value="rounded-sm">{{ __('main.slightly_rounded') ?? 'Slightly Rounded' }}</option>
                                <option value="rounded-circle">{{ __('main.circle') ?? 'Circle' }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-600 mb-1 block">{{ __('main.size') ?? 'Size' }}</label>
                            <select wire:model="bulkState.size" class="select select-sm w-full">
                                <option value="">-- {{ __('main.no_change') ?? 'No Change' }} --</option>
                                <option value="sm">Small</option>
                                <option value="base">Base</option>
                                <option value="lg">Large</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="kt-modal-footer">
                    <div></div>
                    <div class="flex gap-3">
                        <button type="button" class="kt-btn kt-btn-secondary" data-kt-modal-dismiss="#bulk_edit_modal">{{ __('main.cancel') ?? 'Cancel' }}</button>
                        <button wire:click="applyBulkChanges" class="kt-btn kt-btn-primary">
                            <i class="fa-duotone fa-solid fa-check me-1"></i> {{ __('main.apply_bulk') ?? 'Apply Changes' }}
                        </button>
                    </div>
                </div>
        </div>
    </div>

    {{-- ==================== JAVASCRIPT (KTModal API) ==================== --}}
    <script>
        document.addEventListener('livewire:initialized', () => {
            // Open Edit/Add Modal
            Livewire.on('open-edit-modal', () => {
                const modalEl = document.getElementById('edit_icon_modal');
                if (modalEl && window.KTModal) {
                    const modal = KTModal.getOrCreateInstance(modalEl);
                    modal.show();
                }
            });

            // Close Edit/Add Modal
            Livewire.on('close-edit-modal', () => {
                const modalEl = document.getElementById('edit_icon_modal');
                if (modalEl && window.KTModal) {
                    const modal = KTModal.getInstance(modalEl);
                    if (modal) modal.hide();
                }
            });

            // Open Bulk Modal
            Livewire.on('open-bulk-modal', () => {
                const modalEl = document.getElementById('bulk_edit_modal');
                if (modalEl && window.KTModal) {
                    const modal = KTModal.getOrCreateInstance(modalEl);
                    modal.show();
                }
            });

            // Close Bulk Modal
            Livewire.on('close-bulk-modal', () => {
                const modalEl = document.getElementById('bulk_edit_modal');
                if (modalEl && window.KTModal) {
                    const modal = KTModal.getInstance(modalEl);
                    if (modal) modal.hide();
                }
            });

            // Notify via KTToast
            Livewire.on('notify', (data) => {
                const d = Array.isArray(data) ? data[0] : data;
                if (window.KTToast) {
                    KTToast.show({ variant: d.type || 'success', message: d.message || '', duration: 4000, dismiss: true });
                }
            });
        });
    </script>
</div>
