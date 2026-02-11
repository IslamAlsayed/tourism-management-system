@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.transportation-vehicles'),
        'description' => __('main.manage_system_types', ['types' => __('main.transportation-vehicles')]),
        'import_url' => route('import.data', ['models' => 'transportation-vehicles']),
        'page_create_url' => route('dashboard.transportation.vehicles.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.transportation-vehicle')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:transportations.vehicles />
        </div>
    </div>
    <!-- End of Container -->
@endsection
