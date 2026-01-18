<div id="parentColumnsModal">

    @if (isset($view) && $view)
        <div wire:click="toggleView" class="kt-btn kt-btn-outline bg-secondary text-white px-3 h-[45px] cursor-pointer">
            <i class="fas fa-{{ $view == 'grid' ? 'table-list' : 'grid' }}"></i>
        </div>
    @endif

    @if ($selectedIds && count($selectedIds) > 0)
        <div class="kt-menu" data-kt-menu="true">
            <button
                class="user-action relative kt-menu-toggle kt-btn kt-btn-outline bg-danger text-white px-3 h-[45px] cursor-default"
                wire:click="deleteSelected" wire:loading.attr="disabled" wire:target="deleteSelected">
                <span class="kt-menu-title">
                    {{ __('main.delete') . ' (' . count($selectedIds) . ' ' . __('main.items') . ')' }}
                </span>
                {{-- <span wire:loading wire:target="deleteSelected"> --}}
                <span class="hidden absolute top-50 left-50 translate-50" id="loading-spinner">
                    @include('components.load-data', ['color' => 'var(--color-white)'])
                </span>
            </button>
        </div>

        <div class="kt-menu" data-kt-menu="true">
            <div class="kt-menu-item" data-kt-menu-item-offset="0, 10px" data-kt-menu-item-placement="bottom-end"
                data-kt-menu-item-placement-rtl="bottom-start" data-kt-menu-item-toggle="dropdown"
                data-kt-menu-item-trigger="click">
                <button
                    class="user-action relative kt-menu-toggle kt-btn kt-btn-outline bg-primary text-white px-3 h-[45px] cursor-default">
                    <span class="kt-menu-title">
                        {{ __('main.export') . ' (' . count($selectedIds) . ' ' . __('main.items') . ')' }}
                    </span>
                    <span class="hidden absolute top-50 left-50 translate-50" id="loading-spinner">
                        @include('components.load-data', ['color' => 'var(--color-white)'])
                    </span>
                </button>
                <div class="kt-menu-dropdown kt-menu-default w-full max-w-[175px]" data-kt-menu-dismiss="true">
                    <div class="kt-menu-item">
                        <button
                            class="kt-menu-link {{ $pendingColumns && count($pendingColumns) > 7 ? 'disabled' : '' }}"
                            {{ $pendingColumns && count($pendingColumns) > 7 ? 'style=background: var(--color-yellow-100);' : '' }}
                            wire:click="exportSelectedPDF" wire:loading.attr="disabled" wire:target="exportSelectedPDF">
                            <span class="kt-menu-title">
                                {{ __('main.pdf') . ' (' . count($selectedIds) . ' ' . __('main.items') . ')' }}
                            </span>
                            @if ($pendingColumns && count($pendingColumns) > 7)
                                <span class="text-yellow-600" style="font-size: 14px;">
                                    {{ __('main.less_than_count_columns') }}
                                </span>
                            @endif
                            <span wire:loading wire:target="exportSelectedPDF">
                                <i class="fas fa-spinner fa-spin ms-2"></i>
                            </span>
                        </button>
                    </div>
                    <div class="kt-menu-item">
                        <button class="kt-menu-link" wire:click="exportSelectedExcel('csv')"
                            wire:loading.attr="disabled" wire:target="exportSelectedExcel">
                            <span class="kt-menu-title">
                                {{ __('main.csv') . ' (' . count($selectedIds) . ' ' . __('main.items') . ')' }}
                            </span>
                            <span wire:loading wire:target="exportSelectedExcel">
                                <i class="fas fa-spinner fa-spin ms-2"></i>
                            </span>
                        </button>
                    </div>
                    <div class="kt-menu-item">
                        <button class="kt-menu-link" wire:click="exportSelectedExcel('xlsx')"
                            wire:loading.attr="disabled" wire:target="exportSelectedExcel">
                            <span class="kt-menu-title">
                                {{ __('main.xlsx') . ' (' . count($selectedIds) . ' ' . __('main.items') . ')' }}
                            </span>
                            <span wire:loading wire:target="exportSelectedExcel">
                                <i class="fas fa-spinner fa-spin ms-2"></i>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div id="columns" data-target-button="#columnsModal"
        class="columns kt-btn kt-btn-outline bg-secondary text-white px-3 h-[45px] cursor-default">
        <i class="fas fa-list"></i>
    </div>

    <div class="hidden background" data-target-model="#columnsModal" id="columnsModal"
        style="{{ app()->getLocale() == 'ar' ? 'right: auto; left: 0; direction: ltr;' : 'left: auto; right: 0; direction: ltr;' }}">

        @if (isset($allColumns) && count($allColumns) > 0)
            <div class="grid grid-cols-2 xl:grid-cols-3 gap-2 pt-1">

                @foreach ($allColumns as $column)
                    @if ($column == 'uuid' && $settings->app_show_uuid_column == 0)
                        @continue
                    @endif
                    @php
                        $translated = __('main.' . (string) $column);
                        $labelText = is_array($translated)
                            ? ucfirst(str_replace('_', ' ', (string) $column))
                            : $translated;
                    @endphp
                    <div class="custom-input" title="{{ $labelText }}" wire:key="col-{{ (string) $column }}">
                        <input type="checkbox" wire:model="pendingColumns" value="{{ (string) $column }}"
                            id="col-{{ (string) $column }}">
                        <label for="col-{{ (string) $column }}">
                            {{ limitedText(ucfirst($labelText), 15) }}
                            {!! in_array($column, $relations) ? '<span class="text-red-600">R</span>' : '' !!}
                        </label>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="w-full flex justify-end gap-2 mt-4 h-[40px] actions-buttons">
            {{-- All Columns button - shows when not all columns are selected --}}

            @if (isset($pendingColumns) && count($pendingColumns) < count($allColumns))
                <div class="kt-btn kt-btn-outline bg-secondary px-3" type="button" wire:click="toggleAll"
                    onclick="document.getElementById('columnsModal').classList.add('hidden'); setTimeout(() => window.location.reload(), 50)"
                    wire:loading.attr="disabled" toggle-button>
                    <label for="selectAllColumns" class="cursor-pointer">
                        {{ __('main.all_columns') }}
                    </label>
                </div>
            @endif
            {{-- @if (isset($showAllColumnsButton) && $showAllColumnsButton) --}}
            {{-- <button type="button" wire:click="selectAllColumns" wire:loading.attr="disabled"
             class="kt-btn kt-btn-outline bg-secondary text-white px-3 rounded">
                class="kt-btn kt-btn-outline bg-secondary px-3">
                <span wire:loading.remove wire:target="selectAllColumns">
                    {{ __('main.all_columns') }}
                </span>
                <span wire:loading wire:target="selectAllColumns">
                    <i class="fas fa-spinner fa-spin"></i>
                </span>
            </button> --}}
            {{-- @endif --}}

            {{-- Reset to Default button - shows when user has custom columns --}}
            @if (isset($hasCustomColumns) && $hasCustomColumns)
                <button type="button" wire:click="resetColumns" wire:loading.attr="disabled"
                    onclick="setTimeout(() => window.location.reload(), 50)"
                    class="kt-btn kt-btn-outline bg-danger text-white px-3 rounded">
                    <span wire:loading.remove wire:target="resetColumns">
                        {{ __('main.reset_to_default') }}
                    </span>
                    <span wire:loading wire:target="resetColumns">
                        <i class="fas fa-spinner fa-spin"></i>
                    </span>
                </button>
            @endif

            {{-- Apply button --}}
            <button type="button" wire:click="applyColumns" onclick="setTimeout(() => window.location.reload(), 50)"
                wire:loading.attr="disabled" class="kt-btn kt-btn-outline bg-primary text-white px-3 rounded">
                <span wire:loading.remove wire:target="applyColumns">
                    {{ __('main.apply') }}
                </span>
                <span wire:loading wire:target="applyColumns">
                    <i class="fas fa-spinner fa-spin"></i>
                </span>
            </button>
        </div>
    </div>
</div>
