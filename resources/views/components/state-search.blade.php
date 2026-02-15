<div class="kt-card list-search-card">
    <div class="kt-card-header">
        <h3 class="kt-card-title">
            <i class="{{ $models == 'states' ? 'fas fa-map' : 'far fa-building' }} text-warning me-2"></i>
            {{ __('main.' . $models) }} ({{ $records->count() }})
        </h3>

        <div class="flex flex-wrap gap-2 lg:gap-5">
            <div class="flex items-center gap-2 text-red-500 no_results_found hidden">
                <i class="ki-filled ki-information-2 text-lg"></i>
                <p>{{ __('messages.no_results_found') }}</p>
            </div>
            <div class="flex items-center">
                <label class="kt-input">
                    <input type="search" class="py-2 rounded-lg search-par" id="search" placeholder="{{ __('main.search') }}..." autocomplete="off" />
                </label>
            </div>
        </div>
    </div>
    <div class="kt-card-body p-4">
        <div class="flex flex-wrap gap-3">
            {{-- Display first 20 records --}}
            @foreach ($records->take(20) as $record)
                @if (isset($type) && $type == 'route')
                    <a href="{{ route($models . '.show', $record->id) }}" class="kt-btn kt-btn-outline kt-btn-sm bg-info text-white list-item">
                        {{ $record->name }}
                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-white"></i>
                    </a>
                @else
                    <span class="kt-btn kt-btn-outline kt-btn-sm bg-info text-white list-item">
                        @if (isset($flat) && $flat)
                            {{ $record }}
                        @else
                            {{ __('main.' . $record->{$column ?? 'name'}) ?? $record->name }}
                            <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-white"></i>
                        @endif
                    </span>
                @endif
            @endforeach

            {{-- Display remaining records --}}
            @foreach ($records->slice(20) as $record)
                @if (isset($type) && $type == 'route')
                    <a href="{{ route($models . '.show', $record->id) }}" class="more-item hidden kt-btn kt-btn-outline kt-btn-sm bg-info text-white list-item">
                        {{ $record->name }}
                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-white"></i>
                    </a>
                @else
                    <span class="more-item hidden kt-btn kt-btn-outline kt-btn-sm bg-info text-white list-item">
                        @if (isset($flat) && $flat)
                            {{ $record }}
                        @else
                            {{ __('main.' . $record->{$column ?? 'name'}) ?? $record->name }}
                            <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-white"></i>
                        @endif
                    </span>
                @endif
            @endforeach
        </div>

        {{-- Show more/less buttons --}}
        @if ($records->count() > 20)
            <div class="mt-4 text-center">
                <p class="text-sm text-secondary-foreground">
                    <span id="showing-count">
                        {{ __('messages.showing_first_items', ['count' => 20, 'total' => $records->count()]) }}
                    </span>
                    <span id="show-more" class="text-primary underline cursor-pointer">
                        {{ __('messages.more') }}
                    </span>
                    <span id="show-less" class="hidden text-primary underline cursor-pointer">
                        {{ __('messages.less') }}
                    </span>
                </p>
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let listCards = document.querySelectorAll('.list-search-card');
        let showingCount = document.getElementById('showing-count');
        let showMoreButtons = document.getElementById('show-more');
        let showLessButtons = document.getElementById('show-less');
        if (listCards.length === 0) return;
        listCards.forEach(card => {
            let searchPar = card.querySelector('.search-par');
            if (searchPar) {
                let listItems = card.querySelectorAll('.list-item');
                let cardBody = card.querySelector('.kt-card-body');

                // Create no results message
                let noResultsMsg = card.querySelector('.no_results_found');

                searchPar.addEventListener('input', function() {
                    let filter = searchPar.value.toLowerCase();
                    let hasResults = false;

                    Array.from(listItems).forEach(function(item) {
                        let text = item.textContent || item.innerText;
                        if (text.toLowerCase().indexOf(filter) > -1) {
                            item.style.opacity = "1";
                            item.classList.remove("user-select-none");
                            item.classList.add("bg-info", "text-white");
                            item.classList.remove("bg-white", "text-black");
                            hasResults = true;
                        } else {
                            item.style.opacity = "0.5";
                            item.classList.add("user-select-none");
                            item.classList.remove("bg-info", "text-white");
                            item.classList.add("bg-white", "text-black");
                        }
                    });

                    // Show/hide no results message
                    if (filter && !hasResults) {
                        Array.from(listItems).forEach((item) => {
                            item.style.opacity = "1";
                            item.classList.remove("user-select-none");
                            item.classList.add("bg-info", "text-white");
                            item.classList.remove("bg-white", "text-black");
                        });
                        noResultsMsg.classList.remove('hidden');
                    } else {
                        noResultsMsg.classList.add('hidden');
                    }
                });
            }
        });

        // Show more functionality
        if (showMoreButtons) {
            showMoreButtons.addEventListener('click', function() {
                let card = showMoreButtons.closest('.list-search-card');
                let moreItems = card.querySelectorAll('.more-item');
                moreItems.forEach(item => item.classList.remove('hidden'));
                showingCount.textContent = '{{ __('messages.showing_all_items', ['total' => $records->count()]) }}';
                showMoreButtons.classList.add('hidden');
                showLessButtons.classList.remove('hidden');
            });
        }

        // Show less functionality
        if (showLessButtons) {
            showLessButtons.addEventListener('click', function() {
                let card = showLessButtons.closest('.list-search-card');
                let moreItems = card.querySelectorAll('.more-item');
                moreItems.forEach(item => item.classList.add('hidden'));
                showingCount.textContent = '{{ __('messages.showing_first_items', ['count' => 20, 'total' => $records->count()]) }}';
                showMoreButtons.classList.remove('hidden');
                showLessButtons.classList.add('hidden');
            });
        }
    });
</script>
