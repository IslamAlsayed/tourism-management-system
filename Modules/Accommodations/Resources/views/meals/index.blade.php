@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.meals'),
        'description' => __('main.manage_system_types', ['types' => __('main.meals')]),
        'import_url' => route('import.data', ['models' => 'meals']),
        'page_create_url' => route('dashboard.accommodations.meals.create', ['type' => request()->query('type')]),
        'page_create_title' => __('main.create_type', ['type' => __('main.meal')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            @livewire('accommodations::meals')
        </div>
    </div>
    <!-- End of Container -->
@endsection
