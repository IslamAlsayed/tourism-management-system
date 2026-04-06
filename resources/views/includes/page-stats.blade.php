{{-- Page Statistics Summary Component --}}
<div class="bg-gradient-to-r from-blue-50 to-indigo-100 border border-blue-200 rounded-lg p-4 mb-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="bg-blue-500 text-white p-3 rounded-full">
                <i class="{{ $icon ?? 'fa-duotone fa-solid fa-chart-pie' }} text-xl"></i>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-800">{{ $title }}</h2>
                <p class="text-sm text-gray-600">{{ $description }}</p>
            </div>
        </div>

        <div class="text-right">
            <div class="text-3xl font-bold text-blue-600">
                {{ number_format($total) }}
            </div>
            <div class="text-sm text-gray-500">
                {{ __('main.total') }} {{ $entityName }}
            </div>
            @if (isset($additionalStats))
                <div class="text-xs text-gray-400 mt-1">
                    {{ $additionalStats }}
                </div>
            @endif
        </div>
    </div>

    @if (isset($quickActions) && $quickActions)
        <div class="mt-4 pt-4 border-t border-blue-200">
            <div class="flex gap-2">
                @if (isset($createRoute))
                    <a href="{{ $createRoute }}"
                        class="px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600 transition-colors">
                        <i class="fa-duotone fa-solid fa-plus text-sm"></i>
                        {{ __('main.add') }} {{ $entityName }}
                    </a>
                @endif
                @if (isset($exportRoute))
                    <a href="{{ $exportRoute }}"
                        class="px-4 py-2 bg-green-500 text-white text-sm rounded-lg hover:bg-green-600 transition-colors">
                        <i class="fa-duotone fa-solid fa-arrow-down-from-line text-sm"></i>
                        {{ __('main.export') }}
                    </a>
                @endif
            </div>
        </div>
    @endif
</div>
