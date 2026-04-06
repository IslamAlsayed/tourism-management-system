@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.role')]))

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $role->name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('messages.permissions_count', ['count' => $role->permissions->count()]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                @if (!in_array($role->name, ['superadmin', 'admin', 'user']))
                    <a href="{{ route('dashboard.core.roles.edit', $role->id) }}" class="kt-btn kt-btn-primary md:hidden">
                        <i class="fa-duotone fa-solid fa-pen text-sm me-2"></i>
                        {{ __('main.edit') }}
                    </a>
                @endif
                <a href="{{ route('dashboard.core.roles.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.roles')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="container-fixed">
        <div class="grid gap-4 lg:gap-6">

            <!-- Role Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.basic_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.name') }}</label>
                            <p class="text-sm text-secondary-foreground font-medium">{{ $role->name }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.created_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $role->created_at->format('Y-m-d H:i') }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.permissions_count') }}</label>
                            <p class="text-sm text-secondary-foreground font-medium">{{ $role->permissions->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assigned Permissions -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.assigned_permissions') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    @if ($rolePermissions)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($rolePermissions as $permission)
                                <div class="flex items-center gap-3 p-3 bg-muted rounded-lg">
                                    <i class="fa-duotone fa-solid fa-check text-green-600"></i>
                                    <span class="text-sm font-medium">{{ $permission }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-secondary-foreground text-center py-8">
                            {{ __('messages.no_permissions_assigned') }}
                        </p>
                    @endif
                </div>
            </div>

            <!-- Edit Button -->
            @if (!in_array($role->name, ['superadmin', 'admin', 'user']))
                <div class="flex items-center gap-3">
                    <a href="{{ route('dashboard.core.roles.edit', $role->id) }}"
                        class="kt-btn kt-btn-primary hidden md:inline-flex">
                        <i class="fa-duotone fa-solid fa-pen text-sm me-2"></i>
                        {{ __('main.edit') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
