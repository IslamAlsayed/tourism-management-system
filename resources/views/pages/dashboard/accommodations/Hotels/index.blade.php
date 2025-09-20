@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.hotels'),
        'description' => __('main.manage_system_types', ['types' => __('main.hotels')]),
        'import_url' => route('accommodations.import'),
        'page_add_url' => route('hotels.create'),
        'page_add_title' => __('main.add_new_type', ['type' => __('main.hotel')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-5 lg:gap-7.5">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:accommodations.hotels.table :hotels="$hotels" />
        </div>
    </div>
    <!-- End of Container -->
@endsection
