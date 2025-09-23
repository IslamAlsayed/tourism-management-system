@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.quotation'),
        'description' => __('main.manage_system_types', ['types' => __('main.quotation')]),
        'import_url' => '#',
        'page_add_url' => route('dashboard.quote.v2.step1'),
        'page_add_title' => __('main.add_new_type', ['type' => __('main.quotation')]),
    ])
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-5 lg:gap-7.5">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:quote.quotation-table :quotations="$quotations" />
        </div>
    </div>
    <!-- End of Container -->
@endsection
