<div>
    <div class="kt-card">
        <!-- Header -->
        <div class="kt-card-header">
            <h3 class="kt-card-title flex items-center gap-3">
                <i class="fa-duotone fa-solid fa-receipt text-2xl text-primary"></i>
                <div>
                    {{ __('main.pricing_management') }}
                    <span class="block text-sm text-gray-500 font-normal mt-1">{{ $cruise->name }}</span>
                </div>
            </h3>
            <div class="kt-card-toolbar">
                <button wire:click="save" class="kt-btn kt-btn-primary kt-btn-sm flex items-center gap-2">
                    <i class="fa-duotone fa-solid fa-check-circle text-lg"></i>
                    {{ __('main.save_all_prices') }}
                </button>
            </div>
        </div>

        <!-- Matrix Content -->
        <div class="kt-card-body p-0 overflow-x-auto">
            <table class="w-full text-left" style="min-w: 800px;">
                <thead>
                    <tr class="bg-gray-50 dark:bg-dark-card border-b border-gray-200 dark:border-gray-800">
                        <th
                            class="p-4 text-xs font-semibold uppercase text-gray-500 w-48 sticky left-0 bg-gray-50 dark:bg-dark-card z-10 border-r border-gray-200 dark:border-gray-800">
                            {{ __('main.season') }} / {{ __('main.cabin_category') }}
                        </th>
                        @foreach ($categories as $category)
                            <th
                                class="p-4 text-xs font-semibold uppercase text-gray-500 text-center border-r border-gray-200 dark:border-gray-800">
                                {{ $category->name }}
                                <span
                                    class="block text-[10px] text-primary lowercase font-normal">({{ $category->code }})</span>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                    @foreach ($seasons as $season)
                        <tr class="hover:bg-gray-50 dark:hover:bg-dark-card transition-colors">
                            <td
                                class="p-4 sticky left-0 bg-white dark:bg-dark-card z-10 border-r border-gray-200 dark:border-gray-800">
                                <span
                                    class="text-sm font-bold text-gray-800 dark:text-gray-200 block">{{ $season->name }}</span>
                                <span class="text-xs text-gray-500 font-normal flex items-center gap-1 mt-1">
                                    <i class="fa-duotone fa-solid fa-calendar text-sm"></i>
                                    {{ $season->start_date->format('M d') }} - {{ $season->end_date->format('M d') }}
                                </span>
                            </td>
                            @foreach ($categories as $category)
                                <td class="p-4 border-r border-gray-100 dark:border-gray-800/50 align-top">
                                    <div class="grid grid-cols-1 gap-3">
                                        <!-- Buy Price (cost) -->
                                        <div class="relative">
                                            <span
                                                class="absolute left-3 top-1/2 -translate-y-1/2 text-xs font-bold text-gray-400 uppercase">{{ __('main.buy') }}</span>
                                            <input type="number"
                                                wire:model="prices.{{ $season->id }}.{{ $category->id }}.buy"
                                                class="kt-input pl-12 pr-3 h-[40px] text-sm w-full font-mono"
                                                placeholder="{{ __('main.buy_placeholder') }}">
                                        </div>
                                        <!-- Sell Price (Retail) -->
                                        <div class="relative">
                                            <span
                                                class="absolute left-3 top-1/2 -translate-y-1/2 text-xs font-bold text-success uppercase">{{ __('main.sell') }}</span>
                                            <input type="number"
                                                wire:model="prices.{{ $season->id }}.{{ $category->id }}.sell"
                                                class="kt-input pl-12 pr-3 h-[40px] text-sm w-full font-mono border-success/30 focus:border-success focus:ring-success/20 bg-success/5"
                                                placeholder="{{ __('main.sell_placeholder') }}">
                                        </div>
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Footer Actions -->
        <div class="kt-card-footer flex items-center justify-between p-6">
            <div class="flex items-center gap-2 text-sm text-gray-500 opacity-80">
                <i class="fa-duotone fa-solid fa-circle-info-2 text-primary text-xl"></i>
                <span>{{ __('main.all_prices_are_in') }} <strong>{{ $defaultCurrency }}</strong></span>
            </div>
            <div>
                <button wire:click="save" class="kt-btn kt-btn-primary">
                    {{ __('main.save_all_prices') }}
                </button>
            </div>
        </div>
    </div>
</div>
