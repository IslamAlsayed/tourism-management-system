@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.transportations-companies-branches'),
        'description' => __('main.manage_system_types', ['types' => __('main.transportations-company-branch')]),
        'import_url' => route('import.data', ['models' => 'transportations.branches']),
        'page_create_url' => route('transportations.branches.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.branch')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:transportations.branches />
        </div>
    </div>
    <!-- End of Container -->
@endsection
