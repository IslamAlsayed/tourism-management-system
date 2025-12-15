@extends('layouts.master')

@section('title', __('main.user_details'))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $user->name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $user->email }} • {{ $user->phone }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('users.edit', $user->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('users.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.users')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">

            <!-- Basic Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.basic_information') }}</h3>
                </div>

                <div class="text-start w-[200px] pt-6">
                    <!-- Profile Photo -->
                    @include('components.input-image', [
                        'modelKey' => $user->name ?? 'U',
                        'column' => 'user',
                        'columnName' => 'photo',
                        'record' => $user,
                    ])
                </div>

                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @if ($user->name)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $user->name ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($user->name_ar)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $user->name_ar ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($user->email)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.email') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $user->email ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($user->phone)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.phone') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $user->phone ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($user->mobile)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.mobile') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $user->mobile }}</p>
                            </div>
                        @endif
                        @if ($user->user_status)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $user->id,
                                        'modelType' => '\\App\\Models\\User',
                                        'field' => 'is_active',
                                        'value' => (bool) $user->is_active,
                                        'table' => 'users',
                                    ])
                                </div>
                            </div>
                        @endif
                        @if ($user->timezone)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.timezone') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $user->timezone->name ?: __('main.no') }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Metadata -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.metadata') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-6">
                        @if ($user->creator)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.created_by') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $user->creator->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.created_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $user->created_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                        @if ($user->updater)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.updated_by') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $user->updater->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.updated_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $user->updated_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'users',
                    'id' => $user->id,
                ])
                @livewire('delete-bottom', [
                    'type' => 'user',
                    'modelId' => $user->id,
                    'modelType' => '\\App\\Models\\User',
                    'table' => 'users',
                ])
                <a href="{{ route('users.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.users')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
