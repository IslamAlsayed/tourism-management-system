<div class="kt-card list-search-card">
    <div class="kt-card-header">
        <h3 class="kt-card-title">
            <i class="{{ $models == 'states' ? 'fas fa-map' : 'far fa-building'}} text-warning me-2"></i>
            {{ __('main.' . $models) }} ({{ $records->count() }})
        </h3>

        <div class="flex flex-wrap gap-2 lg:gap-5">
            <div class="flex items-center gap-2 text-red-500 no_results_found hidden">
                <i class="ki-filled ki-information-2 text-lg"></i>
                <p>{{ __('messages.no_results_found') }}</p>
            </div>
            <div class="flex items-center">
                <label class="kt-input">
                    <input type="search" class="py-2 rounded-lg search-par" id="search"
                        placeholder="{{ __('main.search') }}..." autocomplete="off" />
                </label>
            </div>
        </div>
    </div>
    <div class="kt-card-body p-4">
        <div class="flex flex-wrap gap-3">
            @foreach ($records->take(20) as $city)
                <a href="{{ route($models . '.show', $city->id) }}"
                    class="kt-btn kt-btn-outline kt-btn-sm bg-info text-white list-item">
                    {{ $city->name }}
                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-white"></i>
                </a>
            @endforeach
        </div>
        @if ($records->count() > 20)
            <div class="mt-4 text-center">
                <p class="text-sm text-secondary-foreground">
                    {{ __('main.showing_first_items', ['count' => 20, 'total' => $records->count()]) }}
                </p>
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let listCards = document.querySelectorAll('.list-search-card');
        if (listCards.length === 0) return;
        listCards.forEach(card => {
            let searchPar = card.querySelector('.search-par');
            if (searchPar) {
                let listItems = card.querySelectorAll('.list-item');
                let cardBody = card.querySelector('.kt-card-body');

                // Create no results message
                let noResultsMsg = card.querySelector('.no_results_found');

                searchPar.addEventListener('input', function () {
                    let filter = searchPar.value.toLowerCase();
                    let hasResults = false;

                    Array.from(listItems).forEach(function (item) {
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
    });
</script>