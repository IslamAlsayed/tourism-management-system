<div id="parentColumnsModal">
    <div id="columns" data-target-button="#columnsModal"
        class="columns kt-btn kt-btn-outline bg-secondary text-white px-3 h-[45px] cursor-default">
        <i class="fas fa-list"></i>
    </div>

    <div class="hidden" data-target-model="#columnsModal" id="columnsModal"
        style="{{ app()->getLocale() == 'ar' ? 'right: auto; left: 0;' : 'left: auto; right: 0;' }}">

        <div class="grid grid-cols-3 gap-2">
            @foreach ($allColumns as $column)
                <div class="flex flex-wrap items-center gap-2 text-sm text-gray-600">
                    <input type="checkbox" wire:model.defer="pendingColumns" value="{{ $column }}"
                        id="{{ $column }}" class="kt-checkbox kt-checkbox-sm"
                        style="width: 15px; height: 15px;" />
                    <label for="{{ $column }}">
                        {{ ucfirst(__('main.' . $column)) }}
                        {!! in_array($column, $relations) ? '<span class="text-red-600">R</span>' : '' !!}
                    </label>
                </div>
            @endforeach
        </div>

        <div class="w-full flex justify-end mt-4">
            <div type="button" wire:click="applyColumns"
                class="kt-btn kt-btn-outline bg-primary text-white px-3 h-[40px] rounded">
                {{ __('Apply') }}
            </div>
        </div>
    </div>
</div>
