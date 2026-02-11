@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.permission')]))

@section('content')
<div class="kt-container-fixed">
    <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
        <div class="flex flex-col justify-center gap-2">
            <h1 class="text-xl font-medium leading-none text-mono">
                {{ $permission->name }}
            </h1>
            <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                {{ $permission->guard_name }} guard
            </div>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('permissions.edit', $permission->id) }}" class="kt-btn kt-btn-primary md:hidden">
                <i class="ki-filled ki-pencil text-sm me-2"></i>
                {{ __('main.edit') }}
            </a>
            <a href="{{ route('permissions.index') }}" class="kt-btn kt-btn-outline">
                {{ __('main.back_to_types', ['types' => __('main.permissions')]) }}
            </a>
        </div>
    </div>
</div>

<div class="kt-container-fixed">
    <div class="grid gap-4 lg:gap-6">

        <!-- Permission Information -->
        <div class="kt-card">
            <div class="kt-card-header">
                <h3 class="kt-card-title">{{ __('main.basic_information') }}</h3>
            </div>
            <div class="kt-card-body p-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div>
                        <label class="kt-label mb-1">{{ __('main.name') }}</label>
                        <p class="text-sm text-secondary-foreground font-medium">{{ $permission->name }}</p>
                    </div>
                    <div>
                        <label class="kt-label mb-1">{{ __('main.guard_name') }}</label>
                        <p class="text-sm text-secondary-foreground">{{ $permission->guard_name }}</p>
                    </div>
                    <div>
                        <label class="kt-label mb-1">{{ __('main.created_at') }}</label>
                        <p class="text-sm text-secondary-foreground">
                            {{ $permission->created_at->format('Y-m-d H:i') }}
                        </p>
                    </div>
                    <div>
                        <label class="kt-label mb-1">{{ __('main.updated_at') }}</label>
                        <p class="text-sm text-secondary-foreground">
                            {{ $permission->updated_at->format('Y-m-d H:i') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Button -->
        <div class="flex items-center gap-3">
            <a href="{{ route('permissions.edit', $permission->id) }}" class="kt-btn kt-btn-primary hidden md:inline-flex">
                <i class="ki-filled ki-pencil text-sm me-2"></i>
                {{ __('main.edit') }}
            </a>
        </div>
    </div>
</div>
@endsection