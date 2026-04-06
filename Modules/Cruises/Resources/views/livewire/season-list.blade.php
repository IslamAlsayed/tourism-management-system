<div>
    {{-- Search Bar --}}
    <div class="flex items-center justify-between gap-4 mb-6">
        <div class="relative flex items-center w-full max-w-sm">
            <i class="fa-duotone fa-solid fa-magnifying-glass absolute left-4 text-gray-500 text-lg"></i>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="{{ __('main.search_here') }}" class="kt-input pl-11 h-[40px] w-full bg-white dark:bg-dark-card">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($seasons as $season)
            <div class="kt-card flex flex-col hover:shadow-lg transition-all border border-gray-200 dark:border-gray-800">
                <div class="kt-card-body p-6 flex flex-col h-full">
                    <div class="flex items-center justify-between mb-4">
                         <div class="flex items-center justify-center w-[50px] h-[50px] rounded-full bg-primary-light dark:bg-primary-light/10 text-primary">
                            <i class="fa-duotone fa-solid fa-calendar text-2xl"></i>
                        </div>
                        <div class="flex flex-col items-end">
                           @livewire('toggle-switch', [
                                'modelId' => $season->id,
                                'modelType' => 'Modules\\Cruises\\Entities\\CruiseSeason',
                                'field' => 'is_active',
                                'value' => (bool)$season->is_active,
                           ], key('toggle-'.$season->id))
                        </div>
                    </div>

                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{ $season->name }}</h3>
                    <div class="mb-6 flex items-center gap-3">
                        <span class="kt-badge kt-badge-light-success py-2 font-bold">{{ $season->start_date->format('Y-m-d') }}</span>
                        <i class="fa-duotone fa-solid fa-arrow-right text-gray-400"></i>
                        <span class="kt-badge kt-badge-light-danger py-2 font-bold">{{ $season->end_date->format('Y-m-d') }}</span>
                    </div>

                    <hr class="border-gray-200 dark:border-gray-800 my-4">

                    <div class="flex items-center justify-between mt-auto mb-6">
                        <span class="text-sm font-semibold text-gray-500 uppercase">{{ __('main.linked_vessels') }}</span>
                        <span class="text-lg font-bold text-primary">{{ $season->prices_count ?? '0' }}</span>
                    </div>

                    <div class="flex items-center gap-2 mt-auto">
                        <a href="{{ route('dashboard.cruises.seasons.edit', $season->uuid) }}" class="kt-btn kt-btn-primary kt-btn-sm w-full flex items-center justify-center gap-2">
                            <i class="fa-duotone fa-solid fa-pen text-lg"></i>
                            {{ __('main.edit') }}
                        </a>
                        <button type="button" class="kt-btn kt-btn-danger kt-btn-sm kt-btn-icon" onclick="confirm('{{ __('main.confirm_delete') }}') || event.stopImmediatePropagation()" wire:click="delete('{{ $season->uuid }}')">
                            <i class="fa-duotone fa-solid fa-trash text-lg"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-1 md:col-span-2 lg:col-span-3">
                <div class="kt-card bg-gray-50 dark:bg-dark-card border border-dashed border-gray-300 dark:border-gray-700 rounded-xl p-16 text-center">
                    <i class="fa-duotone fa-solid fa-calendar text-6xl text-gray-300 dark:text-gray-600 mb-4 inline-block"></i>
                    <h3 class="text-xl font-bold text-gray-500 dark:text-gray-400">{{ __('main.no_seasons_found') }}</h3>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $seasons->links() }}
    </div>
</div>
