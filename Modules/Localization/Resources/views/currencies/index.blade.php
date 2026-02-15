@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.currencies'),
        'description' => __('main.manage_system_types', ['types' => __('main.currencies')]),
        'import_url' => route('import.data', ['models' => 'currencies']),
        'page_create_url' => route('dashboard.localization.currencies.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.currency')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            @livewire('localization::currencies')
        </div>
    </div>
    <!-- End of Container -->
@endsection
