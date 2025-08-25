@extends('pages.dashboard.layouts.index')

@section('table-content')
    @component('includes.page-stats', [
        'title' => 'إدارة المستخدمين',
        'description' => 'إدارة وتنظيم المستخدمين في النظام',
        'icon' => 'ki-filled ki-users',
        'total' => $totalUsers,
        'entityName' => 'المستخدمين',
        'quickActions' => true,
        'createRoute' => route('users.create'),
        'additionalStats' => 'المستخدمون النشطون: ' . \App\Models\User::where('is_active', 1)->count()
    ])
    @endcomponent

    <!-- Container -->
    <div class="grid gap-5 lg:gap-7.5">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:dashboard.user-table :users="$users" />
        </div>
    </div>
    <!-- End of Container -->
@endsection
