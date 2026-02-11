@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.travel-passes'),
        'description' => __('main.manage_system_types', ['types' => __('main.travel-passes')]),
        // 'import_url' => route('import.data', ['models' => 'travel-passes']),
        'page_create_url' => route('dashboard.traveldocuments.travel-passes.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.travel-pass')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            @livewire('traveldocuments::travel-passes')
        </div>
    </div>
    <!-- End of Container -->
@endsection
