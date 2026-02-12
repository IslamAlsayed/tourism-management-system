@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.land-crossings'),
        'description' => __('main.manage_system_types', ['types' => __('main.land-crossings')]),
        'import_url' => route('import.data', ['models' => 'land_crossings']),
        'page_create_url' => route('dashboard.entrypoints.land-crossings.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.land-crossings')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            @livewire('entrypoints::land-crossings')
        </div>
    </div>
    <!-- End of Container -->
@endsection
