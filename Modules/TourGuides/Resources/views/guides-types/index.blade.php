@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.tours.guides-types'),
        'description' => __('main.manage_system_types', ['types' => __('main.tours.guides-types')]),
        'import_url' => route('import.data', ['models' => 'tours.guides-types']),
        'page_create_url' => route('dashboard.tourguides.guides-types.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.tours.guides-type')]),
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
