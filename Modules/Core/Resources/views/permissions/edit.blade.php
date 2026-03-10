@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.permission')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.permission')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $permission->name }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.core.permissions.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.permissions')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <form class="space-y-6" method="POST" action="{{ route('dashboard.core.permissions.update', $permission->id) }}">
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
                            <!-- Permission Name -->
                            <div>
                                <label for="name" class="kt-label mb-2">
                                    {{ __('main.name') }}
                                    <span class="text-red-600">*</span>
                                </label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]"
                                    value="{{ $permission->name }}"
                                    placeholder="e.g., create_users, edit_posts, delete_comments" required>
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                                <p class="text-xs text-secondary-foreground mt-2">
                                    {{ __('messages.permission_name_format') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-3">
                    <button type="submit" class="kt-btn kt-btn-primary">
                        {{ __('main.update') }}
                    </button>
                    <a href="{{ route('dashboard.core.permissions.index') }}" class="kt-btn kt-btn-outline">
                        {{ __('main.cancel') }}
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
