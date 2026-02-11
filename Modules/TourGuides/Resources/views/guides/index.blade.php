@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.tours.guides'),
        'description' => __('main.manage_system_types', ['types' => __('main.tours.guides')]),
        'import_url' => route('import.data', ['models' => 'tours.guides']),
        'page_create_url' => route('dashboard.tourguides.guides.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.tours.guide')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            @livewire('tourguides::guides-types')
        </div>
    </div>
    <!-- End of Container -->
@endsection
