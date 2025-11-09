@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.regions'),
        'description' => __('main.manage_system_types', ['types' => __('main.regions')]),
        'import_url' => route('import.data', ['models' => 'regions']),
        'page_create_url' => route('regions.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.region')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:regions />
        </div>
    </div>
    <!-- End of Container -->
@endsection
