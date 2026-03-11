<div class="space-y-6">
    {{-- Add/Edit Webhook Card --}}
    <div class="kt-card shadow-sm border border-gray-200 rounded-xl bg-white dark:bg-gray-800">
        <div class="kt-card-header px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white flex items-center gap-2">
                <i class="ki-outline ki-setting-2 text-primary"></i>
                {{ $editingWebhookId ? 'Edit Webhook' : 'Add New Webhook (n8n)' }}
            </h3>
        </div>
        <div class="kt-card-body p-6">
            <form wire:submit.prevent="save" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Friendly Name</label>
                    <input type="text" wire:model="name" class="kt-input w-full" placeholder="e.g., n8n Production Server">
                    @error('name') <span class="text-danger text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Webhook URL</label>
                    <input type="url" wire:model="url" class="kt-input w-full" placeholder="https://n8n.your-domain.com/webhook/...">
                    @error('url') <span class="text-danger text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Event Type</label>
                    <select wire:model="event_type" class="kt-select w-full">
                        <option value="*">All Events (*)</option>
                        <option value="restaurant.stored">Restaurant Created</option>
                        <option value="restaurant.updated">Restaurant Updated</option>
                        <option value="accommodation.stored">Hotel Created</option>
                        <option value="booking.created">Booking Created</option>
                    </select>
                    @error('event_type') <span class="text-danger text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Secret Token (Optional)</label>
                    <input type="text" wire:model="secret_token" class="kt-input w-full" placeholder="X-Webhook-Secret value">
                </div>

                <div class="md:col-span-2 flex justify-end gap-3 mt-4">
                    <button type="button" wire:click="resetForm" class="kt-btn kt-btn-light">Cancel</button>
                    <button type="submit" class="kt-btn kt-btn-primary px-10 shadow-lg">
                        {{ $editingWebhookId ? 'Update Bridge' : 'Connect to n8n' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Webhooks List --}}
    <div class="kt-card shadow-sm border border-gray-200 rounded-xl bg-white dark:bg-gray-800">
        <div class="kt-card-header px-6 py-4 border-b border-gray-100 italic text-gray-500 text-sm">
            Active Automation Bridges
        </div>
        <div class="kt-card-body p-0">
            <div class="kt-scrollable-x-auto">
                <table class="kt-table w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700/30">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Event</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-bold uppercase tracking-wider text-gray-500">Actions</th>
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
                                <span class="badge badge-light-primary uppercase text-[10px]">{{ $webhook->event_type }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <button wire:click="toggleStatus({{ $webhook->id }})" class="badge {{ $webhook->is_active ? 'badge-success' : 'badge-danger' }} cursor-pointer border-0">
                                    {{ $webhook->is_active ? 'Active' : 'Paused' }}
                                </button>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button wire:click="edit({{ $webhook->id }})" class="kt-btn kt-btn-sm kt-btn-light-primary border-0 shadow-none"><i class="ki-outline ki-pencil text-md"></i></button>
                                <button wire:click="delete({{ $webhook->id }})" wire:confirm="Are you sure?" class="kt-btn kt-btn-sm kt-btn-light-danger border-0 shadow-none"><i class="ki-outline ki-trash text-md"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Execution Logs --}}
    <div class="kt-card shadow-sm border border-gray-200 rounded-xl bg-white dark:bg-gray-800">
        <div class="kt-card-header px-6 py-4 border-b border-gray-100 flex items-center gap-2">
            <i class="ki-outline ki-monitor text-success text-xl"></i>
            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-tight">Recent Synchronizations</h3>
        </div>
        <div class="kt-card-body p-0">
            <div class="kt-scrollable-x-auto">
                <table class="kt-table w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700/30">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Time</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Bridge</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Response</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($logs as $log)
                        <tr>
                            <td class="px-6 py-3 text-xs text-gray-500">{{ $log->created_at->diffForHumans() }}</td>
                            <td class="px-6 py-3 text-xs font-bold">{{ $log->webhook->name ?? 'Deleted' }}</td>
                            <td class="px-6 py-3">
                                @if($log->response_status >= 200 && $log->response_status < 300)
                                    <span class="text-success flex items-center gap-1 font-bold text-xs"><i class="ki-filled ki-check-circle text-md"></i> {{ $log->response_status }}</span>
                                @else
                                    <span class="text-danger flex items-center gap-1 font-bold text-xs"><i class="ki-filled ki-cross-circle text-md"></i> {{ $log->response_status ?? 'FAIL' }}</span>
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
