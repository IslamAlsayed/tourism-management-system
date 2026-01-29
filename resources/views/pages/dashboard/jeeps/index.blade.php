@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.jeeps'),
        'description' => __('main.manage_system_types', ['types' => __('main.jeeps')]),
        // 'import_url' => route('import.data', ['models' => 'jeeps']),
        'page_create_url' => route('jeeps.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.jeep')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:jeeps />
        </div>
    </div>
    <!-- End of Container -->
@endsection
