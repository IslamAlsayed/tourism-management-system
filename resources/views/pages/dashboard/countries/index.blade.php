@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.countries'),
        'description' => __('main.manage_system_types', ['types' => __('main.countries')]),
        'import_url' => route('import.data', ['model' => 'countries']),
        'page_add_url' => route('countries.create'),
        'page_add_title' => __('main.add_new_type', ['type' => __('main.country')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-5 lg:gap-7.5">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:countries />
        </div>
    </div>
    <!-- End of Container -->
@endsection
