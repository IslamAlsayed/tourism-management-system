@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.restaurants'),
        'description' => __('main.manage_system_types', ['types' => __('main.restaurants')]),
        'import_url' => route('import.data', ['model' => 'restaurants']),
        'page_add_url' => route('restaurants.create'),
        'page_add_title' => __('main.add_new_type', ['type' => __('main.restaurant')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-5 lg:gap-7.5">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:restaurants.table :restaurants="$restaurants" />
        </div>
    </div>
    <!-- End of Container -->
@endsection
