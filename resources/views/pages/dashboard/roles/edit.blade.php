@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.role')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.role')]) }}
                </h1>
                <div class="flex items-center gap-2 text-primary text-sm font-normal">
                    {{ $role->name }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('roles.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.roles')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <form class="space-y-6" method="POST" action="{{ route('roles.update', $role->id) }}">
            @csrf
            @method('PUT')
            <div class="grid gap-4 lg:gap-6">

                <!-- Basic Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.basic_information') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Role Name -->
                            <div>
                                <label for="name" class="kt-label mb-2">
                                    {{ __('main.name') }}
                                    <span class="text-red-600">*</span>
                                </label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]"
                                    value="{{ $role->name }}" required
                                    {{ in_array($role->name, ['superadmin', 'admin', 'user']) ? 'disabled' : '' }}>
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Permissions -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.permissions') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="space-y-4">
                            @forelse($permissions->chunk(3) as $permissionGroup)
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach ($permissionGroup as $permission)
                                        <div class="flex items-center gap-3">
                                            <input type="hidden" name="permissions[]" value="0">
                                            @include('components.elements.checkbox-button', [
                                                'name' => 'permissions[]',
                                                'id' => 'permission_' . $permission->id,
                                                'value' => $permission->id,
                                                'checked' => in_array($permission->id, $rolePermissions),
                                                'label' => $permission->name,
                                            ])
                                        </div>
                                    @endforeach
                                </div>
                            @empty
                                <p class="text-secondary-foreground">{{ __('messages.no_permissions_available') }}</p>
                            @endforelse
                        </div>
                        @error('permissions')
                            <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-3">
                    <button type="submit" class="kt-btn kt-btn-primary"
                        {{ in_array($role->name, ['superadmin', 'admin', 'user']) ? 'disabled' : '' }}>
                        {{ __('main.update') }}
                    </button>
                    <a href="{{ route('roles.index') }}" class="kt-btn kt-btn-outline">
                        {{ __('main.cancel') }}
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
