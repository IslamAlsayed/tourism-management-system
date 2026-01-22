@extends('pages.dashboard.layouts.index')

@section('table-content')
<!-- Container -->
@include('includes.table-breadcrumb', [
'title' => __('main.roles'),
'description' => __('main.manage_system_types', ['types' => __('main.roles')]),
'import_url' => null,
'page_create_url' => route('roles.create'),
'page_create_title' => __('main.create_type', ['type' => __('main.role')]),
])
<!-- End of Container -->

<!-- Container -->
<div class="grid gap-4 lg:gap-6">
    <div class="kt-card kt-card-grid min-w-full">
        <livewire:roles />
    </div>
</div>
<!-- End of Container -->
@endsection