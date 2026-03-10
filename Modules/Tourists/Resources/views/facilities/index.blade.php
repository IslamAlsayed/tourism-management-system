@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.facilities'),
        'description' => __('main.manage_system_types', ['types' => __('main.facilities')]),
        'page_create_url' => route('dashboard.tourists.facilities.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.facility')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            @livewire('tourists::facilities')
        </div>
    </div>
    <!-- End of Container -->
@endsection
