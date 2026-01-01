@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.transportation-vehicle-types'),
        'description' => __('main.manage_system_types', ['types' => __('main.transportation-vehicle-type')]),
        'import_url' => route('import.data', ['models' => 'transportation.vehicle-types']),
        'page_create_url' => route('transportation.vehicle-types.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.transportation-vehicle-type')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:transportation.vehicle-types />
        </div>
    </div>
    <!-- End of Container -->
@endsection
