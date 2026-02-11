@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.transportations-companies'),
        'description' => __('main.manage_system_types', ['types' => __('main.transportations-company')]),
        'import_url' => route('import.data', ['models' => 'dashboard.transportation.companies']),
        'page_create_url' => route('dashboard.transportation.companies.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.company')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            @livewire('transportation::companies')
        </div>
    </div>
    <!-- End of Container -->
@endsection
