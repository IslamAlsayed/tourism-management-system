<!-- Metadata -->
<div class="kt-card">
    <div class="kt-card-header">
        <h3 class="kt-card-title">{{ __('main.metadata') }}</h3>
    </div>
    <div class="kt-card-body p-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-6">
            <div>
                <label class="kt-label mb-1">{{ __('main.created_by') }}</label>
                @if ($record->creator)
                    <a href="{{ route('dashboard.core.users.show', $record->creator?->id) }}" class="block text-sm text-primary underline">
                        {{ $record->creator?->name ?? __('main.na') }}
                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                    </a>
                @else
                    <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                @endif
            </div>
            <div>
                <label class="kt-label mb-1">{{ __('main.created_at') }}</label>
                <p class="text-sm text-secondary-foreground">
                    {{ $record->created_at?->format('Y-m-d H:i') }}
                </p>
            </div>
            <div>
                <label class="kt-label mb-1">{{ __('main.updated_by') }}</label>
                @if ($record->updater)
                    <a href="{{ route('dashboard.core.users.show', $record->updater?->id) }}" class="block text-sm text-primary underline">
                        {{ $record->updater?->name ?? __('main.na') }}
                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                    </a>
                @else
                    <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                @endif
            </div>
            <div>
                <label class="kt-label mb-1">{{ __('main.updated_at') }}</label>
                <p class="text-sm text-secondary-foreground">
                    {{ $record->updated_at?->format('Y-m-d H:i') }}
                </p>
            </div>
        </div>
    </div>
</div>
