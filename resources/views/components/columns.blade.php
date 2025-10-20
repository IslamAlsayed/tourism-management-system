<div id="parentColumnsModal">
    @if (isset($view) && $view)
        <div wire:click="toggleView" class="kt-btn kt-btn-outline bg-secondary text-white px-3 h-[45px] cursor-pointer"
            style="font-size: 16px;">
            <i class="fas fa-{{ $view == 'grid' ? 'grid' : 'table-list' }}"></i>
        </div>
    @endif

    <div id="columns" data-target-button="#columnsModal"
        class="columns kt-btn kt-btn-outline bg-secondary text-white px-3 h-[45px] cursor-default"
        style="font-size: 16px;">
        <i class="fas fa-list"></i>
    </div>

    <div class="hidden" data-target-model="#columnsModal" id="columnsModal"
        style="{{ app()->getLocale() == 'ar' ? 'right: auto; left: 0;' : 'left: auto; right: 0;' }}">
        <div class="grid grid-cols-2 xl:grid-cols-3 gap-2">
            @foreach ($allColumns as $column)
                <div wire:key="col-{{ $column }}-{{ in_array($column, $pendingColumns) ? '1' : '0' }}">
                    <input type="checkbox" wire:model="pendingColumns" value="{{ $column }}"
                        id="col-{{ $column }}" class="kt-checkbox kt-checkbox-sm">
                    <label for="col-{{ $column }}">
                        {{ limitedText(ucfirst(__('main.' . $column)), 15) }}
                        {!! in_array($column, $relations) ? '<span class="text-red-600">R</span>' : '' !!}
                    </label>
                </div>
            @endforeach
        </div>

        <div class="w-full flex justify-end gap-2 mt-4 h-[40px]">
            <div class="kt-btn kt-btn-outline bg-secondary px-3" type="button" wire:click="toggleAll" toggle-input>
                <div
                    class="custom-sm-toggle-input {{ count(array_diff($pendingColumns, ['all'])) === count($allColumns) ? 'active' : '' }}">
                    <div class="handle"></div>
                </div>

                <label for="toggleAll">
                    {{ __('main.all_columns') }}
                </label>
            </div>

            <div type="button" wire:click="applyColumns"
                class="kt-btn kt-btn-outline bg-primary text-white px-3 rounded">
                {{ __('Apply') }}
            </div>
        </div>
    </div>
</div>
