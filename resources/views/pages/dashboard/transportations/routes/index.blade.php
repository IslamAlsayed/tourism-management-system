@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.transportations-routes'),
        'description' => __('main.manage_system_types', ['types' => __('main.transportations-route')]),
        'import_url' => route('import.data', ['models' => 'transportations.routes']),
        'page_create_url' => route('transportations.routes.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.route')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:transportations.routes />
        </div>
    </div>
    <!-- End of Container -->
@endsection
