{{-- restaurants\index.blade.php --}}
@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.restaurants'),
        'description' => __('main.manage_system_types', ['types' => __('main.restaurants')]),
        'import_url' => route('import.data', ['models' => 'restaurants']),
        'page_create_url' => route('dashboard.restaurants.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.restaurant')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            @livewire('restaurants::restaurants')
        </div>
    </div>
    <!-- End of Container -->
@endsection
