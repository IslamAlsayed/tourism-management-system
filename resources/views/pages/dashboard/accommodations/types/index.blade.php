@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.accommodation-types'),
        'description' => __('main.manage_system_types', ['types' => __('main.accommodation-types')]),
        'import_url' => route('import.data', ['models' => 'accommodation-types']),
        'page_create_url' => route('accommodations-types.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.accommodation-type')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:accommodations.types />
        </div>
    </div>
    <!-- End of Container -->
@endsection
