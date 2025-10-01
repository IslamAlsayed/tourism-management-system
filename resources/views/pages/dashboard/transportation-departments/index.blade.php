@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.transportation-departments'),
        'description' => __('main.manage_system_types', ['types' => __('main.transportation-department')]),
        'import_url' => route('import.data', ['model' => 'transportation-departments']),
        'page_add_url' => route('transportation-departments.create'),
        'page_add_title' => __('main.add_new_type', ['type' => __('main.transportation-department')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-5 lg:gap-7.5">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:transportation.departments />
        </div>
    </div>
    <!-- End of Container -->
@endsection
