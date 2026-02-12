@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.seaports'),
        'description' => __('main.manage_system_types', ['types' => __('main.seaports')]),
        'import_url' => route('import.data', ['models' => 'seaports']),
        'page_create_url' => route('dashboard.entrypoints.seaports.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.seaports')]),
    ]) <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            @livewire('entrypoints::seaports')
        </div>
    </div>
    <!-- End of Container -->
@endsection
