{{-- KTUI Pagination Component — Unified across all modules --}}
<div class="kt-card-footer border-t border-gray-200 bg-transparent">
    <div class="w-full flex flex-wrap justify-between items-center gap-4">
        {{-- Records per page selector --}}
        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
            <span>{{ __('main.show') }}</span>

            @if (config('app.paginate_array'))
                <select wire:model.live="paginate" name="paginate" id="paginate"
                    class="kt-select h-[32px] w-[70px] text-sm">
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
                {{-- Info text --}}
                <div class="text-sm text-gray-600 dark:text-gray-400 details_info">
                    {{ $data->firstItem() ?? 0 }} - {{ $data->lastItem() ?? 0 }} {{ __('main.of') }}
                    {{ $data->total() ?? 0 }}
                </div>

                {{-- KTUI Pagination --}}
                <ol class="kt-pagination">
                    {{-- First Page --}}
                    <li class="kt-pagination-item">
                        <button wire:click="gotoPage(1)" wire:key="page-first"
                            class="kt-btn kt-btn-icon kt-btn-ghost"
                            @if ($data->onFirstPage()) disabled @endif>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-chevron-first rtl:rotate-180"
                                aria-hidden="true">
                                <path d="m17 18-6-6 6-6"></path>
                                <path d="M7 6v12"></path>
                            </svg>
                        </button>
                    </li>

                    {{-- Previous --}}
                    <li class="kt-pagination-item">
                        <button wire:click="previousPage" wire:key="page-prev"
                            class="kt-btn kt-btn-icon kt-btn-ghost"
                            @if ($data->onFirstPage()) disabled @endif>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-chevron-left rtl:rotate-180"
                                aria-hidden="true">
                                <path d="m15 18-6-6 6-6"></path>
                            </svg>
                        </button>
                    </li>

                    {{-- Page 1 --}}
                    <li class="kt-pagination-item">
                        <button wire:click="gotoPage(1)" wire:key="page-1"
                            class="kt-btn kt-btn-icon kt-btn-ghost @if ($data->currentPage() == 1) active @endif">
                            1
                        </button>
                    </li>

                    {{-- Left Ellipsis --}}
                    @if ($data->currentPage() > 4)
                        <li class="kt-pagination-ellipsis">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-ellipsis" aria-hidden="true">
                                <circle cx="12" cy="12" r="1"></circle>
                                <circle cx="19" cy="12" r="1"></circle>
                                <circle cx="5" cy="12" r="1"></circle>
                            </svg>
                        </li>
                    @endif

                    {{-- Dynamic Middle Pages --}}
                    @php
                        $start = max(2, $data->currentPage() - 2);
                        $end = min($data->lastPage() - 1, $data->currentPage() + 2);

                        if ($data->currentPage() <= 3) {
                            $end = min(6, $data->lastPage() - 1);
                        }

                        if ($data->currentPage() >= $data->lastPage() - 2) {
                            $start = max($data->lastPage() - 5, 2);
                        }
                    @endphp

                    @for ($i = $start; $i <= $end; $i++)
                        <li class="kt-pagination-item">
                            <button wire:click="gotoPage({{ $i }})" wire:key="page-{{ $i }}"
                                class="kt-btn kt-btn-icon kt-btn-ghost @if ($i == $data->currentPage()) active @endif">
                                {{ $i }}
                            </button>
                        </li>
                    @endfor

                    {{-- Right Ellipsis --}}
                    @if ($data->currentPage() < $data->lastPage() - 3)
                        <li class="kt-pagination-ellipsis">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-ellipsis" aria-hidden="true">
                                <circle cx="12" cy="12" r="1"></circle>
                                <circle cx="19" cy="12" r="1"></circle>
                                <circle cx="5" cy="12" r="1"></circle>
                            </svg>
                        </li>
                    @endif

                    {{-- Last Page --}}
                    @if ($data->lastPage() > 1)
                        <li class="kt-pagination-item">
                            <button wire:click="gotoPage({{ $data->lastPage() }})" wire:key="page-last"
                                class="kt-btn kt-btn-icon kt-btn-ghost @if ($data->currentPage() == $data->lastPage()) active @endif">
                                {{ $data->lastPage() }}
                            </button>
                        </li>
                    @endif

                    {{-- Next --}}
                    <li class="kt-pagination-item">
                        <button wire:click="nextPage" wire:key="page-next"
                            class="kt-btn kt-btn-icon kt-btn-ghost"
                            @if (!$data->hasMorePages()) disabled @endif>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-chevron-right rtl:rotate-180"
                                aria-hidden="true">
                                <path d="m9 18 6-6-6-6"></path>
                            </svg>
                        </button>
                    </li>

                    {{-- Last Page Button --}}
                    <li class="kt-pagination-item">
                        <button wire:click="gotoPage({{ $data->lastPage() }})" wire:key="page-end"
                            class="kt-btn kt-btn-icon kt-btn-ghost"
                            @if (!$data->hasMorePages()) disabled @endif>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-chevron-last rtl:rotate-180"
                                aria-hidden="true">
                                <path d="m7 18 6-6-6-6"></path>
                                <path d="M17 6v12"></path>
                            </svg>
                        </button>
                    </li>
                </ol>
            </div>
        @endif
    </div>
</div>
