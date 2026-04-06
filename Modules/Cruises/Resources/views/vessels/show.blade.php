@extends('pages.dashboard.layouts.index')

@section('title', __('main.type_details', ['type' => __('main.cruise')]))

@section('table-content')
    <!-- Dashboard Header -->
    <div class="container-fixed py-8 border-b mb-8 bg-white dark:bg-dark-card rounded-xl shadow-sm px-6">
        <div class="flex flex-col md:flex-row items-center md:items-start justify-between gap-6">
            <div class="flex flex-col md:flex-row items-center gap-6 text-center md:text-start">
                <!-- Icon Section -->
                <div class="symbol symbol-100px symbol-circle border border-blue-100 shadow-sm overflow-hidden bg-blue-50 dark:bg-blue-900/10 flex items-center justify-center">
                    <i class="fas fa-ship text-4xl text-blue-600 dark:text-blue-400"></i>
                </div>

                <!-- Basic Info Section -->
                <div class="flex flex-col gap-2">
                    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-0">
                        {{ $cruise->name }}
                    </h1>
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-3">
                        <span class="kt-badge kt-badge-light kt-badge-primary font-bold px-4 py-1.5">
                            {{ $cruise->vessel_class ?? __('main.standard') }}
                        </span>
                        @if($cruise->is_active)
                            <span class="kt-badge kt-badge-light kt-badge-success font-bold px-4 py-1.5 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-success"></span>
                                {{ __('main.active') }}
                            </span>
                        @else
                            <span class="kt-badge kt-badge-light kt-badge-destructive font-bold px-4 py-1.5 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-destructive"></span>
                                {{ __('main.inactive') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard.cruises.pricing.standalone', $cruise->uuid) }}" class="btn btn-outline-info btn-sm flex items-center gap-2">
                    <i class="fas fa-external-link-alt fs-4"></i>
                    {{ __('main.standalone_pricing_test') }}
                </a>
                <a href="{{ route('dashboard.cruises.edit', $cruise->uuid) }}" class="btn btn-primary btn-sm flex items-center gap-2">
                    <i class="fa-duotone fa-solid fa-pen fs-4"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('dashboard.cruises.index') }}" class="btn btn-outline btn-sm shadow-sm">
                    <i class="fa-duotone fa-solid fa-arrow-left fs-4"></i>
                    {{ __('main.back') }}
                </a>
            </div>
        </div>
    </div>

    <div class="container-fixed">
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <!-- Left Column: Primary Details -->
            <div class="xl:col-span-2 space-y-8">
                <!-- Vessel Information Card -->
                <div class="kt-card shadow-lg border-0 rounded-2xl overflow-hidden bg-white dark:bg-dark-card transition-all hover:shadow-xl">
                    <div class="card-header p-6 border-b border-gray-50 dark:border-dark-border flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('main.vessel_specifications') }}</h3>
                            <p class="text-sm text-gray-500 mt-1">{{ __('main.technical_details_and_capacity') }}</p>
                        </div>
                    </div>
                    <div class="card-body p-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                            <div class="flex flex-col gap-2 group">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('main.total_cabins') }}</label>
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-bed text-blue-500/50"></i>
                                    <span class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ $cruise->total_cabins ?: __('main.na') }}</span>
                                </div>
                            </div>
                            <div class="flex flex-col gap-2 group">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('main.deck_count') }}</label>
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-layer-group text-purple-500/50"></i>
                                    <span class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ $cruise->deck_count ?: __('main.na') }}</span>
                                </div>
                            </div>
                            <div class="flex flex-col gap-2 group">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('main.built_year') }}</label>
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-calendar-check text-green-500/50"></i>
                                    <span class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ $cruise->built_year ?: __('main.na') }}</span>
                                </div>
                            </div>
                            <div class="flex flex-col gap-2 group">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('main.length') }}</label>
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-arrows-alt-h text-orange-500/50"></i>
                                    <span class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ $cruise->length_meters ?? '0' }} m</span>
                                </div>
                            </div>
                        </div>

                        <div class="separator my-10 border-gray-100 dark:border-dark-border"></div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="p-6 rounded-2xl bg-gray-50 dark:bg-dark-hover/20 border border-gray-100 dark:border-dark-border">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 block">{{ __('main.cancellation_policy') }}</label>
                                <div class="prose prose-sm dark:prose-invert">
                                    {!! $cruise->policies['cancellation'] ?? __('main.no_policy_defined') !!}
                                </div>
                            </div>
                            <div class="p-6 rounded-2xl bg-blue-50/50 dark:bg-blue-900/10 border border-blue-100 dark:border-blue-900/20">
                                <label class="text-xs font-bold text-blue-400 uppercase tracking-widest mb-4 block">{{ __('main.renovation_status') }}</label>
                                @if($cruise->renovated_year)
                                    <div class="flex items-center gap-3 text-blue-700 dark:text-blue-300 font-bold">
                                        <i class="fas fa-tools text-xl"></i>
                                        <span>{{ __('main.last_renovated_in') }} {{ $cruise->renovated_year }}</span>
                                    </div>
                                @else
                                    <span class="text-gray-500 italic">{{ __('main.no_recent_renovations') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabs Section for Experiments -->
                <div class="kt-card shadow-lg border-0 rounded-2xl overflow-hidden bg-white dark:bg-dark-card mt-8">
                    <div class="card-header p-0 border-b border-gray-50 dark:border-dark-border">
                        <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-0 px-8 border-transparent" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active py-6 font-bold text-gray-600 dark:text-gray-400 hover:text-primary transition-all flex items-center gap-2" data-bs-toggle="tab" href="#kt_vessel_tab_pricing">
                                    <i class="fas fa-tags fs-5"></i>
                                    {{ __('main.pricing_matrix') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-6 font-bold text-gray-600 dark:text-gray-400 hover:text-primary transition-all flex items-center gap-2" data-bs-toggle="tab" href="#kt_vessel_tab_cabins">
                                    <i class="fas fa-bed fs-5"></i>
                                    {{ __('main.cabins_inventory') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body p-8">
                        <div class="tab-content">
                            <!-- Pricing Tab -->
                            <div class="tab-pane fade show active" id="kt_vessel_tab_pricing" role="tabpanel">
                                <div class="mb-4 flex items-center justify-between">
                                    <h4 class="font-bold text-gray-800 dark:text-white">{{ __('main.pricing_experiment_mode_a') }}</h4>
                                    <span class="badge badge-light-primary">{{ __('main.tabs_integration') }}</span>
                                </div>
                                @livewire('cruises::vessel-pricing-editor', ['cruise' => $cruise])
                            </div>

                            <!-- Cabins Tab -->
                            <div class="tab-pane fade" id="kt_vessel_tab_cabins" role="tabpanel">
                                <h4 class="font-bold text-gray-800 dark:text-white mb-6">{{ __('main.cabins_inventory_management') }}</h4>
                                <div class="text-center py-20 bg-gray-50 dark:bg-dark-hover/10 rounded-3xl border border-dashed">
                                    <i class="fas fa-hammer text-5xl text-gray-300 mb-6"></i>
                                    <h3 class="text-xl font-bold text-gray-400">{{ __('main.coming_soon') }}</h3>
                                    <p class="text-gray-400">{{ __('main.cabin_management_desc') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-8">
                <!-- Management Card -->
                <div class="kt-card shadow-lg border-0 rounded-2xl overflow-hidden bg-white dark:bg-dark-card p-8">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">{{ __('main.vessel_management') }}</h3>
                    
                    <div class="space-y-6">
                        <div class="flex items-center justify-between p-4 rounded-2xl bg-gray-50 dark:bg-dark-hover/30">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-gray-800 dark:text-white">{{ __('main.operating_status') }}</span>
                                <span class="text-xs text-gray-500">{{ __('main.toggle_availability') }}</span>
                            </div>
                            @livewire('toggle-switch', [
                                'modelId' => $cruise->id,
                                'modelType' => 'Modules\\Cruises\\Entities\\Cruise',
                                'field' => 'is_active',
                                'value' => (bool)$cruise->is_active,
                            ])
                        </div>

                        <div class="flex items-center justify-between p-4 rounded-2xl bg-gray-50 dark:bg-dark-hover/30">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-gray-800 dark:text-white">{{ __('main.charter_status') }}</span>
                                <span class="text-xs text-gray-500">{{ __('main.is_vessel_chartered') }}</span>
                            </div>
                            @livewire('toggle-switch', [
                                'modelId' => $cruise->id,
                                'modelType' => 'Modules\\Cruises\\Entities\\Cruise',
                                'field' => 'is_chartered',
                                'value' => (bool)$cruise->is_chartered,
                            ])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
