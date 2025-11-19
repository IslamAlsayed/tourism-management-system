@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('activity.activity_log'),
        'description' => __('activity.activity_log_page_description'),
        'page_create_title' => __('main.create_type', ['type' => __('activity.activity_log')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:activity-log />
        </div>
    </div>
    <!-- End of Container -->
@endsection
