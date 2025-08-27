@extends('pages.dashboard.layouts.index')

@section('table-content')
    <!-- Container -->
    <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
        <div class="flex flex-col justify-center gap-2">
            <h1 class="text-xl font-medium leading-none text-mono">
                Currencies
            </h1>
            <div class="flex items-center flex-wrap gap-1.5 font-medium">
                <span class="text-base text-secondary-foreground">
                    Manage system currencies
                </span>
            </div>
        </div>
        <div class="flex items-center gap-2.5">
            <a class="kt-btn kt-btn-outline" href="#">
                Import CSV
            </a>
            <a class="kt-btn kt-btn-primary" href="#">
                Add Member
            </a>
        </div>
    </div>
    <!-- End of Container -->

    {{-- @component('includes.page-stats', [
    'title' => 'إدارة العملات',
    'description' => 'إدارة وتنظيم العملات في النظام',
    'icon' => 'ki-filled ki-dollar',
    'total' => $totalCurrencies,
    'entityName' => 'العملات',
    'quickActions' => true,
    'createRoute' => route('currencies.create'),
    'additionalStats' => 'عملات عالمية متنوعة',
])
    @endcomponent --}}

    <!-- Container -->
    <div class="grid gap-5 lg:gap-7.5">
        <div class="kt-card kt-card-grid min-w-full">
            <livewire:dashboard.currency-table :currencies="$currencies" />
        </div>
    </div>
    <!-- End of Container -->
@endsection
