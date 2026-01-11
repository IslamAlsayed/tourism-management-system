@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.tourist-services'),
        'description' => __('main.manage_system_types', ['types' => __('main.tourist-services')]),
        'import_url' => route('import.data', ['models' => 'tourist-services']),
        'page_create_url' => route('tourist-services.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.tourist-service')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:tourist-services />
        </div>
    </div>
    <!-- End of Container -->
@endsection
