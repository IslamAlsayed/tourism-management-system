<div id="parentColumnsModal"
    wire:target="deleteSelected,exportSelectedPDF,exportSelectedExcel,toggleAll,resetColumns,applyColumns"
    wire:loading.class="loading">
    @if (isset($view) && $view)
        <div wire:click="toggleView" class="kt-btn kt-btn-outline bg-secondary text-white px-3 h-[45px] cursor-pointer">
            <i class="fas fa-{{ $view == 'grid' ? 'table-list' : 'grid' }}"></i>
        </div>
    @endif

    <div class="kt-menu {{ $selectedIds && count($selectedIds) ? '' : 'hidden' }}" data-kt-menu="true">
        <button class="kt-menu-toggle kt-btn kt-btn-outline bg-danger text-white px-3 h-[45px] cursor-default"
            wire:click="deleteSelected">
            <span class="kt-menu-title">Delete</span>
        </button>
    </div>

    <div class="kt-menu {{ $selectedIds && count($selectedIds) ? '' : 'hidden' }}" data-kt-menu="true">
        <div class="kt-menu-item" data-kt-menu-item-offset="0, 10px" data-kt-menu-item-placement="bottom-end"
            data-kt-menu-item-placement-rtl="bottom-start" data-kt-menu-item-toggle="dropdown"
            data-kt-menu-item-trigger="click">
            <button class="kt-menu-toggle kt-btn kt-btn-outline bg-primary text-white px-3 h-[45px] cursor-default">
                <span class="kt-menu-title">Export</span>
            </button>
            <div class="kt-menu-dropdown kt-menu-default w-full max-w-[175px]" data-kt-menu-dismiss="true">
                <div class="kt-menu-item">
                    <button class="kt-menu-link {{ $pendingColumns && count($pendingColumns) > 7 ? 'disabled' : '' }}"
                        {{ $pendingColumns && count($pendingColumns) > 7 ? 'style=background: var(--color-yellow-100);' : '' }}
                        wire:click="exportSelectedPDF">
                        <span class="kt-menu-title">PDF</span>
                        @if ($pendingColumns && count($pendingColumns) > 7)
                            <span class="text-yellow-600" style="font-size: 14px;">اقل من 7 أعمدة</span>
                        @endif
                    </button>
                </div>
                <div class="kt-menu-item">
                    <button class="kt-menu-link" wire:click="exportSelectedExcel('csv')">
                        <span class="kt-menu-title">CSV</span>
                    </button>
                </div>
                <div class="kt-menu-item">
                    <button class="kt-menu-link" wire:click="exportSelectedExcel('xlsx')">
                        <span class="kt-menu-title">XLSX</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="columns" data-target-button="#columnsModal"
        class="columns kt-btn kt-btn-outline bg-secondary text-white px-3 h-[45px] cursor-default">
        <i class="fas fa-list"></i>
    </div>

    <div class="hidden" data-target-model="#columnsModal" id="columnsModal"
        style="{{ app()->getLocale() == 'ar' ? 'right: auto; left: 0; direction: ltr;' : 'left: auto; right: 0; direction: ltr;' }}">
        @if (isset($allColumns) && count($allColumns) > 0)
            <div class="grid grid-cols-2 xl:grid-cols-3 gap-2">
                @foreach ($allColumns as $column)
                    <div class="custom-input" title="{{ __('main.' . $column) }}"
                        wire:key="col-{{ $column }}-{{ in_array($column, $pendingColumns) ? '1' : '0' }}">
                        <input type="checkbox" name="remember" wire:model="pendingColumns" value="{{ $column }}"
                            id="col-{{ $column }}">
                        <label for="col-{{ $column }}">
                            {{ limitedText(ucfirst(__('main.' . $column)), 15) }}
                            {!! in_array($column, $relations) ? '<span class="text-red-600">R</span>' : '' !!}
                        </label>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="w-full flex justify-end gap-2 mt-4 h-[40px] actions-buttons">
            {{-- select all button --}}
            @if (isset($pendingColumns) && count($pendingColumns) < count($allColumns))
                <div class="kt-btn kt-btn-outline bg-secondary px-3" type="button" wire:click="toggleAll"
                    wire:loading.attr="disabled" toggle-button>
                    <label for="toggleAll" class="cursor-pointer">
                        {{ __('main.all_columns') }}
                    </label>
                </div>
            @endif

            {{-- check if user has custom columns --}}
            @if (isset($hasCustomColumns) && $hasCustomColumns)
                <div type="button" wire:click="resetColumns" wire:loading.attr="disabled" toggle-button
                    class="kt-btn kt-btn-outline bg-danger text-white px-3 rounded">
                    {{ __('main.reset_to_default') }}
                </div>
            @endif

            {{-- apply button --}}
            <div type="button" wire:click="applyColumns" wire:loading.attr="disabled" toggle-button
                class="kt-btn kt-btn-outline bg-primary text-white px-3 rounded">
                {{ __('main.apply') }}
            </div>
        </div>
    </div>
</div>
