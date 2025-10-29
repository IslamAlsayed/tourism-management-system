@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.system_languages'),
        'description' => __('main.manage_system_types', ['types' => __('main.languages')]),
        'import_url' => route('import.data', ['models' => 'system_languages']),
        'page_add_url' => route('system-languages.create'),
        'page_add_title' => __('main.add_new_type', ['type' => __('main.system_language')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:system_languages />
        </div>
    </div>
    <!-- End of Container -->
@endsection
