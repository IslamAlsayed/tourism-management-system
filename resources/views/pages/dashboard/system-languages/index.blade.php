@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.system_languages'),
        'description' => __('main.manage_system_types', ['types' => __('main.languages')]),
        'import_url' => route('import.data', ['models' => 'system_languages']),
        'page_create_url' => route('system-languages.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.system_language')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:system-languages />
        </div>
    </div>
    <!-- End of Container -->
@endsection
