@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @component('includes.table-breadcrumb', [
        'title' => __('main.clients'),
        'description' => __('main.manage_system_types', ['types' => __('main.clients')]),
        'import_url' => route('import.data', ['models' => 'clients']),
        'page_create_url' => route('dashboard.crm.clients.create'),
        'page_create_title' => __('main.create_type', ['type' => __('main.client')]),
    ])
        @slot('fake_data')
            <span class="inline-block bg-danger text-white font-medium px-2 py-0.5 rounded-[7px] ms-2">
                {{ __('main.fake_data') }}
            </span>
        @endslot
    @endcomponent
    <!-- End of Container -->

    <!-- Container -->
    <div class="grid gap-4 lg:gap-6">
        <div class="kt-card kt-card-grid min-w-full">
            @livewire('crm::clients')
        </div>
    </div>
    <!-- End of Container -->
@endsection
