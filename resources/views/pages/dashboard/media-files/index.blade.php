@extends('pages.dashboard.layouts.index')

@section('title', __('main.media-files'))

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.media-files'),
        'description' => __('main.manage_system_types', ['types' => __('main.media-files')]),
        'import_url' => route('import.data', ['models' => 'media-files']),
        'page_create_url' => route('media-files.create'),
        'page_create_title' => __('main.upload_type', ['type' => __('main.file')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:media-files />
        </div>
    </div>
    <!-- End of Container -->
@endsection
