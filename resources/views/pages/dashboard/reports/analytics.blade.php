@extends('layouts.master')

@section('title', __('main.detailed_analytics'))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.detailed_analytics') }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.advanced_analytics') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('reports.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['type' => __('main.reports')]) }}
                </a>
                <button class="kt-btn kt-btn-primary">
                    {{ __('main.export_analytics') }}
                </button>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- Growth Metrics -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.growth_indicators') }}</h3>
                </div>
                <div class="kt-card-body">
                    <div class="grid gap-5 lg:grid-cols-3">
                        <div class="flex items-center justify-center gap-2 p-2">
                            <div
                                class="text-2xl font-bold text-primary {{ $analytics['growth_metrics']['users_growth'] >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ $analytics['growth_metrics']['users_growth'] }}%
                            </div>
                            <div class="text-sm text-secondary-foreground">{{ __('main.users_growth') }}</div>
                        </div>
                        <div class="flex items-center justify-center gap-2 p-2">
                            <div
                                class="text-2xl font-bold text-primary {{ $analytics['growth_metrics']['cities_growth'] >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ $analytics['growth_metrics']['cities_growth'] }}%
                            </div>
                            <div class="text-sm text-secondary-foreground">{{ __('main.cities_growth') }}</div>
                        </div>
                        <div class="flex items-center justify-center gap-2 p-2">
                            <div
                                class="text-2xl font-bold text-primary {{ $analytics['growth_metrics']['countries_growth'] >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ $analytics['growth_metrics']['countries_growth'] }}%
                            </div>
                            <div class="text-sm text-secondary-foreground">{{ __('main.countries_growth') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid gap-5 lg:grid-cols-2">
                <!-- User Status Distribution -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.user_distribution_by_status') }}</h3>
                    </div>
                    <div class="kt-card-body">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between px-4 py-2">
                                <span>{{ __('main.active_users_label') }}</span>
                                <div class="flex items-center gap-2">
                                    <div class="w-24 h-2 bg-gray-200 rounded">
                                        <div class="h-2 rounded bg-success"
                                            style="width: {{ ($analytics['distribution']['users_by_status']['active'] / ($analytics['distribution']['users_by_status']['active'] + $analytics['distribution']['users_by_status']['inactive'])) * 100 }}%">
                                        </div>
                                    </div>
                                    <span
                                        class="text-sm">{{ number_format($analytics['distribution']['users_by_status']['active']) }}</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between px-4 py-2">
                                <span>{{ __('main.inactive_users_label') }}</span>
                                <div class="flex items-center gap-2">
                                    <div class="w-24 h-2 bg-gray-200 rounded">
                                        <div class="h-2 rounded bg-danger"
                                            style="width: {{ ($analytics['distribution']['users_by_status']['inactive'] / ($analytics['distribution']['users_by_status']['active'] + $analytics['distribution']['users_by_status']['inactive'])) * 100 }}%">
                                        </div>
                                    </div>
                                    <span
                                        class="text-sm">{{ number_format($analytics['distribution']['users_by_status']['inactive']) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Countries by Cities -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.top_5_countries_by_cities') }}</h3>
                    </div>
                    <div class="kt-card-body">
                        <div class="p-4 space-y-3">
                            @foreach ($analytics['distribution']['cities_by_country'] as $country)
                                <div class="flex items-center justify-between">
                                    <span class="text-sm">{{ $country->name }}</span>
                                    <div class="flex items-center gap-2">
                                        <div class="w-16 h-2 bg-gray-200 rounded">
                                            <div class="h-2 rounded bg-primary"
                                                style="width: {{ $analytics['distribution']['cities_by_country']->first()->cities_count > 0 ? ($country->cities_count / $analytics['distribution']['cities_by_country']->first()->cities_count) * 100 : 0 }}%">
                                            </div>
                                        </div>
                                        <span
                                            class="text-sm font-semibold">{{ number_format($country->cities_count) }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
