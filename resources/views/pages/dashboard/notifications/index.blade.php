@extends('pages.dashboard.layouts.index')

@push('styles')
    <style>
        .notification-item {
            transition: all 0.3s ease;
        }

        .notification-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .bg-light-primary {
            background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
            border-left: 4px solid var(--bs-primary) !important;
        }
    </style>
@endpush

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.notifications'),
        'description' => __('main.manage_system_types', ['notifications' => __('main.notifications')]),
        'import_url' => '#',
        'page_create_url' => '#',
        'page_create_title' => __('main.create_type', ['type' => __('main.notification')]),
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
