@extends('layouts.master')

@section('content')
    <div class="w-full px-5 lg:px-10 mt-5">
        <!-- Container -->
        @include('includes.table-breadcrumb', [
            'title' => __('main.system_languages'),
            'description' => __('main.manage_system_types', ['types' => __('main.languages')]),
            'import_url' => route('import.data', ['models' => 'system_languages']),
            'page_create_url' => route('dashboard.localization.system-languages.create'),
            'page_create_title' => __('main.create_type', ['type' => __('main.system_language')]),
        ])
        <!-- End of Container -->

        <!-- Container -->
        <div class="grid gap-4 lg:gap-6 mt-5">
            <livewire:system-languages />
        </div>
        <!-- End of Container -->
    </div>
@endsection
