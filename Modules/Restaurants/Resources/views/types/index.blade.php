@extends('pages.dashboard.layouts.index')

@section('table-content')
    @include('includes.table-breadcrumb', [
        'title' => __('main.restaurant_types'),
        'description' => __('main.manage_system_types', ['types' => __('main.restaurant_types')]),
        'import_url' => route('import.data', ['models' => 'restauranttypes']),
        'page_create_url' => route('dashboard.restaurants.types.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.type')]),
    ])

    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            @livewire('restaurants::restaurant-types')
        </div>
    </div>
@endsection
