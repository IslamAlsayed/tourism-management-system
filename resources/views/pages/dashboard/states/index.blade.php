@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.states'),
        'description' => __('main.manage_system_states'),
        'import_url' => route('states.import'),
        'page_add_url' => route('states.create'),
        'page_add_title' => __('main.add_new_state'),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-5 lg:gap-7.5">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:states.table :states="$states" />
        </div>
    </div>
    <!-- End of Container -->
@endsection
