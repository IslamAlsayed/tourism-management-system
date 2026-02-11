@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.rooms'),
        'description' => __('main.manage_system_types', ['types' => __('main.rooms')]),
        'import_url' => route('import.data', ['models' => 'rooms']),
        'page_create_url' => route('dashboard.accommodations.rooms.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.room')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            @livewire('accommodations::rooms')
        </div>
    </div>
    <!-- End of Container -->
@endsection
