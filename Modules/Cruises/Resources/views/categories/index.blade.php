@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.cabin-categories'),
        'description' => __('main.manage_system_types', ['types' => __('main.cabin-categories')]),
        'import_url' => route('import.data', ['models' => 'cabin_categories']),
        'page_create_url' => route('dashboard.cruises.categories.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.cabin-categories')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            @livewire('cruises::cabin-category-list')
        </div>
    </div>
    <!-- End of Container -->
@endsection
