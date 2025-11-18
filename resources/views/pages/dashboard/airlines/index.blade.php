@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.airlines'),
        'description' => __('main.manage_system_types', ['types' => __('main.airlines')]),
        'import_url' => route('import.data', ['models' => 'airlines']),
        'page_create_url' => route('airlines.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.airline')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:airlines />
        </div>
    </div>
    <!-- End of Container -->
@endsection
