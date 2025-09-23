@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.subregions'),
        'description' => __('main.manage_system_types', ['types' => __('main.subregions')]),
        'import_url' => route('import.data', ['model' => 'subregions']),
        'page_add_url' => route('subregions.create'),
        'page_add_title' => __('main.add_new_type', ['type' => __('main.subregion')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-5 lg:gap-7.5">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:subregions.table :subregions="$subregions" />
        </div>
    </div>
    <!-- End of Container -->
@endsection
