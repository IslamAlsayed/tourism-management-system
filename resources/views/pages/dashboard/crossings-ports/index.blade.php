@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.crossings-ports'),
        'description' => __('main.manage_system_types', ['types' => __('main.crossings-ports')]),
        'import_url' => route('import.data', ['models' => 'crossings-ports']),
        'page_create_url' => route('crossings-ports.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.crossings-ports')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:crossings-ports />
        </div>
    </div>
    <!-- End of Container -->
@endsection
