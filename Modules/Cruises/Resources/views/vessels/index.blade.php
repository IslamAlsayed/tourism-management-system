@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.cruises'),
        'description' => __('main.manage_system_types', ['types' => __('main.cruises')]),
        'import_url' => route('import.data', ['models' => 'cruises']),
        'page_create_url' => route('dashboard.cruises.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.cruises')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        @livewire('cruises::cruise-list')
    </div>
    <!-- End of Container -->
@endsection
