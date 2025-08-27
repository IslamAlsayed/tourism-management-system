{{-- Enhanced pagination information component --}}
<div class="kt-card-footer border-t border-gray-200 bg-gray-50">
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        {{-- Records per page selector --}}
        <div class="flex items-center gap-2 text-sm text-gray-600">
            <span>{{ __('main.show') }}</span>
            <select wire:model.live="perPage" class="kt-select w-20 px-2 py-1 border rounded">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <span>{{ __('main.items_per_page') }}</span>
        </div>

        {{-- Pagination info and links --}}
        <div class="flex items-center gap-4">
            <div class="text-sm text-gray-600">
                {{ $data->firstItem() }} - {{ $data->lastItem() }} {{ __('main.of') }}
                {{ $data->total() }}
            </div>

            {{-- Pagination Links --}}
            @if ($data->hasPages())
                <div class="flex items-center gap-1">
                    {{-- Previous Page Link --}}
                    @if ($data->onFirstPage())
                        <span
                            class="px-3 py-1 text-gray-400 bg-gray-200 rounded cursor-not-allowed">{{ __('main.previous') }}</span>
                    @else
                        <button wire:click="previousPage"
                            class="px-3 py-1 text-blue-600 bg-white border border-gray-300 rounded hover:bg-blue-50">
                            {{ __('main.previous') }}
                        </button>
                    @endif

                    {{-- Page Numbers --}}
                    @for ($i = max(1, $data->currentPage() - 2); $i <= min($data->lastPage(), $data->currentPage() + 2); $i++)
                        @if ($i == $data->currentPage())
                            <span class="px-3 py-1 text-white bg-blue-600 rounded">{{ $i }}</span>
                        @else
                            <button wire:click="gotoPage({{ $i }})"
                                class="px-3 py-1 text-blue-600 bg-white border border-gray-300 rounded hover:bg-blue-50">
                                {{ $i }}
                            </button>
                        @endif
                    @endfor

                    {{-- Next Page Link --}}
                    @if ($data->hasMorePages())
                        <button wire:click="nextPage"
                            class="px-3 py-1 text-blue-600 bg-white border border-gray-300 rounded hover:bg-blue-50">
                            {{ __('main.next') }}
                        </button>
                    @else
                        <span
                            class="px-3 py-1 text-gray-400 bg-gray-200 rounded cursor-not-allowed">{{ __('main.next') }}</span>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
