@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.transportations-pricings'),
        'description' => __('main.manage_system_types', ['types' => __('main.transportations-pricing')]),
        'import_url' => route('import.data', ['models' => 'dashboard.transportation.pricings']),
        'page_create_url' => route('dashboard.transportation.pricings.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.transportations-pricing')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            @livewire('transportation::pricings')
        </div>
    </div>
    <!-- End of Container -->
@endsection
