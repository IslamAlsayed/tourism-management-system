@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.tour-guides-reviews'),
        'description' => __('main.manage_system_types', ['types' => __('main.tour-guides-reviews')]),
        'import_url' => route('import.data', ['models' => 'tour-guides-reviews']),
        'page_create_url' => route('tour-guides-reviews.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.tour-guide-review')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:tour-guides-reviews />
        </div>
    </div>
    <!-- End of Container -->
@endsection
