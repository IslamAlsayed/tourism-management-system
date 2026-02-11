@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.transportations-company-bus-types'),
        'description' => __('main.manage_system_types', ['types' => __('main.transportations-company-bus-types')]),
        'import_url' => route('import.data', ['models' => 'transportation-company-bus-types']),
        'page_create_url' => route('dashboard.transportation.company-bus-types.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.transportations-company-bus-type')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:transportations.company-bus-types />
        </div>
    </div>
    <!-- End of Container -->
@endsection
