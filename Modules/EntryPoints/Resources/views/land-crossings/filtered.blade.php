@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => $typeLabel,
        'description' => __('main.manage_system_types', ['types' => $typeLabel]),
        'page_create_url' => route('dashboard.entrypoints.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.land-crossings')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:crossings-ports :filterType="$typeValue" />
        </div>
    </div>
    <!-- End of Container -->
@endsection
