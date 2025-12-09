@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.accommodations-seasons'),
        'description' => __('main.manage_system_types', ['types' => __('main.accommodations-seasons')]),
        'import_url' => route('import.data', ['models' => 'accommodations-seasons']),
        'page_create_url' => route('accommodations-seasons.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.accommodations-season')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:accommodations.seasons />
        </div>
    </div>
    <!-- End of Container -->
@endsection
