@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.supplements'),
        'description' => __('main.manage_system_types', ['types' => __('main.supplements')]),
        'import_url' => route('import.data', ['models' => 'supplements']),
        'page_create_url' => route('dashboard.accommodations.supplements.create', ['type' => request()->query('type')]),
        'page_create_title' => __('main.create_type', ['type' => __('main.supplement')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            @livewire('accommodations::supplements')
        </div>
    </div>
    <!-- End of Container -->
@endsection
