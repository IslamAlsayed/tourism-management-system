@extends('pages.dashboard.layouts.index')

@section('table-content')
    <div class="p-6">
        <div class="flex flex-col gap-4">
            <!-- Container -->
            @include('includes.table-breadcrumb', [
                'title' => __('main.accommodations'),
                'description' => __('main.manage_system_types', ['types' => __('main.accommodations')]),
                'import_url' => route('accommodations.import'),
                'page_add_url' => route('accommodations.create'),
                'page_add_title' => __('main.add_new_type', ['type' => __('main.accommodation')]),
            ])
            <!-- End of Container -->

            <!-- Container -->
            <div class="grid gap-5 lg:gap-7.5">
                <div class="kt-card kt-card-grid min-w-full">
                    <livewire:accommodations.accommodations :accommodations="$dataType" />
                </div>
            </div>
            <!-- End of Container -->
        </div>
    </div>
@endsection
