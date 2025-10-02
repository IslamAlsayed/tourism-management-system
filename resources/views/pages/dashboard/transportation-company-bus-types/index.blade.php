@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.transportation-company-bus-types'),
        'description' => __('main.manage_system_types', ['types' => __('main.transportation-company-bus-types')]),
        'import_url' => route('import.data', ['model' => 'transportation-company-bus-types']),
        'page_add_url' => route('transportation-company-bus-types.create'),
        'page_add_title' => __('main.add_new_type', ['type' => __('main.transportation-company-bus-types')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-5 lg:gap-7.5">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:transportation.company-bus-types />
        </div>
    </div>
    <!-- End of Container -->
@endsection
