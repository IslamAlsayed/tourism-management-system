@extends('pages.dashboard.layouts.index')

@section('table-content')
    @component('includes.page-stats', [
        'title' => 'إدارة المدن',
        'description' => 'إدارة وتنظيم المدن في النظام',
        'icon' => 'ki-filled ki-map',
        'total' => $totalCities,
        'entityName' => 'المدن',
        'quickActions' => true,
        'createRoute' => route('cities.create'),
        'additionalStats' => 'موزعة على ' . number_format(\App\Models\Country::count()) . ' بلد'
    ])
    @endcomponent

    <!-- Container -->
    <div class="grid gap-5 lg:gap-7.5">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:dashboard.city-table :cities="$cities" />
        </div>
    </div>
    <!-- End of Container -->
@endsection
