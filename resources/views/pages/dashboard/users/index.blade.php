@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
        <div class="flex flex-col justify-center gap-2">
            <h1 class="text-xl font-medium leading-none text-mono">
                {{ __('main.users') }}
            </h1>
            <div class="flex items-center flex-wrap gap-1.5 font-medium">
                <span class="text-base text-secondary-foreground">
                    {{ __('main.manage_system_users') }}
                </span>
            </div>
        </div>
        <div class="flex items-center gap-2.5">
            <a class="kt-btn kt-btn-outline" href="#">
                {{ __('main.import_csv') }}
            </a>
            <a class="kt-btn kt-btn-primary" href="{{ route('users.create') }}">
                {{ __('main.add_member') }}
            </a>
        </div>
    </div>
    <!-- End of Container -->

    {{-- @component('includes.page-stats', [
    'title' => __('main.user_management_title'),
    'description' => __('main.user_management_description'),
    'icon' => 'ki-filled ki-users',
    'total' => $totalUsers,
    'entityName' => __('main.users'),
    'quickActions' => true,
    'createRoute' => route('users.create'),
    'additionalStats' => __('main.active_users_count') . ' ' . \App\Models\User::where('is_active', 1)->count(),
])
    @endcomponent --}}

    <!-- Container -->
    <div class="grid gap-5 lg:gap-7.5">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:dashboard.user-table :users="$users" />
        </div>
    </div>
    <!-- End of Container -->
@endsection
