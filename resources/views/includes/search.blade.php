<div class="kt-card-header flex-wrap gap-2">
    <h3 class="kt-card-title text-sm">
        Showing {{ $count }} of {{ $totalCount }} users
    </h3>
    <div class="flex flex-wrap gap-2 lg:gap-5">
        <div class="flex">
            <label class="kt-input">
                <i class="ki-filled ki-magnifier"></i>
                <input wire:model.live="search" data-kt-datatable-search="#team_crew_table" placeholder="Search users"
                    type="text" value="" />
            </label>
        </div>
    </div>
</div>
