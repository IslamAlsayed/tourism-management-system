{{-- Enhanced pagination information component --}}
<div class="kt-card-footer border-t border-gray-200 bg-gray-50">
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        {{-- Records per page selector --}}
        <div class="flex items-center gap-2 text-sm text-gray-600">
            <span>{{ __('main.show') }}</span>

            {{-- Generate options from config array --}}
            @if (config('app.paginate_array'))
                <select wire:model.live="paginate" name="paginate" id="paginate"
                    class="kt-select w-20 px-2 py-1 border rounded">
                    @foreach (config('app.paginate_array') as $limit)
                        <option value="{{ $limit }}">{{ $limit }}</option>
                    @endforeach
                </select>
            @endif
            <span>{{ __('main.items_per_page') }}</span>
        </div>

        {{-- Pagination info and links --}}
        <div class="flex items-center gap-4">
            <div class="text-sm text-gray-600">
                {{ $data->firstItem() }} - {{ $data->lastItem() }} {{ __('main.of') }}
                {{ $data->total() }}
            </div>

            <div class="flex items-center gap-1">
                {{-- Previous --}}
                <span>
                    <button wire:click="previousPage"
                        class="px-3 py-1 text-blue-600 bg-white border border-gray-300 rounded hover:bg-blue-50 cursor-pointer previousPage"
                        @if ($data->onFirstPage()) disabled @endif>
                        &laquo; {{ __('main.previous') }}
                    </button>
                </span>

                {{-- First Page --}}
                <span>
                    <button wire:click="gotoPage(1)" wire:key="page-1"
                        class="px-3 py-1 border border-gray-300 rounded cursor-pointer @if ($data->currentPage() == 1) text-white bg-blue-600 @else text-blue-600 bg-white hover:bg-blue-50 @endif">
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
                        class="px-3 py-1 border border-gray-300 rounded cursor-pointer @if ($i == $data->currentPage()) text-white bg-blue-600 @else text-blue-600 bg-white hover:bg-blue-50 @endif">
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
                            class="px-3 py-1 border border-gray-300 rounded hover:bg-blue-50 cursor-pointer @if ($data->currentPage() == $data->lastPage()) text-white bg-blue-600 @else text-blue-600 bg-white @endif">
                            {{ $data->lastPage() }}
                        </button>
                    </span>
                @endif

                {{-- Next --}}
                <span>
                    <button wire:click="nextPage"
                        class="px-3 py-1 text-blue-600 bg-white border border-gray-300 rounded hover:bg-blue-50 cursor-pointer nextPage"
                        @if (!$data->hasMorePages()) disabled @endif>
                        {{ __('main.next') }} &raquo;
                    </button>
                </span>
            </div>
        </div>

    </div>
</div>
