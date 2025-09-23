@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.regions'),
        'description' => __('main.manage_system_types', ['types' => __('main.regions')]),
        'import_url' => route('import.data', ['model' => 'regions']),
        'page_add_url' => route('regions.create'),
        'page_add_title' => __('main.add_new_type', ['type' => __('main.region')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-5 lg:gap-7.5">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:regions.table :regions="$regions" />
        </div>
    </div>
    <!-- End of Container -->
@endsection
