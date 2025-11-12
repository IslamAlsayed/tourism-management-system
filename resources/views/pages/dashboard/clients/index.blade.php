@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.clients'),
        'description' => __('main.manage_system_types', ['types' => __('main.clients')]),
        'import_url' => route('import.data', ['models' => 'clients']),
        'page_create_url' => route('clients.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.client')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:clients />
        </div>
    </div>
    <!-- End of Container -->
@endsection
