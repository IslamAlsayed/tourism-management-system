@extends('pages.dashboard.layouts.index')

@section('table-content')
    @php
        $titles = [
            'pricing_unit' => [
                'title' => __('main.pricing-units'),
                'desc' => __('main.manage_system_types', ['types' => __('main.pricing-units')]),
            ],
            'site_type' => [
                'title' => __('main.field-definitions'),
                'desc' => __('main.manage_system_types', ['types' => __('main.field-definitions')]),
            ],
        ];
        $pageTitle = $titles[$category ?? '']['title'] ?? __('main.pricing-definitions');
        $pageDesc =
            $titles[$category ?? '']['desc'] ??
            __('main.manage_system_types', ['types' => __('main.pricing-definitions')]);
    @endphp

    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => $pageTitle,
        'description' => $pageDesc,
        'page_create_url' => route('dashboard.definitions.pricing-definitions.create', ['category' => $category]),
        'page_create_title' => __('main.create_type', ['type' => $pageTitle]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            @livewire('definitions::pricing-definitions', ['category' => $category])
        </div>
    </div>
    <!-- End of Container -->
@endsection
