@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.transportation-vehicles'),
        'description' => __('main.manage_system_types', ['types' => __('main.transportation-vehicles')]),
        'import_url' => route('import.data', ['model' => 'transportation-vehicles']),
        'page_add_url' => route('transportation-vehicles.create'),
        'page_add_title' => __('main.add_new_type', ['type' => __('main.transportation-vehicles')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-5 lg:gap-7.5">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:transportation.vehicles />
        </div>
    </div>
    <!-- End of Container -->
@endsection
