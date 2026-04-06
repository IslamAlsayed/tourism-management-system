<div class="kt-card-header flex-wrap gap-2">
    <h3 class="kt-card-title text-sm">
        {{ __('main.showing_count') }} {{ $count }} {{ __('main.of_total') }} {{ $totalCount }}
        {{ __('main.users') }}
    </h3>
    <div class="flex flex-wrap gap-2 lg:gap-5">
        <div class="flex">
            <label class="kt-input h-[45px]">
                <i class="fa-duotone fa-solid fa-magnifying-glass"></i>
                <input wire:model.live="search" data-kt-datatable-search="#team_crew_table"
                    placeholder="{{ __('main.search_placeholder') }}" type="text" value="" />
            </label>
        </div>
    </div>
</div>
