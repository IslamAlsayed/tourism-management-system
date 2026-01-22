@extends('pages.dashboard.layouts.index')

@section('table-content')
<!-- Container -->
@include('includes.table-breadcrumb', [
'title' => __('main.permissions'),
'description' => __('main.manage_system_types', ['types' => __('main.permissions')]),
'import_url' => null,
'page_create_url' => route('permissions.create'),
'page_create_title' => __('main.create_type', ['type' => __('main.permission')]),
])
<!-- End of Container -->

<!-- Container -->
<div class="grid gap-4 lg:gap-6">
    <div class="kt-card kt-card-grid min-w-full">
        <livewire:permissions />
    </div>
</div>
<!-- End of Container -->
@endsection