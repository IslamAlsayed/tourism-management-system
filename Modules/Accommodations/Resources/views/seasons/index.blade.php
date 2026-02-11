@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.seasons'),
        'description' => __('main.manage_system_types', ['types' => __('main.seasons')]),
        'import_url' => route('import.data', ['models' => 'seasons']),
        'page_create_url' => route('dashboard.accommodations.seasons.create', [
            'type' => request()->query('type'),
            \Illuminate\Support\Str::random(120),
        ]),
        'page_create_title' => __('main.create_type', ['type' => __('main.season')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            @livewire('accommodations::seasons')
        </div>
    </div>
    <!-- End of Container -->
@endsection
