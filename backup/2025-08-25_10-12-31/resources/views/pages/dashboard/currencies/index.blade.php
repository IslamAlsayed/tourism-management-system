@extends('pages.dashboard.layouts.index')

@section('table-content')
    @component('includes.page-stats', [
        'title' => 'إدارة العملات',
        'description' => 'إدارة وتنظيم العملات في النظام',
        'icon' => 'ki-filled ki-dollar',
        'total' => $totalCurrencies,
        'entityName' => 'العملات',
        'quickActions' => true,
        'createRoute' => route('currencies.create'),
        'additionalStats' => 'عملات عالمية متنوعة'
    ])
    @endcomponent

    <!-- Container -->
    <div class="grid gap-5 lg:gap-7.5">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:dashboard.currency-table :currencies="$currencies" />
        </div>
    </div>
    <!-- End of Container -->
@endsection
