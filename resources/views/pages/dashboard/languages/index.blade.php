@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.languages'),
        'description' => __('main.manage_system_types', ['types' => __('main.languages')]),
        'import_url' => route('import.data', ['model' => 'languages']),
        'page_add_url' => route('languages.create'),
        'page_add_title' => __('main.add_new_type', ['type' => __('main.language')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-5 lg:gap-7.5">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:languages />
        </div>
    </div>
    <!-- End of Container -->
@endsection
