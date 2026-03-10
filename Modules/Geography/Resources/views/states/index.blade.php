@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.states'),
        'description' => __('main.manage_system_types', ['types' => __('main.states')]),
        'import_url' => route('import.data', ['models' => 'states']),
        'page_create_url' => route('dashboard.geography.states.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.state')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            @livewire('geography::states')
        </div>
    </div>
    <!-- End of Container -->
@endsection
