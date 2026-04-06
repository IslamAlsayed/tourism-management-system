<div class="space-y-6">
    {{-- Add/Edit Webhook Card --}}
    <div class="kt-card shadow-sm border border-gray-200 rounded-xl bg-white dark:bg-gray-800">
        <div class="kt-card-header px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white flex items-center gap-2">
                <i class="fa-duotone fa-solid fa-gear-2 text-primary"></i>
                {{ $editingWebhookId ? __('automation.edit_webhook') : __('automation.add_new_webhook') }}
            </h3>
        </div>
        <div class="kt-card-body p-6">
            <form wire:submit.prevent="save" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('automation.friendly_name') }}</label>
                    <input type="text" wire:model="name" class="kt-input w-full" placeholder="e.g., n8n Production Server">
                    @error('name') <span class="text-danger text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('automation.webhook_url') }}</label>
                    <input type="url" wire:model="url" class="kt-input w-full" placeholder="https://n8n.your-domain.com/webhook/...">
                    @error('url') <span class="text-danger text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('automation.event_type') }}</label>
                    <select wire:model="event_type" class="kt-select w-full">
                        <option value="*">{{ __('automation.all_events') }}</option>
                        <option value="restaurant.stored">{{ __('automation.restaurant_created') }}</option>
                        <option value="restaurant.updated">{{ __('automation.restaurant_updated') }}</option>
                        <option value="accommodation.stored">{{ __('automation.hotel_created') }}</option>
                        <option value="booking.created">{{ __('automation.booking_created') }}</option>
                    </select>
                    @error('event_type') <span class="text-danger text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('automation.secret_token') }}</label>
                    <input type="text" wire:model="secret_token" class="kt-input w-full" placeholder="X-Webhook-Secret value">
                </div>

                <div class="md:col-span-2 flex justify-end gap-3 mt-4">
                    <button type="button" wire:click="resetForm" class="kt-btn kt-btn-light">{{ __('automation.cancel') }}</button>
                    <button type="submit" class="kt-btn kt-btn-primary px-10 shadow-lg">
                        {{ $editingWebhookId ? __('automation.update_bridge') : __('automation.connect_to_n8n') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Webhooks List --}}
    <div class="kt-card shadow-sm border border-gray-200 rounded-xl bg-white dark:bg-gray-800">
        <div class="kt-card-header px-6 py-4 border-b border-gray-100 italic text-gray-500 text-sm">
            {{ __('automation.active_automation_bridges') }}
        </div>
        <div class="kt-card-body p-0">
            <div x-data="{ 
                init() {
                    setTimeout(() => this.updateWidth(), 200);
                    window.addEventListener('resize', () => { setTimeout(() => this.updateWidth(), 100); });
                    const observer = new MutationObserver(() => this.updateWidth());
                    if (this.$refs.actualTable) observer.observe(this.$refs.actualTable, { childList: true, subtree: true });
                },
                syncScroll(source) {
                    if (source === 'top') {
                        this.$refs.bottomScroll.scrollLeft = this.$refs.topScroll.scrollLeft;
                    } else {
                        this.$refs.topScroll.scrollLeft = this.$refs.bottomScroll.scrollLeft;
                    }
                },
                updateWidth() {
                    if (this.$refs.actualTable && this.$refs.topScrollInner) {
                        this.$refs.topScrollInner.style.width = this.$refs.actualTable.scrollWidth + 'px';
                    }
                }
            }" class="w-full">
            <!-- Global scrolling styles now in main.css -->
                <div class="top-scroll w-full overflow-x-auto overflow-y-hidden custom-scrollbar" x-ref="topScroll" @scroll="syncScroll('top')">
                    <div class="top-scroll-inner" x-ref="topScrollInner" style="height: 1px;"></div>
                </div>

                <div class="kt-scrollable-x-auto w-full overflow-x-auto custom-scrollbar" x-ref="bottomScroll" @scroll="syncScroll('bottom')">
                    <table x-ref="actualTable" class="kt-table w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700/30">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">{{ __('automation.name') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">{{ __('automation.event') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">{{ __('automation.status') }}</th>
                                <th class="px-6 py-3 text-right text-xs font-bold uppercase tracking-wider text-gray-500">{{ __('automation.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($webhooks as $webhook)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900 dark:text-white">{{ $webhook->name }}</div>
                                    <div class="text-[10px] text-gray-400 font-mono truncate max-w-xs">{{ $webhook->url }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="kt-badge kt-badge-light kt-badge-primary uppercase text-[10px]">{{ $webhook->event_type }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <button wire:click="toggleStatus({{ $webhook->id }})" class="kt-badge {{ $webhook->is_active ? 'kt-badge-success' : 'kt-badge-destructive' }} cursor-pointer border-0">
                                        {{ $webhook->is_active ? __('automation.active') : __('automation.paused') }}
                                    </button>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <button wire:click="edit({{ $webhook->id }})" class="kt-btn kt-btn-sm kt-btn-light kt-btn-primary border-0 shadow-none"><i class="fa-duotone fa-solid fa-pen text-md"></i></button>
                                    <button wire:click="delete({{ $webhook->id }})" wire:confirm="Are you sure?" class="kt-btn kt-btn-sm kt-btn-light kt-btn-destructive border-0 shadow-none"><i class="fa-duotone fa-solid fa-trash text-md"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Execution Logs --}}
    <div class="kt-card shadow-sm border border-gray-200 rounded-xl bg-white dark:bg-gray-800">
        <div class="kt-card-header px-6 py-4 border-b border-gray-100 flex items-center gap-2">
            <i class="fa-duotone fa-solid fa-desktop text-success text-xl"></i>
            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-tight">{{ __('automation.recent_synchronizations') }}</h3>
        </div>
        <div class="kt-card-body p-0">
            <div x-data="{ 
                init() {
                    setTimeout(() => this.updateWidth(), 200);
                    window.addEventListener('resize', () => { setTimeout(() => this.updateWidth(), 100); });
                    const observer = new MutationObserver(() => this.updateWidth());
                    if (this.$refs.actualTable) observer.observe(this.$refs.actualTable, { childList: true, subtree: true });
                },
                syncScroll(source) {
                    if (source === 'top') {
                        this.$refs.bottomScroll.scrollLeft = this.$refs.topScroll.scrollLeft;
                    } else {
                        this.$refs.topScroll.scrollLeft = this.$refs.bottomScroll.scrollLeft;
                    }
                },
                updateWidth() {
                    if (this.$refs.actualTable && this.$refs.topScrollInner) {
                        this.$refs.topScrollInner.style.width = this.$refs.actualTable.scrollWidth + 'px';
                    }
                }
            }" class="w-full">
            <style>
                .top-scroll {
                    overflow-x: auto;
                    overflow-y: hidden;
                    height: 12px;
                    margin-bottom: 4px;
                    scrollbar-width: thin;
                    scrollbar-color: #2563eb rgba(37, 99, 235, 0.08); /* Blue thumb, very light blue track */
                    border-radius: 6px;
                }
                .top-scroll::-webkit-scrollbar {
                    height: 8px; /* Slightly thicker for better usability */
                }
                .top-scroll::-webkit-scrollbar-track {
                    background: rgba(37, 99, 235, 0.08);
                    border-radius: 6px;
                }
                .top-scroll::-webkit-scrollbar-thumb {
                    background-color: #2563eb;
                    border-radius: 6px;
                    border: 2px solid transparent;
                    background-clip: padding-box; /* Makes thumb look floating */
                }
                .top-scroll::-webkit-scrollbar-thumb:hover {
                    background-color: #1d4ed8; /* Darker blue on hover */
                }
                /* Hide bottom scrollbar to prevent double scrollbars if intended, or keep it styled */
                .bottom-scroll {
                    overflow-x: auto;
                    padding-bottom: 10px; /* Space for the text/content */
                }
            </style>
                <div class="top-scroll" x-ref="topScroll" @scroll="syncScroll('top')">
                    <div x-ref="topScrollInner" style="height: 1px;"></div>
                </div>

                <div class="bottom-scroll" x-ref="bottomScroll" @scroll="syncScroll('bottom')">
                    <table x-ref="actualTable" class="kt-table w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700/30">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">{{ __('automation.time') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">{{ __('automation.bridge') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">{{ __('automation.status') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">{{ __('automation.response') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($logs as $log)
                            <tr>
                                <td class="px-6 py-3 text-xs text-gray-500">{{ $log->created_at->diffForHumans() }}</td>
                                <td class="px-6 py-3 text-xs font-bold">{{ $log->webhook->name ?? 'Deleted' }}</td>
                                <td class="px-6 py-3">
                                    @if($log->response_status >= 200 && $log->response_status < 300)
                                        <span class="text-success flex items-center gap-1 font-bold text-xs"><i class="fa-duotone fa-solid fa-check-circle text-md"></i> {{ $log->response_status }}</span>
                                    @else
                                        <span class="text-danger flex items-center gap-1 font-bold text-xs"><i class="fa-duotone fa-solid fa-xmark-circle text-md"></i> {{ $log->response_status ?? 'FAIL' }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3">
                                    <div class="text-[10px] text-gray-400 italic truncate max-w-[200px]" title="{{ $log->response_body }}">
                                        {{ $log->response_body ?: $log->error }}
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
