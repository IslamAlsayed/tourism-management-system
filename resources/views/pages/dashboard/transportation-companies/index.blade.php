@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.transportation-companies'),
        'description' => __('main.manage_system_types', ['types' => __('main.transportation-company')]),
        'import_url' => route('import.data', ['models' => 'transportation-companies']),
        'page_add_url' => route('transportation-companies.create'),
        'page_add_title' => __('main.add_new_type', ['type' => __('main.transportation-company')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:transportation.companies />
        </div>
    </div>
    <!-- End of Container -->
@endsection
