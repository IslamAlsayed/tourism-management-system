@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.transportations-route-assignments'),
        'description' => __('main.manage_system_types', ['types' => __('main.transportations-route-assignment')]),
        'import_url' => route('import.data', ['models' => 'transportations.route-assignments']),
        'page_create_url' => route('transportations.route-assignments.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.transportations-route-assignment')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:transportations.route-assignments />
        </div>
    </div>
    <!-- End of Container -->
@endsection
