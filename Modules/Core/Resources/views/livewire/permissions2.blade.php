<div class="kt-card-body p-4">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center justify-between mb-6">
        <div class="flex-1">
            <input type="text" wire:model.live="search" placeholder="{{ __('main.search') }}" class="kt-input w-full">
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="kt-table">
            <thead>
                <tr>
                    <th>{{ __('main.name') }}</th>
                    <th>{{ __('main.guard_name') }}</th>
                    <th>{{ __('main.created_at') }}</th>
                    <th class="text-right">{{ __('main.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $permission)
                <tr>
                    <td class="font-medium">{{ $permission->name }}</td>
                    <td>
                        <span
                            class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-700">
                            {{ $permission->guard_name }}
                        </span>
                    </td>
                    <td>{{ $permission->created_at->format('Y-m-d H:i') }}</td>
                    <td class="text-right">
                        <div class="flex items-center gap-2 justify-end">
                            <a href="{{ route('permissions.show', $permission->id) }}"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg hover:bg-gray-100">
                                <i class="ki-filled ki-eye text-gray-600"></i>
                            </a>
                            <a href="{{ route('permissions.edit', $permission->id) }}"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg hover:bg-gray-100">
                                <i class="ki-filled ki-pencil text-gray-600"></i>
                            </a>
                            <button wire:click="destroy({{ $permission->id }})"
                                wire:confirm="{{ __('messages.confirm_delete') }}"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg hover:bg-red-50">
                                <i class="ki-filled ki-trash text-red-600"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-8">
                        <p class="text-secondary-foreground">{{ __('messages.no_data_found') }}</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if ($data->hasPages())
    <div class="mt-6">
        {{ $data->links() }}
    </div>
    @endif
</div>