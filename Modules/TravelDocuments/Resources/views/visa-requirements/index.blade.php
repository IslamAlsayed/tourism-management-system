@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.visa-requirements'),
        'description' => __('main.manage_system_types', ['types' => __('main.visa-requirements')]),
        // 'import_url' => route('import.data', ['models' => 'visa-requirements']),
        'page_create_url' => route('dashboard.traveldocuments.visa-requirements.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.visa-requirement')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            @livewire('traveldocuments::visa-requirements')
        </div>
    </div>
    <!-- End of Container -->
@endsection
