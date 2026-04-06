@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.seasons'),
        'description' => __('main.manage_system_types', ['types' => __('main.seasons')]),
        'import_url' => route('import.data', ['models' => 'cruise_seasons']),
        'page_create_url' => route('dashboard.cruises.seasons.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.seasons')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            @livewire('cruises::season-list')
        </div>
    </div>
    <!-- End of Container -->
@endsection
