@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.tourist-sites'),
        'description' => __('main.manage_system_types', ['types' => __('main.tourist-sites')]),
        'import_url' => route('import.data', ['models' => 'tourist-sites']),
        'page_create_url' => route('tourist-sites.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.tourist-site')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:tourist-sites />
        </div>
    </div>
    <!-- End of Container -->
@endsection
