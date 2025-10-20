@if ($this->message)
    <div class="custom-alerts" id="custom-alerts">
        @foreach ($this->message as $key => $message)
            @php $id = 'alert_' . uniqid(); @endphp

            <div id="{{ $id }}" class="kt-alert kt-alert-{{ $key }} mb-5" role="alert">
                {{ $message }}
            </div>
        @endforeach
    </div>
@endif

<div class="flex-wrap gap-2 p-2">
    <div class="w-full flex justify-between items-start">
        <div>
            <p class="text-sm text-gray-600 p-2">
                {{ __('main.showing') }} {{ $data->firstItem() ?? 0 }} -
                <strong class="text-primary">{{ $data->lastItem() ?? 0 }}</strong>
                {{ __('main.of') }} {{ $data->total() }} {{ $entityName ?? __('main.items') }}
                @if ($data->hasPages())
                    <span class="text-blue-600">({{ __('main.page') }} {{ $data->currentPage() }} {{ __('main.of') }}
                        {{ $data->lastPage() }})</span>
                @endif
            </p>
        </div>

        <div class="flex gap-2">
            <span id="selectedCount" style="align-self: anchor-center;"></span>

            <div class="flex flex-wrap gap-2 lg:gap-5">
                <button type="button" id="deleteAllBtn" data-route="{{ route('deleteAll') }}"
                    data-model="{{ lcfirst($entityName) }}"
                    class="deleteAllBtn hidden kt-btn kt-btn-outline bg-secondary px-3 h-[45px]">
                    <i class="fas fa-trash text-red-600"></i>
                </button>
            </div>

            {{ $slot }}

            @if (isset($showSearch) && $showSearch)
                <div class="flex flex-wrap gap-2 lg:gap-5">
                    <div class="flex">
                        <label class="kt-input h-[45px]">
                            <i class="ki-filled ki-magnifier"></i>
                            <input wire:model.live="search" type="search"
                                placeholder="{{ __('main.search_in') }} {{ $entityName ?? __('main.items') }}..."
                                class="px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        </label>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Progress bar showing current page position --}}
    @if ($data->hasPages() && $data->lastPage() > 1)
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
