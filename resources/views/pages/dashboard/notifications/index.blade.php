@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.notifications'),
        'description' => __('main.manage_system_types', ['types' => __('main.notifications')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:notifications.notifications />
        </div>
    </div>
    <!-- End of Container -->
@endsection
