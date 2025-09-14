@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.nationalities'),
        'description' => __('main.manage_system_nationalities'),
        'import_url' => route('nationalities.import'),
        'page_add_url' => route('nationalities.create'),
        'page_add_title' => __('main.add_new_subregion'),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-5 lg:gap-7.5">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:nationalities.table :nationalities="$nationalities" />
        </div>
    </div>
    <!-- End of Container -->
@endsection
