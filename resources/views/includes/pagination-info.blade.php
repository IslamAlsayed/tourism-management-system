<div class="flex-wrap gap-2 p-2">
    <div class="w-full flex justify-between items-start">
        {{-- Pagination Info --}}
        @if (isset($data) && !empty($data) && $data->count() > 0)
            <div class="pagination-showing">
                <p class="text-sm text-gray-600 p-2">
                    {{ __('main.showing') }} {{ $data->firstItem() ?? 0 }} -
                    <strong class="text-primary">{{ $data->lastItem() ?? 0 }}</strong>
                    {{ __('main.of') }} {{ $data->total() }} {{ isset($entityName) ? $entityName : __('main.items') }}
                    @if ($data->hasPages())
                        <span class="text-blue-600">({{ __('main.page') }} {{ $data->currentPage() }} {{ __('main.of') }}
                            {{ $data->lastPage() }})</span>
                    @endif
                </p>
            </div>
        @else
            <div></div>
        @endif

        {{-- selected items count --}}
        <div class="flex gap-2">
            <span id="selectedCount" style="align-self: anchor-center;"></span>
            <div class="flex flex-wrap gap-2 lg:gap-5">
                <button type="button" id="deleteAllBtn" data-route="{{ route('deleteAll') }}"
                    data-model="{{ isset($entityName) ? lcfirst($entityName) : '' }}"
                    title="{{ __('main.delete_selected') }}"
                    class="deleteAllBtn hidden kt-btn kt-btn-outline bg-secondary px-3 h-[45px]">
                    <i class="fas fa-trash text-red-600"></i>
                </button>
            </div>

            {{-- Reset Sort Button
            @if (isset($sortField) && !empty($sortField))
                <div class="flex items-center">
                    <button type="button" wire:click="resetSort" title="{{ __('main.reset_sort') }}" toggle-button
            class="kt-btn kt-btn-outline bg-white px-3 h-[45px] hover:bg-gray-50 transition-colors">
            <i class="fas fa-arrow-rotate-left text-blue-600 me-1"></i>
            <span class="text-sm">{{ __('main.reset_sort') }}</span>
            </button>
        </div>
        @endif --}}

            @isset($slot)
                {{ $slot }}
            @endisset

            {{-- Search input --}}
            @if (isset($showSearch) && $showSearch)
                <div class="flex flex-wrap gap-2 lg:gap-5">
                    <div class="flex items-center search-container" id="search-container">
                        <label class="kt-input h-[45px]">
                            <input wire:model.live="search" class="py-2 rounded-lg" id="search"
                                placeholder="{{ __('main.search_in') }} {{ isset($title) ? $title : __('main.items') }}..."
                                autocomplete="off" />
                        </label>

                        @if (isset($searchValue) && $searchValue)
                            <i class="fas fa-xmark text-red-600 cursor-pointer" wire:click="$set('search', '')"
                                onclick="setTimeout(() => search.value = '', 500);"></i>
                        @endif
                        <div class="search-load">
                            <div wire:loading wire:target="search">
                                @include('components.load-data')
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Progress bar showing current page position --}}
    @if (isset($data) &&
            !empty($data) &&
            getPaginate() != config('app.paginate_max') &&
            $data->hasPages() &&
            $data->lastPage() > 1)
        <div class="w-full mt-3">
            <div class="flex items-center gap-2 text-xs text-gray-500">
                <span>{{ __('main.progress') }}:</span>
                <div class="flex-1 bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-300"
                        style="width: {{ ($data->currentPage() / $data->lastPage()) * 100 }}%"></div>
                </div>
                <span>{{ number_format(($data->currentPage() / $data->lastPage()) * 100, 1) }}%</span>
            </div>
        </div>
    @endif
</div>
