@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @component('includes.table-breadcrumb', [
        'title' => __('main.transportations-route-assignments'),
        'description' => __('main.manage_system_types', ['types' => __('main.transportations-route-assignment')]),
        'import_url' => route('import.data', ['models' => 'transportations.route-assignments']),
        'page_create_url' => route('transportations.route-assignments.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.transportations-route-assignment')]),
    ])
        @slot('fake_data')
            <span class="inline-block bg-danger text-white font-medium px-2 py-0.5 rounded-[7px] ms-2">
                {{ __('main.fake_data') }}
            </span>
        @endslot
    @endcomponent
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:transportations.route-assignments />
        </div>
    </div>
    <!-- End of Container -->
@endsection
