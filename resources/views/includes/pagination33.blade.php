<nav role="navigation" class="custom-pagination">
    <div></div>
    <div>
        <p class="showing">
            {{ __('dashboard.tasks.showing') }}
            {{ $data->firstItem() ?? 0 }}
            {{ __('dashboard.tasks.to') }}
            {{ $data->lastItem() ?? 0 }}
            {{ __('dashboard.tasks.of') }}
            {{ $data->total() }}
            {{ __('dashboard.tasks.results') }}
        </p>

        <ul class="pagination-list">
            {{-- Previous --}}
            <li>
                <button wire:click="previousPage" class="pagination-btn previousPage"
                    @if ($data->onFirstPage()) disabled @endif>
                    &laquo; {{ __('dashboard.tasks.previous') }}
                </button>
            </li>

            {{-- First Page --}}
            <li>
                <button wire:click="gotoPage(1)" class="pagination-btn @if ($data->currentPage() == 1) active @endif">
                    1
                </button>
            </li>

            {{-- Left Dots --}}
            @if ($data->currentPage() > 4)
                <li><span>...</span></li>
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
                <li>
                    <button wire:click="gotoPage({{ $i }})"
                        class="pagination-btn @if ($i == $data->currentPage()) active @endif">
                        {{ $i }}
                    </button>
                </li>
            @endfor

            {{-- Right Dots --}}
            @if ($data->currentPage() < $data->lastPage() - 3)
                <li><span>...</span></li>
            @endif

            {{-- Last Page --}}
            @if ($data->lastPage() > 1)
                <li>
                    <button wire:click="gotoPage({{ $data->lastPage() }})"
                        class="pagination-btn @if ($data->currentPage() == $data->lastPage()) active @endif">
                        {{ $data->lastPage() }}
                    </button>
                </li>
            @endif

            {{-- Next --}}
            <li>
                <button wire:click="nextPage" class="pagination-btn nextPage"
                    @if (!$data->hasMorePages()) disabled @endif>
                    {{ __('dashboard.tasks.next') }} &raquo;
                </button>
            </li>
        </ul>
    </div>
</nav>
