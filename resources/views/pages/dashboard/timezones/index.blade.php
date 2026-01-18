@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.timezones'),
        'description' => __('main.manage_system_types', ['types' => __('main.timezones')]),
        'import_url' => route('import.data', ['models' => 'timezones']),
        'page_create_url' => route('timezones.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.timezone')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:timezones />
        </div>
    </div>
    <!-- End of Container -->
@endsection
