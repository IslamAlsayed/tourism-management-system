@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.cities'),
        'description' => __('main.manage_system_types', ['types' => __('main.cities')]),
        'import_url' => route('cities.import'),
        'page_add_url' => route('cities.create'),
        'page_add_title' => __('main.add_new_type', ['type' => __('main.city')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-5 lg:gap-7.5">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:dashboard.city-table :cities="$cities" />
        </div>
    </div>
    <!-- End of Container -->
@endsection
