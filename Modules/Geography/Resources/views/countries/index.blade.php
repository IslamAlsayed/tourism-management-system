@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.countries'),
        'description' => __('main.manage_system_types', ['types' => __('main.countries')]),
        'import_url' => route('import.data', ['models' => 'countries']),
        'page_create_url' => route('dashboard.geography.countries.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.country')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            @livewire('geography::countries')
        </div>
    </div>
    <!-- End of Container -->
@endsection
