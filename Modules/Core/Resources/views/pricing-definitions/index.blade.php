@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.pricing-definitions'),
        'description' => __('main.manage_system_types', [
            'types' => __('main.pricing-definitions'),
        ]),
        'page_create_url' => route('dashboard.core.pricing-definitions.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.pricing-definition')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            @livewire('core::pricing-definitions')
        </div>
    </div>
    <!-- End of Container -->
@endsection
