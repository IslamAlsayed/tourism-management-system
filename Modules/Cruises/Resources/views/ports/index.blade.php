@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.ports'),
        'description' => __('main.manage_system_types', ['types' => __('main.ports')]),
        'import_url' => route('import.data', ['models' => 'ports']),
        'page_create_url' => route('dashboard.cruises.ports.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.ports')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        @livewire('cruises::port-list')
    </div>
    <!-- End of Container -->
@endsection
