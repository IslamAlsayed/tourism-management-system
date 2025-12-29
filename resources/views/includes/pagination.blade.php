{{-- Enhanced pagination information component --}}
<div class="kt-card-footer border-t border-gray-200 bg-gray-50">
    <div class="w-full flex justify-between items-center gap-4">
        {{-- Records per page selector --}}
        <div class="flex items-center gap-2 text-sm text-gray-600">
            <span>{{ __('main.show') }}</span>

            {{-- Generate options from config array --}}
            @if (config('app.paginate_array'))
                <select wire:model.live="paginate" name="paginate" id="paginate"
                    class="kt-select w-20 px-2 py-1 border rounded" style="width: 65px">
                    @foreach (config('app.paginate_array') as $limit)
                        <option value="{{ $limit }}">{{ $limit }}</option>
                    @endforeach
                </select>
            @endif
            <span class="items_per_page">{{ __('main.items_per_page') }}</span>
        </div>

        {{-- Pagination info and links --}}
        @if (getPaginate() != config('app.paginate_max'))
            <div class="flex items-center gap-4">
                <div class="text-sm text-gray-600 details_info">
                    {{ $data->firstItem() ?? 0 }} - {{ $data->lastItem() ?? 0 }} {{ __('main.of') }}
                    {{ $data->total() ?? 0 }}
                </div>

                <div class="flex items-center gap-1">
                    {{-- Previous --}}
                    <span>
                        <button wire:click="previousPage"
                            class="px-3 py-1 text-blue-600 background border border-gray-300 rounded hover:bg-gray-50 cursor-pointer previousPage"
                            @if ($data->onFirstPage()) disabled @endif>
                            <span>&laquo;</span><span class="s">{{ __('main.previous') }}</span>
                        </button>
                    </span>

                    <div class="flex items-center gap-1" id="pagination_links">
                        {{-- First Page --}}
                        <span>
                            <button wire:click="gotoPage(1)" wire:key="page-1"
                                class="px-3 py-1 border border-gray-300 rounded cursor-pointer @if ($data->currentPage() == 1) text-white bg-blue-600 @else text-blue-600 background hover:bg-blue-50 @endif">
                                1
                            </button>
                        </span>

                        {{-- Left Dots --}}
                        @if ($data->currentPage() > 4)
                            <span><span>...</span></span>
                        @endif

                        {{-- Middle Pages (max 5 pages dynamic) --}}
                        @php
                            $start = max(2, $data->currentPage() - 2);
                            $end = min($data->lastPage() - 1, $data->currentPage() + 2);

                            // Ensure we always show 5 pages when possible
                            if ($data->currentPage() <= 3) {
                                $end = min(6, $data->lastPage() - 1);
                            }

                            if ($data->currentPage() >= $data->lastPage() - 2) {
                                $start = max($data->lastPage() - 5, 2);
                            }
                        @endphp

                        @for ($i = $start; $i <= $end; $i++)
                            <button wire:click="gotoPage({{ $i }})" wire:key="page-{{ $i }}"
                                class="px-3 py-1 border border-gray-300 rounded cursor-pointer @if ($i == $data->currentPage()) text-white bg-blue-600 @else text-blue-600 background hover:bg-blue-50 @endif">
                                {{ $i }}
                            </button>
                        @endfor

                        {{-- Right Dots --}}
                        @if ($data->currentPage() < $data->lastPage() - 3)
                            <span><span>...</span></span>
                        @endif

                        {{-- Last Page --}}
                        @if ($data->lastPage() > 1)
                            <span>
                                <button wire:click="gotoPage({{ $data->lastPage() }})" wire:key="page-last"
                                    class="px-3 py-1 border border-gray-300 rounded hover:bg-blue-50 cursor-pointer @if ($data->currentPage() == $data->lastPage()) text-white bg-blue-600 @else text-blue-600 background @endif">
                                    {{ $data->lastPage() }}
                                </button>
                            </span>
                        @endif
                    </div>

                    {{-- Next --}}
                    <span>
                        <button wire:click="nextPage"
                            class="flex align-items-center px-3 py-1 text-blue-600 background border border-gray-300 rounded hover:bg-gray-50 cursor-pointer nextPage"
                            @if (!$data->hasMorePages()) disabled @endif>
                            <span class="s">{{ __('main.next') }}</span><span>&raquo;</span>
                        </button>
                    </span>
                </div>
            </div>
        @endif
    </div>
</div>
