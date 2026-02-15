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
                    <th>{{ __('main.permissions_count') }}</th>
                    <th>{{ __('main.created_at') }}</th>
                    <th class="text-right">{{ __('main.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $role)
                    <tr>
                        <td class="font-medium">{{ $role->name }}</td>
                        <td>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-50 text-blue-700">
                                {{ $role->permissions->count() }}
                            </span>
                        </td>
                        <td>{{ $role->created_at->format('Y-m-d H:i') }}</td>
                        <td class="text-right">
                            <div class="flex items-center gap-2 justify-end">
                                <a href="{{ route('dashboard.core.roles.show', $role->id) }}"
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg hover:bg-gray-100">
                                    <i class="ki-filled ki-eye text-gray-600"></i>
                                </a>
                                @if (!in_array($role->name, ['superadmin', 'admin', 'user']))
                                    <a href="{{ route('dashboard.core.roles.edit', $role->id) }}"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg hover:bg-gray-100">
                                        <i class="ki-filled ki-pencil text-gray-600"></i>
                                    </a>
                                    <button wire:click="destroy({{ $role->id }})" wire:confirm="{{ __('messages.confirm_delete') }}"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg hover:bg-red-50">
                                        <i class="ki-filled ki-trash text-red-600"></i>
                                    </button>
                                @endif
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
