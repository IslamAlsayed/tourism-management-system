@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.nationalities'),
        'description' => __('main.manage_system_types', ['types' => __('main.nationalities')]),
        'import_url' => route('import.data', ['models' => 'dashboard.geography.nationalities']),
        'page_create_url' => route('dashboard.geography.nationalities.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.nationality')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            @livewire('geography::nationalities')
        </div>
    </div>
    <!-- End of Container -->
@endsection
