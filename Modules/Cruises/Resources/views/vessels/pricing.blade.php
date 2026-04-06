@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    @include('includes.table-breadcrumb', [
        'title' => __('main.pricing_experiment'),
        'description' => __('main.standalone_pricing_page_desc'),
        'page_create_url' => route('dashboard.cruises.show', $cruise->uuid),
        'page_create_title' => __('main.back_to_vessel'),
    ])
    <!-- End of Container -->

    <!-- Matrix Editor -->
    <div class="grid gap-6">
        @livewire('cruises::vessel-pricing-editor', ['cruise' => $cruise])
    </div>
@endsection
