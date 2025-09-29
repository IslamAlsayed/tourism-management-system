@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.users'),
        'description' => __('main.manage_system_types', ['types' => __('main.users')]),
        'import_url' => route('import.data', ['model' => 'users']),
        'page_add_url' => route('users.create'),
        'page_add_title' => __('main.add_new_type', ['type' => __('main.user')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-5 lg:gap-7.5">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:users />
        </div>
    </div>
    <!-- End of Container -->
@endsection
