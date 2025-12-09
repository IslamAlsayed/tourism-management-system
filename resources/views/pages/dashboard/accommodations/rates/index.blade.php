@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.accommodation_rates'),
        'description' => __('main.manage_system_types', ['types' => __('main.accommodation_rates')]),
        'import_url' => route('import.data', ['models' => 'rates']),
        'page_create_title' => __('main.create_type', ['type' => __('main.accommodation_rate')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:accommodations.rates />
        </div>
    </div>
    <!-- End of Container -->
@endsection
